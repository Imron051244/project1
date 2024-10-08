<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NotificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderModel;
use App\Models\User;
use App\Models\AmphuresModel;
use App\Models\CustomerAddressModel;
use App\Models\CustomerModel;
use App\Models\DistrictsModel;
use App\Models\ProvincesModel;
use App\Models\ProductWishlistModel;
use App\Models\ProductReviewModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $data['meta_title'] = 'Dashboard';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';

        $data['TotalOrder'] = OrderModel::getTotalOrderUser(Auth::user()->id);
        $data['TotalTodayOrder'] = OrderModel::getTotalTodayOrderUser(Auth::user()->id);
        $data['TotalAmount'] = OrderModel::getTotalAmountUser(Auth::user()->id);
        $data['TotalTodayAmount'] = OrderModel::getTotalTodayAmountUser(Auth::user()->id);

        $data['TotalPencing'] = OrderModel::getTotalStatusUser(Auth::user()->id, 0);
        $data['TotalInprogress'] = OrderModel::getTotalStatusUser(Auth::user()->id, 1);
        $data['TotalComplete'] = OrderModel::getTotalStatusUser(Auth::user()->id, 3);
        $data['TotalCancelled'] = OrderModel::getTotalStatusUser(Auth::user()->id, 4);

        return view('user.dashboard', $data);
    }
    public function orders(Request $request)
    {
        if (!empty($request->noti_id)) {
            NotificationModel::updateReadNoti($request->noti_id);
        }
        $data['getRecord'] = OrderModel::getRecordUser(Auth::user()->id);
        $data['meta_title'] = 'Orders';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';
        return view('user.orders', $data);
    }
    public function orders_detail(Request $request, $id)
    {
        if (!empty($request->noti_id)) {
            NotificationModel::updateReadNoti($request->noti_id);
        }
        $data['getRecord'] = OrderModel::getSingleUser(Auth::user()->id, $id);
        $data['meta_title'] = 'Orders Detail';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';
        return view('user.orders_detail', $data);
    }
    public function orders_confirmReceipt($id, $order_number)
    {
        $order = OrderModel::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if ($order && $order->status == 3 || $order->status == 2) {
            $order->status = 5;
            $order->is_payment = 1;
            $order->updated_at = Carbon::now();
            $order->save();

            $user_id = 1;
            $url = url('admin/orders/detail/' . $id);
            $message = "Customer Confirm Receipt Order #" . $order_number;
            NotificationModel::insertRecord($user_id, $url, $message);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function orders_cancelOrder($id, $order_number)
    {
        $order = OrderModel::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if ($order && $order->status == 0) {
            $order->status = 4;
            $order->is_payment = 0;
            $order->updated_at = Carbon::now();
            $order->save();

            $user_id = 1;
            $url = url('admin/orders/detail/' . $id);
            $message = "Customer Cancel Order #" . $order_number;
            NotificationModel::insertRecord($user_id, $url, $message);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function edit_profile()
    {
        $data['meta_title'] = 'Edit Profile';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';

        $data['getRecord'] = CustomerModel::getFindUsersId(Auth::user()->id);
        $data['getUser'] = User::getSingle(Auth::user()->id);

        return view('user.edit_profile', $data);
    }
    public function update_profile(Request $request)
    {
        $user = CustomerModel::getFindUsersId(Auth::user()->id);
        $user->first_name = trim($request->first_name);
        $user->last_name = trim($request->last_name);
        $user->gender = trim($request->gender);
        $user->birthdate = trim($request->birthdate);
        $user->phone = trim($request->phone);
        $user->save();

        return redirect()->back()->with('success', "Profile successfully updated");
    }

    // ที่อยู่
    public function customer_address()
    {
        $data['meta_title'] = 'Address';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';

        $userId = Auth::user()->id;
        $data['getRecord'] = CustomerAddressModel::with(['province', 'amphure', 'district'])->where('user_id', $userId)->get();

        $data['getUser'] = User::getSingle(Auth::user()->id);

        return view('user.customer_address', $data);
    }

    public function add_address()
    {
        $data['meta_title'] = 'Address';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';

        $data['getProvinces'] = ProvincesModel::getRecord();

        return view('user.address.add', $data);
    }
    public function insert_address(Request $request)
    {
        $checkDefaultAddress = CustomerAddressModel::where('user_id', Auth::user()->id)->exists();
        $address = new CustomerAddressModel;
        $address->user_id = Auth::user()->id;
        $address->provinces_id = trim($request->provinces_id);
        $address->amphures_id = trim($request->amphures_id);
        $address->districts_id = trim($request->districts_id);
        $address->zip_code = trim($request->zip_code);
        $address->country = trim($request->country);
        if (!$checkDefaultAddress) {
            $address->is_default = 1;
        }
        $address->save();

        return redirect("user/customer-address")->with('success', "Add Address successfully");
    }
    public function edit_address($address_id)
    {
        $getaddress = CustomerAddressModel::getSingle($address_id);
        if (!empty($getaddress)) {
            $data['meta_title'] = 'Edit Address';

            $data['getAddress'] = $getaddress;
            $data['getProvinces'] = ProvincesModel::getRecord();
            $data['getAmphures'] = AmphuresModel::getRecordAmphures($getaddress->provinces_id);
            $data['getDistricts'] = DistrictsModel::getRecordDistricts($getaddress->amphures_id);

            return view('user.address.detail', $data);
        }
    }
    public function update_address($address_id, Request $request)
    {
        $getaddress = CustomerAddressModel::getSingle($address_id);

        if (!empty($getaddress)) {
            $getaddress->provinces_id = trim($request->provinces_id);
            $getaddress->amphures_id = trim($request->amphures_id);
            $getaddress->districts_id = trim($request->districts_id);
            $getaddress->zip_code = trim($request->zip_code);
            $getaddress->country = trim($request->country);
            $getaddress->is_default = !empty($request->default) ? 1 : 0;
            $getaddress->save();

            return redirect()->back()->with('success', "Address Successfully Update");
        } else {
            abort(404);
        }
    }
    public function delete_address($id)
    {
        $address = CustomerAddressModel::find($id);

        if (!$address) {
            return redirect()->back()->with('error', "Address not found");
        }

        $address->delete();

        return redirect()->back()->with('success', "Address successfully deleted");
    }
    public function updateDefaultAddress($addressId)
    {
        $user_id = Auth::user()->id;

        CustomerAddressModel::where('user_id', $user_id)->update(['is_default' => 0]);

        CustomerAddressModel::where('id', $addressId)->update(['is_default' => 1]);

        return redirect()->back()->with('success', 'Default address updated successfully');
    }
    // จบที่อยู่


    //  จ. อ. ต.
    public function get_amphures(Request $request)
    {
        $provinces_id = $request->provinces_id;
        $get_amphures = AmphuresModel::getRecordAmphures($provinces_id);
        $html = '';
        $html .= '<option value="">Select</option>';
        foreach ($get_amphures as $value) {
            $html .= '<option value="' . $value->id . '">' . $value->name . '</option>';
        }
        $json['html'] = $html;
        echo json_encode($json);
    }
    public function get_districts(Request $request)
    {
        $amphures_id = $request->amphures_id;
        $get_amphures = DistrictsModel::getRecordDistricts($amphures_id);
        $html = '';
        $html .= '<option value="">Select</option>';
        foreach ($get_amphures as $value) {
            $html .= '<option value="' . $value->id . '">' . $value->name . '</option>';
        }
        $json['html'] = $html;
        echo json_encode($json);
    }
    public function get_zip_code(Request $request)
    {
        $zip_code = $request->zip_code;
        $get_amphures = DistrictsModel::getZipcode($zip_code);
        echo $get_amphures;
    }
    // จบ จ. อ. ต.

    public function notification()
    {
        $data['meta_title'] = 'Notification';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';
        $data['getRecord'] = NotificationModel::getRecordUser(Auth::user()->id);
        return view('user.notification', $data);
    }
    public function change_password()
    {
        $data['meta_title'] = 'Change Password';
        $data['meta_description'] = '';
        $data['meta_keyword'] = '';
        return view('user.change_password', $data);
    }
    public function update_password(Request $request)
    {
        $user = User::getSingle(Auth::user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            if ($request->password == $request->cpassword) {
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect()->back()->with('success', "Password successfully updated.");
            } else {
                return redirect()->back()->with('error', "New Password and Comfirm Password does not match.");
            }
        } else {
            return redirect()->back()->with('error', "Old Password is not cerrect.");
        }
    }
    public function add_to_wishlist(Request $request)
    {
        $user_id = Auth::user()->id;
        if (empty(ProductWishlistModel::checkAlready($request->product_id, $user_id))) {
            $save = new ProductWishlistModel;
            $save->product_id = $request->product_id;
            $save->user_id = $user_id;
            $save->save();
            $json['is_wishlist'] = 1;
        } else {
            ProductWishlistModel::DeleteRecord($request->product_id, $user_id);
            $json['is_wishlist'] = 0;
        }
        $json['status'] = true;
        echo json_encode($json);
    }
    public function submit_review(Request $request)
    {
        $save = new ProductReviewModel;
        $save->product_id = trim($request->product_id);
        $save->order_id = trim($request->order_id);
        $save->user_id = Auth::user()->id;
        $save->rating = trim($request->rating);
        $save->review = trim($request->review);
        $save->save();

        return redirect()->back()->with('success', "Thank you for your review");
    }
}
