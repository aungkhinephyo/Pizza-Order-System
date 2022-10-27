@extends('admin.layouts.master')
@section('title', 'Admin Order List Page')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Placed Orders</h2>

                            </div>
                        </div>
                    </div>

                    {{-- Start Search box --}}
                    <div class="row mb-4">
                        <div class="col-6 d-flex align-items-center">
                            <h4 class="btn btn-dark rounded-pill shadow-sm">Total: {{ $orders->total() }}</h4>
                        </div>
                        <div class="col-3 ml-auto d-flex align-items-end">
                            <select name="searchStatus" id="search-status" class="form-control">
                                <option value="all">All</option>
                                <option value="0">Pending</option>
                                <option value="1">Complete</option>
                                <option value="2">Reject</option>
                            </select>
                        </div>
                    </div>
                    {{-- End Search box --}}

                    @if (count($orders) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr class="bg-dark">
                                        <th>Order No.</th>
                                        <th>Customer</th>
                                        <th>Total Price</th>
                                        <th>Placed Time</th>
                                        <th>Status</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="tr-shadow" id="order_{{ $order->id }}">
                                            <td><a
                                                    href="{{ route('admin#order#orderDetails', $order->order_code) }}">{{ $order->order_code }}</a>
                                            </td>
                                            <td>{{ $order->user_name }}</td>
                                            <td>$ {{ $order->total_price }}</td>
                                            <td>{{ $order->created_at->format('M-j-Y') }}</td>
                                            <td>
                                                <div class="table-data-feature align-items-center">
                                                    <select name="status" class="change-status custom-badge"
                                                        data-id='{{ $order->id }}'>
                                                        <option value="0"
                                                            @if ($order->status === 0) selected @endif>pending
                                                        </option>
                                                        <option value="1"
                                                            @if ($order->status === 1) selected @endif>complete
                                                        </option>
                                                        <option value="2"
                                                            @if ($order->status === 2) selected @endif>reject
                                                        </option>
                                                    </select>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="javascript:void(0);" class="item remove-btn"
                                                        data-id="{{ $order->id }}"><i
                                                            class="zmdi zmdi-delete text-danger"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                        {{ $orders->links() }}
                    @else
                        <div class="alert alert-info text-center mt-5">There is no orders now.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $(document).on('change', '#search-status', function() {
                const status = $(this).val();
                $.ajax({
                    type: 'get',
                    url: '/admin/order/sortingOrders',
                    data: {
                        'status': status
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        const orderList = response;
                        $('tbody').html('');
                        const rows = $('tbody tr');
                        var orders = '';

                        const month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug',
                            'Sep', 'Oct', 'Nov', 'Dec'
                        ];


                        for (let i = 0; i < orderList.length; i++) {

                            const date = new Date(orderList[i].updated_at);
                            const formatDate =
                                `${month[date.getMonth()]}-${date.getDate()}-${date.getFullYear()}`;

                            let status = [];
                            if (orderList[i].status === 0) status = ['selected', '', ''];
                            if (orderList[i].status === 1) status = ['', 'selected', ''];
                            if (orderList[i].status === 2) status = ['', '', 'selected'];

                            orders += `
                                <tr class="tr-shadow">
                                    <td><a href="">${orderList[i] . order_code}</a></td>
                                    <td>${orderList[i] . user_name}</td>
                                    <td>$ ${orderList[i] . total_price}</td>
                                    <td>${formatDate}</td>
                                    <td>
                                        <select name="status" class="change-status custom-badge" data-id="${orderList[i].id}">
                                            <option value="0" ${status[0]}>pending</option>
                                            <option value="1" ${status[1]}>complete</option>
                                            <option value="2" ${status[2]}>reject</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="table-data-feature">
                                            <a href="javascript:void(0);" class="item remove-btn"
                                                data-toggle="tooltip" data-placement="top" title="Delete"
                                                data-id="${orderList[i].id}"><i
                                                    class="zmdi zmdi-delete text-danger"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                            `;
                        }

                        $('tbody').html(orders);
                    }
                })
            })

            $(document).on('change', '.change-status', function() {

                $.ajax({
                    type: 'get',
                    url: '/admin/order/changeStatus',
                    data: {
                        'status': $(this).val(),
                        'id': $(this).data('id')
                    },
                    dataType: 'json'
                })

            })

            $(document).on('click', '.remove-btn', function() {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const id = $(this).data('id');
                        $.ajax({
                            type: 'get',
                            url: '/admin/order/delete',
                            data: {
                                'id': id
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    $(document).find('#order_' + id).remove();
                                }
                            }
                        })

                        Swal.fire(
                            'Deleted!',
                            'That account has been deleted.',
                            'success'
                        )
                    }
                })
            })

        })
    </script>
@endsection
