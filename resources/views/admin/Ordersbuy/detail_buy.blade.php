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
                                        <p><strong>วันที่สั่งซื้อ:</strong> {{$getdetailbuy->created_at}}</p>
                                        <p><strong>สถานะ:</strong> {{$getdetailbuy->status}} <span class="badge bg-warning"></span></p>
                                        <p><strong>วันที่เก็บสินค้าได้:</strong> {{$getdetailbuy->ready_date}}</p>
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
                                        <a type="button" href="#" class="btn btn-info">เพิ่มรายการรับซื้อ</a>
                                        <a type="button" href="#" class="btn btn-primary">ออกใบเสร็จ</a>
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
                                                <td>วันที่</td>
                                                <td>
                                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                        <a onclick="return confirm('คุณต้องการลบราคา หรือไม่ ?')"
                                                            type="button" href=""
                                                            class="btn btn-danger">ลบ</a>
                                                        <a class="btn btn-success" href="{{ route('edit_order_buy', $getbuy->id) }}">แก้ไข้</a>
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
