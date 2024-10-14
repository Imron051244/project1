<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserBuyModel;
use App\Models\OderBuyModel;

class OrdersbuyController extends Controller
{

    public function list_order_buy()
    {
        $data['getbuy'] = UserBuyModel::getRecord();
        return view('admin.Ordersbuy.list_buy', $data);
    }
    public function detail_order_buy()
    {
        // $data['getdetailbuy'] = UserBuyModel::getdetail($id);
        // $data['getSingle'] = UserBuyModel::getSingle($id);

        return view('admin.Ordersbuy.detail_buy');
    }

}
