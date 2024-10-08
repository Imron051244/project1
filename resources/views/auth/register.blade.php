@extends('layouts.User.footer')

@section('content')
<div id="content" class="site-content">
    <!-- Breadcrumb -->
    <div id="breadcrumb">
        <div class="container">
            <h2 class="title">ลงทะเบียน</h2>


        </div>
    </div>


    <div class="container">
        <div class="register-page">
            <div class="register-form form">
                <div class="block-title">
                    <h2 class="title"><span>ลงทะเบียน</span></h2>
                </div>

                <form action="#" method="post">
                    {{ csrf_field() }}
                    <!-- ชื่อ -->
                    <div class="form-group">
                        <label for="name">ชื่อ</label>
                        <input type="text" name="name" value="{{ old('name') }}">
                        @error('name')
                        <span class="text-warning">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- สกุล -->
                    <div class="form-group">
                        <label for="last_name">สกุล</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}">
                        @error('last_name')
                        <span class="text-warning">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- เบอร์โทร -->
                    <div class="form-group">
                        <label for="phone">เบอร์โทร</label>
                        <input type="text" name="phone" value="{{ old('phone') }}">
                        @error('phone')
                        <span class="text-warning">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- อีเมล -->
                    <div class="form-group">
                        <label for="email">อีเมล</label>
                        <input type="email" name="email" value="{{ old('email') }}">
                        @error('email')
                        <span class="text-warning">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- รหัสผ่าน -->
                    <div class="form-group">
                        <label for="password">รหัสผ่าน</label>
                        <input type="password" name="password">
                        @error('password')
                        <span class="text-warning">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- ยืนยันรหัสผ่าน -->
                    <div class="form-group">
                        <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
                        <input type="password" name="password_confirmation">
                        @error('password_confirmation')
                        <span class="text-warning">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- ประเภทผู้ใช้ -->
                    <div class="form-group">
                        <label for="type">ประเภทผู้ใช้</label>
                        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                            <option value="#" disabled selected>โปรดเลือกประเภทผู้ใช้</option>
                            <option value="ผู้ซื้อ" {{ old('type') == 'ผู้ซื้อ' ? 'selected' : '' }}>ผู้ซื้อ</option>
                            <option value="ผู้ขาย" {{ old('type') == 'ผู้ขาย' ? 'selected' : '' }}>ผู้ขาย</option>
                        </select>
                        @error('type')
                        <span class="text-warning">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" class="btn btn-primary" value="ลงทะเบียน">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection