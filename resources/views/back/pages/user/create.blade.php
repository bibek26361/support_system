@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Department Forms</h1>
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

                                    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                            <div class="form-group">
                                                <label>User Type <span class="text-danger">*</span>
                                                    @if ($errors->has('user_type'))
                                                        <small
                                                            class="text-danger">{{ $errors->first('user_type') }}</small>
                                                    @endif
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user-circle"></i>
                                                    </div>
                                                    <select name="user_type" class="form-control ">
                                                        <option value="">Select User Type</option>
                                                        <option>Admin</option>
                                                        <option>Staff</option>
                                                    </select>
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
                                                        <option value="{{ $department->id }}">
                                                            {{ $department->departmentname }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Name:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Enter Name" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Email:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <input type="text" class="form-control" name="email"
                                                    placeholder="Enter Email" required>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>Password:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Enter Password" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Contact Number:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" name="contact"
                                                    placeholder="Enter Contact Number" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Status:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>

                                                <select class="form-control" name="status" id="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <label>Photo</label>
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
