<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserBuyModel;
use App\Models\OderBuyModel;
use App\Models\ProductModel;
use App\Models\PriceModel;



class OrdersbuyController extends Controller
{

    public function list_order_buy()
    {
        $data['getbuy'] = UserBuyModel::getRecord();
        return view('admin.Ordersbuy.list_buy', $data);
    }
    public function detail_order_buy($id)
    {
        $data['getdetailbuy'] = UserBuyModel::getdetail($id);
        $data['getSingle'] = UserBuyModel::getSingle($id);

        return view('admin.Ordersbuy.detail_buy', $data);
    }

    public function grade_price(Request $request)
    {
        $grade = $request->input('grade');

        // ดึงข้อมูลราคาตาม product_id และ grade
        $price = PriceModel::where('grade', $grade)->first();
        return response()->json($price->price_buy);
    }

    public function edit_order_buy($id)
    {
        $data['getProductPrices'] = ProductModel::getPrices($id);
        // $data['getdetailbuy'] = UserBuyModel::getdetail($id);
        $data['getSingle'] = OderBuyModel::getSingle_edit($id);

        return view('admin.Ordersbuy.edit_buy', $data);
    }
}
