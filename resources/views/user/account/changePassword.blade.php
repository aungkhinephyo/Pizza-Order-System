@extends('user.layouts.master')
@section('title', 'User Password Change')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="container-fluid">

        <a href="javascript:void(0);" class="text-decoration-none btn btn-dark rounded-2 my-3"
            onclick="window.history.back();"><i class="fas fa-arrow-left text-light"></i> Back</a>

        <div class="col-lg-5 mx-auto mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2">Change Password</h3>
                    </div>
                    <hr>
                    <form action="{{ route('user#account#changePassword') }}" method="POST" novalidate="novalidate">
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
                                <i class="fa-solid fa-circle-right"></i>
                            </button>
                        </div>
                    </form>
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
