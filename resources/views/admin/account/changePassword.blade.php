@extends('admin.layouts.master')
@section('title', 'Admin Password Change Page')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 mx-auto text-right">
                        <a href="{{ route('admin#category#list') }}"><button
                                class="btn bg-dark text-white my-3 mx-2">List</button></a>
                    </div>
                </div>
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Change Password</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#account#changePassword') }}" method="POST"
                                novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label mb-1">Old Password</label>
                                    <input name="oldPassword" type="password"
                                        class="form-control @error('oldPassword')
                                        is-invalid @enderror"
                                        aria-required="true" aria-invalid="false" autofocus />
                                    @error('oldPassword')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">New Password</label>
                                    <input name="newPassword" type="password"
                                        class="form-control @error('newPassword')
                                        is-invalid @enderror"
                                        aria-required="true" aria-invalid="false" autofocus />
                                    @error('newPassword')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Confirm Password</label>
                                    <input name="confirmPassword" type="password"
                                        class="form-control @error('confirmPassword')
                                        is-invalid @enderror"
                                        aria-required="true" aria-invalid="false" autofocus />
                                    @error('confirmPassword')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <span id="payment-button-amount"><i class="fas fa-edit mr-1"></i>Update
                                            Password</span>
                                        {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                        <i class="fa-solid fa-circle-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection

@section('script')
    <script>
        /* after old password wrong show alert box */
        @if (session('passwordWrong'))
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'Seems like you forgot your old password. Try again!!',
            })
        @endif
    </script>
@endsection
