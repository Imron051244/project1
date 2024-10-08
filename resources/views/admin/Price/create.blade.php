@extends('layouts.admin.navbar')


@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>เพิ่มราคา</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('price_save')}}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="basic-url">ชื่อสินค้า</label>
                                <select name="product_id" id="product_id" class="form-control">
                                    <option disabled {{ old('product_id') ? '' : 'selected' }}>โปรดเลือกประเภทสินค้า</option>
                                    @foreach ($getProduct as $product)
                                    <option value="{{$product->id}}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{$product->title}}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="basic-url">เกรดสินค้า</label>
                                <select name="grade" id="grade" class="form-control">
                                    <option disabled {{ old('grade') ? '' : 'selected' }}>โปรดเลือกเกรดสินค้า</option>
                                    <option value="LA (ใหญ่ สวย)" {{ old('grade') == 'LA (ใหญ่ สวย)' ? 'selected' : '' }}>LA (ใหญ่ สวย)</option>
                                    <option value="MA (กลาง สวย)" {{ old('grade') == 'MA (กลาง สวย)' ? 'selected' : '' }}>MA (กลาง สวย)</option>
                                    <option value="SA (เล็ก สวย)" {{ old('grade') == 'SA (เล็ก สวย)' ? 'selected' : '' }}>SA (เล็ก สวย)</option>
                                </select>
                                @error('grade')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>ราคาขาย</label>
                                <input type="text" class="form-control" name="price_sell" value="{{ old('price_sell') }}">
                                @error('price_buy')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>ราคารับซื้อ</label>
                                <input type="text" class="form-control" name="price_buy" value="{{ old('price_buy') }}">
                                @error('price_sell')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
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