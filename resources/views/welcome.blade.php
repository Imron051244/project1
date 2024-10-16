@extends('layouts.User.footer')

@section('content')
<div id="content" class="site-content" style="font-family: 'Noto Serif Thai', serif;">
    <!-- Slideshow -->
    <div class="section slideshow">
        <div class="tiva-slideshow-wrapper">
            <div id="tiva-slideshow" class="nivoSlider">
                <a href="#">
                    <img class="img-responsive" src="img/slideshow/home1-slideshow-1.jpg" alt="Slideshow Image">
                </a>
                <a href="#">
                    <img class="img-responsive" src="img/slideshow/home1-slideshow-2.jpg" alt="Slideshow Image">
                </a>
                <a href="#">
                    <img class="img-responsive" src="img/slideshow/home1-slideshow-3.jpg" alt="Slideshow Image">
                </a>
            </div>
        </div>
    </div>

    <!-- Product - Deals Of The Day -->
    <div class="section products-block deals-of-day show-hover nav-color layout-2">
        <div class="block-title">
            <h2 class="title">สินค้าที่ปรับราคา <span>วันนี้</span></h2>
            <div class="sub-title">Lorem ipsum dolor sit amet consectetur adipiscing elit eiusmod tempor</div>
        </div>

        <div class="block-content">
            <div class="products owl-theme owl-carousel">
                <div class="product-item">
                    <div class="row">
                        <div class="col-md-6 col-xs-12 product-left">
                            <div class="product-info">
                                <div class="product-title">
                                    <a href="#">
                                        Organic Strawberry Fruits
                                    </a>
                                </div>

                                <div class="product-rating">
                                    <div class="star on"></div>
                                    <div class="star on"></div>
                                    <div class="star on "></div>
                                    <div class="star on"></div>
                                    <div class="star"></div>
                                </div>

                                <div class="product-price">
                                    <span class="sale-price">$35.00</span>
                                    <span class="base-price">$55.00</span>
                                </div>

                                <div class="product-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                    elit....</div>

                                <div class="product-countdown" data-date="2018/10/30">
                                </div>

                                <div class="product-buttons">
                                    <a class="add-to-cart" href="#">
                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                    </a>

                                    <a class="add-wishlist" href="#">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>

                                    <a class="quickview" href="#">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xs-12 product-right">
                            <div class="product-image">
                                <a href="#">
                                    <img src="{{asset('img/product/18.jpg')}}" alt="Product Image">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-item">
                    <div class="row">
                        <div class="col-md-6 col-xs-12 product-left">
                            <div class="product-info">
                                <div class="product-title">
                                    <a href="product-detail-left-sidebar.html">
                                        Organic Strawberry Fruits
                                    </a>
                                </div>

                                <div class="product-rating">
                                    <div class="star on"></div>
                                    <div class="star on"></div>
                                    <div class="star on "></div>
                                    <div class="star on"></div>
                                    <div class="star on"></div>
                                </div>

                                <div class="product-price">
                                    <span class="sale-price">$60.00</span>
                                    <span class="base-price">$78.00</span>
                                </div>

                                <div class="product-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                    elit....</div>

                                <div class="product-countdown" data-date="2018/11/22">
                                </div>

                                <div class="product-buttons">
                                    <a class="add-to-cart" href="#">
                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                    </a>

                                    <a class="add-wishlist" href="#">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>

                                    <a class="quickview" href="#">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xs-12">
                            <div class="product-image">
                                <a href="product-detail-left-sidebar.html">
                                    <img src="img/product/7.jpg" alt="Product Image">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>


    <!-- Product - Best Sellers -->
    <div class="section products-block product-tab nav-color show-hover nav-round best-sellers">
        <div class="block-title">
            <h2 class="title">สินค้า <span>ร้านสหายผลไม้</span></h2>
            <div class="sub-title">Lorem ipsum dolor sit amet consectetur adipiscing elit eiusmod tempor</div>
        </div>

        <div class="block-content">
            <!-- Tab Navigation -->
            <div class="tab-nav">
                <ul>
                    <li class="active">
                        <a data-toggle="tab" href="#all-products">
                            <img src="img/product/product-category-0.png" alt="All Product">
                            <span>All Products</span>
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- All Products -->
                <div role="tabpanel" class="tab-pane fade in active" id="all-products">
                    <div class="products owl-theme owl-carousel">

                        @foreach ($getProducts as $itam)
                        <div class="product-item">

                            @php
                            $getProductImage = $itam->getImageSingle($itam->id);
                            @endphp
                            <div class="product-image">
                                <a href="{{ route('detail', ['id' => $itam->id]) }}">
                                    @if (!empty($getProductImage) && !empty($getProductImage->image_name))
                                    <img src="{{ asset('upload/product/' . $getProductImage->image_name) }}" alt="{{$itam->title}}">
                                    @endif
                                </a>
                            </div>

                            <div class="product-title">
                                <a href="{{ route('detail', ['id' => $itam->id]) }}">
                                    {{$itam->title}}
                                </a>
                            </div>

                            <div class="product-price">
                                <span class="sale-price">฿80.00</span>
                                <span class="base-price">฿90.00</span>
                            </div>

                            <div class="product-buttons">

                                <a class="quickview" href="{{ route('detail', ['id' => $itam->id]) }}">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
@endsection