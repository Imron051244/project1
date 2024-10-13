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
                        <form action="{{route('order_save_edit', $getSingle->id)}}" method="post">
                            <!-- Flash message -->

                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">
                                    <h4>แก้ไข้สินค้า</h4>
                                </div>
                                <div class="card-body">

                                    <!-- <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">ชื่อ</label>
                                            <input type="text" name="name" value="{{ old('name', $getSingle->name) }}" class="form-control">
                                            @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">สกุล</label>
                                            <input type="text" name="last_name" value="{{ old('last_name', $getSingle->last_name) }}" class="form-control">
                                            @error('last_name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">เบอร์โทร</label>
                                            <input type="tell" name="phone" value="{{ old('phone', $getSingle->phone )}}" class="form-control">
                                            @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div> -->

                                    <div class="form-group">
                                        <label for="inputAddress">ชื่อสินค้า</label>
                                        <select name="product_id" id="product_id" class="form-control">
                                            <option disabled selected>โปรดเลือกสินค้า</option>
                                            @foreach ($getRecord as $product)
                                            <option value="{{$product->id}}" {{ old('product_id', $getSingle->product_id ?? '') == $product->id ? 'selected' : '' }}>
                                                {{$product->title}}
                                            </option>

                                            @endforeach
                                        </select>
                                        @error('product_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>

                                    <div id="Append">
                                        <!-- แถวเริ่มต้นสำหรับเกรด -->
                                        <div class="form-row" id="row_1">
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">เกรด</label>
                                                <select name="grade" value="{{ old('grade', default: $getSingle->grade )}}" class="form-control productGrade" data-row-id="1">
                                                    <option disabled selected>โปรดเลือกเกรด</option>
                                                </select>
                                                @error('grade')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">ราคา</label>
                                                <input type="number" name="price" value="{{ old('price', $getSingle->price )}}" class="form-control price" data-row-id="1">
                                                @error('price')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">จำนวน</label>
                                                <input type="number" name="qty" value="{{ old('qty', $getSingle->qty_buy )}}" class="form-control qty" data-row-id="1">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // โหลดเกรดเมื่อมีการเลือกสินค้า
        $('#product_id').change(function() {
            var productId = $(this).val();

            $.ajax({
                url: "{{ route('grade') }}",
                type: 'GET',
                data: {
                    product_id: productId
                },
                success: function(response) {
                    // ลบเกรดที่มีอยู่และเพิ่มเกรดใหม่
                    $('.productGrade').each(function(index, element) {
                        var rowId = $(element).data('row-id');
                        $(element).empty();
                        $(`#row_${rowId} .productGrade`).append(`<option disabled selected>โปรดเลือกเกรด</option>`);
                        $.each(response, function(key, value) {

                            $(`#row_${rowId} .productGrade`).append(`<option value="${value.grade}">${value.grade}</option>`);
                        });
                    });
                }
            });
        });

        // โหลดราคาเมื่อมีการเลือกเกรด
        $('body').on('change', '.productGrade', function() {
            var grade = $(this).val();
            var rowId = $(this).data('row-id');
            var productId = $('#product_id').val();

            $.ajax({
                url: "{{ route('price_grade') }}",
                type: 'GET',
                data: {
                    product_id: productId,
                    grade: grade
                },
                success: function(response) {
                    $(`#row_${rowId} .price`).val(response);
                }
            });
        });
    });
</script>

@endsection