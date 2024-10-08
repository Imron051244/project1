@extends('layouts.admin.navbar')


@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>แก้ไขประเภทสินค้า</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <form action="#" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>ชื่อประเภท</label>
                                <input type="text" required value="{{old('title', $getRecord->title)}}" class="form-control" name="title">
                                @error('title')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                    </div>

                    <div class="card-footer text-right">
                        <input type="submit" class="btn btn-primary mr-1" value="บันทึก">

                    </div>
                    </form>
                </div>

            </div>

        </div>



    </section>
</div>
@endsection