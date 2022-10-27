@extends('admin.layouts.master')
@section('title', 'Message List Page')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content ">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Mesasge Inbox</h2>

                            </div>
                        </div>
                    </div>

                    {{-- Start Search box --}}
                    <div class="row mb-4">
                        <div class="col-6 d-flex align-items-center">
                            <h4 class="btn btn-dark rounded-pill shadow-sm">Total: {{ $messages->total() }}</h4>
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

                    @if (count($messages) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr class="bg-dark">
                                        <th>No.</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Subject</th>
                                        <th>Sent at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $index => $message)
                                        <tr class="tr-shadow" id="message_{{ $message->id }}">
                                            <td>{{ $index + 1 }}.</td>
                                            <td>{{ $message->name }}</td>
                                            <td>{{ $message->email }}</td>
                                            <td>{{ $message->phone }}</td>
                                            <td>{{ $message->subject }}</td>
                                            <td>{{ $message->created_at->format('M-j-Y g:i a') }}</td>
                                            <td class="d-flex align-items-center justify-content-center">
                                                <div class="table-data-feature">
                                                    <a href="{{ route('admin#contact#messageDetails', $message->id) }}"
                                                        class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Message Details"><i
                                                            class="fas fa-info-circle text-primary"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="item remove-btn"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"
                                                        data-id="{{ $message->id }}"><i
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

                        {{ $messages->links() }}
                    @else
                        <div class="alert alert-info text-center mt-5">There is no message to show.</div>
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
                            url: '/admin/contact/delete',
                            data: {
                                'id': id
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    $(document).find('#message_' + id).remove();
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
