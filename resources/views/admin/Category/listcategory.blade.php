@extends('layouts.admin.navbar')


@section('content')
<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>ข้อมูลประเภทสินค้า</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>ข้อมูลประเภทสินค้า</h4>

                        <div class="card-header-action">
                            <a href="{{route('create')}}" class="btn btn-lg btn-dark">เพิ่มประเภทสินค้าสินค้า</a>
                        </div>

                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped v_center" id="sortable-table">
                                <thead>
                                    <tr>
                                        <th>
                                            ลำดับ
                                        </th>
                                        <th>ชื่อประเภท</th>
                                        <th>วันที่เพิ่ม</th>
                                        <th>สถานะ</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getRecord as $item)
                                        <tr>
                                            <td>
                                                {{$item->id}}
                                            </td>

                                            <td>{{$item->title}}</td>


                                            <td>{{date('d-m-Y',strtotime($item->created_at))}}</td>

                                            <td>
                                                <div class="buttons">
                                                <form action="{{route('categiry' ,['id' => $item->id] )}}" method="post" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการจะปิด ?');">
                                                @csrf
                                                @if($item->status == 0)
                                                <button type="submit" class="btn btn-success">ขาย</button>
                                                @else
                                                <button type="submit" class="btn btn-danger">ไม่ขาย</button>
                                                @endif
                                            </form>
                                                   

                                                </div>
                                            </td>

                                            <td>
                                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                    <a onclick="return confirm('คุณต้องการลบประเภท {{$item->title}} หรือไม่ ?')"
                                                    type="button" href="{{route('deletectr', $item->id)}}"
                                                        class="btn btn-danger">ลบ</a>
                                                    <a type="button" href="{{route('editctr', $item->id)}}"
                                                        class="btn btn-warning">แก้ไข</a>

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