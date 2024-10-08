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
                        <form action="#" method="post">
                            {{ csrf_field() }}

                            <div class="card">
                                <div class="card-header">
                                    <h4>เพิ่มสินค้าที่รับซื้อ</h4>
                                </div>
                                <div class="card-body">


                                    @foreach ($getSingle->getItem as $itam)

                                    <div class="form-group">
                                        <label for="inputAddress">ชื่อสินค้า</label>

                                        <input type="text" id="product_id" class="form-control" value="{{old('title', $itam->getProduct->title)}}" readonly>

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">เกรด</label>

                                            <select id="productGrade" name="grade" class="form-control">
                                                <option value="#" selected disabled>เลือกเกรด</option>
                                                @foreach ($getProductPrices as $grade)
                                                <option value="{{$grade->grade}}">
                                                    {{$grade->grade}}
                                                </option>
                                                @endforeach

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
                                    @endforeach

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

        // โหลดราคาเมื่อมีการเลือกสินค้า
        $('#productGrade').change(function() {
            var grade = $(this).val();

            $.ajax({
                url: "{{ route(name: 'price_grade') }}",
                type: 'GET',
                data: {
                    price: grade, // ส่ง product_id
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