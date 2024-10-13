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
                        <form action="{{route('order_e_save', $getSingle->id)}}" method="post">
                            <!-- Flash message -->
                           
                            {{ csrf_field() }}
                            <div class="card">
                                <div class="card-header">
                                    <h4>เพิ่มสินค้าที่รับซื้อ</h4>
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="inputAddress">ชื่อสินค้า</label>
                                        <select name="product_id" id="product_id" class="form-control">
                                            <option disabled selected>โปรดเลือกสินค้า</option>
                                            @foreach ($getRecord as $product)
                                            <option value="{{$product->id}}">{{$product->title}}</option>
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
                                                <select name="grade[]" class="form-control productGrade" data-row-id="1">
                                                    <option disabled selected>โปรดเลือกเกรด</option>
                                                </select>
                                                @error('grade')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">ราคา</label>
                                                <input type="number" name="price[]" class="form-control price" data-row-id="1">
                                                @error('price')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4">จำนวน</label>
                                                <input type="number" name="qty[]" class="form-control qty" data-row-id="1">
                                                @error('qty')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer text-right">
                                    <input type="button" class="btn btn-success mr-1 Addgrade" value="เพิ่มเกรดสินค้า">
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
    var i = 2; // ตั้งค่าตัวแปรเริ่มต้นที่ 2 เพราะแถวแรกมีแล้ว
    var maxRows = 3; // จำกัดจำนวนแถวที่สามารถเพิ่มได้

    $('body').on('click', '.Addgrade', function() {
        if (i <= maxRows) {
            // HTML ที่จะแสดงเมื่อคลิกปุ่ม Add
            var html = `
            <div class="form-row" id="row_${i}">
                <div class="form-group col-md-4">
                    <label for="inputEmail4">เกรด</label>
                    <select name="grade[]" class="form-control productGrade" data-row-id="${i}">
                        <option disabled selected>โปรดเลือกเกรด</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">ราคา</label>
                    <input type="number" name="price[]" class="form-control price" data-row-id="${i}">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">จำนวน</label>
                    <input type="number" name="qty[]" class="form-control qty" data-row-id="${i}">
                </div>
            </div>
            `;
            i++;
            $('#Append').append(html);

            // ถ้าจำนวนแถวถึงขีดจำกัดแล้ว ให้ปิดการใช้งานปุ่ม "เพิ่มเกรดสินค้า"
            if (i > maxRows) {
                $('.Addgrade').attr('disabled', true); // ปิดการใช้งานปุ่ม
                alert("สามารถเพิ่มเกรดได้ 3 เกรด");
            }
        }
    });




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