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
                          
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>รายละเอียดสินค้า</h4>

                               
                                <div class="card-header-action">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <a class="btn btn-success" href="{{route('showReceipt_sell', $getSingle->id )}}">ออกใบเสร็จ</a>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="card-body">
                                @if(session('successa'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                        {{ session('successa') }}
                                    </div>
                                </div>
                                @endif
                                <table class="table">

                                    <thead>
                                

                                        <tr>
                                            <th>ชื่อสินค้า</th>
                                            <th>รูปสินค้า</th>
                                            <th>เกรดสินค้า</th>
                                            <th>ปริมาณกีโลกรัม</th>
                                            <th>ราคา/กิโลกรัม</th>
                                            <th>ราคารวม</th>
                                            <th>เพิ่มเติม</th>
                                        </tr>
                                      
                                    </thead>
                                    <tbody>
                                    
                                        @php
                                        $totalAmount = 0; // ตัวแปรสำหรับเก็บยอดรวมทั้งหมด
                                        $total_QTY = 0;
                                        @endphp

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
                                                            <a class="btn btn-success" href="{{route('order_editsell', $getSingle->id)}}">แก้ไข้</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        @php
                                        // เพิ่มราคาของแต่ละรายการในยอดรวมทั้งหมด
                                        $totalAmount += $detailSell->total_price;
                                        $total_QTY += $detailSell->quantity
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
                                        <p><strong>ยอดรวมผมไม้:</strong> {{$total_QTY}} กีโลกรัม</p>
                                        <p><strong>ยอดรวมทั้งหมด:</strong> ฿ {{ number_format($totalAmount, 2) }} </p>

                                    </div>

                                    <div class="col-md-6">
                                        <h4>ยอดรวม</h4>
                                        <p><strong>ยอดรวมที่ต้องจ่าย:</strong> ฿ {{ number_format($totalAmount, 2) }} </p>

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