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
                                <h4>ข้อมูลคำสั่งขาย</h4>
                            </div>

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
                                                รอวันเก็บเกียว
                                                @elseif($getdetailbuy->status == 3)
                                                สำเร็จ
                                                @elseif($getdetailbuy->status == 4)
                                                ยกเลิก
                                                @endif
                                            </span></p>
                                        <p><strong>วันที่เก็บสินค้าได้:</strong> {{ \Carbon\Carbon::parse($getdetailbuy->date_play)->locale('th')->translatedFormat('d M Y')}}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <h4>ข้อมูลผู้ขาย</h4>
                                        <p><strong>ชื่อผู้ขาย:</strong> {{$getdetailbuy->name}} {{$getdetailbuy->last_name}}</p>
                                        <p><strong>เบอร์โทรศัพท์:</strong> {{ substr($getdetailbuy->phone, 0, 3) }}-{{ substr($getdetailbuy->phone, 3, 3) }}-{{ substr($getdetailbuy->phone, 6) }}</p>
                                        <p><strong>ที่อยู่สวน:</strong> {{$getdetailbuy->address}} ตำบล {{$getdetailbuy->name_th}} อำเภอ {{$getdetailbuy->districts}} จังหวัด {{$getdetailbuy->provinces}} {{$getdetailbuy->zip_code}}</p>
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
                                <h4>รายละเอียดข้อมูลสินค้าที่ขาย</h4>

                                <div class="card-header-action">
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <a type="button" href="{{ route('list_order_buy') }}" class="btn btn-info">กลับหน้าหลัก</a>
                                        <a type="button" href="{{route('create_order_buy', $getSingle->id)}}" class="btn btn-primary">เพิ่มรายการรับซื้อ</a>
                                        
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
                                            <th>รูปสินค้า</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>ประมารสินค้า (คิดเป็นลูก)</th>
                                            <th>วันที่เก็บเกียวได้</th>
                                            <th>สถานะ</th>
                                            <th>เพิ่มเติม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalAmount = 0; // ตัวแปรสำหรับเก็บยอดรวมทั้งหมด
                                        $total_QTY = 0;
                                        @endphp

                                        @if($getSingle->getBuy->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">ยังไม่มีรายการ</td>
                                        </tr>
                                        @else
                                        @foreach ($getSingle->getBuy as $getbuy)
                                        @php
                                        $getCartProduct = App\Models\ProductModel::getSingle($getbuy->getProduct->id);
                                        $getProductImage = $getCartProduct->getImageSingle($getCartProduct->id);
                                        @endphp
                                        <tr>
                                            <td class="product-image">
                                                <a>
                                                    <img width="80" style="height: 63.11px; width:63.11px;" alt="Product Image"
                                                        class="img-responsive"
                                                        src="{{ asset('upload/product/' . $getProductImage->image_name) }}">
                                                </a>
                                            </td>
                                            <td>{{ $getbuy->getProduct->title }}</td>
                                            <td>{{ $getbuy->quantity }} ลูก</td>
                                            <td>{{ \Carbon\Carbon::parse($getbuy->date_play)->locale('th')->translatedFormat('d M Y')}}</td>
                                            <td>
                                                <div class="dropdown d-inline mr-2">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        @if($getbuy->status == 0)
                                                        รอการยืนยัน
                                                        @elseif($getbuy->status == 1)
                                                        รอการตรวจสอบ
                                                        @elseif($getbuy->status == 2)
                                                        ผ่านการตรวจสอบ
                                                        @elseif($getbuy->status == 3)
                                                        สำเร็จ
                                                        @elseif($getbuy->status == 4)
                                                        ยกเลิก
                                                        @endif
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <form action="{{route('status_e_buy', $getbuy->id)}}" method="post" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการอนุมัติคำสั่งขายนี้?');">
                                                            @csrf
                                                            <button class="dropdown-item" type="submit" name="status" value="1">รอการตรวจสอบ</button>
                                                            <button class="dropdown-item" type="submit" name="status" value="2">ผ่านการตรวจสอบ</button>
                                                            <button class="dropdown-item" type="submit" name="status" value="3">สำเร็จ</button>
                                                            <button class="dropdown-item" type="submit" name="status" value="4">ยกเลิก</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                    <a onclick="return confirm('คุณต้องการลบราคา หรือไม่ ?')"
                                                        type="button" href=""
                                                        class="btn btn-danger">ลบ</a>
                                                    <a class="btn btn-success" href="{{ route('edit_order_buy', $getbuy->id) }}">เพิ่มรับซื้อ</a>
                                                    <a type="button" href="{{ route('detail_e_buy', $getbuy->id) }}"
                                                        class="btn btn-warning">รายละเอียด</a>
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

            </div>
        </div>
    </section>
</div>

@endsection