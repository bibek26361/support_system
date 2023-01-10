@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Modify Ticket</h1>
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

                                    <form action="{{ route('ticket.update', $ticket->id) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')



                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class=" form-group">

                                                    <label>Organization :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </div>
                                                        <select name="organization_id" class="form-control select2 ">
                                                            <option value="">Select Organization Type</option>
                                                            @foreach ($organizations as $organization)
                                                                <option value="{{ $organization->id }}"
                                                                    {{ $organization->id == $ticket->organization_id ? 'selected' : '' }}>
                                                                    {{ $organization->organizationname }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">

                                                    <label>Department :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </div>
                                                        <select name="department_id" class="form-control select2 ">
                                                            <option value="">Select Department</option>
                                                            @foreach ($departments as $department)
                                                                <option value="{{ $department->id }}"
                                                                    {{ $department->id == $ticket->department_id ? 'selected' : '' }}>
                                                                    {{ $department->departmentname }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-3">
                                                <div class="form-group">

                                                    <label>Assign To:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <select name="assigned_to" class="form-control select2 ">

                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ $user->id == $ticket->user_id ? 'selected' : '' }}>
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">

                                                <div class="form-group">

                                                    <label>Priority:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <select name="priority" class="form-control ">
                                                            <option value="">Select Priority</option>
                                                            <option value="5"
                                                                {{ $ticket->priority == '5' ? 'selected' : '' }}>Highest
                                                            </option>
                                                            <option value="4"
                                                                {{ $ticket->priority == '4' ? 'selected' : '' }}>High
                                                            </option>
                                                            <option value="3"
                                                                {{ $ticket->priority == '3' ? 'selected' : '' }}>Medium
                                                            </option>
                                                            <option value="2"
                                                                {{ $ticket->priority == '2' ? 'selected' : '' }}>Low
                                                            </option>
                                                            <option value="1"
                                                                {{ $ticket->priority == '1' ? 'selected' : '' }}>Lowest
                                                            </option>


                                                        </select>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-6">
                                                <div class="form-group">

                                                    <label>Support Type:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <select name="support_type" class="form-control ">

                                                            <option value="survey"
                                                                {{ $ticket->support_type == 'survey' ? 'selected' : '' }}>
                                                                Survey</option>
                                                            <option value="call"
                                                                {{ $ticket->support_type == 'call' ? 'selected' : '' }}>
                                                                Call</option>
                                                            <option value="anydesk"
                                                                {{ $ticket->support_type == 'anydesk' ? 'selected' : '' }}>
                                                                Anydesk</option>
                                                        </select>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">

                                                    <label>Problem Type:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-exclamation"></i>
                                                        </div>
                                                        <select name="problem_type_id" class="form-control select2 ">
                                                            <option value="">Select Problem Type</option>
                                                            @foreach ($problemtypes as $problemtype)
                                                                <option value="{{ $problemtype->id }}"
                                                                    {{ $problemtype->id == $ticket->problem_type_id ? 'selected' : '' }}>
                                                                    {{ $problemtype->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">

                                                    <label>Problem Category:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-exclamation"></i>
                                                        </div>
                                                        <select name="problem_category_id" class="form-control select2 ">
                                                            <option value="">Select Problem Category</option>
                                                            @foreach ($problemcategories as $problemcategory)
                                                                <option value="{{ $problemcategory->id }}"
                                                                    {{ $problemcategory->id == $ticket->problem_category_id ? 'selected' : '' }}>
                                                                    {{ $problemcategory->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">

                                                    <label>File</label><br>
                                                    <img src="{{ $ticket->image }}" height="80"
                                                        width="80"><br><br>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-file"></i>
                                                        </div>

                                                        <input type="file" class="form-control" name="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Details</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-pen"></i>
                                                        </div>

                                                        <textarea class="form-control" rows="5" name="details" required>{{ $ticket->details }}</textarea>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">

                                                    <label>Remarks</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-pen"></i>
                                                        </div>
                                                        <textarea class="form-control" rows="5" name="remarks" required>{{ $ticket->remarks }}</textarea>
                                                    </div>
                                                </div>
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
