@extends('admin.layouts.master')
@section('title', 'Admin List Page')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool mb-4">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap btn-group">
                                <a href="{{ route('admin#account#listPage') }}"
                                    class="btn @if (request()->is('admin/account/listPage')) btn-warning @else btn-dark @endif">Admins</a>
                                <a href="{{ route('admin#account#user#listPage') }}"
                                    class="btn @if (request()->is('admin/account/userListPage')) btn-warning @else btn-dark @endif">Users</a>
                            </div>
                        </div>
                    </div>

                    {{-- Start Search box --}}
                    <div class="row mb-4">
                        <div class="col-6 d-flex align-items-center">
                            <h4 class="btn btn-dark rounded-pill shadow-sm">Total: {{ $admins->total() }}</h4>
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

                    @if (count($admins) != 0)
                        @foreach ($admins as $admin)
                            <div class="row" id="admin_{{ $admin->id }}">
                                <div class="col-lg-10 mx-auto" id="admin_{{ $admin->id }}">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title d-flex justify-content-between align-items-center px-2">

                                                <h4 class="text-center text-uppercase">{{ $admin->role }}</h4>

                                                @if (Auth::user()->role === 'president')
                                                    @if ($admin->role !== 'president')
                                                        <button type="button" class="btn btn-dark remove-btn"
                                                            data-id="{{ $admin->id }}"><i
                                                                class="fas fa-user-times text-danger mr-2"></i> Remove
                                                            Account</button>
                                                    @endif
                                                @endif

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-lg-4 ml-auto d-flex align-items-center">

                                                    @if ($admin->image == null)
                                                        @if ($admin->gender == 'male')
                                                            <img src="{{ asset('images/default-user.jpg') }}"
                                                                class="profile_img rounded-circle">
                                                        @else
                                                            <img src="{{ asset('images/female_default.webp') }}"
                                                                class="profile_img rounded-circle">
                                                        @endif
                                                    @else
                                                        <img src="{{ asset('storage/admin_profile/' . $admin->image) }}"
                                                            class="profile_img rounded-circle">
                                                    @endif

                                                </div>

                                                <div class="col-lg-6 ml-auto d-flex align-items center">

                                                    <ul class="list-unstyled">
                                                        <li class="my-3" style="font-weight:bold;"><i
                                                                class="fas fa-user text-primary mr-3"></i>{{ $admin->name }}
                                                        </li>
                                                        <li class="my-3" style="font-weight:bold;"><i
                                                                class="fas fa-envelope text-primary mr-3"></i>{{ $admin->email }}
                                                        </li>
                                                        <li class="my-3" style="font-weight:bold;">
                                                            <i
                                                                class="fas fa-phone-volume text-primary mr-3"></i>{{ $admin->phone }}
                                                        </li>
                                                        <li class="my-3" style="font-weight:bold;">
                                                            <i
                                                                class="fas fa-map-marker-alt text-primary mr-3"></i>{{ $admin->address }}
                                                        </li>
                                                        @if (Auth::user()->role === 'president')
                                                            @if ($admin->role !== 'president')
                                                                <li>
                                                                    <div class="d-flex align-items-center">

                                                                        <i class="fas fa-info-circle text-primary mr-3"></i>

                                                                        <div class="input-group fs-6 w-50">
                                                                            <select name="role"
                                                                                class="form-control change-role"
                                                                                data-id="{{ $admin->id }}">
                                                                                <option value="admin"
                                                                                    @if ($admin->role === 'admin') selected @endif>
                                                                                    Admin</option>
                                                                                <option value="user"
                                                                                    @if ($admin->role === 'user') selected @endif>
                                                                                    User</option>
                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endif

                                                    </ul>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- END DATA TABLE -->
                        {{ $admins->links() }}
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
        $(document).ready(function() {

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
                            url: '/admin/account/delete',
                            data: {
                                'id': id
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    $(document).find('#admin_' + id).remove();
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

            $(document).on('change', '.change-role', function() {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to change this account's role",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const id = $(this).data('id');
                        const role = $(this).val();
                        $.ajax({
                            type: 'get',
                            url: '/admin/account/changeRole',
                            data: {
                                'id': id,
                                'role': role
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    $(document).find('#admin_' + id).remove();
                                }
                            }
                        })

                        Swal.fire(
                            'Updated!',
                            'That account has been changed in role.',
                            'success'
                        )
                    }
                })
            })

        })
    </script>
@endsection
