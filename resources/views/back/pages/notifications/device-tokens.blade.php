@extends('back.layouts.main')

@push('custom-styles')
    <style>
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
                        Device Tokens
                    </div>
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Customer</th>
                                    <th>Device Token</th>
                                    <th>Notification Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deviceTokens as $key => $deviceToken)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{!! $deviceToken->customer_name !!}</td>
                                        <td>{{ $deviceToken->device_token }}</td>
                                        <td>
                                            @if ($deviceToken->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
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
@endsection
@push('custom-scripts')
    <script>
    </script>
@endpush
