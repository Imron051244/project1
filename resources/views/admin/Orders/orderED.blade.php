@extends('layouts.admin.navbar')

@section('content')

<div class="main-content" style="min-height: 647px;">
    <section class="section">
        <div class="section-header">
            <h1>แก้ไขรายการซื้อลูกค้า</h1>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('order_editsell_update', $getSingle->id)}}" method="post">
                            {{ csrf_field() }}

                            <div class="card">
                                <div class="card-header">
                                    <h4>แก้ไข</h4>
                                </div>
                                
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="inputAddress">ชื่อสินค้า</label>
                                        <input type="text" class="form-control" value="{{$getSingle->getProduct->title}}" readonly>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputEmail4">เกรด</label>
                                            <input type="text" name="grade" class="form-control" value="{{$getSingle->grade}}" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputPrice">ราคา</label>
                                            <input type="text" name="price" id="price" value="{{$getSingle->price}}" class="form-control" oninput="calculateTotal()">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputQuantity">ปริมาน/กีโลกรัม</label>
                                            <input type="text" name="qty" id="quantity" value="{{$getSingle->quantity}}" class="form-control" oninput="calculateTotal()">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputTotalPrice">ราคารวม</label>
                                            <input type="text" name="total_price" id="total_price" value="{{$getSingle->total_price}}" class="form-control" readonly>
                                        </div>

                                        <script>
                                            function calculateTotal() {
                                                var price = parseFloat(document.getElementById('price').value) || 0;
                                                var quantity = parseFloat(document.getElementById('quantity').value) || 0;
                                                var totalPrice = price * quantity;
                                                document.getElementById('total_price').value = totalPrice.toFixed();
                                            }
                                        </script>

                                    </div>


                                </div>

                                <div class="card-footer text-right">
                                    <input type="submit" class="btn btn-primary mr-1" value="บันทึก">

                                </div>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </section>
</div>
@endsection