@extends('layouts.admin.navbar')


@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>เพิ่มที่อยู่</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>ชื่อลูก</label>
                                <input value="{{ $getRecord->name_lasname }}" type="text" class="form-control"
                                    name="name_lasname" readonly>
                            </div>

                            <div class="form-group">
                                <label>เบอร์โทร</label>
                                <input type="tel" value="{{ old('tell', $getRecord->tell) }}" class="form-control"
                                    name="tell">
                                @error('tell')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>ที่อยู่</label>
                                <input type="text" class="form-control" value="{{ old('adress', $getRecord->adress) }}"
                                    name="adress">
                                @error('adress')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="provinces">จังหวัด</label>
                                    <select id="provinces" class="form-control">
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ $getRecord->provinces_id == $province->id ? 'selected' : '' }}>{{ $province->name_th }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="amphures">อำเภอ</label>
                                    <select id="amphures" class="form-control">
                                        <!-- จะมีการเติมข้อมูลผ่าน Ajax -->
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="districts">ตำบล</label>
                                    <select id="districts" name="districts_id" class="form-control">
                                        <!-- จะมีการเติมข้อมูลผ่าน Ajax -->
                                    </select>
                                </div>

                                <div class=" form-group col-md-6">
                                        <label for="zip_code">รหัสไปรษณีย์</label>
                                        <input class="form-control" type="text" id="zipcode" readonly>

                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <input type="submit" class="btn btn-primary mr-1" value="บันทึก">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="{{asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // โหลดข้อมูลอำเภอเมื่อมีการเลือกจังหวัด
        $('#provinces').change(function () {
            var provinceId = $(this).val();

            $.ajax({
                url: "{{ route('getAmphures') }}",
                type: 'GET',
                data: { province_id: provinceId },
                success: function (response) {
                    $('#amphures').empty();
                    $('#amphures').append('<option>เลือกอำเภอ</option>');
                    $.each(response, function (key, value) {
                        $('#amphures').append('<option value="' + value.id + '">' + value.name_th + '</option>');
                    });
                }
            });
        });

        // โหลดข้อมูลตำบลเมื่อมีการเลือกอำเภอ
        $('#amphures').change(function () {
            var amphureId = $(this).val();

            $.ajax({
                url: "{{ route('getDistricts') }}",
                type: 'GET',
                data: { amphure_id: amphureId },
                success: function (response) {
                    $('#districts').empty();
                    $('#districts').append('<option>เลือกตำบล</option>');
                    $.each(response, function (key, value) {
                        $('#districts').append('<option value="' + value.id + '">' + value.name_th + '</option>');
                    });
                }
            });
        });

        // โหลดรหัสไปรษณีย์เมื่อมีการเลือกตำบล
        $('#districts').change(function () {
            var districtId = $(this).val();

            $.ajax({
                url: "{{ route('getZipCode') }}",
                type: 'GET',
                data: { district_id: districtId, },
                success: function (response) {
                    $('#zipcode').val(response);
                }
            });
        });
    });
</script>
@endsection