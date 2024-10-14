@extends('layouts.User.footer')

@section('content')

<div id="content" class="site-content">
    <!-- Breadcrumb -->
    <div id="breadcrumb">
        <div class="container">
            <h2 class="title">การซื้อขายสินค้า</h2>


        </div>
    </div>

    <div class="container">
        <div class="page-checkout">
            <div class="row">
                <div class="checkout-left col-lg-9 col-md-9 col-sm-9 col-xs-12">

                    @if (auth()->user()->type === 'ผู้ซื้อ')
                    <!-- Flash message -->
                    @if (session('successPD'))
                    <div class="alert alert-success">
                        {{ session('successPD') }}
                    </div>
                    @endif

                    @elseif (auth()->user()->type === 'ผู้ขาย')
                    <!-- Flash message -->
                    @if (session('successBS'))
                    <div class="alert alert-success">
                        {{ session('successBS') }}
                    </div>
                    @endif
                    @endif

                    <div class="panel-group" id="accordion">

                        <form action="{{url('place-order')}}" method="post">
                            {{ csrf_field()}}

                            @if (auth()->user()->type === 'ผู้ซื้อ')
                            <!-- ผู้ซื้อ -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse"
                                            data-parent="#accordion" href="#collapseOne">
                                            ผู้ซื้อ
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>First Name</label>
                                                <input type="text" value="{{ Auth::user()->name}}" name="name" class="form-control">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>




                                            <div class="col-md-6">
                                                <label>Last Name</label>
                                                <input type="text" value="{{ Auth::user()->last_name}}" name="last_Name" class="form-control">
                                                @error('last_Name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>


                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Phone</label>
                                                <input type="phone" value="{{ Auth::user()->phone}}" name="phone" class="form-control">
                                                @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Address </label>
                                                <input type="text" value="{{ Auth::user()->address}}" name="address" class="form-control">
                                                @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        @php
                                        $provinces = App\Models\provinces::all();
                                        @endphp

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Province</label>
                                                <select id="provinces" value="" name="province_id" class="form-control">
                                                    @foreach($provinces as $province)
                                                    <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                                        {{ $province->name_th }}
                                                        @endforeach
                                                </select>
                                                @error('province_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>District</label>
                                                <select id="amphures" name="district_id" class="form-control">
                                                    <!-- จะมีการเติมข้อมูลผ่าน Ajax -->
                                                </select>
                                                @error('district_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>SubDistrict</label>
                                                <select id="districts" name="subdistrict_id" class="form-control">
                                                    <!-- จะมีการเติมข้อมูลผ่าน Ajax -->
                                                </select>
                                                @error('subdistrict_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>zip code</label>
                                                <input class="form-control" type="text" id="zipcode" readonly>
                                                @error('zip_code')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            @elseif (auth()->user()->type === 'ผู้ขาย')
                            <!-- ผู้ขาย -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse"
                                            data-parent="#accordion" href="#collapseOne">
                                            ผู้ขาย
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label>ชื่อ</label>
                                                <input type="text" value="{{ Auth::user()->name}}" name="name" class="form-control">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>สกุล</label>
                                                <input type="text" value="{{ Auth::user()->last_name}}" name="last_Name" class="form-control">
                                                @error('last_Name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>เบอร์โทร</label>
                                                <input type="phone" value="{{ Auth::user()->phone}}" name="phone" class="form-control">
                                                @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>ที่อยู่</label>
                                                <input type="text" value="{{ Auth::user()->address}}" name="address" class="form-control">
                                                @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        @php
                                        $provinces = App\Models\provinces::all();
                                        @endphp

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>จังหวัด</label>
                                                <select id="provinces" value="" name="province_id" class="form-control">
                                                    @foreach($provinces as $province)
                                                    <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                                        {{ $province->name_th }}
                                                        @endforeach
                                                </select>
                                                @error('province_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>อำเภอ</label>
                                                <select id="amphures" name="district_id" class="form-control">
                                                    <!-- จะมีการเติมข้อมูลผ่าน Ajax -->
                                                </select>
                                                @error('district_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>ตำบล</label>
                                                <select id="districts" name="subdistrict_id" class="form-control">
                                                    <!-- จะมีการเติมข้อมูลผ่าน Ajax -->
                                                </select>
                                                @error('subdistrict_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>รหัสไปรษณี</label>
                                                <input class="form-control" type="text" id="zipcode" readonly>
                                                @error('zip_code')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- สินค้าที่ซื้อ -->
                            @if (auth()->user()->type === 'ผู้ซื้อ')
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse"
                                            data-parent="#accordion" href="#collapseThree">
                                            ราละเอียดสินค้า
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="accordion-body collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <table class="cart-summary table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="width-80 text-center">รูปภาพ</th>
                                                    <th>สินค้า/เกรด</th>
                                                    <th class="width-100 text-center">ราคา</th>
                                                    <th class="width-100 text-center">ปริมาณ/กีโลกรัม</th>
                                                    <th class="width-100 text-center">ยอดรวม</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach(Cart::getContent() as $key => $header_cart)
                                                @php
                                                $getCartProduct = App\Models\ProductModel::getSingle($header_cart->id);
                                                $getProductImage = $getCartProduct->getImageSingle($getCartProduct->id);
                                                $gradeName = $header_cart->attributes->grade_name ?? 'ไม่ระบุ';
                                                @endphp
                                                @if (!empty($getCartProduct))
                                                <tr>
                                                    <td>
                                                        <a href="product-detail-left-sidebar.html">
                                                            <img width="80" style="height:62px; width:62px;"
                                                                alt="Product Image" class="img-responsive"
                                                                src="{{ asset('upload/product/' . $getProductImage->image_name) }}">
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <a class="product-name">
                                                            <span style="font-weight: bold;">
                                                                {{ $header_cart->name }}
                                                            </span>
                                                            x {{$gradeName}}</a>
                                                    </td>
                                                    <td class="text-center">
                                                        ฿{{ $header_cart->price }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $header_cart->quantity }}
                                                    </td>
                                                    <td class="text-center">
                                                        ฿{{ $header_cart->price * $header_cart->quantity }}
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <h4 class="heading-primary">ยอดรายการสินค้า</h4>
                                        <table class="table cart-total">
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        ยอด
                                                    </th>
                                                    <td class="total">
                                                        ฿{{Cart::getTotal()}}
                                                    </td>
                                                </tr>
                                               
                                                <tr>
                                                    <th>
                                                        <strong>ยอดรวมทั้งหมด</strong>
                                                    </th>
                                                    <td name="total_prict" class="total">
                                                        <input type="hidden" name="total_prict"
                                                            value="{{Cart::getTotal()}}">
                                                        ${{Cart::getTotal()}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                       


                                        <div class="pull-right">
                                            <input type="submit" value="ยืนยันรายการ" class="btn btn-primary">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            @elseif (auth()->user()->type === 'ผู้ขาย')
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse"
                                            data-parent="#accordion" href="#collapseThree">
                                            ราละเอียดสินค้า
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="accordion-body collapse" style="height: 0px;">
                                    <div class="panel-body">

                                        <table class="cart-summary table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="width-80 text-center">รูปภาพ</th>
                                                    <th>สินค้า</th>
                                                    
                                                    <th class="width-100 text-center">Qty (คิดเป็นต้น)</th>
                                                    
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach(Cart::getContent() as $key => $header_cart)
                                                @php
                                                $getCartProduct = App\Models\ProductModel::getSingle($header_cart->id);
                                                $getProductImage = $getCartProduct->getImageSingle($getCartProduct->id);
                                                $gradeName = $header_cart->attributes->grade_name ?? 'ไม่ระบุ';
                                                @endphp
                                                @if (!empty($getCartProduct))
                                                <tr>
                                                    <td>
                                                        <a href="product-detail-left-sidebar.html">
                                                            <img width="80" style="height:62px; width:62px;"
                                                                alt="Product Image" class="img-responsive"
                                                                src="{{ asset('upload/product/' . $getProductImage->image_name) }}">
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <a class="product-name">
                                                            <span style="font-weight: bold;">
                                                                {{ $header_cart->name }}
                                                            </span>
                                                            </a>
                                                    </td>
                                                   
                                                    <td class="text-center">
                                                        {{ $header_cart->quantity }}
                                                    </td>
                                                    
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="pull-right">
                                            <input type="submit" value="ยืนยันรายการ" class="btn btn-primary">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>



                </div>

                <div class="checkout-right col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <h4 class="title">ยอดรายการสินค้า</h4>
                    <table class="table cart-total">
                        <tbody>
                            <tr class="cart-subtotal">
                                <th>
                                    <strong>ยอด</strong>
                                </th>
                                <td>
                                    <strong><span class="amount">${{Cart::getTotal()}}</span></strong>
                                </td>
                            </tr>
                            
                            <tr class="total">
                                <th>
                                    <strong>ยอดรวมทั่งหมด</strong>
                                </th>
                                <td>
                                    <strong><span class="amount">${{Cart::getTotal()}}</span></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('Ajax')
<script src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // โหลดข้อมูลอำเภอเมื่อมีการเลือกจังหวัด
        $('#provinces').change(function() {
            var provinceId = $(this).val();

            $.ajax({
                url: "{{ url('getAmphures') }}",
                type: 'GET',
                data: {
                    province_id: provinceId
                },
                success: function(response) {
                    $('#amphures').empty();
                    $('#amphures').append('<option>เลือกอำเภอ</option>');
                    $.each(response, function(key, value) {
                        $('#amphures').append('<option value="' + value.id + '">' + value.name_th + '</option>');
                    });
                }
            });
        });

        // โหลดข้อมูลตำบลเมื่อมีการเลือกอำเภอ
        $('#amphures').change(function() {
            var amphureId = $(this).val();

            $.ajax({
                url: "{{ url('getDistricts') }}",
                type: 'GET',
                data: {
                    amphure_id: amphureId
                },
                success: function(response) {
                    $('#districts').empty();
                    $('#districts').append('<option>เลือกตำบล</option>');
                    $.each(response, function(key, value) {
                        $('#districts').append('<option value="' + value.id + '">' + value.name_th + '</option>');
                    });
                }
            });
        });

        // โหลดรหัสไปรษณีย์เมื่อมีการเลือกตำบล
        $('#districts').change(function() {
            var districtId = $(this).val();

            $.ajax({
                url: "{{ url('getZipCode') }}",
                type: 'GET',
                data: {
                    district_id: districtId,
                },
                success: function(response) {
                    $('#zipcode').val(response);
                }
            });
        });
    });
</script>
@endsection