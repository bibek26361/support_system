@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Products</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Manage Product Type
                        <a href="{{ route('producttypes.create') }}">
                            <button type="button" class="btn btn-success btn-xs pull-right"><i class="fa fa-user-plus"
                                    aria-hidden="true"></i>
                                Create Product Type</button>
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productTypes as $productType)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $productType->name }}</td>
                                            <td>{{ $productType->description ?? 'N/A' }}</td>
                                            <td>
                                                @if ($productType->status)
                                                    <span class="badge badge-success"
                                                        style="background-color:green;">Active</span>
                                                @else
                                                    <span class="badge badge-danger"
                                                        style="background-color:red;">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('producttypes.edit', $productType->id) }}">
                                                    <button type="button"
                                                        class="btn btn-primary btn-rounded btn-sm my-0"><i
                                                            class="fa fa-edit fa-fw"></i>
                                                        Modify
                                                    </button>
                                                </a>
                                                <span style="display:inline-block">
                                                    <form action="{{ route('producttypes.destroy', $productType->id) }}"
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
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
@endsection
