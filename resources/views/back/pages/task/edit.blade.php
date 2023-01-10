@extends('back.layouts.main')
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Modify Task</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">

                                <form action="{{route('task.update',$task->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')


                                    <div class="form-group">

                                        <label>Assign To:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <select name="user_id" class="form-control sleect2 ">
                                                <option value="">Select User</option>
                                                @foreach($users as $user)
                                                <option value="{{$user->id}}" {{$user->id== $task->user_id ? 'selected':''}}>{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>





                                    <div class="form-group">
                                        <label>Task</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-pen"></i>
                                            </div>

                                            <input type="text" class="form-control" rows="5" name="title" value="{{$task->title}}">
                                        </div>

                                    </div>








                                    <div class="form-group">

                                        <label>Priority:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <select name="priority" class="form-control ">
                                                <option value="">Select Priority</option>
                                                <option value="5" {{$task->priority == '5' ? 'selected' : ''}}>Highest</option>
                                                <option value="4" {{$task->priority == '4' ? 'selected' : ''}}>High</option>
                                                <option value="3" {{$task->priority == '3' ? 'selected' : ''}}>Medium</option>
                                                <option value="2" {{$task->priority == '2' ? 'selected' : ''}}>Low</option>
                                                <option value="1" {{$task->priority == '1' ? 'selected' : ''}}>Lowest</option>


                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Status:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>

                                            <select class="form-control" name="status" id="status">
                                                <option value="1" {{ $user->status ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $user->status ? '' : 'selected' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label>File</label>
                                        <img src="{{asset('public/images/tasks')}}/{{$task->image}}" height="80" width="80"><br><br>
                                        <div class="input-group">
                                       
                                            <div class="input-group-addon">
                                                <i class="fa fa-file"></i>
                                            </div>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>





                                    <div class="form-group">
                                        <label>Description</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-pen"></i>
                                            </div>

                                            <textarea class="form-control" rows="5" name="description" required></textarea>
                                        </div>

                                    </div>

























                                    <hr>


                                    <div class="text-center">
                                        <input class="btn btn-primary" type="submit" value="submit">

                                    </div>
                                </form>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
@endsection
@push('custom-scripts')
<script>
   $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.select2').select2();


    });
</script>
@endpush
