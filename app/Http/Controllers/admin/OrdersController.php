<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OderSellModel;
use App\Models\UserSellModel;
use App\Models\UserBuyModel;
use App\Models\OderBuyModel;
use App\Models\ProductModel;
use App\Models\PriceModel;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\select;

class OrdersController extends Controller
{
    public function Order(Request $request)
    {
        // คำค้นหาสำหรับการซื้อและการขาย
        $searchBuy = $request->get('search_buy');
        $searchSell = $request->get('search_sell');

        // ค้นหาการซื้อ
        if ($searchBuy) {
            $getOrder = UserSellModel::where('phone', 'LIKE', "%$searchBuy%")
                ->where('is_delete', 0)
                ->paginate(10);
        } else {
            $getOrder = UserSellModel::getRecord(); // ดึงข้อมูลทั้งหมดถ้าไม่มีการค้นหา
        }

        // ค้นหาการขาย
        if ($searchSell) {
            $getOrderBuy = UserBuyModel::where('phone', 'LIKE', "%$searchSell%")
                ->where('is_delete', 0)
                ->paginate(10);
        } else {
            $getOrderBuy = UserBuyModel::getRecord(); // ดึงข้อมูลทั้งหมดถ้าไม่มีการค้นหา
        }

        // เตรียมข้อมูลที่จะส่งไปยัง View
        $data = [
            'getOrder' => $getOrder,
            'getOrderBuy' => $getOrderBuy,
        ];


        return view('admin.Orders.listOD', $data);
    }

    public function order_detailsell($id)
    {
        $data['getdetailsell'] = UserSellModel::getdetail($id);
        $data['getSingle'] = UserSellModel::getSingle($id);

        return view('admin.Orders.orderDT', $data);
    }

    public function order_detailbuy($id)
    {
        $data['getdetailbuy'] = UserBuyModel::getdetail($id);
        $data['getSingle'] = UserBuyModel::getSingle($id);

        return view('admin.Orders.orderDT', $data);
    }

    public function updateStatus(Request $request, $id)
    {
        // ดึงข้อมูลคำสั่งซื้อจาก UserSellModel หรือ UserBuyModel
        $Order = UserSellModel::find($id);

        // ตรวจสอบว่าพบคำสั่งซื้อจาก UserSellModel หรือ UserBuyModel หรือไม่
        if ($Order) {
            // รับค่า status จากฟอร์มที่ส่งมา
            $status = $request->input('status');

            // เปลี่ยนสถานะใหม่
            $Order->status = $status;


            // บันทึกการเปลี่ยนแปลง
            $Order->save();

            // ส่งข้อความตอบกลับเมื่ออัปเดตสำเร็จ
            return redirect()->back();
        } else {
        }
    }

    public function updateStatusbuy(Request $request, $id)
    {
        // ดึงข้อมูลคำสั่งซื้อจาก UserSellModel หรือ UserBuyModel
        $Orderbuy = UserBuyModel::find($id);

        // ตรวจสอบว่าพบคำสั่งซื้อจาก UserSellModel หรือ UserBuyModel หรือไม่
        if ($Orderbuy) {
            // เปลี่ยนสถานะ: ถ้าเป็น 0 จะเปลี่ยนเป็น 1, ถ้าเป็น 1 จะเปลี่ยนเป็น 0
            $status = $request->input('status');

            // เปลี่ยนสถานะใหม่
            $Orderbuy->status = $status;

            // บันทึกการเปลี่ยนแปลง
            $Orderbuy->save();

            // ส่งข้อความตอบกลับเมื่ออัปเดตสำเร็จ
            return redirect()->back();
        } else {
        }
    }

    public function order_delete($id)
    {
        $Order = UserSellModel::getSingle($id);
        if ($Order) {
            $Order->is_delete = 1;
            $Order->save();
        }
        return redirect()->back();
    }



    public function order_deletebuy($id)
    {
        $Order = UserBuyModel::getSingle($id);
        if ($Order) {
            $Order->is_delete = 1;
            $Order->save();
        }
        return redirect()->back();
    }


    public function order_editbuy(Request $request, $id)
    {
        $data['getProductPrices'] = ProductModel::getPrices($id);
        $data['getdetailbuy'] = UserBuyModel::getdetail($id);
        $data['getSingle'] = UserBuyModel::getSingle($id);

        return view('admin.Orders.orderED', $data);
    }

    public function order_editsell($id)
    {
        $data['getSingle'] = OderSellModel::getSingle($id);

        return view('admin.Orders.orderED', $data);
    }

    public function order_editsell_update($id, Request $request)
    {
        $editsell = OderSellModel::getSingle($id);
        $editsell->grade = trim($request->grade);
        $editsell->price = trim($request->price);
        $editsell->quantity = trim($request->qty);
        $editsell->total_price = trim($request->total_price);
        $editsell->save();

        return redirect("/orders/detail-sell/{$id}")->with('successa', 'อัปเดตข้อมูลการขายสำเร็จ!');
    }




    public function grade(Request $request)
    {
        $productId = $request->input('product_id');
        // ดึงข้อมูลเกรดสินค้าที่มีตาม product_id
        $grades = PriceModel::where('product_id', $productId)->get();
        return response()->json($grades);
    }

    public function price_grade(Request $request)
    {
        // ดึงข้อมูล price ตาม product_id และ grade
        $productId = $request->input('product_id');
        $grade = $request->input('grade');

        // ดึงข้อมูลราคาตาม product_id และ grade
        $price = PriceModel::where('product_id', $productId)
            ->where('grade', $grade)->first();
        return response()->json($price->price_buy);
    }

    public function showReceipt($id)
    {
        $data['getdetailsell'] = UserSellModel::getdetail($id);
        $data['getSingle'] = UserSellModel::getSingle($id);


        return view('admin.Orders.receipt', $data);
    }
}
