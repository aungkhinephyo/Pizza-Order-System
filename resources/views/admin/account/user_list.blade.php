@extends('admin.layouts.master')
@section('title', 'User List')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content">
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
                            <h4 class="btn btn-dark rounded-pill shadow-sm">Total: {{ $users->total() }}</h4>
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

                    @if (count($users) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr class="bg-dark">
                                        <th>ID</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="tr-shadow" id="user_{{ $user->id }}">
                                            <td class="user_id">{{ $user->id }}</td>
                                            <td class="px-2">
                                                @if ($user->image == null)
                                                    @if ($user->gender == 'male')
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                            class="product_img">
                                                    @else
                                                        <img src="{{ asset('images/female_default.webp') }}"
                                                            class="product_img">
                                                    @endif
                                                @else
                                                    <img src="{{ asset('storage/user_profile/' . $user->image) }}"
                                                        class="product_img">
                                                @endif
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>
                                                <select name="role" class="form-control change-role">
                                                    <option value="admin"
                                                        @if ($user->role === 'admin') selected @endif>
                                                        Admin</option>
                                                    <option value="user"
                                                        @if ($user->role === 'user') selected @endif>
                                                        User</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <button class="item remove-btn">
                                                        <i class="zmdi zmdi-delete text-danger"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                        {{ $users->links() }}
                        {{-- {{ $categories->appends(request()->query())->links() }} --}}
                    @else
                        <div class="alert alert-info text-center mt-5">There is no user.</div>
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
                        const id = $(this).parents('tr').find('.user_id').text();
                        $.ajax({
                            type: 'get',
                            url: '/admin/account/delete',
                            data: {
                                'id': id
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    $(document).find('#user_' + id).remove();
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
                        const id = $(this).parents('tr').find('.user_id').text();
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
                                    $(document).find('#user_' + id).remove();
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
