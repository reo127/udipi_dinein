<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\FoodCategory;
use App\Models\FoodItems;
use App\Models\Tables;
use Hash;
use Str;

class RestaurantController extends Controller
{
    public function addTable(Request $request){

        $this->validate($request, [
            'table_name' => 'required',
        ]);

        $qrCodeName = Str::random(16);
        
        $table = new Tables();
        $table->name = $request->table_name;
        // $table->status = 'Active';
        $table->save();
        
        \QrCode::size(500)
            ->format('png')
            ->generate('http://phplaravel-786870-2685559.cloudwaysapps.com/menu?table_id='.$table->id.'', public_path('images/'.$qrCodeName.'.png'));
        $table->qr_code = $qrCodeName.'.png';
        $table->save();
        
        return response()->json(['code' => '1', 'message' => 'Table added successfully.'], 200);
        
    }

    public function deleteTable(Request $request) {
        $table = Tables::where('id', $request->table_id)->delete();

        return response()->json(['code' => '1', 'message' => 'Table deleted successfully.'], 200);
    }

    public function listTabel(Request $request) {
        $table = Tables::get();

        if (count($table) > 0) {
            return response()->json(['code' => '1', 'message' => 'Table details found.', 'data' => $table], 200);
        } else {
            return response()->json(['code' => '1', 'message' => 'Table details not found.', 'data' => []], 200);
        }
    }
}
