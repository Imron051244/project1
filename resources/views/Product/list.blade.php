@extends('layouts.User.footer')

@section('content')

<div id="content" class="site-content">
	<!-- Breadcrumb -->
	<!-- Breadcrumb -->
	<div id="breadcrumb">
		<div class="container">
			@if (isset($getCategoryName))
			<h2 style="font-family: 'Noto Serif Thai', serif; " class="title">{{ $getCategoryName->title }}</h2>
			@else
			<h2 style="font-family: 'Noto Serif Thai', serif; " class="title">สินค้า</h2>
			@endif

		</div>
	</div>


	<div class="container" style="font-family: 'Noto Serif Thai', serif; ">

		<div class="row">
			<!-- Sidebar -->
			<div id="left-column" class="sidebar col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<!-- Block - Product Categories -->
				<div class="block product-categories">
					<h3 class="block-title">ประเภทสินค้า</h3>
					@php
					$getCategory = App\Models\CategoryModel::getRecordMenu();
					@endphp

					@foreach ($getCategory as $CategoryName)
					<div class="block-content">
						<div class="item">
							<a style="font-family: 'Noto Serif Thai', serif; " class="category-title" href="{{route('categoryName', $CategoryName->title)}}">
								{{ $CategoryName->title }}
							</a>
						</div>
					</div>
					@endforeach


				</div>
			</div>


			<!-- Page Content -->
			<div id="center-column" class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
				<div class="product-category-page">
					<!-- Nav Bar -->
					<div class="products-bar">
						<div class="row">
							<div class="col-md-6 col-xs-6">
								<div class="total-products">{{ $getProduct->count() }}</div>
							</div>
						</div>
					</div>

					<div class="tab-content">
						<!-- Products Grid -->
						<div class="tab-pane active" id="products-grid">
							<div class="products-block">
								<div class="row">
									@foreach ($getProduct as $Product)

									@php
									$getProductImage = $Product->getImageSingle($Product->id);
									@endphp

									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<div class="product-item">
											<div class="product-image">
												<a href="{{ route('detail', ['productId' => $Product->title]) }}">
													@if (!empty($getProductImage) && !empty($getProductImage->image_name))
													<img style="height:199px; width:100%" class=" img-responsive"
														src="{{ asset('upload/product/' . $getProductImage->image_name) }}"
														alt="{{$Product->title}}">
													@endif

												</a>
											</div>

											<div class="product-title">
												<a style="font-family: 'Noto Serif Thai', serif; " href="{{ route('detail', ['productId' =>$Product->title]) }}">
													{{$Product->title}}
												</a>
											</div>



											<div class="product-price">
												<span style="font-family: 'Noto Serif Thai', serif; " class="sale-price">฿</span>
											</div>

											<div class="product-buttons">

												<a class="quickview"
													href="{{ route('detail', ['productId' => $Product->title]) }}">
													<i class="fa fa-eye" aria-hidden="true"></i>
												</a>
											</div>
										</div>
									</div>
									@endforeach



								</div>
							</div>
						</div>
					</div>

					<!-- Pagination Bar -->
					<div class="pagination-bar">
						<div class="row">

							<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="text">Showing {{ $getProduct->firstItem() }}-{{ $getProduct->lastItem() }}
									of {{ $getProduct->total() }} item(s)</div>

							</div>

							<div class="col-md-8 col-sm-8 col-xs-12">
								<div class="pagination">
									<ul class="page-list">
										<li><a href="#" class="prev">Previous</a></li>
										<li><a href="#" class="current">1</a></li>
										<li><a href="#">2</a></li>
										<li><a href="#" class="next">Next</a></li>
									</ul>
								</div>
							</div>



						</div>



					</div>
				</div>

			</div>
		</div>
	</div>
</div>


@endsection