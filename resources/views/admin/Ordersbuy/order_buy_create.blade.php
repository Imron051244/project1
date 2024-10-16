@extends('layouts.admin.navbar')

@section('content')

<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>การรับซื้อหน้าร้าน</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('create_order_save', $getSingle->id)}}" method="post">
                            <!-- Flash message -->
                           
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">
                                    <h4>เพิ่มสินค้าที่รับซื้อ</h4>
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="inputAddress">ชื่อสินค้า</label>
                                        <select name="product_id" id="product_id" class="form-control">
                                            <option disabled selected>โปรดเลือกสินค้า</option>
                                            @foreach ($getRecord as $product)
                                            <option value="{{$product->id}}">{{$product->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">จำนวนสินค้า</label>
                                        <input type="number" name="qty" class="form-control qty" data-row-id="1">
                                    
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <input type="submit" class="btn btn-primary mr-1" value="บันทึก">
                                </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </section>
</div>

@endsection