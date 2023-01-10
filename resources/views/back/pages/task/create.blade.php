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
                    <h1 class="page-header">Manage Tasks</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Create Task
                            <a href="{{ route('task.index') }}">
                                <button type="button" class="btn btn-warning btn-xs pull-right"><i
                                        class="fa fa-hand-point-left" aria-hidden="true"></i>
                                    Back To Task List
                                </button>
                            </a>
                        </div>
                        <form action="{{ route('task.store') }}" name="createTaskForm" id="createTaskForm" class="dropzone"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="task_id" name="task_id" id="taskId" value="">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Assign To <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <select name="user_id" class="form-control select2">
                                                            <option value="">Select User</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
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
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-pen"></i>
                                                        </div>
                                                        <input type="text" class="form-control" rows="5"
                                                            name="title" placeholder="Enter Task Title" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-comment"></i>
                                                        </div>
                                                        <textarea class="form-control" rows="3" name="description" placeholder="Enter Task Descriptions" required></textarea>
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
                                <button type="submit" class="btn btn-success">Create Task</button>
                            </div>
                        </form>
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
                url: "{{ route('task.store-image') }}",
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
                    $("form[name='createTaskForm']").submit(function(event) {
                        //Make sure that the form isn't actully being sent.
                        event.preventDefault();
                        URL = $("#createTaskForm").attr('action');
                        formData = $('#createTaskForm').serialize();
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
                                    var taskId = data.task_id;
                                    $("#taskId").val(taskId);
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
                        //fetch the task Id from hidden input field and send that taskId with our image
                        let taskId = document.getElementById('taskId').value;
                        formData.append('task_id', taskId);
                    });

                    this.on("success", function(file, response) {
                        //reset the form
                        $('#createTaskForm')[0].reset();
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
