@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Log</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Organization Log
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>User</th>
                                        <th>Operation</th>
                                        <th>Description</th>
                                        <th>Operation At</th>
                                        <th>Operation Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logData as $log)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $log->organization_name }}</td>
                                            <td>{{ $log->operation }}</td>
                                            <td>{!! $log->description !!}</td>
                                            <td>{{ $log->operation_at }}</td>
                                            <td>{{ $log->operation_time }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if (Session()->has('success'))
                            <script>
                                alert(`{{ Session()->get('success') }}`)
                            </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
