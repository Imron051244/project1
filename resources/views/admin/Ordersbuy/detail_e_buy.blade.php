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
                                <h4>รายละเอียดสินค้า</h4>

                                <div class="card-header-action">
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <a type="button" href="#" class="btn btn-info">กลับหน้าหลัก</a>
                                        <a type="button" href="#" class="btn btn-primary">กลับหน้ารายการ</a>
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
                                            <th>เกรดสินค้า</th>
                                            <th>จำนวน</th>
                                            <th>ราคาต่อหน่วย (฿)</th>
                                            <th>ราคารวม (฿)</th>
                                            <th>เพิ่มเติม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalAmount = 0; // ตัวแปรสำหรับเก็บยอดรวมทั้งหมด
                                        $total_QTY = 0;
                                        @endphp

                                        @if($getSingle->getbuys->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">ยังไม่มีรายการ</td>
                                            </tr>
                                        @else
                                            @foreach ($getSingle->getbuys as $product)
                                            @php
                                            $getCartProduct = App\Models\ProductModel::getSingle($product->getProduct->id);
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
                                                <td>{{ $product->getProduct->title }}</td>
                                                <td>{{ $product->grade }}</td>
                                                <td>{{ $product->qty_buy }}</td>
                                                <td>฿ {{ $product->price }}</td>
                                                <td>฿ {{ $product->price_total }}</td>
                                                <td>
                                                    <div class="card-header-action">
                                                        <div class="input-group">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-success" href="{{route('edit_e_buy', $product->id)}}">แก้ไข้</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                            // เพิ่มราคาของแต่ละรายการในยอดรวมทั้งหมด
                                            $totalAmount += $product->price_total;
                                            $total_QTY += $product->qty_buy;
                                            @endphp
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
        </div>
    </section>
</div>

@endsection
