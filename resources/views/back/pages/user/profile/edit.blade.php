@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit User Profile</h1>
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

                                    <form action="{{ route('profile.update', $user->id) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label>Name:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $user->name }}" placeholder="Enter contact number" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Department :</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <select name="department_id" class="form-control ">
                                                    <option value="">Select Department</option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            {{ $department->id == $user->department_id ? 'selected' : '' }}>
                                                            {{ $department->departmentname }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <input type="text" class="form-control" name="email"
                                                    value="{{ $user->email }}" placeholder="Enter contact number"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile Number:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" name="contact"
                                                    value="{{ $user->contact }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Status:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>

                                                <select class="form-control" name="status" id="status">
                                                    <option value="1" {{ $user->status ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="0" {{ $user->status ? '' : 'selected' }}>Inactive
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <label>Photo</label>
                                            <img src="{{ $user->profile_image }}" height="80" width="80"><br><br>
                                            <div class="input-group">

                                                <div class="input-group-addon">
                                                    <i class="fa fa-file"></i>
                                                </div>
                                                <input type="file" class="form-control" name="image">
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
