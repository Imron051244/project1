@extends('layouts.admin.navbar')

@section('content')
<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>การรับซื้อสินค้า</h1>
        </div>
        <div class="row">
            <div class="col-12">

                <!-- การซื้อ -->

                <!-- การขาย -->
                <div class="card">

                    <div class="card-header">
                        <h4>การรับซื้อสินค้า</h4>

                        <div class="card-header-action">
                            <form method="get">
                                <div class="input-group">
                                    <input type="text" name="search_sell" value="" class="form-control" placeholder="ค้นหา (เบอร์โทรผู้ขาย)">
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
                                    <tr>
                                        <th>ผู้ขาย</th>
                                        <th>ประมารสินค้า (คิดเป็นลูก)</th>
                                        <th>เบอร์โทร</th>
                                        <th>วันที่ทำการขาย</th>
                                        <th>สถานะ</th>
                                        <th>วันที่เก็บสินค้าได้</th>
                                        <th>เพิ่มเติม</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if($getbuy->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">ยังไม่มีรายการ</td>
                                        </tr>
                                    @else
                                        @foreach ($getbuy as $buy)
                                            <tr>
                                                <td>{{ $buy->name }} {{ $buy->last_name }}</td>
                                                <td>{{ $buy->quantity }} ลูก</td>
                                                <td>{{ substr($buy->phone, 0, 3) }}-{{ substr($buy->phone, 3, 3) }}-{{ substr($buy->phone, 6) }}</td>
                                                <td>{{ $buy->created_at }}</td>
                                                <td>
                                                    <div class="dropdown d-inline mr-2">
                                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <!-- ปุ่มสถานะ -->
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <form action="" method="post" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการอนุมัติคำสั่งขายนี้?');">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $buy->ready_date }}</td>
                                                <td>
                                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                        <a onclick="return confirm('คุณต้องการลบราคา หรือไม่ ?')" type="button" href="" class="btn btn-danger">ลบ</a>
                                                        <a type="button" href="{{ route('detail_order_buy', $buy->id) }}" class="btn btn-warning">รายละเอียด</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="card-footer text-right">
                                <!-- ปุ่มหรือลิงก์อื่น ๆ ถ้ามี -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
