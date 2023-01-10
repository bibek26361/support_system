@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Tasks</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Tasks
                        <a href="{{ route('task.create') }}">
                            <button type="button" class="btn btn-success btn-xs pull-right"><i class="fa fa-user-plus"
                                    aria-hidden="true"></i>
                                Create Task
                            </button>
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Image</th>
                                        <th>Task</th>
                                        <th>Assign To</th>
                                        <th>priority</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ $task->image }}" height="50" width="50"></td>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->user ? $task->user->name : 'N/A' }}</td>
                                            <td>
                                                @if ($task->priority === 5)
                                                    <span class="badge badge-danger"
                                                        style="background-color:red;">Highest</span>
                                                @elseif($task->priority === 4)
                                                    <span class="badge badge-warning"
                                                        style="background-color:blue; ">High</span>
                                                @elseif($task->priority === 3)
                                                    <span
                                                        class="badge badge-primary"style="background-color:green;">Medium</span>
                                                @elseif($task->priority === 2)
                                                    <span class="badge badge-info"
                                                        style="background-color:yellow; color:black;">Low</span>
                                                @elseif($task->priority === 1)
                                                    <span class="badge badge-secondary"
                                                        style="background-color:gray;">Lowest</span>
                                                @else
                                                    <span class="badge badge-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($task->status === 2)
                                                    <span class="badge badge-primary"
                                                        style="background-color:green;">Opened</span>
                                                @elseif($task->status === 1)
                                                    <span class="badge badge-warning"
                                                        style="background-color:blue;">Assigned</span>
                                                @else
                                                    <span class="badge badge-success"
                                                        style="background-color:red;">Closed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('task.show', $task->id) }}">
                                                    <button type="button" class="btn btn-info btn-rounded btn-sm my-0"><i
                                                            class="fa fa-eye fa-fw"></i>
                                                        View
                                                    </button>
                                                </a>
                                                <a href="{{ route('task.edit', $task->id) }}">
                                                    <button type="button"
                                                        class="btn btn-primary btn-rounded btn-sm my-0"><i
                                                            class="fa fa-edit fa-fw"></i>
                                                        Modify
                                                    </button>
                                                </a>
                                                <span style="display:inline-block">
                                                    <form action="{{ route('task.destroy', $task->id) }}" method="post">
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
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
@endsection
