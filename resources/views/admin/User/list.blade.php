@extends('layouts.admin.navbar')

@section('content')
<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>ข้อมูลสมาชิก</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>รายชื่อผู้ซื้อ</h4>

                        <div class="card-header-action">
                            <a href="{{route('user.create')}}" class="btn btn-lg btn-dark">เพิ่มสมาชิก</a>
                        </div>
                    </div>



                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped v_center" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            ที่
                                        </th>
                                        <th>ชื่อ สกุล</th>
                                        <th>อีเมล</th>
                                        <th>วันที่สมัค</th>
                                        <th>ประเภท</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usersSell as $Sell)
                                    <tr>
                                        <td>
                                            {{$Sell->id}}
                                        </td>

                                        <td>{{$Sell->name}} {{$Sell->last_name}}</td>

                                        <td>{{$Sell->email}}
                                        </td>

                                        <td>{{date('d-m-Y',strtotime($Sell->created_at))}}</td>
                                        <td>
                                            <div class="badge badge-success">
                                                ผู้ซื้อ
                                            </div>
                                        </td>
                                        <td>

                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                <a
                                                    onclick="return confirm('คุณต้องการลบสมาชิก {{$Sell->name}} {{$Sell->last_name}} หรือไม่ ?')"
                                                    type="button"
                                                    href="{{route('user.delete', $Sell->id)}}"
                                                    class="btn btn-danger">ลบ</a>

                                            </div>

                                        </td>
                                    </tr>

                                    @endforeach




                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>รายชื่อผู้ขาย</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped v_center" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            ที่
                                        </th>
                                        <th>ชื่อ สกุล</th>
                                        <th>อีเมล</th>
                                        <th>วันที่สมัค</th>
                                        <th>ประเภท</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        @foreach ($usersBuy as $Buy)
                                    <tr>
                                        <td>
                                            {{$Buy->id}}
                                        </td>

                                        <td>{{$Buy->name}} {{$Sell->last_name}}</td>

                                        <td>{{$Buy->email}}
                                        </td>

                                        <td>{{date('d-m-Y',strtotime($Buy->created_at))}}</td>
                                        <td>
                                            <div class="badge badge-success">
                                                ผู้ขาย
                                            </div>
                                        </td>
                                        <td>

                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                <a
                                                    onclick="return confirm('คุณต้องการลบสมาชิก {{$Buy->name}} {{$Sell->last_name}} หรือไม่ ?')"
                                                    type="button"
                                                    href="{{route('user.delete', $Buy->id)}}"
                                                    class="btn btn-danger">ลบ</a>

                                            </div>

                                        </td>
                                    </tr>

                                    @endforeach




                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </section>
</div>
@endsection