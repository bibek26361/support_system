@extends('back.layouts.main')

@push('custom-styles')
    <style>
        #saveAndSend label {
            font-weight: bold;
        }

        #saveAndSend label:first-child {
            margin-right: 10px;
        }

        table#dataTables-example {
            font-size: 12px;
        }
    </style>
@endpush

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Notifications</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Notifications
                        <button type="submit" class="btn btn-success btn-xs pull-right" data-toggle="modal"
                            data-target="#createNotificationModal"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Create Notification
                        </button>
                    </div>
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover"
                            id="dataTables-example">
                            <thead>
                                <tr>
                                    <th style="width: 6%">S.N</th>
                                    <th style="width: 19%">Target</th>
                                    <th style="width: 15%">Title</th>
                                    <th style="width: 30%">Message</th>
                                    <th style="width: 30%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $key => $notification)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{!! $notification->user_name !!}</td>
                                        <td>{{ $notification->title }}</td>
                                        <td>{{ $notification->message }}</td>
                                        <td style="text-align: center">
                                            <button
                                                onclick="resendNotification('{{ route('notifications.resend', $notification->id) }}')"
                                                class="btn btn-xs btn-info"><i class="fa fa-retweet"></i>
                                                Resend
                                            </button>
                                            @if (!$notification->model_name)
                                                <button
                                                    onclick="sendNotificationToAll('{{ route('notifications.send-to-all', $notification->id) }}')"
                                                    class="btn btn-xs btn-success"><i class="fa fa-send"></i>
                                                    Send To All
                                                </button>
                                                <a href="{{ route('notifications.edit', $notification->id) }}"
                                                    class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>
                                                    Modify
                                                </a>
                                            @endif
                                            <button class="btn btn-danger btn-xs"
                                                onclick="return deleteToast({{ $notification->id }})" type="button"><i
                                                    class="fa fa-trash"></i> Delete</button>
                                            <form class="deleteForm_{{ $notification->id }}"
                                                action="{{ route('notifications.destroy', $notification->id) }}"
                                                method="post">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createNotificationModal">
        <div class="modal-dialog model-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i> Create Notification</h4>
                </div>
                <form action="{{ route('notifications.createNotification') }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">User <span class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-control select2" style="width: 100%">
                                <option value="0">All</option>
                                @foreach ($userDevices as $user)
                                    <option value="{{ $user->user_id }}">{{ $user->user_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Enter Notification Title" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message <span class="text-danger"></span></label>
                            <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>
                                Want to send notification after saving?
                            </label>
                            <div class="radio" id="saveAndSend">
                                <label>
                                    <input type="radio" name="save_and_send" value="1">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" name="save_and_send" value="0" checked>
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        @if (session('response'))
            let response = `{!! json_encode(session('response')) !!}`;
            response = JSON.parse(response);
            let {
                status,
                title,
                message
            } = response;
            Swal.fire(title, message, status);
        @endif

        function resendNotification(url) {
            console.log(url);
            Swal.fire({
                title: 'Are you sure?',
                text: "You notification will be sent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085D6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, resend it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        function sendNotificationToAll(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You notification will be sent to all!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085D6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, send it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        function deleteToast(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085D6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`.deleteForm_${id}`).submit();
                }
            });
        }
    </script>
@endpush
