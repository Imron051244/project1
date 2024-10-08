@extends('layouts.admin.navbar')


@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>เพิ่มประเภทสินค้า</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <form action="#" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>ชื่อประเภท</label>
                                <input type="text" required value="{{old('title')}}" class="form-control" name="title">
                                @error('title')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <label for="basic-url">สถานะ</label>
                            <select name="status" class="form-control">
                                <option value="0">ขาย</option>
                                <option value="1">ไม่ขาย</option>
                            </select>
                            @error('status')
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