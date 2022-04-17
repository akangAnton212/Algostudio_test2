<?php

namespace App\Http\Controllers;
use App\Models\m_inv_item;
use App\Models\m_inv_item_type;
use App\Models\m_inv_item_group;
use Illuminate\Http\Request;

class ItemMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllComboboxItemMaster(Request $request){
        try{
            $dataType = m_inv_item_type::select('uid','type_name as name')->where([
                'enabled'       => true,
            ])->get();

            $dataGroup = m_inv_item_group::select('uid','group_name as name')->where([
                'enabled'       => true,
            ])->get();

            return response()->json([
                'status'        => true,
                'message'       => 'success',
                'data'          => [
                    'dataType'      => $dataType,
                    'dataGroup'     => $dataGroup
                ]
                
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'status'        => false,
                'message'       => $e->getMessage(),
                'data'          => null
            ], $e->getCode());
        }
    }

    public function getAllItems(Request $request){
        try{
            $data = m_inv_item::where([
                'enabled'       => true,
            ])
            ->with([
                'type',
                'group'
            ])
            ->get()
            ->map(function($key){
                return [
                    'item_name'     => $key->item_name,
                    'uid_item_group'=> $key->uid_item_group,
                    'group_name'    => !empty($key->group) ? $key->group->group_name : "-",
                    'uid_item_type' => $key->uid_item_type,
                    'type_name'     => !empty($key->type) ? $key->type->type_name : "-",
                    'stock'         => $key->stock,
                    'item_description'=> $key->item_description,
                    'uid'           => $key->uid
                ];
            });

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

    public function saveItem(Request $request){
        try{

            if(!empty($request->input('uidItem'))){
                $updateItem = m_inv_item::where('uid', $request->input('uidItem'))
                    ->update([
                        'item_name'         => $request->input('itemName'),
                        'uid_item_group'    => $request->input('itemGroup'),
                        'uid_item_type'     => $request->input('itemType'),
                        'uid_store'         => NULL,
                        'last_price'        => 0,
                        'stock'             => $request->input('itemStock'),
                        'item_description'  => $request->input('description'),
                    ]);
            }else{
                $newItem = m_inv_item::create([
                    'item_name'         => $request->input('itemName'),
                    'uid_item_group'    => $request->input('itemGroup'),
                    'uid_item_type'     => $request->input('itemType'),
                    'uid_store'         => NULL,
                    'last_price'        => 0,
                    'stock'             => $request->input('itemStock'),
                    'item_description'  => $request->input('description'),
                ]);
            }

            return response()->json([
                'status'        => true,
                'message'       => 'success',
                'data'          => ""
            ], 200);
        }catch (Exception $e){
            return response()->json([
                'status'        => false,
                'message'       => $e->getMessage(),
                'data'          => null
            ], $e->getCode());
        }
    }

    public function deleteItem(Request $request){
        try{
            $updateItem = m_inv_item::where('uid', $request->input('uidItem'))
                    ->update([
                        'enabled'           => false,
                    ]);

            return response()->json([
                'status'        => true,
                'message'       => 'success',
                'data'          => ""
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