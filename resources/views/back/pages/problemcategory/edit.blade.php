@extends('back.layouts.main')
@section('content')
 
 <div id="page-wrapper">
            <div class="row">
                <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"> Create Problem category</h1>
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
                                   
        <form action="{{route('problemcategory.update',$problemcategory->id)}}" method="post"  enctype="multipart/form-data">
            @csrf
          @method('PATCH')
    
           

            <div class="form-group">
                            <label>Problem Type :</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <select name="problem_type_id" class="form-control ">
                                                    <option value="">Select Problem Type</option>
                                                    @foreach($problemtypes as $problemtype)
                                                    <option value="{{$problemtype->id}}" {{$problemtype->id==$problemcategory->problem_type_id?'selected':''}}>{{$problemtype->name}}</option>
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
                                <input type="text" class="form-control" name="name"  value="{{$problemcategory->name}}" placeholder="Enter problem" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Points:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control" name="points" placeholder="Enter points" value="{{$problemcategory->points}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                
                                <select class="form-control" name="status" id="status">
                                <option value="1" {{ $problemcategory->status ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $problemcategory->status ? '' : 'selected' }}>Inactive</option>
                                            </select>
                            </div>
                        </div>

                      
                       

         
         


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