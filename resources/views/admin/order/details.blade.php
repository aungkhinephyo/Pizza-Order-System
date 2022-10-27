@extends('admin.layouts.master')
@section('title', 'Order Info')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">

        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <a href="javascript:void(0);" onclick="window.history.back()"><button
                        class="btn bg-dark text-white my-2 mx-3"><i class="fas fa-arrow-left"></i> Back</button></a>
                <div class="col-md-12">

                    @if (count($orderLists) != 0)

                        <div class="col-6 p-4 mb-4 bg-white shadow">
                            <h4 class="text-center mb-3"><i class="fas fa-clipboard-list"></i> Order Details <br> <span
                                    class="small text-info">**Include delivery charge**</span></h4>

                            <div class="row col-12 d-flex align-items-center">
                                <div class="col-6">
                                    <p class="mb-2"><i class="fas fa-barcode"></i> Order Code:</p>
                                    <p class="mb-2"><i class="fas fa-user"> </i> Customer:</p>
                                    <p class="mb-2"><i class="fas fa-money-check-alt"></i> Overall Price:</p>
                                    <p class="mb-2"><i class="fas fa-clock"></i> Placed at:</p>
                                </div>
                                <div class="col-6 p-0" style="font-weight: bold !important">
                                    <p class="mb-2">{{ $orderLists[0]->order_code }}</p>
                                    <p class="mb-2">{{ $orderLists[0]->user_name }}</p>
                                    <p class="mb-2">$ {{ $overallprice[0] }}</p>
                                    <p class="mb-2">{{ $orderLists[0]->updated_at->format('M-j-Y g:i a') }}</p>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr class="bg-dark">
                                        <th>No.</th>
                                        <th>Item Image</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        {{-- <th>Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderLists as $index => $list)
                                        <tr class="tr-shadow">
                                            <td>{{ $index + 1 }}</td>
                                            <td><img src="{{ asset('storage/product_img/' . $list->image) }}"
                                                    class="product_img"></td>
                                            <td>{{ $list->product_name }}</td>
                                            <td>{{ $list->quantity }}</td>
                                            <td>$ {{ $list->total_price }}</td>

                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    @else
                        <div class="alert alert-info text-center mt-5">There is no items.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection

@section('script')
    <script></script>
@endsection
