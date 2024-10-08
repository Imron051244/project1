@extends('layouts.admin.app')

@section('Admin')


<!-- Start app top navbar -->
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">

        <div class="search-element">

            <div class="search-backdrop"></div>
            <div class="search-result">
                <div class="search-header">Histories</div>
                <div class="search-item">
                    <a href="#">How to Used HTML in Laravel</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
                <div class="search-item">
                    <a href="https://themeforest.net/user/admincraft/portfolio" target="_black">Admincraft
                        Portfolio</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
                <div class="search-item">
                    <a href="#">#CodiePie</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
                <div class="search-header">Result</div>
                <div class="search-item">
                    <a href="#">
                        <img class="mr-3 rounded" width="30" src="assets/img/products/product-3-50.png" alt="product">
                        oPhone 11 Pro
                    </a>
                </div>
                <div class="search-item">
                    <a href="#">
                        <img class="mr-3 rounded" width="30" src="assets/img/products/product-2-50.png" alt="product">
                        Drone Zx New Gen-3
                    </a>
                </div>
                <div class="search-item">
                    <a href="#">
                        <img class="mr-3 rounded" width="30" src="assets/img/products/product-1-50.png" alt="product">
                        Headphone JBL
                    </a>
                </div>
                <div class="search-header">Projects</div>
                <div class="search-item">
                    <a href="https://themeforest.net/item/epice-laravel-admin-template-for-hr-project-management/24466729"
                        target="_black">
                        <div class="search-icon bg-danger text-white mr-3"><i class="fas fa-code"></i></div>
                        Epice Laravel - Admin Template
                    </a>
                </div>
                <div class="search-item">
                    <a href="https://themeforest.net/item/soccer-project-management-admin-template-ui-kit/24646866"
                        target="_black">
                        <div class="search-icon bg-primary text-white mr-3"><i class="fas fa-laptop"></i>
                        </div>
                        Soccer - Admin Template
                    </a>
                </div>
            </div>
        </div>
    </form>
    <ul class="navbar-nav navbar-right">

        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">ร้านสหายผลไม้</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">ร้านสหายผลไม้</div>
                <a href="#" class="dropdown-item has-icon"> จัดการข้อมูลส่วนตัว</a>
                <a href="#" class="dropdown-item has-icon"> จัดการข้อมูลหน้าร้าน</a>
                <div class="dropdown-divider"></div>

                <!-- ฟอร์ม Logout แบบซ่อน -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <!-- ปุ่ม Logout -->
                <a class="dropdown-item has-icon text-danger" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    title="Log out"> ออกจากระบบ</a>
            </div>
        </li>
    </ul>
</nav>

<!-- Start main left sidebar menu -->
<div class="main-sidebar sidebar-style-3">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a>เจ้าของร้าน</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index-2.html">CP</a>
        </div>

        <ul class="sidebar-menu">
            <li class="dropdown">

            <li class="menu-header">เมนู</li>
            <li><a class="nav-link @if (Request::segment(2) == 'deshboard') active @endif"
                    href="{{route('deshboard')}}"><i class="far fa-square"></i> <span>สถิติ</span></a></li>

            <li><a class="nav-link @if (Request::segment(2) == 'user') active @endif" href="{{route('user')}}"><i
                        class="far fa-square"></i> <span>ผู้ใช้</span></a></li>

            <li><a class="nav-link @if (Request::segment(2) == 'Category') active @endif"
                    href="{{route('listcategory')}}"><i class="far fa-square"></i> <span>ประเภทสินค้า</span></a></li>

            <li><a class="nav-link @if (Request::segment(2) == 'Product') active @endif" href="{{route('listpdt')}}"><i
                        class="far fa-square"></i> <span>สินค้า</span></a></li>

            <li><a class="nav-link @if (Request::segment(2) == 'Price') active @endif" href="{{route('price')}}"><i
                        class="far fa-square"></i> <span>ราคาสินค้า</span></a></li>

            <li><a class="nav-link @if (Request::segment(2) == 'Price') active @endif" href="{{route('orders')}}"><i
                        class="far fa-square"></i> <span>ราการซื้อขาย</span></a></li>


        </ul>







    </aside>
</div>

@endsection