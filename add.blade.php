@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ url('assets/css/plugins/nouislider/nouislider.css') }}">
@endsection

@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('{{ url('') }}/assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Add Address</b></h1>
            </div>
        </div>

        <div class="page-content">
            <div class="dashboard">
                <div class="container">
                    <br>
                    <div class="row">
                        @include('user._sidebar')
                        <div class="col-md-8 col-lg-9">
                            <div class="tab-content">
                                @include('layouts._message')

                                <form action="" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Provinces <span style="color:red">*</span></label>
                                                <select class="form-control" id="ChangeProvinces" name="provinces_id" required>
                                                    <option value="">Select</option>
                                                    @foreach ($getProvinces as $provinces)
                                                        <option value="{{ $provinces->id }}">{{ $provinces->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Amphures <span style="color:red">*</span></label>
                                                <select class="form-control" id="getAmphures" name="amphures_id" required>
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Districts <span style="color:red">*</span></label>
                                                <select class="form-control" id="getDistricts" name="districts_id" required>
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Zip Code <span style="color:red">*</span></label>
                                            <input type="text" name="zip_code" id="getZipcode" class="form-control"
                                                readonly>
                                        </div>
                                    </div>

                                    <label>Country <span style="color:red">*</span></label>
                                    <input type="text" name="country" class="form-control"
                                        placeholder="House number and Street name" required>

                                    <button type="submit" style="width: 100px;"
                                        class="btn btn-outline-primary-2 btn-order btn-block">
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script type="text/javascript">
        $('body').on('change', '#ChangeProvinces, #getAmphures, #getDistricts', function() {
            var elementId = $(this).attr('id');
            var data = {
                "_token": "{{ csrf_token() }}"
            };
            var url;
            var target;

            if (elementId === 'ChangeProvinces') {
                data.provinces_id = $(this).val();
                url = "{{ url('get_amphures') }}";
                target = '#getAmphures';
            } else if (elementId === 'getAmphures') {
                data.amphures_id = $(this).val();
                url = "{{ url('get_districts') }}";
                target = '#getDistricts';
            } else if (elementId === 'getDistricts') {
                data.zip_code = $(this).val();
                url = "{{ url('get_zip_code') }}";
                target = '#getZipcode';
            }

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: "json",
                success: function(response) {
                    if (elementId === 'getDistricts') {
                        $(target).val(response.zip_code);
                    } else {
                        $(target).html(response.html);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
