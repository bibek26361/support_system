@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Survey</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Manage Survey
                        <a href="{{ route('surveys.create') }}">
                            <button type="button" class="btn btn-success btn-xs pull-right"><i class="fa fa-plus-circle"
                                    aria-hidden="true"></i>
                                Create Survey</button>
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Signature</th>
                                        <th>Organization</th>
                                        <th>Representative Name</th>
                                        <th>Survey By</th>
                                        <th>Survey At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($surveys as $survey)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ $survey->signature_image }}" height="70" width="70">
                                            </td>
                                            <td>{{ $survey->organization->organizationname }}</td>
                                            <td>{{ $survey->representative_name }}</td>
                                            <td>{!! $survey->user->name !!}</td>
                                            <td>{{ $survey->survey_at }}</td>
                                            <td>
                                                <a href="{{ route('surveys.show', $survey->id) }}">
                                                    <button type="button" class="btn btn-info btn-rounded btn-sm my-0"><i
                                                            class="fa fa-eye fa-fw"></i>
                                                        View
                                                    </button>
                                                </a>
                                                <a href="{{ route('surveys.edit', $survey->id) }}">
                                                    <button type="button"
                                                        class="btn btn-primary btn-rounded btn-sm my-0"><i
                                                            class="fa fa-edit fa-fw"></i>
                                                        Modify
                                                    </button>
                                                </a>
                                                <span style="display:inline-block">
                                                    <form action="{{ route('surveys.destroy', $survey->id) }}"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete?')">
                                                            <i class="fas fa-trash" aria-hidden="true"
                                                                style="color:white"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- /.table-responsive -->
                        @if (Session()->has('success'))
                            <script>
                                alert(`{{ Session()->get('success') }}`)
                            </script>
                        @endif

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
        </div>
    @endsection
