@extends('layouts.admin.navbar')

@section('content')

<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>รายละเอียด</h1>
        </div>

        <div class="row">
            <div class="col-12">


                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>ข้อมูลคำสั่งขาย</h4>
                            </div>



                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>หมายเลขคำสั่งซื้อ:</strong> </p>
                                        <p><strong>วันที่สั่งซื้อ:</strong></p>
                                        <p><strong>สถานะ:</strong> <span class="badge bg-warning">

                                            </span></p>
                                        <p><strong>วันที่เก็บสินค้าได้:</strong></p>
                                    </div>

                                    <div class="col-md-6">
                                        <h4>ข้อมูลผู้ขาย</h4>
                                        <p><strong>ชื่อผู้ขาย:</strong> </p>
                                        <p><strong>เบอร์โทรศัพท์:</strong></p>
                                        <p><strong>ที่อยู่สวน:</strong> ตำบล
                                            อำเภอ จังหวัด

                                        </p>
                                    </div>
                                </div>
                            </div>

                           
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>รายละเอียดสินค้า</h4>

                               



                               
                                <div class="card-header-action">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <a class="btn btn-success" href="">ออกใบเสร็จ</a>
                                        </div>
                                    </div>
                                </div>
                               

                            </div>



                            <div class="card-body">
                                @if(session('successa'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                        {{ session('successa') }}
                                    </div>
                                </div>
                                @endif
                                <table class="table">

                                    <thead>
                                        <tr>
                                            
                                            <th>รูปสินค้า</th>
                                            <th>ประมานกีลูก</th>
                                            <th>ชื่อสินค้า</th> 
                                            <th>เกรดสินค้า</th>
                                            <th>จำนวน</th>
                                            <th>ราคาต่อหน่วย</th>
                                            <th>ราคารวม</th>
                                            <th>เพิ่มเติม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                       
                                        @php
                                        $totalAmount = 0; // ตัวแปรสำหรับเก็บยอดรวมทั้งหมด
                                        $total_QTY = 0;
                                        @endphp

                                       

                                    
                                        <tr>
                                            <td></td>

                                            <td class="product-image">

                                                <a>
                                                    <img width="80" style="height: 63.11px; width:63.11px;" alt="Product Image"
                                                        class="img-responsive"
                                                        src="">
                                                </a>

                                            </td>
                                            <td>
                                               
                                            </td>

                                            <td></td>

                                            <td>฿ </td>

                                            <td>฿ </td>
                                            <td>
                                                <div class="card-header-action">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <a class="btn btn-success" href="">แก้ไข้</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                       
                                      

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>สรุปรายการสินค้า</h4>
                            </div>
                           
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>ยอดรวมผมไม้:</strong> {{$total_QTY}} กีโลกรัม</p>
                                        <p><strong>ยอดรวมทั้งหมด:</strong> ฿ {{ number_format($totalAmount, 2) }} </p>

                                    </div>

                                    <div class="col-md-6">
                                        <h4>ยอดรวม</h4>
                                        <p><strong>ยอดรวมที่ต้องจ่าย:</strong> ฿ {{ number_format($totalAmount, 2) }} </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>


            </div>
    </section>
</div>


@endsection