@extends('back.layouts.auth')
@section('content')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Change password</title>

<!-- Core CSS - Include with every page -->
    <link href="{{asset('back/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('back/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="{{asset('back/css/sb-admin.css')}}" rel="stylesheet">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Change Password </h3>
                    </div>
                    <div class="panel-body">
                        <form action="" role="form" method="post">
                            @csrf
                            <fieldset>
                                <div class="form-group">
                         <input class="form-control" placeholder="Current Password" name="current_password" type="password" autofocus >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New password" name="new_password" type="password" value="" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Confirm password" name="confirm_password" type="password" value="" >
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
        
                                </div>

 <!-- Change this to a button or input when using this as a form -->
                    <button type="submit" name="change_password"class="btn btn-lg btn-success btn-block">Submit</button>
                            </fieldset>

                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

 <!-- Core Scripts - Include with every page -->
    <script src="{{asset('back/js/jquery-1.10.2.js')}}"></script>
    <script src="{{asset('back/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('back/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="{{asset('back/js/sb-admin.js')}}"></script>
   @endsection