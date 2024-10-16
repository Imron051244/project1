@extends('layouts.admin.navbar')

@section('content')

<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>แก้ไขการรับซื้อที่สวน</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('edit_e_save', $getSingle->id)}}" method="post">
                            <!-- Flash message -->

                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">
                                    <h4>แก้ไข้สินค้า</h4>

                                    <div class="card-header-action">
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <a type="button" href="#" class="btn btn-info">กลับหน้าหลัก</a>
                                        <a type="button" href="#" class="btn btn-primary">กลับหน้ารายการ</a>
                                    </div>
                                </div>


                                </div>
                                @if(session('successa'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                        {{ session('successa') }}
                                    </div>
                                </div>
                                @endif
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="inputAddress">ชื่อสินค้า</label>
                                        <input type="text" class="form-control" value="{{$getSingle->getProduct->title}}" readonly>
                                        <input type="hidden" name="product_id" value="{{$getSingle->getProduct->id}}">
                                    </div>


                                    <div id="Append">
                                        <!-- แถวเริ่มต้นสำหรับเกรด -->
                                        <div class="form-row" id="row_1">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">เกรด</label>
                                                <input type="text" name="grade" class="form-control" value="{{$getSingle->grade}}" readonly>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">ราคา</label>
                                                <input type="number" name="price" value="{{ old('price', $getSingle->price)}}" class="form-control price" data-row-id="1">
                                                @error('price')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">จำนวน</label>
                                                <input type="number" name="qty" value="{{ old('qty',$getSingle->qty_buy)}}" class="form-control qty" data-row-id="1">
                                                @error('qty')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
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