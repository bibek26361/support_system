@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Departments</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Create
                        <a href="{{ route('department.create') }}" class="btn btn-info btn-xs pull-right">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Create Department</button>
                        </a>

                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Department Name</th>
                                        <th>Contact Number</th>
                                        <th>Contact Network</th>
                                        <th>Department Code</th>

                                        <th>Status</th>


                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($departments as $department)
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $department->departmentname }}</td>
                                        <td>{{ $department->contact }}</td>
                                        <td>{{ $department->contact_network }}</td>
                                        <td>{{ $department->code }}</td>




                                        <td>
                                            @if ($department->status)
                                                <span class="badge badge-success"
                                                    style="background-color:green;">Active</span>
                                            @else
                                                <span class="badge badge-danger"
                                                    style="background-color:red;">Inactive</span>
                                            @endif
                                        </td>


                                        <td>



                                            <a href="{{ route('department.edit', $department->id) }}">
                                                <button type="button" class="btn btn-primary btn-rounded btn-sm my-0"><i
                                                        class="fa fa-edit fa-fw"></i>
                                                    modify
                                                </button></a>



                                            <span style="display:inline-block">
                                                <form action="{{ route('department.destroy', $department->id) }}"
                                                    method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete?')">
                                                        <i class="fas fa-trash" aria-hidden="true" style="color:white"></i>
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
