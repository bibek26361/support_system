@extends('back.layouts.main')

@push('custom-styles')
    <style>
        .dropzoneDragArea {
            background-color: #fbfdff;
            border: 1px dashed #c0ccda;
            border-radius: 6px;
            padding: 60px;
            text-align: center;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .dropzone {
            border: none;
            padding: 0;
        }
    </style>
@endpush

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manage Tickets</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Create Ticket
                            <a href="{{ route('ticket.index') }}">
                                <button type="button" class="btn btn-warning btn-xs pull-right"><i
                                        class="fa fa-hand-point-left" aria-hidden="true"></i>
                                    Back To Ticket List
                                </button>
                            </a>
                        </div>
                        <form action="{{ route('ticket.store') }}" name="createTicketForm" id="createTicketForm"
                            class="dropzone" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="ticket_id" name="ticket_id" id="ticketId" value="">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
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
                                                                <option value="{{ $organization->id }}">
                                                                    {{ $organization->organizationname }}</option>
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
                                                                <option value="{{ $department->id }}">
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
                                                        <select name="assigned_to" class="form-control select2">
                                                            <option value="">Select Organization Type</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                                </option>
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
                                                            <option value="5">Highest</option>
                                                            <option value="4">High</option>
                                                            <option value="3">Medium</option>
                                                            <option value="2">Low</option>
                                                            <option value="1">Lowest</option>


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
                                                            <option value="">Select Support Type</option>
                                                            <option value="survey">Survey</option>
                                                            <option value="Call">Calll</option>
                                                            <option value="anydesk">Anydesk</option>
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
                                                                <option value="{{ $problemtype->id }}">
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
                                                                <option value="{{ $problemcategory->id }}">
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
                                                    <label>Details</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-pen"></i>
                                                        </div>
                                                        <textarea class="form-control" rows="3" name="details" required></textarea>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">

                                                    <label>Remarks</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-pen"></i>
                                                        </div>
                                                        <textarea class="form-control" rows="3" name="remarks" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div id="dropzoneDragArea"
                                                        class="dz-default dz-message dropzoneDragArea">
                                                        <span>Drag and drop files here</span>
                                                    </div>
                                                    <div class="dropzone-previews"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <a href="{{ route('ticket.index') }}" class="btn btn-danger">Close</a>
                                <button type="submit" class="btn btn-success">Create Ticket</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        Dropzone.autoDiscover = false;
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.select2').select2();

            let token = $('meta[name="csrf-token"]').attr('content');
            var myDropzone = new Dropzone("div#dropzoneDragArea", {
                paramName: "file",
                url: "{{ route('ticket.store-image') }}",
                previewsContainer: 'div.dropzone-previews',
                addRemoveLinks: true,
                autoProcessQueue: false,
                uploadMultiple: true,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                parallelUploads: 10,
                maxFiles: 10,
                params: {
                    _token: token
                },
                // The setting up of the dropzone
                init: function() {
                    var myDropzone = this;
                    //form submission code goes here
                    $("form[name='createTicketForm']").submit(function(event) {
                        //Make sure that the form isn't actully being sent.
                        event.preventDefault();
                        URL = $("#createTicketForm").attr('action');
                        formData = $('#createTicketForm').serialize();
                        $.ajax({
                            type: 'POST',
                            url: URL,
                            data: formData,
                            success: function(responseData) {
                                let {
                                    success,
                                    data
                                } = responseData;
                                if (success) {
                                    var ticketId = data.ticket_id;
                                    $("#ticketId").val(ticketId);
                                    //process the queue
                                    myDropzone.processQueue();
                                } else {
                                    console.log("error");
                                }
                            }
                        });
                    });
                    //Gets triggered when we submit the image.
                    this.on('sending', function(file, xhr, formData) {
                        //fetch the ticket Id from hidden input field and send that ticketId with our image
                        let ticketId = document.getElementById('ticketId').value;
                        formData.append('ticket_id', ticketId);
                    });

                    this.on("success", function(file, response) {
                        //reset the form
                        $('#createTicketForm')[0].reset();
                        setTimeout(() => {
                            window.location.href = "{{ route('task.create') }}";
                        }, 1000);
                    });
                    this.on("queuecomplete", function() {

                    });

                    // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                    // of the sending event because uploadMultiple is set to true.
                    this.on("sendingmultiple", function() {
                        // Gets triggered when the form is actually being sent.
                        // Hide the success button or the complete form.
                    });

                    this.on("successmultiple", function(files, response) {
                        // Gets triggered when the files have successfully been sent.
                        // Redirect user or notify of success.
                    });

                    this.on("errormultiple", function(files, response) {
                        // Gets triggered when there was an error sending the files.
                        // Maybe show form again, and notify user of error
                    });
                }
            });
        });
    </script>
@endpush
