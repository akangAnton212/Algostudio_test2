<?php

namespace App\Http\Controllers;
use App\Models\t_inv_stock_card;

use Illuminate\Http\Request;
use Carbon\Carbon;

class StockCardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function getAllStock(Request $request){
        try{

            $tglAwal = $request->query("tglAwal");
            $tglAkhir = $request->query("tglAkhir");
            $itemSelected = $request->query("itemSelected");
            $data = "";

            if(!empty($tglAwal) && !empty($tglAkhir) && !empty($itemSelected)){
                $data = t_inv_stock_card::where([
                    'enabled'       => true,
                    'uid_item'      => $itemSelected
                ])
                ->whereBetween('trans_date', [$tglAwal, $tglAkhir])
                ->whereHas('item')
                ->with('item')
                ->orderBy('trans_date','DESC')
                ->get()
                ->map(function($key){
                    return [
                        'uid_item'      => $key->uid_item,
                        'item_name'     => $key->item->item_name,
                        'trans_type'    => $key->trans_type == 1 ? 'Receiving' : 'Usage',
                        'trans_date'    => $key->trans_date,
                        'ref_number'    => $key->ref_number,
                        'initial_balance'=> $key->initial_balance,
                        'qty'           => $key->qty,
                        'final_balance' => $key->final_balance,
                        'information'   => $key->information,
                        'uid'           => $key->uid
                    ];
                });
            }else if(!empty($tglAwal) && !empty($tglAkhir) && empty($itemSelected)){
                $data = t_inv_stock_card::where([
                    'enabled'       => true,
                ])
                ->whereBetween('trans_date', [$tglAwal, $tglAkhir])
                ->whereHas('item')
                ->with('item')
                ->orderBy('trans_date','DESC')
                ->get()
                ->map(function($key){
                    return [
                        'uid_item'      => $key->uid_item,
                        'item_name'     => $key->item->item_name,
                        'trans_type'    => $key->trans_type == 1 ? 'Receiving' : 'Usage',
                        'trans_date'    => $key->trans_date,
                        'ref_number'    => $key->ref_number,
                        'initial_balance'=> $key->initial_balance,
                        'qty'           => $key->qty,
                        'final_balance' => $key->final_balance,
                        'information'   => $key->information,
                        'uid'           => $key->uid
                    ];
                });
            }else if(empty($tglAwal) && empty($tglAkhir) && !empty($itemSelected)){
                $data = t_inv_stock_card::where([
                    'enabled'       => true,
                    'uid_item'      => $itemSelected
                ])
                ->whereHas('item')
                ->with('item')
                ->orderBy('trans_date','DESC')
                ->get()
                ->map(function($key){
                    return [
                        'uid_item'      => $key->uid_item,
                        'item_name'     => $key->item->item_name,
                        'trans_type'    => $key->trans_type == 1 ? 'Receiving' : 'Usage',
                        'trans_date'    => $key->trans_date,
                        'ref_number'    => $key->ref_number,
                        'initial_balance'=> $key->initial_balance,
                        'qty'           => $key->qty,
                        'final_balance' => $key->final_balance,
                        'information'   => $key->information,
                        'uid'           => $key->uid
                    ];
                });
            }else{
                $data = t_inv_stock_card::where([
                    'enabled'       => true
                ])
                ->whereHas('item')
                ->with('item')
                ->orderBy('trans_date','DESC')
                ->get()
                ->map(function($key){
                    return [
                        'uid_item'      => $key->uid_item,
                        'item_name'     => $key->item->item_name,
                        'trans_type'    => $key->trans_type == 1 ? 'Receiving' : 'Usage',
                        'trans_date'    => $key->trans_date,
                        'ref_number'    => $key->ref_number,
                        'initial_balance'=> $key->initial_balance,
                        'qty'           => $key->qty,
                        'final_balance' => $key->final_balance,
                        'information'   => $key->information,
                        'uid'           => $key->uid
                    ];
                });
            }

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
}
