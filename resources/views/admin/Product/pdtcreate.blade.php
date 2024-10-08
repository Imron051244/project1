@extends('layouts.admin.navbar')


@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>เพิ่มสินค้า</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="basic-url">ประเภทสินค้า</label>
                                <select name="category_id" value="{{ old('category_id') }}" class="form-control">
                                    <option disabled selected>โปรดเลือกประเภทสิค้า</option>
                                    @foreach ($getCategory as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label>ชื่อสินค้า</label>
                                <input type="text" value="{{ old('title') }}" name="title" class="form-control">
                                @error('title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="basic-url">รูปภาพ</label>
                                <input type="file" class="form-control" name="image[]" multiple accept="image/*">
                                @error('image')
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