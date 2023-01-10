@extends('back.layouts.main')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Problems</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create
                    <a href="{{route('problemtype.create')}}">
                        <div class="text-right">
                            <button type="button" class="btn btn-info " text-right><i class="fa fa-user-plus" aria-hidden="true"></i>
                                Create Problem Type</button>
                    </a>
                </div>

            </div>



            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach($problemtypes as $problemtype)

                            <td>{{$loop->iteration}}</td>
                            <td>{{$problemtype->name}}</td>
                            
                            




                            <td>
                                @if ($problemtype->status)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>


                            <td>



                                <a href="{{route('problemtype.edit', $problemtype->id)}}">
                                    <button type="button" class="btn btn-primary btn-rounded btn-sm my-0"><i class="fa fa-edit fa-fw"></i>
                                        modify
                                    </button></a>

                               

                                <span style="display:inline-block">
                                    <form action="{{ route('problemtype.destroy',$problemtype->id) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">
                                            <i class="fas fa-trash" aria-hidden="true" style="color:white"></i> Delete
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
                @if(Session()->has('success'))
                <script>
                    alert(`{{ Session()->get('success')}}`)
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