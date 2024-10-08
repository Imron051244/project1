@extends('layouts.admin.navbar')


@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>สมัคสมาชิก</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <form action="#" method="post">
                            {{ csrf_field() }}
                            <!-- ชื่อ -->
                            <div class="form-group">
                                <label for="name">ชื่อ</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                @error('name')
                                <span class="text-warning">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- สกุล -->
                            <div class="form-group">
                                <label for="last_name">สกุล</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}">
                                @error('last_name')
                                <span class="text-warning">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- เบอร์โทร -->
                            <div class="form-group">
                                <label for="phone">เบอร์โทร</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                <span class="text-warning">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- อีเมล -->
                            <div class="form-group">
                                <label for="email">อีเมล</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="text-warning">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- รหัสผ่าน -->
                            <div class="form-group">
                                <label for="password">รหัสผ่าน</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                <span class="text-warning">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- ยืนยันรหัสผ่าน -->
                            <div class="form-group">
                                <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
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

                            <div class="card-footer text-right">
                                <input type="submit" class="btn btn-primary mr-1" value="ลงทะเบียน">

                            </div>

                        </form>
                    </div>


                </div>

            </div>

        </div>



    </section>
</div>
@endsection