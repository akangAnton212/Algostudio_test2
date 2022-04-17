<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\t_inv_order;
use App\Models\t_inv_receive;
use App\Models\t_inv_receive_detail;
use App\Models\t_inv_stock_card;
use App\Models\m_inv_item;
use App\Models\t_inv_usage_detail;
use App\Models\t_inv_usage;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllOrderNumber(Request $request){
        try{
            $data = t_inv_order::select('order_number')->where([
                'enabled'       => true,
                'is_received'   => false
            ])->get();

            return response()->json([
                'status'        => true,
                'message'       => 'success',
                'data'          => $data
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'status'        => false,
                'message'       => $e->getMessage(),
                'data'          => null
            ], $e->getCode());
        }
    }

    public function detailOrderByOrderNumber(Request $request){
        $orderNumber = $request->query('orderNumber');

        try{
            $data = t_inv_order::where([
                'enabled'       => true,
                'is_received'   => false,
                'order_number'  =>$orderNumber
            ])
            ->whereHas('orderDetail')
            ->with([
                'userOrder',
                'orderDetail',
                'orderDetail.item'
            ])
            ->first();

            return response()->json([
                'status'        => true,
                'message'       => 'success',
                'data'          => $data
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'status'        => false,
                'message'       => $e->getMessage(),
                'data'          => null
            ], $e->getCode());
        }
    }

    public function receiveOrder(Request $request){
        try{
            DB::beginTransaction();

            $updateStatusReceiveOrder = t_inv_order::where([
                'enabled'       => true,
                'is_received'   => false,
                'order_number'  => $request->input('order_number')
            ])->update([
                'is_received'   => true
            ]);

            $insertInvReceive = t_inv_receive::create([
                'uid_order'         => $request->input('uid_order'),
                'receive_date'      => Carbon::now(),
                'receive_num'       => null,
                'invoice_num'       => $request->input('invoice_number'),
                'delivery_note'     => $request->input('delivery_note'),
                'uid_receive_by'    => Auth::user()->uid,
            ]);
            $orderDetail = (Array)json_decode($request->input('order_detail'));
            for ($i=0; $i < count($orderDetail) ; $i++) { 
                $insertInvReceiveDetail =t_inv_receive_detail::create([
                    'uid_receive'           => $insertInvReceive->uid,
                    'uid_item'              => $orderDetail[$i]->uid_item,
                    'uid_order_detail'      => $orderDetail[$i]->uid,
                    'qty_order'             => $orderDetail[$i]->qty,
                    'qty_receive'           => $orderDetail[$i]->qty,
                ]);

                $getStockCard = t_inv_stock_card::where('uid_item', $orderDetail[$i]->uid_item)->orderBy('created_at','DESC')->first();
                //1=>Receiving, 2=>inMutation, 3=>outMutation, 4=>returnMutation, 5=>usage, 6=>opname, 7=>Adjusment, 8=>Return, 9=>Selling
                $insertStockCard = "";
                if($getStockCard){
                    $insertStockCard = t_inv_stock_card::create([
                        'trans_type'        => 1,
                        'trans_date'        => $insertInvReceive->receive_date,
                        'uid_item'          => $orderDetail[$i]->uid_item,
                        'initial_balance'   => $getStockCard->final_balance,
                        'qty'               => $orderDetail[$i]->qty,
                        'final_balance'     => $getStockCard->final_balance + $orderDetail[$i]->qty,
                        'information'       => "-",
                        'ref_number'        => $request->input('order_number'),
                    ]);
                }else{
                    $insertStockCard = t_inv_stock_card::create([
                        'trans_type'        => 1,
                        'trans_date'        => $insertInvReceive->receive_date,
                        'uid_item'          => $orderDetail[$i]->uid_item,
                        'initial_balance'   => 0,
                        'qty'               => $orderDetail[$i]->qty,
                        'final_balance'     => $orderDetail[$i]->qty,
                        'information'       => "-",
                        'ref_number'        => $request->input('order_number'),
                    ]);
                }

                $updateStockItem = m_inv_item::where([
                    'uid'       => $orderDetail[$i]->uid_item
                ])->update([
                    'stock'     => $insertStockCard->final_balance
                ]);
            }

           $result = DB::commit();

            if($result === false){
                DB::rollback();
                return response()->json([
                    'status'        => false,
                    'message'       => "Internal Server Error!",
                    'data'          => null
                ], 500);
            }else{
                return response()->json([
                    'status'        => true,
                    'message'       => 'success',
                    'data'          => ""
                ], 200);
            }
        }catch (Exception $e){
            DB::rollback();
            return response()->json([
                'status'        => false,
                'message'       => $e->getMessage(),
                'data'          => null
            ], $e->getCode());
        }
    }

    public function getAllItems(Request $request){
        try{
            $data = m_inv_item::select('uid','item_name')->where([
                'enabled'       => true,
            ])->get();

            return response()->json([
                'status'        => true,
                'message'       => 'success',
                'data'          => $data
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'status'        => false,
                'message'       => $e->getMessage(),
                'data'          => null
            ], $e->getCode());
        }
    }

    public function getLastStockItem(Request $request){
        $uidItem = $request->query('uid_item');

        try{
            $stock = 0;
            $data = t_inv_stock_card::where('uid_item', $uidItem)->orderBy('created_at','DESC')->first();
            if($data){
                $stock = $data->final_balance;
            }

            return response()->json([
                'status'        => true,
                'message'       => 'success',
                'data'          => $stock
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'status'        => false,
                'message'       => $e->getMessage(),
                'data'          => null
            ], $e->getCode());
        }
    }

    public function itemUsage(Request $request){
        try{
            DB::beginTransaction();

            $usageNumber = $request->input('usage_num');
            $items = (Array)json_decode($request->input('items'));

            $insertItemUsage = t_inv_usage::create([
                'uid_created_by'    => Auth::user()->uid,
                'created_date'      => Carbon::now(),
                'uid_acc_by'        => NULL,
                'acc_date'          => NULL,
                'usage_num'         => $usageNumber,
            ]);

            for ($i=0; $i < count($items) ; $i++) { 
                $insertItemUsageDetail =t_inv_usage_detail::create([
                    'uid_usage'     => $insertItemUsage->uid,
                    'uid_item'      => $items[$i]->uid,
                    'qty'           => $items[$i]->qty,
                ]);

                $getStockCard = t_inv_stock_card::where('uid_item',$items[$i]->uid)->orderBy('created_at','DESC')->first();
                //1=>Receiving, 2=>inMutation, 3=>outMutation, 4=>returnMutation, 5=>usage, 6=>opname, 7=>Adjusment, 8=>Return, 9=>Selling
                $insertStockCard = "";
                if($getStockCard){
                    $insertStockCard = t_inv_stock_card::create([
                        'trans_type'        => 5,
                        'trans_date'        => $insertItemUsage->created_date,
                        'uid_item'          => $items[$i]->uid,
                        'initial_balance'   => $getStockCard->final_balance,
                        'qty'               => $items[$i]->qty,
                        'final_balance'     => $getStockCard->final_balance - $items[$i]->qty,
                        'information'       => "-",
                        'ref_number'        => $usageNumber,
                    ]);
                }else{
                    $insertStockCard = t_inv_stock_card::create([
                        'trans_type'        => 5,
                        'trans_date'        => $insertItemUsage->created_date,
                        'uid_item'          => $items[$i]->uid,
                        'initial_balance'   => 0,
                        'qty'               => $items[$i]->qty,
                        'final_balance'     => $items[$i]->qty,
                        'information'       => "-",
                        'ref_number'        => $usageNumber,
                    ]);
                }

                $updateStockItem = m_inv_item::where([
                    'uid'       => $items[$i]->uid
                ])->update([
                    'stock'     => $insertStockCard->final_balance
                ]);
            }

            $result = DB::commit();

            if($result === false){
                DB::rollback();
                return response()->json([
                    'status'        => false,
                    'message'       => "Internal Server Error!",
                    'data'          => null
                ], 500);
            }else{
                return response()->json([
                    'status'        => true,
                    'message'       => 'success',
                    'data'          => ""
                ], 200);
            }
        }catch (Exception $e){
            DB::rollback();
            return response()->json([
                'status'        => false,
                'message'       => $e->getMessage(),
                'data'          => null
            ], $e->getCode());
        }
    }
}
