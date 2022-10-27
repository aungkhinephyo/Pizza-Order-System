@extends('user.layouts.master')
@section('title', 'My Orders')

@section('content')

    <!-- Cart Start -->
    <div class="container-fluid mt-2">
        <a href="javascript:void(0);" class="text-decoration-none btn btn-dark rounded-2 mb-3"
            onclick="window.history.back();"><i class="fas fa-arrow-left text-light"></i> Back</a>

        <div class="row px-xl-5">
            <h3 class=" text-center text-uppercase mx-auto mb-3"><span class="bg-secondary pr-3">Order History</span></h3>
            @if (count($orders) !== 0)
                <div class="col-lg-8 table-responsive mx-auto mb-5" style="height: 450px">
                    <table class="table table-light table-borderless table-hover text-center mb-3">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>Order ID</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="row-container" class="align-middle">

                            @foreach ($orders as $order)
                                <tr class="fw-bold">
                                    <td class="align-middle">{{ $order->updated_at->format('M-j-Y') }}</td>
                                    <td class="align-middle">{{ $order->order_code }}</td>
                                    <td class="align-middle">$ {{ $order->total_price }}</td>
                                    <td class="align-middle">
                                        @if ($order->status === 0)
                                            <span class="custom-badge bg-info">pending</span>
                                        @elseif ($order->status === 1)
                                            <span class="custom-badge bg-success">complete</span>
                                        @elseif($order->status === 2)
                                            <span class="custom-badge bg-danger">reject</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
            @else
                <h5 class="alert alert-info text-center w-50 mx-auto mt-5">There is no previous order.</h5>
            @endif
        </div>
    </div>
    <!-- Cart End -->

@endsection
