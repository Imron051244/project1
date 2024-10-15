@extends('layouts.admin.navbar')

@section('content')

<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>รายละเอียด</h1>


        </div>

        <div class="row">
            <div class="col-12">


                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>ข้อมูลคำสั่งซื้อ</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>หมายเลขคำสั่งซื้อ:</strong> {{$getdetail->home_id}} </p>
                                        <p><strong>วันที่สั่งซื้อ:</strong> {{ \Carbon\Carbon::parse($getdetail->created_at)->locale('th')->translatedFormat('d M Y H:i')}}</p>
                                        <p><strong>สถานะ:</strong> <span class="badge bg-warning">
                                                @if($getdetail->status == 0)
                                                รอการยืนยัน
                                                @elseif($getdetail->status == 1)
                                                ยืนยันแล้ว

                                                @elseif($getdetail->status == 2)
                                                สำเร็จ
                                                @elseif($getdetail->status == 3)
                                                ยกเลิก
                                                @endif
                                            </span></p>

                                    </div>

                                    <div class="col-md-6">
                                        <h4>ข้อมูลผู้ขาย</h4>
                                        <p><strong>ชื่อผู้ขาย:</strong> {{$getdetail->name}} {{$getdetail->last_name}}</p>
                                        <p><strong>เบอร์โทรศัพท์:</strong> {{ substr($getdetail->phone, 0, 3) }}-{{ substr($getdetail->phone, 3, 3) }}-{{ substr($getdetail->phone, 6) }}</p>


                                        </p>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>รายละเอียดสินค้า</h4>

                                <div class="card-header-action">
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <a type="button" href="{{route('order_e_create', $getdetail->id)}}"
                                            class="btn btn-info">เพิ่มรายการรับซื้อ</a>

                                        <a type="button" href="{{route('showReceipt_buyhome', $getdetail->id )}}"
                                            class="btn btn-primary">ออกใบเสร็จ</a>

                                    </div>
                                </div>
                            </div>


                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        @if(session('successs'))
                                        <div class="alert alert-success alert-dismissible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                                {{ session('successs') }}
                                            </div>
                                        </div>

                                        @endif
                                        <tr>
                                            <th>ชื่อสินค้า</th>
                                            <th>รูปสินค้า</th>
                                            <th>เกรดสินค้า</th>
                                            <th>ปริมาณ/กีโลกรัม</th>
                                            <th>ราคา/กิโลกรัม</th>
                                            <th>ราคารวม</th>
                                            <th>เพิ่มเติม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalAmount = 0;
                                        $total_QTY = 0;
                                        @endphp

                                        @foreach ($getdetail->getItem as $getdetail)
                                        @php
                                        $getCartProduct = App\Models\ProductModel::getSingle($getdetail->getProduct->id);
                                        $getProductImage = $getCartProduct->getImageSingle($getCartProduct->id);
                                        @endphp
                                        <tr>
                                            <td>{{$getdetail->getProduct->title}}</td>

                                            <td class="product-image">

                                                <a>
                                                    <img width="80" style="height: 63.11px; width:63.11px;" alt="Product Image"
                                                        class="img-responsive"
                                                        src="{{ asset('upload/product/' . $getProductImage->image_name) }}">
                                                </a>

                                            </td>
                                            <td>{{$getdetail->grade}}</td>

                                            <td>{{$getdetail->qty_buy}}</td>

                                            <td>฿ {{$getdetail->price}} </td>

                                            <td>฿ {{$getdetail->price_total}} </td>
                                            <td>
                                                <div class="card-header-action">
                                                    <div class="input-group">
                                                        <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                            <a onclick="return confirm('คุณต้องการลบราคา หรือไม่ ?')"
                                                                type="button" href="{{route('ordder_home_delete', $getdetail->id )}}"
                                                                class="btn btn-danger">ลบ</a>
                                                            <a class="btn btn-success" href="{{route('order_home_edit', $getdetail->id )}}">แก้ไข้</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                        // เพิ่มราคาของแต่ละรายการในยอดรวมทั้งหมด
                                        $totalAmount += $getdetail->price_total;
                                        $total_QTY += $getdetail->qty_buy
                                        @endphp

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>สรุปรายการสินค้า</h4>
                            </div>


                            <div class="card-body">
                                <div class="row">



                                    <div class="col-md-6">
                                        <p><strong>ยอดรวมผมไม้:</strong> ฿ {{$total_QTY}} </p>
                                        <p><strong>ยอดรวมทั้งหมด:</strong> ฿ {{$totalAmount}} </p>
                                    </div>

                                    <div class="col-md-6">
                                        <h4>ยอดรวม</h4>
                                        <p><strong>ยอดรวมที่ต้องจ่าย:</strong> ฿ {{$totalAmount}} </p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>


            </div>
    </section>
</div>


@endsection