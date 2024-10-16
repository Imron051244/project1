@extends('layouts.User.app')

@section('Header')

<!-- Header -->
<header id="header">
    <!-- Topbar -->
    <div class="topbar">
        <!-- Close Topbar -->
        <div class="close-topbar">
            <i class="zmdi zmdi-close"></i>
        </div>

        <!-- Topbar Content -->
        <div class="container topbar-content">
            <div class="row">
                <!-- Topbar Left -->
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="topbar-left d-flex">
                        <div class="email">
                            <i class="fa fa-envelope" aria-hidden="true"></i>Email: tivatheme@gmail.com
                        </div>
                        <div class="skype">
                            <i class="fa fa-skype" aria-hidden="true"></i>Skype: tivatheme
                        </div>
                    </div>
                </div>

                <!-- Topbar Right -->
                <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="topbar-right d-flex justify-content-end">
                        <!-- My Account -->
                        <div class="dropdown account">
                            <div class="dropdown-toggle" data-toggle="dropdown">
                                My Account
                            </div>

                            <div class="dropdown-menu">

                                @if (Auth::check())
                                <!-- หากผู้ใช้เข้าสู่ระบบแล้ว -->

                                <div class="item">
                                    <a title="Log in to your customer account"><i
                                            class="fa fa-user"></i>{{ Auth::user()->name}} {{ Auth::user()->last_name}}</a>
                                </div>

                                <div class="item">
                                    <a href="#" title="My Account"><i class="fa fa-cog"></i> จัดการข้อมูลส่วนตัว</a>
                                </div>
                                <div class="item">
                                    <a href="#" title="My Wishlists"><i class="fa fa-heart"></i> รายการซื้อขาย</a>
                                </div>

                                <div class="item">
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        title="Logout from your account">
                                        <i class="fa fa-sign-out"></i>ออกจากระบบ
                                    </a>
                                    <!-- Form สำหรับ logout -->
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                                @else
                                <!-- หากผู้ใช้ยังไม่ได้เข้าสู่ระบบ -->
                                <div class="item">
                                    <a href="{{ route('login') }}" title="Log in to your customer account"><i
                                            class="fa fa-sign-in"></i> เข้าสู่ระบบ</a>
                                </div>
                                <div class="item">
                                    <a href="{{ route('register') }}" title="Register Account"><i
                                            class="fa fa-user"></i> สมัครสมาชิก</a>
                                </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Open Topbar -->
        <div class="container active">
            <div id="toggle-topbar"><i class="zmdi zmdi-plus"></i></div>
        </div>
    </div>

    <!-- Header Top -->
    <div class="header-top">
        <div class="container">
            <div class="row">
                <!-- Search -->
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-search">
                        <form action="#" method="get">
                            <input type="text" class="form-input" placeholder="Search">
                            <button type="submit" class="fa fa-search"></button>
                        </form>
                    </div>
                </div>

                <!-- Logo -->
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="logo">
                        <a>
                            <img style="height: 114px;width: 173px;" class="img-responsive" src="{{asset('img/logoa.jpg')}}"
                                alt="Logo">
                        </a>
                    </div>

                    <span id="toggle-mobile-menu"><i class="zmdi zmdi-menu"></i></span>
                </div>

                <!-- Cart -->
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="block-cart dropdown">
                        <div class="cart-title">
                            <i class="fa fa-shopping-basket"></i>
                            <span class="cart-count">{{Cart::getContent()->count()}}</span>
                        </div>

                        <div class="dropdown-content">
                            <div class="cart-content">
                                <table>
                                    <tbody>

                                        @foreach(Cart::getContent() as $header_cart)
                                        @php
                                        $getCartProduct = App\Models\ProductModel::getSingle($header_cart->id);
                                        $getProductImage = $getCartProduct->getImageSingle($getCartProduct->id);
                                        @endphp
                                        @if (auth()->check() && auth()->user()->type === 'ผู้ขาย')
                                        
                                        <tr>
                                            <td class="product-image">
                                                <a href="product-detail-left-sidebar.html">
                                                    <img style="height: 89px;width: 90px;"
                                                        src="{{ asset('upload/product/' . $getProductImage->image_name) }}"
                                                        alt="Product">
                                                </a>
                                            </td>

                                            <td>
                                                <div class="product-name"></div>
                                                <a href="#">{{ $header_cart->name }}</a>

                                                <div>
                                                    <span class="product-price">{{ $header_cart->quantity }} (คิดเป็นต้น)</span>
                                                </div>

                                            </td>
                                            <td class="action">
                                                <a class="remove" href="{{url('cart/delete/' . $header_cart->id) }}" onclick="return confirm('คุณจะลบสินค้า {{$header_cart->name}} ?')">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        @else

                                        @php
                                        $gradeName = $header_cart->attributes->grade_name ?? 'ไม่ระบุ';
                                        @endphp

                                        <tr>
                                            <td class="product-image">
                                                <a href="product-detail-left-sidebar.html">
                                                    <img style="height: 89px;width: 90px;"
                                                        src="{{ asset('upload/product/' . $getProductImage->image_name) }}"
                                                        alt="Product">
                                                </a>
                                            </td>

                                            <td>
                                                <div class="product-name"></div>
                                                <a href="#">{{ $header_cart->name }}</a>

                                                <div class="product-grade">
                                                    เกรด: <span class="grade-name">
                                                        {{$gradeName}}
                                                    </span>
                                                </div>

                                                <div>

                                                    <span class="product-price">{{ $header_cart->quantity }} x</span>
                                                    <span class="product-price">฿{{ $header_cart->price }}</span>
                                                </div>
                                            </td>
                                            <td class="action">
                                                <a class="remove" href="{{url('cart/delete/' . $header_cart->id) }}" onclick="return confirm('คุณจะลบสินค้า {{$header_cart->name}} ?')">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        @endif
                                        @endforeach

                                        <tr class="total">
                                            <td>ยอดรวม:</td>
                                            <td colspan="2">฿{{Cart::getTotal()}}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="3">
                                                <div class="cart-button">
                                                    <a class="btn btn-primary" href="{{url('cart')}}"
                                                        title="View Cart">ตรวจสอบรายการ</a>
                                                    <a class="btn btn-primary" href="{{url('checkout')}}"
                                                        title="Checkout">ยืนยันรายการ</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Menu -->
    <div id="main-menu">
        <ul class="menu">
            <li class="dropdown">
                <a style="font-family: 'Noto Serif Thai', serif;" href="{{route('home')}}" title="Homepage">หน้าหลัก</a>
            </li>

            <li class="dropdown">
                <a style="font-family: 'Noto Serif Thai', serif; " href="{{route('list')}}" title="Page">สินค้า</a>
            
            </li>

            <li class="dropdown">
                <a style="font-family: 'Noto Serif Thai', serif; " href="{{route('contact')}}">เกียวกับเรา</a>
            </li>

            <li>
                <a style="font-family: 'Noto Serif Thai', serif; " href="{{route('about')}}">ติดต่อเรา</a>
            </li>

        </ul>
    </div>
</header>


@endsection