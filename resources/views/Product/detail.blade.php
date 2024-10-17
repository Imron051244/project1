@extends('layouts.User.footer')

@section('content')
<div id="content" class="site-content">
    <!-- Breadcrumb -->
    <div id="breadcrumb">
        <div class="container">
            <h2 class="title" style="font-family: 'Noto Serif Thai', serif;">{{$getProductDetail->title}}</h2>
        </div>
    </div>

    <div class="container" style="font-family: 'Noto Serif Thai', serif;">
        <div class="row">
            <!-- Sidebar -->
            <div id="left-column" class="sidebar col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="block product-categories">
                    <h3 style="font-family: 'Noto Serif Thai', serif;" class="block-title">ประเภทสินค้า</h3>
                    @php
                    $getCategory = App\Models\CategoryModel::getRecordMenu();
                    @endphp

                    @foreach ($getCategory as $CategoryName)
                    <div class="block-content">
                        <div class="item">
                            <a style="font-family: 'Noto Serif Thai', serif;" class="category-title" href="{{route('categoryName', $CategoryName->title)}}">
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
                            <div class="product-title" style="font-size: 28px; font-family: 'Noto Serif Thai', serif;">
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
                                            <img class="img-responsive" src="{{ asset('upload/product/' . $getProductImage->image_name) }}" alt="Product Image">
                                            @endif
                                        </div>

                                        <div class="thumb-images owl-theme owl-carousel">
                                            @foreach ($getProductDetail->getImage as $image)
                                            <img class="img-responsive" src="{{ asset('upload/product/' . $image->image_name) }}" alt="Product Image">
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
                                            {{ csrf_field() }}
                                            <input type="hidden" id="product_id" name="product_id" value="{{ $getProductDetail->id }}">

                                            <!-- แสดงราคาตามประเภทผู้ใช้ -->
                                            <div class="product-price">
                                                @if (auth()->check())
                                                    @if (auth()->user()->type === 'ผู้ซื้อ')
                                                    <span style="font-family: 'Noto Serif Thai', serif;" id="productSellPrice" class="sale-price">
                                                        ราคา ฿{{$getProductDetail->price_buy }}
                                                    </span>
                                                    @elseif (auth()->user()->type === 'ผู้ขาย')
                                                    <span style="font-family: 'Noto Serif Thai', serif;" id="productPrice" class="sale-price">
                                                        ราคา ฿{{$getProductDetail->price_sell}}
                                                    </span>
                                                    @endif
                                                @else
                                                <span style="font-family: 'Noto Serif Thai', serif;" id="productPrice" class="sale-price">
                                                    ราคารับซื้อ ฿{{$getProductDetail->price_sell }}
                                                </span>
                                                <p></p>
                                                <span style="font-family: 'Noto Serif Thai', serif;" id="productSellPrice" class="sale-price">
                                                    ราคาขาย ฿{{$getProductDetail->price_buy}}
                                                </span>
                                                @endif
                                            </div>

                                            <div class="product-variants border-bottom">
                                                <div class="product-variants-item">
                                                    <span class="control-label">เกรด :</span>
                                                    <select id="productGrade" name="grade" required>
                                                        <option value="#" selected disabled>เลือกเกรด</option>
                                                        @foreach ($getProductPrices as $grade)
                                                        <option value="{{$grade->grade}}">{{$grade->grade}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('grade')
                                                    <span class="text-danger" style="color: red;">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="product-add-to-cart border-bottom">
                                                <div class="product-quantity">
                                                    <span class="control-label">{{ auth()->check() && auth()->user()->type === 'ผู้ขาย' ? 'ประมาณ :' : 'กิโลกรัม :' }}</span>
                                                    <div class="qty">
                                                        <div class="input-group">
                                                            <input type="number" name="quantity" min="{{ auth()->check() && auth()->user()->type === 'ผู้ขาย' ? '20' : '1' }}" max="100" step="1" data-decimals="0">
                                                        </div>
                                                    </div>
                                                    <span class="control-label">{{ auth()->check() && auth()->user()->type === 'ผู้ขาย' ? '(คิดเป็นลูก)' : 'ก.' }}</span>
                                                </div>
                                                @error('quantity')
                                                <span class="text-danger" style="color: red;">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="product-buttons">
                                                <button type="submit" class="add-to-cart">
                                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                                    <span>เพิ่มในตะกร้า</span>
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
@endsection

@section('Ajax')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#productGrade').change(function() {
            var priceId = $(this).val();
            var productId = $('#product_id').val();
            var tmpproductId = productId + '-' + priceId;

            $('#product_id').val(tmpproductId);

            $.ajax({
                url: "{{ route('grade_product') }}",
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    price: priceId,
                    product_id: productId,
                },
                success: function(response) {
                    $('#productPrice').text('ราคา ฿' + response.price_buy);
                    $('#productSellPrice').text('ราคา ฿' + response.price_sell);
                }
            });
        });
    });
</script>
@endsection
