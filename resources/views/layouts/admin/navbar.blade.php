@extends('layouts.admin.app')

@section('Admin')


<!-- Start app top navbar -->
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fa fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
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
            <a href="">CP</a>
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

            <li><a class="nav-link @if (Request::segment(2) == 'Price') active @endif" href="{{route('listpdt')}}"><i
                        class="far fa-square"></i> <span>สินค้า</span></a></li>

            <li><a class="nav-link @if (Request::segment(2) == 'Price') active @endif" href="{{route('price')}}"><i
                        class="far fa-square"></i> <span>ราคาสินค้า</span></a></li>

            <li><a class="nav-link @if (Request::segment(2) == 'Price') active @endif" href="{{route('orders')}}"><i
                        class="far fa-square"></i> <span>ราการซื้อขาย</span></a></li>


        </ul>

    </aside>
</div>

@endsection