@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage User</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Users
                        <a href="{{ route('user.create') }}">
                            <button type="button" class="btn btn-success btn-xs pull-right"><i class="fa fa-user-plus"
                                    aria-hidden="true"></i>
                                Create User
                            </button>
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Profile</th>
                                        <th>Department</th>
                                        <th> Name</th>
                                        <th>Email</th>
                                        <th>Contact No.</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ $user->profile_image }}" height="50" width="50"></td>
                                            <td>{{ $user->department->departmentname }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->contact }}</td>
                                            <td>
                                                @if ($user->status)
                                                    <span
                                                        class="badge badge-success"style=background-color:green;>Active</span>
                                                @else
                                                    <span
                                                        class="badge badge-danger"style=background-color:red;>Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('user.edit', $user->id) }}">
                                                    <button type="button"
                                                        class="btn btn-primary btn-rounded btn-xs my-0"><i
                                                            class="fa fa-edit fa-fw"></i>
                                                        Modify
                                                    </button></a>
                                                <span style="display:inline-block">
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-danger btn-xs"
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
