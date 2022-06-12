<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\FoodCategory;
use App\Models\FoodItems;
use App\Models\Tables;
use App\Models\Order;
use Hash;
use Str;

class UserController extends Controller
{
    public function menuListing(Request $request){

        // $foodCategory = FoodCategory::where('status', 'Active')->get();

        // if (count($foodCategory) > 0) {
            // foreach ($foodCategory as $key => $value) {
        $foodItem = FoodItems::where('status', 'Active')->get();

        if (count($foodItem) <= 0) {
            $foodItem = [];
            return response()->json(['code' => '2', 'message' => 'Menu details not found!'], 200);
        } else {
            foreach ($foodItem as $key => $value) {
                $foodItem[$key]['full_image'] = url("images/".$value->product_image."");
            }
        }
        return response()->json(['code' => '1', 'message' => 'Menu details found!', 'data' => $foodItem], 200);
    }

    public function checkTableAvailability(Request $request) {
        $table = Tables::where('id', $request->table_id)->first();

        if (!empty($table)) {
            if ($table->status == 'Free') {
                return response()->json(['code' => '1', 'message' => 'Table is free', 'data' => $table->status ], 200);
            } else {
                return response()->json(['code' => '2', 'message' => 'Table is occupied', 'data' => $table->status ], 200);
            }
        } else {
            return response()->json(['code' => '2', 'message' => 'Table details not found!'], 200);
        }
    }

    public function placeOrder(Request $request) {

        $user = Users::where('token', $request->token)->first();

        $order = new Order();
        $order->user_id = $user->id;
        $order->table_id = $request->table_id;
        $order->status = 'Pending';
        $order->items = $request->cart;
        $order->sub_total = $request->sub_total;
        $order->charges = $request->charges;
        $order->total = $request->total;
        $order->save();

        return response()->json(['code' => '1', 'message' => 'Order placed successfully'], 200);
    }

    public function orderList(Request $request) {
        $user = Users::where('token', $request->token)->first();

        $orders = Orders::where('user_id', $user->id)->get();

        if (count($orders) > 0) {
            return response()->json(['code' => '1', 'message' => 'Your order list has been found.', 'data' => $orders], 200);
        } else {
            return response()->json(['code' => '2', 'message' => 'Your order list not found.', 'data' => []], 200);
        }
    }
}
