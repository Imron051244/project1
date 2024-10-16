<?php

namespace App\Http\Controllers;

use App\Models\PriceModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Models\UserSellModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\amphures;
use App\Models\districts;
use App\Models\OderSellModel;
use App\Models\UserBuyModel;
use App\Models\OderBuyModel;
use Carbon\Carbon;


use Darryldecode\Cart\Facades\CartFacade as Cart;

class PaymentController extends Controller
{
    public function __construct()
    {
        // ใช้ middleware 'auth' เพื่อบังคับให้ผู้ใช้ต้องเข้าสู่ระบบก่อนเข้าถึง 'checkout' และ 'place_order_sell'
        $this->middleware('auth')->only(['checkout', 'place_order_sell']);
    }

    public function cart(Request $request)
    {
        return view('Payment.cart');
    }



    public function checkout()
    {
        return view('Payment.checkout');
    }

    public function getAmphures(Request $request)
    {
        $provinceId = $request->input('province_id');
        $amphures = amphures::where('province_id', $provinceId)->get();

        return response()->json($amphures);
    }

    public function getDistricts(Request $request)
    {
        $amphureId = $request->input('amphure_id');
        $districts = districts::where('amphure_id', $amphureId)->get();

        return response()->json($districts);
    }

    public function getZipCode(Request $request)
    {
        $districtId = $request->input('district_id');
        $districts = districts::find($districtId);
        return response()->json($districts->zip_code);
    }

    public function place_order_sell(Request $request)
    {

        if (auth()->user()->type === 'ผู้ซื้อ') {


            $request->validate([
                'name' => 'required',
                'last_Name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'province_id' => 'required',
                'district_id' => 'required',
                'subdistrict_id' => 'required',

            ], [
                'name.required' => 'กรุณากรอกชื่อ',
                'last_Name.required' => 'กรุณากรอกนามสกุล',
                'phone.required' => 'กรุณากรอกหมายเลขโทรศัพท์',
                'address.required' => 'กรุณากรอกที่อยู่',
                'province_id.required' => 'กรุณาเลือกจังหวัด',
                'district_id.required' => 'กรุณาเลือกอำเภอ',
                'subdistrict_id.required' => 'กรุณาเลือกตำบล',


            ]);

            $cartTotal = Cart::getTotal(); // คำนวณยอดรวมจาก Cart
            // สร้าง UserSellModel ใหม่และตั้งค่า
            $usersell = new UserSellModel;
            $usersell->name = trim($request->name);
            $usersell->last_Name = trim($request->last_Name);
            $usersell->phone = trim($request->phone);
            $usersell->address = trim($request->address);
            $usersell->subdistrict_id = trim($request->subdistrict_id);
            $usersell->total = trim($cartTotal);
            $usersell->user_id = Auth::id(); // เก็บ user_id ของผู้ใช้ที่เข้าสู่ระบบ
            $usersell->save();

            // อัปเดตที่อยู่ในโมเดล User
            $user = User::find(Auth::id()); // หาผู้ใช้ตาม user_id
            if ($user) { // ตรวจสอบว่าพบผู้ใช้หรือไม่
                $user->address = trim($request->address);
                $usersell->subdistrict_id = trim($request->subdistrict_id);
                $user->save(); // บันทึกการเปลี่ยนแปลง
            }

            // บันทึกข้อมูลการสั่งซื้อ
            foreach (Cart::getContent() as $key => $header_cart) {

                $odersell = new OderSellModel;
                $odersell->user_sell_id = $usersell->id;
                $odersell->product_id = explode('-', $header_cart->id)[0];
                $odersell->price = $header_cart->price;
                $odersell->quantity = $header_cart->quantity;
                $odersell->grade = explode('-', $header_cart->id)[1];
                $odersell->total_price = $header_cart->price * $header_cart->quantity;
                $odersell->save();

                $product = PriceModel::where('product_id', $odersell->product_id)
                ->where('grade', $odersell->grade)
                ->first(); // หาผู้ใช้ตาม user_id
                if ($product) {
                    $product->qty -= $odersell->quantity;
                    $product->save();
                }
            }

            // ล้างตะกร้า
            Cart::clear();

            return redirect()->back()->with('successPD', 'สั่งซื้อเรียบร้อยแล้ว');
        } elseif (auth()->user()->type === 'ผู้ขาย') {
            
            $request->validate([
                'name' => 'required',
                'last_Name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'province_id' => 'required',
                'district_id' => 'required',
                'subdistrict_id' => 'required',
                'date' => 'required'
            ], [
                'name.required' => 'กรุณากรอกชื่อ',
                'last_Name.required' => 'กรุณากรอกนามสกุล',
                'phone.required' => 'กรุณากรอกหมายเลขโทรศัพท์',
                'address.required' => 'กรุณากรอกที่อยู่',
                'province_id.required' => 'กรุณาเลือกจังหวัด',
                'district_id.required' => 'กรุณาเลือกอำเภอ',
                'subdistrict_id.required' => 'กรุณาเลือกตำบล',
                'date.required' => 'กรุณากรอกวันที่เก็บผลได้',

            ]);

            // บันทึกข้อมูลผู้สั่งขาย
            $userbuy = new UserBuyModel;
            $userbuy->name = trim($request->name);
            $userbuy->last_Name = trim($request->last_Name);
            $userbuy->phone = trim($request->phone);
            $userbuy->address = trim($request->address);
            $userbuy->subdistrict_id = trim($request->subdistrict_id);
            $total_quantity = Cart::getContent()->sum('quantity');
            $userbuy->quantity = $total_quantity;
            $userbuy->user_id = Auth::id(); // เก็บ user_id ของผู้ใช้ที่เข้าสู่ระบบ


            $userbuy->save();

            // บันทึกข้อมูลการสั่งขาย
            foreach (Cart::getContent() as $key => $header_cart) {

                $formattedDate = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
                $oderbuy = new OderBuyModel;
                $oderbuy->user_buy_id = $userbuy->id;
                $oderbuy->product_id = explode('-', $header_cart->id)[0];
                $oderbuy->quantity = $header_cart->quantity;
                $oderbuy->date_play = trim($formattedDate);

                // บันทึกข้อมูลลงฐานข้อมูล
                 
                $oderbuy->save();
            }

            // ล้างตะกร้า
            Cart::clear();

            return redirect()->back()->with('successBS', 'สั่งขายเรียบร้อยแล้ว');
        }
    }



