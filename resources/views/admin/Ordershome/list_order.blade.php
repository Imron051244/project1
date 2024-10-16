@extends('layouts.admin.navbar')

@section('content')
<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>การรับซื้อหน้าร้าน</h1>


            <div class="section-header-breadcrumb">
                <div class="buttons">
                    <a href="{{route('order_home_create')}}" class="btn btn-primary">เพิ่มการรับซื้อ</a>

                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-12">

                <!-- การซื้อ -->
                <div class="card">
                    <div class="card-header">
                        <h4>รายการรับซื้อ</h4>
                        <div class="card-header-action">
                            <form method="get">
                                <div class="input-group">
                                    <input type="text" name="search_buy" value="{{ Request::get('search_buy') }}" class="form-control" placeholder="ค้นหา (เบอร์โทรผู้ซื้อ)">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped v_center" id="sortable-table">
                                <thead>
                                    @if(session('successd'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                            {{ session('successd') }}
                                        </div>
                                    </div>
                                    @endif
                                    <tr>

                                        <th>ลำดับ</th>
                                        <th>ผู้ขาย</th>
                                        <th>เบอร์โทร</th>
                                        <th>วันที่ทำการสั้่งซื้อ</th>
                                        <th>สถานะ</th>
                                        <th>เพิ่มเติม</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($getRecord as $list )


                                    <tr>
                                        <td>{{$list->id}}</td>
                                        <td>{{$list->name}} {{$list->last_name}}</td>
                                        <td>{{ substr($list->phone, 0, 3) }}-{{ substr($list->phone, 3, 3) }}-{{ substr($list->phone, 6) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($list->created_at)->locale('th')->translatedFormat('d M Y H:i')}}</td>

                                        <td>
                                            <div class="dropdown d-inline mr-2">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    @if($list->status == 0)
                                                    รอการยืนยัน
                                                    @elseif($list->status == 1)
                                                    ยืนยันแล้ว
                                                    @elseif($list->status == 2)
                                                    สำเร็จ
                                                    @elseif($list->status == 3)
                                                    ยกเลิก
                                                    @endif
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <form action="{{ route('update_status_buyhome', $list->id) }}" method="post" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการอนุมัติคำสั่งขายนี้?');">
                                                        @csrf

                                                        <!-- สถานะ 1: ยืนยันแล้ว -->
                                                        <button class="dropdown-item" type="submit" name="status" value="1">ยืนยันแล้ว</button>

                                                        <!-- สถานะ 2: สำเร็จ -->
                                                        <button class="dropdown-item" type="submit" name="status" value="2">สำเร็จ</button>

                                                        <!-- สถานะ 3: ยกเลิก -->
                                                        <button class="dropdown-item" type="submit" name="status" value="3">ยกเลิก</button>

                                                    </form>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                <a onclick="return confirm('คุณต้องการลบราคา หรือไม่ ?')"
                                                    type="button" href=""
                                                    class="btn btn-danger">ลบ</a>
                                                <a type="button" href="{{route('order_deile_home', $list->id )}}"
                                                    class="btn btn-warning">รายละเอียด</a>

                                            </div>
                                        </td>

                                    </tr>

                                    @endforeach
                                </tbody>

                            </table>
                            <div class="card-footer text-right">
                                {{$getRecord->links()}}
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection