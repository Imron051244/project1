@extends('layouts.User.footer')

@section('content')
<div id="content" class="site-content">
    <!-- Breadcrumb -->
    <div id="breadcrumb">
        <div class="container">
            <h2 class="title">{{$getProductDetail->title}}</h2>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div id="left-column" class="sidebar col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <!-- Block - Product Categories -->
                <div class="block product-categories">
                    <h3 class="block-title">ประเภทสินค้า</h3>
                    @php
                    $getCategory = App\Models\CategoryModel::getRecordMenu();
                    @endphp

                    @foreach ($getCategory as $CategoryName)
                    <div class="block-content">
                        <div class="item">
                            <a class="category-title" href="{{route('categoryName', $CategoryName->title)}}">
                                {{ $CategoryName->title }}
                            </a>
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>

            <!-- Page Content -->
            <div id="center-column" class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="product-detail">
                    <div class="products-block layout-5">
                        <div class="product-item">
                            <div class="product-title">
                                {{$getProductDetail->title}}
                            </div>

                            <div class="row">

                                @php
                                $getProductImage = $getProductDetail->getImageSingle($getProductDetail->id);
                                @endphp

                                <div class="product-left col-md-5 col-sm-5 col-xs-12">
                                    <div class="product-image horizontal">

                                        <div class="main-image">
                                            @if (!empty($getProductImage) && !empty($getProductImage->image_name))
                                            <img class="img-responsive"
                                                src="{{ asset('upload/product/' . $getProductImage->image_name) }}"
                                                alt="Product Image">
                                            @endif
                                        </div>

                                        <div class="thumb-images owl-theme owl-carousel">
                                            @foreach ($getProductDetail->getImage as $image)
                                            <img class="img-responsive"
                                                src="{{ asset('upload/product/' . $image->image_name) }}"
                                                alt="Product Image">
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                                <div class="product-right col-md-7 col-sm-7 col-xs-12">
                                    <div class="product-info">
                                        <!-- Flash message -->
                                        @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif

                                        <form action="{{url('add-to-cart')}}" method="post">
                                            {{ csrf_field()}}
                                            @if (auth()->check() && auth()->user()->type === 'ผู้ขาย')
                                            <input type="hidden" name="product_id" value="{{ $getProductDetail->id }}">
                                            @else
                                            <input type="hidden" id="product_id" name="product_id" value="{{ $getProductDetail->id }}">
                                            @endif


                                            @if (auth()->check() && auth()->user()->type === 'ผู้ซื้อ')
                                            <!-- แสดงเฉพาะราคาขายสำหรับผู้ซื้อ -->
                                            <div class="product-price">
                                                <span id="productSellPrice" class="sale-price">
                                                    ราคาขาย ฿{{$getProductDetail->price_buy }}
                                                </span>
                                            </div>
                                            @elseif (auth()->check() && auth()->user()->type === 'ผู้ขาย')
                                            <!-- แสดงเฉพาะราคาขายสำหรับผู้ขาย -->
                                            <div class="product-price">
                                                <span id="productPrice" class="sale-price">
                                                    ราคาซื้อ ฿{{$getProductDetail->price_sell}}
                                                </span>
                                            </div>
                                            @else
                                            <!-- แสดงทั้งราคาซื้อและราคาขายสำหรับผู้ใช้ที่ไม่ได้เข้าสู่ระบบหรือไม่ใช่ผู้ซื้อ -->
                                            <div class="product-price">
                                                <span id="productPrice" class="sale-price">
                                                    ราคารับซื้อ ฿{{$getProductDetail->price_sell }}
                                                </span>
                                            </div>
                                            <p></p>
                                            <div class="product-price">
                                                <span id="productSellPrice" class="sale-price">
                                                    ราคาขาย ฿{{$getProductDetail->price_buy}}
                                                </span>
                                            </div>
                                            @endif

                                            @if (auth()->check() && auth()->user()->type === 'ผู้ขาย')
                                            <div class="product-variants border-bottom">
                                                <div class="product-variants-item">
                                                    <span class="control-label">เกรด :</span>

                                                    <select id="productGrade">
                                                        <option value="#" selected disabled>เลือกเกรด</option>
                                                        @foreach ($getProductPrices as $grade)
                                                        <option value="{{$grade->grade}}">
                                                            {{$grade->grade}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!-- @error('grade')
                                                <span class="text-danger" style="color: red;">{{$message}}</span>
                                                @enderror -->

                                            </div>

                                            @else
                                            <div class="product-variants border-bottom">
                                                <div class="product-variants-item">
                                                    <span class="control-label">เกรด :</span>

                                                    <select id="productGrade" name="grade" required>
                                                        <option value="#" selected disabled>เลือกเกรด</option>
                                                        @foreach ($getProductPrices as $grade)
                                                        <option value="{{$grade->grade}}">
                                                            {{$grade->grade}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                @error('grade')
                                                <span class="text-danger" style="color: red;">{{$message}}</span>
                                                @enderror
                                            </div>
                                            @endif

                                            @if (auth()->check() && auth()->user()->type === 'ผู้ขาย')
                                            <!-- แสดงเฉพาะราคาขายสำหรับผู้ขาย -->
                                            <div class="product-add-to-cart border-bottom">
                                                <div class="product-quantity">
                                                    <span class="control-label">ประมาณ :</span>
                                                    <div class="qty">
                                                        <div class="input-group">
                                                            <input type="number" name="quantity" min="20" max="100" step="1" data-decimals="0">
                                                        </div>
                                                    </div>
                                                    <span class="control-label">(คิดเป็นต้น)</span>
                                                </div>
                                                @error('quantity')
                                                <span class="text-danger" style="color: red;">{{$message}}</span>
                                                @enderror


                                            </div>

                                            @else
                                            <div class="product-add-to-cart border-bottom">
                                                <div class="product-quantity">
                                                    <span class="control-label">กิโลกรัม :</span>
                                                    <div class="qty">
                                                        <div class="input-group">
                                                            <input type="number" name="quantity" min="1" max="100" step="1" data-decimals="0">

                                                        </div>

                                                    </div>
                                                    <span class="control-label">ก.</span>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="product-buttons">
                                                <button type="submit" class="add-to-cart">
                                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                                    <span>เพิ่มในตักกร้า</span>
                                                </button>
                                            </div>

                                        </form>



                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@section('Ajax')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('#productGrade').change(function() {
            var priceId = $(this).val();
            var tmpproductId = $('#product_id').val() + '-' + priceId;
            // alert(tmpproductId)
            // alert(priceId)

            $('#product_id').val(tmpproductId)

            $.ajax({
                url: "{{ url('/produstb') }}",
                type: 'GET',
                data: {
                    price: priceId,
                },
                success: function(response) {
                    // alert(response)

                    // ลบราคาที่แสดงอยู่ก่อนหน้านี้ออก
                    $('#productPrice').empty();
                    $('#productSellPrice').empty(); // ลบราคาขาย


                    // เพิ่มราคาที่ได้รับจาก response
                    $('#productPrice').text('ราคารับซื้อ' + ' ฿' + response.price_buy);
                    $('#productSellPrice').text('ราคาขาย' + ' ฿' + response.price_sell); // แสดงราคาขาย

                }
            });
        });
    });
</script>

@endsection


@endsection