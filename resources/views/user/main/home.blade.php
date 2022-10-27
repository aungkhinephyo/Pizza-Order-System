@extends('user.layouts.master')

@section('title', 'Home Page')

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                        price</span></h5>
                <div class="bg-light p-4 mb-30">

                    <div class="d-flex align-items-center justify-content-between bg-dark text-light p-2 mb-3">
                        <span class="text-warning">Categories</span>
                        <span class="badge border border-light">{{ count($categories) }}</span>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('user#homePage') }}"
                            class="text-decoration-none text-decoration-none text-dark">All</a>
                    </div>
                    @foreach ($categories as $category)
                        <div class="mb-3">
                            <a href="{{ route('filterCategory', $category->id) }}"
                                class="text-decoration-none text-dark">{{ $category->name }}</a>
                        </div>
                    @endforeach

                </div>

            </div>
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{ route('user#cartPage') }}"
                                    class="btn btn-dark rounded-3 mr-2 position-relative">
                                    <i class="fas fa-cart-arrow-down text-light"></i>
                                    <span id="cart-icon"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ count($cart) }}
                                    </span>
                                </a>

                                <a href="{{ route('user#historyPage') }}" class="btn btn-dark rounded-3 position-relative">
                                    <i class="fas fa-history text-light"></i> History
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ count($history) }}
                                    </span>
                                </a>
                            </div>
                            <div class="col-6">
                                <form action="" method="get">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="searchKey" class="form-control"
                                            value="{{ request('searchKey') }}" placeholder="Search..." />
                                        <button type="submit" class="input-group-text"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="ml-2">
                                <div class="">
                                    <select name="sorting" id="sortingProducts" class="form-select">
                                        <option value="">Sorting</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (count($products) !== 0)
                    <div class="row" id="productList">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6 mx-auto p-2">
                                <div class="card pizza_box shadow">

                                    <div class="img_box">
                                        <div class="actions">
                                            <a href="javascript:void(0);"><i class="fas fa-heart"></i></a>
                                            <a href="{{ route('user#prodcutDetailsPage', $product->id) }}"><i
                                                    class="fas fa-info-circle"></i></a>
                                        </div>
                                        <img src="{{ asset('storage/product_img/' . $product->image) }}"
                                            class="pizza_img" />
                                    </div>
                                    <div class="card-body text-center">
                                        <h6>{{ ucwords($product->name) }}</h6>
                                        <h5>${{ $product->price }}</h5>
                                        <div class="mt-3 order">
                                            <input type="number" name="quantity" class="form-control quantity"
                                                min="1" value="1" />
                                            <button type="button" class="btn btn-dark w-100 addtocart-btn"
                                                data-id="{{ $product->id }}">Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center h5">There is no item yet.</i>
                    </div>
                @endif

            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            function sorting(input) {
                console.log(input[1].id);
                $('#productList').html('');
                var product = '';

                for (let i = 0; i < input.length; i++) {

                    // cannot directly pass parameter to route
                    var url = '{{ route('user#prodcutDetailsPage', ':id') }}';
                    url = url.replace(':id', input[i].id);

                    product += `
                        <div class="col-lg-4 col-md-6 mx-auto p-2">
                            <div class="card pizza_box shadow">

                                <div class="img_box">
                                    <div class="actions">
                                        <a href="javascript:void(0);"><i class="fas fa-heart"></i></a>
                                        <a href="${url}"><i class="fas fa-info-circle"></i></a>
                                    </div>
                                    <img src="{{ asset('storage/product_img/${input[i] . image}') }}"
                                        class="pizza_img" />
                                </div>
                                <div class="card-body text-center">
                                    <h6>${input[i].name}</h6>
                                    <h5>$ ${input[i].price}</h5>
                                    <div class="mt-3 order">
                                        <input type="number" name="quantity" class="form-control quantity"
                                            min="1" value="1" />
                                        <button type="button" class="btn btn-dark w-100 addtocart-btn"
                                            data-id="${input[i].id}">Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                `;
                }
                $('#productList').html(product);
                // console.log(product);
            }

            $('#sortingProducts').change(function() {
                var selectOption = $('#sortingProducts').val();
                if (selectOption === 'asc') {
                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/sortingProducts',
                        data: {
                            'status': 'asc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            sorting(response);
                        },
                    })

                } else if (selectOption === 'desc') {
                    $.ajax({
                        type: 'get',
                        url: '/user/ajax/sortingProducts',
                        data: {
                            'status': 'desc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            sorting(response);
                        },
                    })

                }

            })


            $(document).on('click', '.addtocart-btn', function() {
                const product_id = $(this).data('id');
                const quantity = $(this).siblings('input[type="number"]').val();
                console.log(product_id, quantity);
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/addToCart',
                    data: {
                        user_id: {{ Auth::user()->id }},
                        product_id: product_id,
                        quantity: quantity
                    },
                    dataType: 'json',
                    success: function(response) {
                        var count = +$('#cart-icon').text();
                        $('#cart-icon').text(count + 1);
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully added to cart',
                            text: 'Check your cart.',
                        })
                    }
                })
            })


        });
    </script>
@endsection
