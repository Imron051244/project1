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
                                    <tr>

                                        <th>ลำดับ</th>
                                        <th>ผู้ขาย</th>
                                        <th>เบอร์โทร</th>
                                        <th>วันที่ทำการสั้่งซื้อ</th>
                                        <th>ยอดรวม</th>
                                        <th>สถานะ</th>
                                        <th>เพิ่มเติม</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>


                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>




                                        <td>
                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                <a onclick="return confirm('คุณต้องการลบราคา หรือไม่ ?')"
                                                    type="button" href=""
                                                    class="btn btn-danger">ลบ</a>
                                                <a type="button" href=""
                                                    class="btn btn-warning">รายละเอียด</a>

                                            </div>
                                        </td>
                                    </tr>


                                </tbody>

                            </table>
                            <div class="card-footer text-right">

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection