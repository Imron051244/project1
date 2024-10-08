@extends('layouts.admin.navbar')

@section('content')



<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>รายการรับซื้อ</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('order_create_save')}}" method="post">
                            @if (session('successd'))
                            <script>
                                alert("{{ session('successd') }}");
                            </script>
                            @endif
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">
                                    <h4>เพิ่มสินค้าที่รับซื้อ</h4>
                                </div>
                                <div class="card-body">

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">ชื่อ</label>
                                            <input type="text" name="name" class="form-control">
                                            @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">สกุล</label>
                                            <input type="text" name="last_name" class="form-control">
                                            @error('last_name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">เบอร์โทร</label>
                                            <input type="text" name="phone" class="form-control">
                                            @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputAddress">ชื่อสินค้า</label>

                                        <select name="product_id" id="product_id" class="form-control">
                                            <option disabled selected>โปรดเลือกประเภทสิค้า</option>
                                            @foreach ($getRecord as $product)
                                            <option value="{{$product->id}}">{{$product->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">เกรด</label>

                                            <select id="productGrade" name="grade" class="form-control">
                                                <option disabled selected>โปรดเลือกเกรด</option>

                                                
                                            </select>
                                            @error('grade')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">ราคา</label>
                                            <input type="text" id="price" name="price" class="form-control">
                                            @error('price')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPassword4">จำนวน</label>
                                            <input type="text" name="qty" class="form-control">
                                            @error('qty')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
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

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // โหลดเกรดเมื่อมีการเลือกสินค้า
        $('#product_id').change(function() {
            var productId = $(this).val();
            // alert(productId)

            $.ajax({
                url: "{{ route(name: 'grade') }}",
                type: 'GET',
                data: {
                    product_id: productId
                },
                success: function(response) {
                    // alert(response)

                    $.each(response, function(key, value) {
                        $('#productGrade').append('<option value="' + value.grade + '">' + value.grade + '</option>');
                    });
                }
            });
        });

        // โหลดราคาเมื่อมีการเลือกสินค้า
        $('#productGrade').change(function() {
            var grade = $(this).val();
            var productId = $('#product_id').val(); // ดึง product_id จากการเลือกสินค้า

            $.ajax({
                url: "{{ route(name: 'price_grade') }}",
                type: 'GET',
                data: {
                    product_id: productId, // ส่ง product_id
                    grade: grade // ส่ง grade ที่เลือก
                },
                success: function(response) {
                    $('#price').val(response);
                }
            });
        });
    });
</script>

@endsection


@endsection