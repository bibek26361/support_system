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
                                   
        <form action="{{route('department.update', $department->id)}}" method="post"  enctype="multipart/form-data">
            @csrf
            @method('PATCH')
          
    
           

                        <div class="form-group">
                            <label>Department Name:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control" name="departmentname" value="{{($department->departmentname)}}" placeholder="Enter department name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Contact Number:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control" name="contact" value="{{($department->contact)}}" placeholder="Enter contact number" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Contact Network:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control" name="contact_network" value="{{($department->contact_network)}}" placeholder="Enter contact number" required>
                            </div>
                        </div>

         
         <div class="form-group">
                            <label>Department Code</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" name="code" value="{{($department->code)}}" required>
                            </div>
                        </div>

                       


                        <div class="form-group">
                            <label>Status:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                
                                <select class="form-control" name="status" id="status">
                                                    <option value="1" {{ $department->status ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ $department->status ? '' : 'selected' }} >Inactive</option>
                                            </select>
                            </div>
                        </div>
                        

                        
                         


<hr>


      <div class="text-center">
       <input class="btn btn-primary" type="submit"  value="submit">
  
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