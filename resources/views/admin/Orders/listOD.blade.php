@extends('layouts.admin.navbar')

@section('style')
<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 1200px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .btn-custom {
        background-color: #007bff;
        color: white;
    }

    .btn-custom:hover {
        background-color: #0056b3;
        color: white;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .pagination {
        justify-content: center;
    }

    .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        border-color: #6c757d;
    }
</style>

@endsection

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
                                        <th>status</th>
                                        <th>Action</th>

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
                                            <form action="{{ route('order.updateStatus', $Order->id) }}" method="post" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการอนุมัติคำสั่งซื้อนี้?');">
                                                @csrf
                                                @if($Order->status == 0)
                                                <button type="submit" class="btn btn-success">อนุมัติ</button>
                                                @else
                                                <button type="submit" class="btn btn-danger">ยกเลิกการอนุมัติ</button>
                                                @endif
                                            </form>
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

                <!-- การขาย -->
                <div class="card">

                    <div class="card-header">
                        <h4>การขาย</h4>
                        <div class="col-9 col-md-9 col-lg-9">
                            <div class="buttons">
                                <a href="{{route('order_create')}}" class="btn btn-sm btn-warning">รับซื้อ</a>
                            </div>
                        </div>
                        <div class="card-header-action">

                            <form method="get">
                                <div class="input-group">
                                    <input type="text" name="search_sell" value="{{ Request::get('search_sell') }}" class="form-control" placeholder="ค้นหา (เบอร์โทรผู้ขาย)">
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
                                        <th>ลำดับ</th>
                                        <th>ผู้ขาย</th>
                                        <th>สินค้า</th>
                                        <th>ประมารสินค้า (คิดเป็นต้น)</th>
                                        <th>เบอร์โทร</th>
                                        <th>วันที่ทำการขาย</th>
                                        <th>สถานะ</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>

                                <tbody>


                                    <tr>
                                        @foreach ($getOrderBuy as $Orderbuy )

                                        <td></td>
                                        <td>{{$Orderbuy->id}}</td>
                                        <td>{{$Orderbuy->name}} {{$Orderbuy->last_name}}</td>
                                        <td>{{$Orderbuy->quantity}}</td>
                                        <td>{{ substr($Orderbuy->phone, 0, 3) }}-{{ substr($Orderbuy->phone, 3, 3) }}-{{ substr($Orderbuy->phone, 6) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($Orderbuy->created_at)->locale('th')->translatedFormat('d M Y H:i')}}</td>


                                        <td>
                                            <form action="{{ route('order.updateStatusbuy', $Orderbuy->id) }}" method="post" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการอนุมัติคำสั่งขายนี้?');">
                                                @csrf
                                                @if($Orderbuy->status == 0)
                                                <button type="submit" class="btn btn-success">อนุมัติ</button>
                                                @else
                                                <button type="submit" class="btn btn-danger">ยกเลิกการอนุมัติ</button>
                                                @endif
                                            </form>
                                        </td>

                                        <td>
                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                <a onclick="return confirm('คุณต้องการลบราคา หรือไม่ ?')"
                                                    type="button" href="{{route('delete_buy', $Orderbuy->id)}}"
                                                    class="btn btn-danger">ลบ</a>
                                                <a type="button" href="{{ route('order_detailbuy', $Orderbuy->id ) }}"
                                                    class="btn btn-warning">รายละเอียด</a>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer text-right">
                                {{$getOrderBuy->links()}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection