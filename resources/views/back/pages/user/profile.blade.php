@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">My Profile</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="container-fluid">
                            <div style="display: flex; flex-direction: column; align-items: center">
                                <img src="{{ $user->profile_image }}" height="100" width="100"
                                    style="border-radius: 50%;">
                                <h3 class="text-light display-6" style="text-align: center;">
                                    {{ $user->name }}
                                </h3>
                                <p class="text-light display-6" style="text-align: center;">
                                    {{ $user->email }}
                                </p>
                                <p class="text-light display-6" style="text-align: center;">
                                    {{ $user->contact }}
                                </p>
                                <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary btn-xs">
                                    <i class="fa fa-edit"></i> Edit Profile
                                </a>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive table-responsive-data2" style="background-color:white;">
                                        <table class="table table-bordered table-data2">
                                            <tbody style="font-size: 13px">
                                                <tr>
                                                    <th>Name</th>
                                                    <th style="font-weight: normal">
                                                        {{ $user->name }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Department</th>
                                                    <th style="font-weight: normal">
                                                        {{ $user->department->departmentname }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <th style="font-weight: normal">
                                                        {{ $user->email }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Mobile No.</th>
                                                    <th style="font-weight: normal">
                                                        {{ $user->contact }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <th style="font-weight: normal">
                                                        {{ $user->address }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <th style="font-weight: normal">
                                                        @if ($user->status)
                                                            <span class="badge badge-primary"
                                                                style=background-color:green;>Active</span>
                                                        @else
                                                            <span class="badge badge-success"
                                                                style=background-color:red;>Suspended</span>
                                                        @endif
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('custom-scripts')
    <script></script>
@endpush
