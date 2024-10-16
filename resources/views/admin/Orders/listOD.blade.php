@extends('layouts.admin.navbar')

@section('content')
<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>การซื้อขาย</h1>
        </div>
        <div class="row">
            <div class="col-12">

                <!-- การซื้อ -->
                <div class="card">
                    <div class="card-header">
                        <h4>การซื้อ</h4>
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
                                    <tr>
                                        <th class="text-center">
                                            <i class="fas fa-th"></i>
                                        </th>
                                        <th>ลำดับ</th>
                                        <th>ผู้ซื้อ</th>
                                        <th>เบอร์โทร</th>
                                        <th>วันที่ทำการสั้่งซื้อ</th>
                                        <th>ยอดรวม</th>
                                        <th>สถานะ</th>
                                        <th>เพิ่มเติม</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        @foreach ($getOrder as $Order )

                                        <td></td>
                                        <td>{{$Order->id}}</td>
                                        <td>{{$Order->name}} {{$Order->last_name}}</td>
                                        <td>{{ substr($Order->phone, 0, 3) }}-{{ substr($Order->phone, 3, 3) }}-{{ substr($Order->phone, 6) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($Order->created_at)->locale('th')->translatedFormat('d M Y H:i')}}</td>
                                        <td>{{$Order->total}}</td>

                                        <td>

                                            <div class="dropdown d-inline mr-2">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    @if($Order->status == 0)
                                                    รอการยืนยัน
                                                    @elseif($Order->status == 1)
                                                    ยืนยันแล้ว
                                                    @elseif($Order->status == 2)
                                                    รอการชำระเงิน
                                                    @elseif($Order->status == 3)
                                                    ชำระเงินแล้ว
                                                    @elseif($Order->status == 4)
                                                    กำลังจัดเตรียมสินค้า
                                                    @elseif($Order->status == 5)
                                                    จัดเตรียมสำเร็จ
                                                    @elseif($Order->status == 6)
                                                    สำเร็จ
                                                    @elseif($Order->status == 7)
                                                    ยกเลิก
                                                    @endif
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <form action="{{ route('order.updateStatus', $Order->id) }}" method="post" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการอัปเดตสถานะนี้?');">
                                                        @csrf

                                                        <!-- สถานะ 1: ยืนยันแล้ว -->
                                                        <button class="dropdown-item" type="submit" name="status" value="1">ยืนยันแล้ว</button>

                                                        <!-- สถานะ 2: รอการชำระเงิน -->
                                                        <button class="dropdown-item" type="submit" name="status" value="2">รอการชำระเงิน</button>

                                                        <!-- สถานะ 3: ชำระเงินแล้ว -->
                                                        <button class="dropdown-item" type="submit" name="status" value="3">ชำระเงินแล้ว</button>

                                                        <!-- สถานะ 4: กำลังจัดเตรียมสินค้า -->
                                                        <button class="dropdown-item" type="submit" name="status" value="4">กำลังจัดเตรียมสินค้า</button>

                                                        <!-- สถานะ 5: จัดเตรียมสำเร็จ -->
                                                        <button class="dropdown-item" type="submit" name="status" value="5">จัดเตรียมสำเร็จ</button>

                                                        <!-- สถานะ 6: สำเร็จ -->
                                                        <button class="dropdown-item" type="submit" name="status" value="6">สำเร็จ</button>

                                                        <!-- สถานะ 7: ยกเลิก -->
                                                        <button class="dropdown-item" type="submit" name="status" value="7">ยกเลิก</button>

                                                    </form>
                                                </div>
                                            </div>


                                        </td>

                                        <td>
                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                <a onclick="return confirm('คุณต้องการลบราคา หรือไม่ ?')"
                                                    type="button" href="{{url('/orders/delete/' . $Order->id) }}"
                                                    class="btn btn-danger">ลบ</a>
                                                <a type="button" href="{{ route('order_detailsell', $Order->id ) }}"
                                                    class="btn btn-warning">รายละเอียด</a>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>

                            </table>
                            <div class="card-footer text-right">
                                {{$getOrder->links()}}
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection