@extends('layouts.admin.navbar')

@section('content')
<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>การซื้อขาย</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>การซื้อขาย</h4>

                        <div class="card-header-action">
                            <a href="{{route('pdtcreate')}}" class="btn btn-lg btn-dark">เพิ่มสินค้า</a>
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
                                        <th>ประเภท</th>
                                        <th>ชือสินค้า</th>
                                        <th>เกรด</th>
                                        <th>ราคารับซื้อ฿</th>
                                        <th>ราคาขาย฿</th>
                                        <th>สินค้าคงอยู่ (kg.)</th>
                                        <th>รูปภาพสินค้า</th>
                                        <th>วันที่เพิ่ม</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>

                                    @foreach ($getRecord as $Product)

                                    <tr>
                                        <td>{{$Product->id}}</td>

                                        <td>{{$Product->category_name}}</td>

                                        <td>{{$Product->title}}</td>

                                        <td>
                                            <select class="form-control grade-select" data-product-id="{{$Product->id}}">
                                                <option value="#" selected disabled>เลือกเกรด</option>
                                                @foreach ($Product->getPrice as $grade )
                                                <option value="{{$grade->id}}">
                                                    {{$grade->grade}}
                                                </option>
                                                @endforeach


                                            </select>
                                        </td>

                                        <td><span class="PriceBuy sale-price">฿</span></td>
                                        <td><span class="PriceSell sale-price">฿</span></td>

                                        <td><span class="qty"></span></td>

                                        <td>
                                            <div class="card-body">
                                                <div class="gallery">
                                                    @foreach ($Product->getImage as $poto )
                                                    <div class="gallery-item" data-image="{{ asset('upload/product/' . $poto->image_name) }}" data-title="{{$poto->order_by = 1}}"></div>
                                                    @endforeach

                                                </div>
                                            </div>

                                        </td>

                                        <td>{{date('d-m-Y', strtotime($Product->created_at))}}</td>

                                        <td>
                                            <form action="{{route('updateStatusProduct', $Product->id)}}" method="post" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการปิดขายนี้?');">
                                                @csrf
                                                @if($Product->status == 0)
                                                <button type="submit" class="btn btn-success">ขาย</button>
                                                @else ($Product->status == 1)
                                                <button type="submit" class="btn btn-danger">ไม่ขาย</button>
                                                @endif
                                            </form>
                                        </td>

                                        <td>
                                            <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                <a onclick="return confirm('คุณต้องการลบราคา หรือไม่ ?')"
                                                    type="button" href="{{route('deletepdt', $Product->id)}}"
                                                    class="btn btn-danger">ลบ</a>
                                                <a type="button" href="{{route('editpdt', $Product->id)}}"
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

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('.grade-select').change(function() {
            var priceIds = $(this).val();
            var productId = $(this).data('product-id');
            // alert(priceIds)

            $.ajax({
                url: "{{ url('/products') }}",
                type: 'GET',
                data: {
                    price: priceIds,
                    product_id: productId
                },
                success: function(response) {
                    var row = $(this).closest('tr'); // หาช่องที่เกี่ยวข้อง
                    row.find('.PriceBuy').text(' ฿' + response.price_buy);
                    row.find('.PriceSell').text(' ฿' + response.price_sell);
                    row.find('.qty').text(response.qty);
                }.bind(this)

            });
        });
    });
</script>

@endsection