    public function add_to_cart(Request $request)
{
    $request->validate(
        [
            'grade' => 'required_if:user_type,ผู้ซื้อ', // ถ้าผู้ใช้เป็นผู้ซื้อ ต้องเลือกเกรด
            'quantity' => 'required|integer|min:1' // ต้องกรอกจำนวน และต้องเป็นจำนวนเต็มบวก
        ],
        [
            'grade.required_if' => 'กรุณาเลือกเกรดสินค้า',
            'quantity.required' => 'กรุณากรอกจำนวน',
            'quantity.integer' => 'จำนวนต้องเป็นตัวเลข',
            'quantity.min' => 'จำนวนต้องมากกว่าหรือเท่ากับ 1',
        ]
    );

    $getProduct = ProductModel::getSingle($request->product_id);
    $getPrice = PriceModel::getSingle($request->grade, $request->product_id);
    
    // ตรวจสอบว่าราคาที่ได้มาไม่เป็น null
    if ($getPrice) {
        $price_sell = $getPrice->price_sell;  // ราคาขาย

        // คำนวณราคาโดยขึ้นอยู่กับประเภทผู้ใช้
        $total = $request->user() ? 
            ($request->user()->type === 'ผู้ขาย' ? 0 : $price_sell) : 
            $price_sell; // หากไม่เข้าสู่ระบบ ใช้ราคาขาย
    } else {
        return redirect()->back()->withErrors('เกิดข้อผิดพลาด: ไม่สามารถดึงข้อมูลราคาได้');
    }

    // ตรวจสอบว่ามีสินค้าที่เกรดเดียวกันอยู่ในตะกร้าแล้วหรือไม่
    $cartItems = Cart::getContent();
    $quantity = $request->quantity;

    if ($request->user() && $request->user()->type === 'ผู้ขาย') {
        $existingCartItem = $cartItems->where('id', $request->product_id)->first();

        if ($existingCartItem) {
            // เพิ่มจำนวนสินค้าในตะกร้า
            Cart::update($existingCartItem->id, [
                'quantity' => $existingCartItem->quantity + $quantity,
            ]);
        } else {
            // เพิ่มสินค้าใหม่ลงในตะกร้า
            Cart::add([
                'id' => $request->product_id,
                'name' => $getProduct->title,
                'quantity' => $quantity,
                'price' => $total,
            ]);
        }
    } else {
        // สำหรับผู้ใช้อื่น (เช่น ผู้ซื้อ)
        $existingCartItem = $cartItems->where('id', $request->product_id)
            ->where('attributes.grade', $request->grade)
            ->first();

        if ($existingCartItem) {
            // เพิ่มจำนวนสินค้าในตะกร้า
            Cart::update($existingCartItem->id, [
                'quantity' => $existingCartItem->quantity + $quantity,
            ]);
        } else {
            // เพิ่มสินค้าใหม่ลงในตะกร้า
            Cart::add([
                'id' => $request->product_id,
                'name' => $getProduct->title,
                'price' => $total,
                'quantity' => $quantity,
                'attributes' => [
                    'grade' => $request->grade,
                    'grade_name' => $getPrice->grade ?? '',
                ]
            ]);
        }
    }

    return redirect()->back()->with('success', 'สินค้าได้ถูกเพิ่มลงในตะกร้าเรียบร้อยแล้ว');
}


    public function update_cart(Request $request)
    {
        if (is_array($request->cart) || is_object($request->cart)) {
            foreach ($request->cart as $cart) {
                Cart::update($cart['id'], array(
                    'quantity' => array(
                        'relative' => false,
                        'value' => $cart['qty']
                    ),
                ));
            }
        } else {
            // กรณีที่ $request->cart เป็น null หรือไม่ใช่ array/object
            return redirect()->back()->with('error', 'Cart is empty or invalid.');
        }

        return redirect()->back();
    }

    public function cart_delete($id)
    {
        Cart::remove($id);
        return redirect()->back();
    }
}
