@extends('layouts.admin.navbar')


@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>แก้ไขสินค้า</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="basic-url">ประเภทสินค้า</label>
                                <select name="category_id" class="form-control">
                                    <option value="#" disabled selected>โปรดเลือกประเภทสิค้า</option>
                                    @foreach ($getCategory as $category)
                                        <option {{$category->id == $getRecord->category_id ? 'selected' : ''}}
                                            value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>ชื่อสินค้า</label>
                                <input type="text" value="{{ old('title', $getRecord->title) }}" name="title"
                                    class="form-control">
                                @error('title')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="basic-url">รูปภาพ</label>
                                <input type="file" class="form-control" name="image[]" multiple accept="image/*">
                            </div>

                            @if ($getRecord->getImage->count())
                                <div class="row" id="sortable">
                                    @foreach ($getRecord->getImage as $image)
                                        <div class="col-md-2 sortable_image" id="{{$image->id}}" style="text-align: center;">
                                            <img style="width:100%; height:anto;"
                                                src="{{ asset('upload/product/' . $image->image_name) }}" alt="Image"
                                                class="img-thumbnail">
                                            <a onclick="return confirm('คุณจะลบภาพสินค้านี้หรือไม่ ?')"
                                                href="{{route('delete_image', $image->id)}}" style="margin-top: 10px;"
                                                class="btn btn-danger btn-sm">ลบ</a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

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

@section('script')
<script src="{{asset('https://code.jquery.com/ui/1.13.3/jquery-ui.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#sortable").sortable({
            update: function (event, ui) {
                var photo_id = new Array();
                $('.sortable_image').each(function () {
                    var id = $(this).attr('id');
                    photo_id.push(id);
                });

                $.ajax({
                    url: "{{ route('image_sortable') }}",
                    type: 'POST',
                    data: {
                        "photo_id": photo_id,
                        "_token": "{{ csrf_token()}}"
                    },
                    dataType: "json",
                    success: function (data) {

                    },
                    error: function (data) {

                    }
                });
            }
        });
    });
</script>

@endsection