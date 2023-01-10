@extends('back.layouts.main')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">My Profile</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">


                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-header user-header alt bg-dark" style="background-color:#2d3436; color:white;">
                                    <div class="media">

                                        <div class="media-body">
                                            <h3 class="text-light display-6" style="text-align: center;">
                                                Manage Task
                                            </h3>
                                            <p class="text-light display-6" style="text-align: center;">
                                                {{$user->name}}
                                            </p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><br>
                                
                                
                                <img src="{{asset('public/images/users')}}/{{$user->image}}" height="150" width="150" style="margin-left:400px;border-radius: 50%;" > 
                                
                                <br><br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive table-responsive-data2" style="background-color:white;">
                                            <table class="table table-bordered table-data2">
                                                <tbody style="font-size: 13px">
                                                <tr>
                                                        <th>Name</th>
                                                        <th style="font-weight: normal">
                                                            {{$user->name}}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Department</th>
                                                        <th style="font-weight: normal">
                                                            {{$user->department->departmentname}}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <th style="font-weight: normal">
                                                            {{$user->email}}
                                                        </th>

                                                  
                                                   
                                                    <tr>
                                                        <th>Mobile-no</th>
                                                        <th style="font-weight: normal">
                                                            {{$user->contact}}
                                                 

                                                    <tr>
                                                        <th>Status</th>
                                                        <th style="font-weight: normal">
                                                            @if ($user->status === 2)
                                                            <span class="badge badge-primary" style=background-color:light-green; >Opened</span>
                                                            @elseif($user->status === 1)
                                                            <span class="badge badge-warning" style=background-color:green;>Assigned</span>
                                                            @else
                                                            <span class="badge badge-success" style=background-color:red;>Closed</span>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    
                                                        
                                                        
                                                        
                                                   

                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <!-- /.panel-heading -->

                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->
    </div>
    @endsection
    @push('custom-scripts')
    <script>
        function collapse(key) {
            $(`.collapse`).removeClass('show');
            $(`#collapse${key}`).toggleClass('show');
        }
    </script>
    @endpush