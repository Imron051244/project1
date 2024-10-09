@extends('layouts.admin.navbar')


@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>แก้ไข้ราคาสินค้า</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="basic-url">ชื่อสินค้า</label>
                                <select name="product_id" class="form-control" disabled>
                                    <option disabled selected>โปรดเลือกสินค้า</option> <!-- เพิ่มออปชันนี้เพื่อแนะนำ -->
                                    @foreach ($getProduct as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id', $getRecord->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="basic-url">เกรดสินค้า</label>
                                <select name="grade" class="form-control" disabled>
                                    <option value="#" disabled {{ old('grade', $getRecord->grade) ? '' : 'selected' }}>โปรดเลือกเกรดสินค้า</option>
                                    <option value="LA (ใหญ่ สวย)" {{ old('grade', $getRecord->grade) == 'LA (ใหญ่ สวย)' ? 'selected' : '' }}>LA (ใหญ่ สวย)</option>
                                    <option value="MA (กลาง สวย)" {{ old('grade', $getRecord->grade) == 'MA (กลาง สวย)' ? 'selected' : '' }}>MA (กลาง สวย)</option>
                                    <option value="SA (เล็ก สวย)" {{ old('grade', $getRecord->grade) == 'SA (เล็ก สวย)' ? 'selected' : '' }}>SA (เล็ก สวย)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>ราคาขาย</label>
                                <input type="text" class="form-control" name="price_sell"
                                    value="{{ old('price', $getRecord->price_sell) }}">

                            </div>

                            <div class="form-group">
                                <label>ราคารับซื้อ</label>
                                <input type="text" class="form-control" name="price_buy"
                                    value="{{ old('price', $getRecord->price_buy) }}">
                            </div>

                            <div class="form-group">
                                <label>จำนวนสินค้า</label>
                                <input type="text" value="{{ old('qty', $getRecord->qty) }}" name="qty"
                                    class="form-control">
                                @error('title')
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