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
                            @if (!empty($getdetailsell))
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>หมายเลขคำสั่งซื้อ:</strong> {{$getdetailsell->users_sell_id}}</p>
                                        <p><strong>วันที่สั่งซื้อ:</strong> {{ \Carbon\Carbon::parse($getdetailsell->created_at)->locale('th')->translatedFormat('d M Y H:i')}}</p>
                                        <p><strong>สถานะ:</strong> <span class="badge bg-warning">
                                                @if($getdetailsell->status == 0)
                                                รอการยืนยัน
                                                @elseif($getdetailsell->status == 1)
                                                ยืนยันแล้ว
                                                @elseif($getdetailsell->status == 2)
                                                รอการชำระเงิน
                                                @elseif($getdetailsell->status == 3)
                                                ชำระเงินแล้ว
                                                @elseif($getdetailsell->status == 4)
                                                กำลังจัดเตรียมสินค้า
                                                @elseif($getdetailsell->status == 5)
                                                จัดเตรียมสำเร็จ
                                                @elseif($getdetailsell->status == 6)
                                                สำเร็จ
                                                @elseif($getdetailsell->status == 7)
                                                ยกเลิก
                                                @endif
                                            </span></p>
                                        <p><strong>วิธีการชำระเงิน:</strong> โอนผ่านธนาคาร</p>
                                    </div>

                                    <div class="col-md-6">
                                        <h4>ข้อมูลผู้รับ</h4>
                                        <p><strong>ชื่อผู้รับ:</strong> {{$getdetailsell->name}} {{$getdetailsell->last_name}}</p>
                                        <p><strong>เบอร์โทรศัพท์:</strong> {{ substr($getdetailsell->phone, 0, 3) }}-{{ substr($getdetailsell->phone, 3, 3) }}-{{ substr($getdetailsell->phone, 6) }}</p>
                                        <p><strong>ที่อยู่:</strong> {{$getdetailsell->address}} ตำบล {{$getdetailsell->name_th}}
                                            อำเภอ {{$getdetailsell->districts}} จังหวัด {{$getdetailsell->provinces}}
                                            {{$getdetailsell->zip_code}}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @elseif (!empty($getdetailbuy))
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>หมายเลขคำสั่งซื้อ:</strong> {{$getdetailbuy->users_buy_id}}</p>
                                        <p><strong>วันที่สั่งซื้อ:</strong> {{ \Carbon\Carbon::parse($getdetailbuy->created_at)->locale('th')->translatedFormat('d M Y H:i')}}</p>
                                        <p><strong>สถานะ:</strong> <span class="badge bg-warning">
                                                @if($getdetailbuy->status == 0)
                                                รอการยืนยัน
                                                @elseif($getdetailbuy->status == 1)
                                                ยืนยันแล้ว
                                                @elseif($getdetailbuy->status == 2)
                                                รอการชำระเงิน
                                                @elseif($getdetailbuy->status == 3)
                                                ชำระเงินแล้ว
                                                @elseif($getdetailbuy->status == 4)
                                                กำลังจัดเตรียมสินค้า
                                                @elseif($getdetailbuy->status == 5)
                                                จัดเตรียมสำเร็จ
                                                @elseif($getdetailbuy->status == 6)
                                                สำเร็จ
                                                @elseif($getdetailbuy->status == 7)
                                                ยกเลิก
                                                @endif
                                            </span></p>
                                        <p><strong>วิธีการชำระเงิน:</strong> โอนผ่านธนาคาร</p>
                                    </div>

                                    <div class="col-md-6">
                                        <h4>ข้อมูลผู้รับ</h4>
                                        <p><strong>ชื่อผู้รับ:</strong> {{$getdetailbuy->name}} {{$getdetailbuy->last_name}}</p>
                                        <p><strong>เบอร์โทรศัพท์:</strong> {{ substr($getdetailbuy->phone, 0, 3) }}-{{ substr($getdetailbuy->phone, 3, 3) }}-{{ substr($getdetailbuy->phone, 6) }}</p>
                                        <p><strong>ที่อยู่:</strong> {{$getdetailbuy->address}} ตำบล {{$getdetailbuy->name_th}}
                                            อำเภอ {{$getdetailbuy->districts}} จังหวัด {{$getdetailbuy->provinces}}
                                            {{$getdetailbuy->zip_code}}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>รายละเอียดสินค้า</h4>
                                @if (!empty($getdetailsell))
                                <div class="card-header-action">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <a class="btn btn-success" href="{{route('showReceipt')}}">ออกใบเสร็จ</a>
                                        </div>
                                    </div>
                                </div>
                                @endif


                                @if (!empty($getdetailbuy))
                                <div class="card-header-action">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <a class="btn btn-success" href="{{route('showReceipt')}}">ออกใบเสร็จ</a>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>



                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        @if (!empty($getdetailbuy))
                                        <tr>
                                            <th>ชื่อสินค้า</th>
                                            <th>รูปสินค้า</th>
                                            <th>ประมานกีต้น</th>
                                            <th>เกรดสินค้า</th>
                                            <th>จำนวน</th>
                                            <th>ราคาต่อหน่วย</th>
                                            <th>ราคารวม</th>
                                            <th>เพิ่มเติม</th>
                                        </tr>

                                        @elseif(!empty($getdetailsell))

                                        <tr>
                                            <th>ชื่อสินค้า</th>
                                            <th>รูปสินค้า</th>
                                            <th>เกรดสินค้า</th>
                                            <th>ปริมาณ</th>
                                            <th>ราคา/กิโลกรับ</th>
                                            <th>ราคารวม</th>
                                            <th>เพิ่มเติม</th>
                                        </tr>
                                        @endif
                                    </thead>
                                    <tbody>
                                        @if (!empty($getdetailsell))
                                        <!-- การซื้อ -->
                                        @foreach ($getSingle->getItem as $detailSell)

                                        @php
                                        $getCartProduct = App\Models\ProductModel::getSingle($detailSell->getProduct->id);
                                        $getProductImage = $getCartProduct->getImageSingle($getCartProduct->id);
                                        @endphp
                                        <tr>
                                            <td>{{$detailSell->getProduct->title}}</td>

                                            <td class="product-image">

                                                <a>
                                                    <img width="80" style="height: 63.11px; width:63.11px;" alt="Product Image"
                                                        class="img-responsive"
                                                        src="{{ asset('upload/product/' . $getProductImage->image_name) }}">
                                                </a>

                                            </td>
                                            <td>
                                                {{$detailSell->grade}}
                                            </td>

                                            <td>{{$detailSell->quantity}}</td>

                                            <td>฿ {{$detailSell->price}}</td>

                                            <td>฿ {{$detailSell->total_price}}</td>
                                            <td>
                                                <div class="card-header-action">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <a class="btn btn-success" href="#">แก้ไข้</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>



                                        </tr>
                                        @endforeach

                                        @elseif (!empty($getdetailbuy))
                                        <!-- การขาย -->
                                        @foreach ($getSingle->getItem as $detailbuy)
                                        @php
                                        $getCartProduct = App\Models\ProductModel::getSingle($detailbuy->getProduct->id);
                                        $getProductImage = $getCartProduct->getImageSingle($getCartProduct->id);
                                        @endphp
                                        <tr>
                                            <td>{{$detailbuy->getProduct->title}}</td>

                                            <td class="product-image">
                                                <a>
                                                    <img width="80" style="height: 63.11px; width:63.11px;" alt="Product Image"
                                                        class="img-responsive"
                                                        src="{{ asset('upload/product/' . $getProductImage->image_name) }}">
                                                </a>
                                            </td>

                                            <td>{{$getdetailbuy->quantity}}</td>

                                            <td>{{$detailbuy->grade}}</td>

                                            <td>{{$detailbuy->price}}</td>

                                            <td>{{$detailbuy->quantity}}</td>

                                            <td>{{$detailbuy->total_price}}</td>

                                            <td>
                                                <div class="card-header-action">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <a class="btn btn-success" href="#">แก้ไข้</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>

                                        </tr>
                                        @endforeach
                                        @endif


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
                            @if (!empty($getdetailsell))
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>ยอดรวมผมไม้:</strong> ฿ </p>
                                        <p><strong>ยอดรวมทั้งหมด:</strong> ฿ </p>

                                    </div>

                                    <div class="col-md-6">
                                        <h4>ยอดรวม</h4>
                                        <p><strong>ยอดรวมที่ต้องจ่าย:</strong> ฿ </p>

                                    </div>
                                </div>
                            </div>

                            @elseif (!empty($getdetailbuy))
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>ยอดรวมผมไม้:</strong> ฿ </p>
                                        <p><strong>ยอดรวมทั้งหมด:</strong> ฿ </p>

                                    </div>

                                    <div class="col-md-6">
                                        <h4>ยอดรวม</h4>
                                        <p><strong>ยอดรวมที่ต้องจ่าย:</strong> ฿ </p>

                                    </div>
                                </div>
                            </div>

                            @endif


                        </div>
                    </div>



                </div>


            </div>
    </section>
</div>


@endsection