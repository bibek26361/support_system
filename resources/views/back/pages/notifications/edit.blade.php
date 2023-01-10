@extends('back.layouts.main')

@push('custom-styles')
    <style>
        #updateAndSend label {
            font-weight: bold;
        }

        #updateAndSend label:first-child {
            margin-right: 10px;
        }
    </style>
@endpush

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Modify Notification</h1>
            </div>
        </div>

        <form action="{{ route('notifications.update', $notification->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="user_id">User <span class="text-danger">*</span></label>
                <select name="user_id" id="user_id" class="form-control select2">
                    <option value="0">All</option>
                    @foreach ($userDevices as $user)
                        <option value="{{ $user->user_id }}"
                            {{ $notification->user_id === $user->user_id ? 'selected' : '' }}>
                            {{ $user->user_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ $notification->title }}" placeholder="Enter Notification Title" required>
            </div>
            <div class="form-group">
                <label for="message">Message <span class="text-danger"></span></label>
                <textarea class="form-control" id="message" name="message" rows="10" required>{{ $notification->message }}</textarea>
            </div>
            <hr>
            <div class="form-group">
                <label>
                    Want to send notification after updating?
                </label>
                <div class="radio" id="updateAndSend">
                    <label>
                        <input type="radio" name="update_and_send" value="1">
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="update_and_send" value="0" checked>
                        No
                    </label>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <button id="updateNotificationBtn" type="submit" class="btn btn-primary pull-right">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('custom-scripts')
    <script></script>
@endpush
