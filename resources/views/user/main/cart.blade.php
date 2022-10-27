@extends('user.layouts.master')
@section('title', 'My Cart')

@section('content')

    <!-- Cart Start -->
    <div class="container-fluid mt-2">
        <a href="javascript:void(0);" class="text-decoration-none btn btn-dark rounded-2 mb-5"
            onclick="window.history.back();"><i class="fas fa-arrow-left text-light"></i> Back</a>

        <div class="row px-xl-5">
            <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Items In
                    Cart</span></h2>
            @if (count($cart) !== 0)
                <div class="col-lg-8 table-responsive mb-5">
                    <div class="d-flex justify-content-end mb-2">
                        <button type="button" id="clear-btn" class="btn btn-danger w-25 rounded-2"><i
                                class="fas fa-trash-alt"></i>
                            Clear
                            Cart</button>
                    </div>
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Order Items</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody id="row-container" class="align-middle">

                            @foreach ($cart as $index => $item)
                                <tr data-price="{{ $item->price }}" data-user-id={{ $item->user_id }}
                                    data-product-id={{ $item->product_id }} data-cart-id={{ $item->id }}>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="align-middle">
                                        {{ $item->name }}</td>
                                    <td class="align-middle">$ {{ $item->price }}</td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text"
                                                class="form-control form-control-sm bg-secondary border-0 text-center quantities"
                                                value="{{ $item->quantity }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle row-total">$ {{ $item->price * $item->quantity }}</td>
                                    <td class="align-middle"><button type="button"
                                            class="btn btn-sm btn-danger removeItem-btn"><i
                                                class="fa fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="col-lg-4">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                            Summary</span></h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>
                                <h6 id="subtotal-price">$ {{ $subtotal }}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Delivery Charge</h6>
                                <h6 class="font-weight-medium">$3</h6>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total</h5>
                                <h5 id="total-price">$ {{ $subtotal + 3 }}</h5>
                            </div>
                            <button id="checkout-btn" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed
                                To
                                Checkout</button>
                        </div>
                    </div>
                </div>
            @else
                <h5 class="alert alert-info text-center w-50 mx-auto">There is no item in your cart.</h5>
            @endif

        </div>
    </div>
    <!-- Cart End -->

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            function changeRowPrice() {
                console.log('wroks');
                const row = $(this).parents('tr');
                const price = +row.data('price');
                const quantity = +row.find('.quantities').val();
                const rowTotal = '$ ' + (price * quantity);
                row.find('.row-total').text(rowTotal);

                changeTotalPrice();
            };

            function changeTotalPrice() {

                const rows = $('tbody tr');
                const deliveryCharge = 3;
                var subTotal = 0;

                rows.each(function(index, row) {
                    const rowTotal = +$(row).find('.row-total').text().replace('$ ', '');
                    subTotal += rowTotal
                });

                $('#subtotal-price').text(`$ ${subTotal}`)

                if (subTotal !== 0) {
                    $('#total-price').text(`$ ${subTotal + deliveryCharge}`);
                } else {
                    $('#total-price').text(`$ ${subTotal}`);
                }

            }

            function removeRow() {
                const row = $(this).parents('tr');
                const cart_id = row.data('cart-id');
                row.remove();
                changeTotalPrice();

                $.ajax({
                    type: 'get',
                    url: '/user/ajax/removeRow',
                    data: {
                        'cart_id': cart_id
                    },
                    dataType: 'json',
                })

            }

            function removeAll() {
                Swal.fire({
                    title: 'Are you sure to remove all?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('tbody tr').each(function(index, row) {
                            $(row).remove();
                        })

                        $.ajax({
                            type: 'get',
                            url: '/user/ajax/clearCart',
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    window.location.reload();
                                }
                            }
                        })

                        Swal.fire(
                            'Deleted!',
                            'Your cart is now empty.',
                            'success'
                        )
                    }
                })
            }

            function checkOut() {
                Swal.fire({
                    title: 'Are you ready to proceed?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Order now'
                }).then((result) => {
                    if (result.isConfirmed) {

                        const orderList = [];
                        const rows = $('tbody tr');
                        const orderCode = Math.floor(Math.random() * 100000001);
                        rows.each(function(index, row) {
                            orderList.push({
                                'user_id': +$(row).data('user-id'),
                                'product_id': +$(row).data('product-id'),
                                'quantity': +$(row).find('.quantities').val(),
                                'total_price': +$(row).find('.row-total').text()
                                    .replace('$ ', ''),
                                'order_code': 'POS' + orderCode
                            })
                        });

                        $.ajax({
                            type: 'get',
                            url: '/user/ajax/addToOrderList',
                            data: Object.assign({}, orderList),
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    window.location.href =
                                        '{{ route('user#homePage') }}';
                                }
                            }
                        })

                        Swal.fire(
                            'Order Complete',
                            'Check your history.',
                            'success'
                        )
                    }
                })
            }

            $(document).on('click', '.btn-minus', changeRowPrice);
            $(document).on('click', '.btn-plus', changeRowPrice);
            $(document).on('click', '.removeItem-btn', removeRow);
            $(document).on('click', '#clear-btn', removeAll);
            $(document).on('click', '#checkout-btn', checkOut)

        })



        // $(document).on('change', '#quantity', changePrice)
    </script>
@endsection
