@extends('layouts.User.footer')

@section('content')

<div id="content" class="site-content">
    <!-- Breadcrumb -->
    <div id="breadcrumb">
        <div class="container">
            <h2 class="title">รายการสินค้า</h2>

        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="container">
        <div class="page-cart">

            <form action="{{url('update_cart')}}" method="post">
                {{ csrf_field()}}
                <div class="table-responsive">

                    <table class="cart-summary table table-bordered">
                        <thead>
                            <tr>
                                <th class="width-20">&nbsp;</th>
                                <th class="width-80 text-center">Image</th>
                                <th>Name</th>
                                <!-- <th class="width-100 text-center">Unit grade</th> -->
                                <th class="width-100 text-center"></th>
                                <th class="width-100 text-center"></th>
                                <th class="width-100 text-center">Qty</th>
                            </tr>
                        </thead>

                        <tbody>

                            

                            @php
                            $getCartProduct = App\Models\ProductModel::getSingle($header_cart->id);
                            $getProductImage = $getCartProduct->getImageSingle($getCartProduct->id);
                            @endphp

                            @if (!empty($getCartProduct))

                            @if (auth()->check() && auth()->user()->type === 'ผู้ขาย')
                            <tr>
                                <td class="product-remove">
                                    <a title="Remove this item" class="remove"
                                        href="{{url('cart/delete/' . $header_cart->id) }}"
                                        onclick="return confirm('คุณจะลบสินค้า {{$header_cart->name}} ?')">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                                <td>
                                    <a>
                                        <img width="80" style="height: 63.11px; width:63.11px;" alt="Product Image"
                                            class="img-responsive"
                                            src="{{ asset('upload/product/' . $getProductImage->image_name) }}">
                                    </a>
                                </td>
                                <td>
                                    <a class="product-name">{{ $header_cart->name }}

                                    </a>
                                </td>

                                <td class="text-center">


                                </td>
                                <td>

                                </td>
                                <td class="text-center">
                                    <div class="product-quantity">
                                        <div class="qty">
                                            <div class="input-group">
                                                <input type="number" name="cart[{{ $key }}][qty]"
                                                    value="" min="1" max="100" step="1"
                                                    data-decimals="0">
                                            </div>
                                            <input type="hidden" name="cart[{{$key}}][id]"
                                                value="">

                                        </div>
                                    </div>
                                </td>
                            </tr>

                            @else
                            @php
                            $gradeName = $header_cart->attributes->grade_name ?? 'ไม่ระบุ';
                            @endphp
                            <tr>
                                <td class="product-remove">
                                    <a title="Remove this item" class="remove"
                                        href="{{url('cart/delete/' . $header_cart->id) }}"
                                        onclick="return confirm('คุณจะลบสินค้า {{$header_cart->name}} ?')">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                                <td>
                                    <a>
                                        <img width="80" style="height: 63.11px; width:63.11px;" alt="Product Image"
                                            class="img-responsive"
                                            src="{{ asset('upload/product/' . $getProductImage->image_name) }}">
                                    </a>
                                </td>
                                <td>
                                    <a class="product-name">{{ $header_cart->name }} x {{$gradeName}}

                                    </a>
                                </td>

                                <td class="text-center">
                                    {{$header_cart->gradeName}}
                                    ฿{{ $header_cart->price }}
                                </td>
                                <td>
                                    <div class="product-quantity">
                                        <div class="qty">
                                            <div class="input-group">
                                                <input type="number" name="cart[{{ $key }}][qty]"
                                                    value="{{ $header_cart->quantity }}" min="1" max="100" step="1"
                                                    data-decimals="0">
                                            </div>
                                            <input type="hidden" name="cart[{{$key}}][id]"
                                                value="{{ $header_cart->id }}">

                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    ฿{{ $header_cart->price * $header_cart->quantity }}
                                </td>
                            </tr>
                            @endif
                            @endif
                            @endforeach

                        </tbody>

                        <tfoot>

                            <tr class="cart-total">
                                <td rowspan="3" colspan="3"></td>
                                <td colspan="2" class="text-right">Total products</td>
                                <td colspan="1" class="text-center">฿{{Cart::getTotal()}}</td>
                            </tr>
                            <tr class="cart-total">
                                <td colspan="2" class="text-right">Total shipping</td>
                                <td colspan="1" class="text-center">฿10</td>
                            </tr>

                            <tr class="cart-total">
                                <td colspan="2" class="total text-right">Total</td>
                                <td colspan="1" class="total text-center">฿{{Cart::getTotal()}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="checkout-btn">
                    <a href="{{url('checkout')}}" class="btn btn-primary pull-right" title="Proceed to checkout">
                        <span>shipping</span>
                        <i class="fa fa-angle-right ml-xs"></i>
                    </a>
                </div>

                <div class="checkout-btn">
                    <button type="submit" class="btn btn-primary pull-right" title="Proceed to checkout">
                        <span>Update Cart</span>
                        <i class="fa fa-angle-right ml-xs"></i>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection