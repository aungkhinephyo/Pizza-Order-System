@extends('admin.layouts.master')
@section('title', 'Product Page')

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
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('admin#product#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add product
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    {{-- Start Search box --}}
                    <div class="row mb-4">
                        <div class="col-6 d-flex align-items-center">
                            <h4 class="btn btn-dark rounded-pill shadow-sm">Total: {{ $products->total() }}</h4>
                        </div>
                        <div class="col-6">
                            <form action="" method="get">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="searchKey" class="form-control"
                                        value="{{ request('searchKey') }}" placeholder="Search..." />
                                    <button type="submit" class="input-group-text"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- End Search box --}}

                    @if (count($products) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr class="bg-dark">
                                        <th>Preview</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>View Count</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $index => $product)
                                        <tr class="tr-shadow">
                                            <td><img src="{{ asset('storage/product_img/' . $product->image) }}"
                                                    class="product_img"></td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category_name }}</td>
                                            <td>${{ $product->price }}</td>
                                            <td><i class="fas fa-eye"></i> {{ $product->view_count }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="{{ route('admin#product#detailsPage', $product->id) }}"
                                                        class="item" data-toggle="tooltip" data-placement="top"
                                                        title="details">
                                                        <i class="zmdi zmdi-eye text-primary"></i>
                                                    </a>
                                                    <a href="{{ route('admin#product#editPage', $product->id) }}"
                                                        class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Edit">
                                                        <i class="zmdi zmdi-edit text-primary"></i>
                                                    </a>
                                                    <a href="{{ route('admin#product#delete', $product->id) }}"
                                                        class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="zmdi zmdi-delete text-danger"></i>
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
                        {{ $products->links() }}
                    @else
                        <div class="alert alert-info text-center mt-5">There is no items to show.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection

@section('script')
    <script>
        /* after create product show alert box */
        @if (session('createSuccess'))
            Swal.fire({
                icon: 'success',
                title: 'Successfully Created',
                text: 'New product is successfully created.',
            })
        @endif

        /* after delete product show alert box */
        @if (session('deleteSuccess'))
            Swal.fire({
                icon: 'success',
                title: 'Successfully Deleted',
                text: 'That product is successfully deleted.',
            })
        @endif

        /* after update product show alert box */
        @if (session('editSuccess'))
            Swal.fire({
                icon: 'success',
                title: 'Successfully Updated',
                text: 'That product is successfully updated.',
            })
        @endif

        /* after no edit show alert box */
        @if (session('noEdit'))
            Swal.fire({
                icon: 'info',
                title: 'No Update',
                text: 'That product is the same as the old.',
            })
        @endif
    </script>
@endsection
