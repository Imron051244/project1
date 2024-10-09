@extends('layouts.admin.navbar')

@section('content')
<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>ข้อมูลราคาสินค้า</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>ข้อมูลราคาสินค้า</h4>

                        <div class="card-header-action">
                            <a href="{{route('create.price')}}" class="btn btn-lg btn-dark">เพิ่มราคาสินค้า</a>
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

                                        <th>ชือสินค้า</th>
                                        <th>เกรด</th>
                                        <th>ราคารับซื้อ</th>
                                        <th>ราคาขาย</th>
                                        <th>สินค้าคงอยู่ (ก.)</th>
                                        <th>วันที่เพิ่ม</th>
                                        <th>วันที่อัพเดด</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($getRecord as $price)
                                    <tr>
                                        <td>{{$price->id}}</td>

                                        <td>{{$price->product_name}}</td>

                                        <td>
                                        {{$price->grade}}
                                           
                                        </td>

                                        <td>{{$price->price_buy}}</td>

                                        <td>{{$price->price_sell}}</td>
                                        <td>{{$price->qty}}</td>

                                        <td>{{date('d-m-Y', strtotime($price->created_at))}}</td>

                                        <td>{{date('d-m-Y', strtotime($price->updated_at))}}</td>

                                        <td>
                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                <a onclick="return confirm('คุณต้องการลบราคา หรือไม่ ?')"
                                                    type="button" href="{{route("deleteprc",$price->id)}}"
                                                    class="btn btn-danger">ลบ</a>
                                                <a type="button" href="{{route("editprin",$price->id)}}"
                                                    class="btn btn-warning">แก้ไข</a>

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