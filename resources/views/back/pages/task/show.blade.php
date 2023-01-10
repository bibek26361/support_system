@extends('back.layouts.main')

@push('custom-styles')
    <style>
        ul.images {
            cursor: grab;
            margin: 0;
            padding: 10px;
            white-space: nowrap;
            width: 100%;
            overflow-x: auto;
            background-color: #ddd;
            text-align: center;
            transition: all 0.2s;
            will-change: transform;
            user-select: none;
        }

        ul.images.active {
            cursor: grabbing;
            cursor: -webkit-grabbing;
        }

        ul.images::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #f5f5f5;
        }

        ul.images::-webkit-scrollbar {
            height: 5px;
            background-color: #f5f5f5;
        }

        ul.images::-webkit-scrollbar-thumb {
            background-color: #327fba;
            background-image: -webkit-linear-gradient(45deg,
                    rgba(255, 255, 255, 0.2) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.2) 50%,
                    rgba(255, 255, 255, 0.2) 75%,
                    transparent 75%,
                    transparent);
        }

        ul.images li {
            display: inline;
            margin: 5px;
        }

        ul.images li img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 20px;
            border: 1px solid #ffffff;
        }

        .taskImageListItem {
            cursor: pointer;
        }

        #modalCloseBtn {
            cursor: pointer;
            float: right;
        }
    </style>
@endpush

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Task</h1>
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
                                    <div class="card-header user-header alt bg-dark"
                                        style="background-color:#2d3436; color:white;">
                                        <div class="media">
                                            <div class="media-body">
                                                <h3 class="text-light display-6" style="text-align: center;">
                                                    {{ $task->title }}
                                                </h3>
                                                <p class="text-light display-6" style="text-align: center;">
                                                    {{ $task->user->name }} &nbsp; <i class="fa fa-hand-point-right"></i>
                                                    &nbsp; {{ $task->created_by }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <ul class="images">
                                        @foreach ($task->images as $key => $image)
                                            <li class="taskImageListItem" data-image="{{ $image }}">
                                                <img src="{{ $image }}">
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive table-responsive-data2" style="background-color:white;">
                                        <table class="table table-bordered table-data2">
                                            <tbody style="font-size: 13px">
                                                <tr>
                                                    <th>Assigned By</th>
                                                    <th style="font-weight: normal">
                                                        {{ $task->created_by }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Assigned To</th>
                                                    <th style="font-weight: normal">
                                                        {{ $task->user->name }}
                                                    </th>
                                                </tr>

                                                </tr>
                                                <tr>
                                                    <th>Task</th>
                                                    <th style="font-weight: normal">
                                                        {{ $task->title }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Priority</th>
                                                    <th style="font-weight: normal">
                                                        @if ($task->priority === 5)
                                                            <span class="badge badge-danger">Highest</span>
                                                        @elseif($task->priority === 4)
                                                            <span class="badge badge-warning">High</span>
                                                        @elseif($task->priority === 3)
                                                            <span class="badge badge-primary">Medium</span>
                                                        @elseif($task->priority === 2)
                                                            <span class="badge badge-info">Low</span>
                                                        @elseif($task->priority === 1)
                                                            <span class="badge badge-secondary">Lowest</span>
                                                        @else
                                                            <span class="badge badge-secondary">N/A</span>
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Assigned At</th>
                                                    <th style="font-weight: normal">
                                                        {{ $task->assigned_at }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <th style="font-weight: normal">
                                                        @if ($task->status === 3)
                                                            <span class="badge badge-success">Completed</span>
                                                        @elseif($task->status === 2)
                                                            <span class="badge badge-warning">New</span>
                                                        @elseif($task->status === 1)
                                                            <span class="badge badge-info">In Progress</span>
                                                        @else
                                                            <span class="badge badge-danger">Closed</span>
                                                        @endif
                                                        {{ $task->action_at }}
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <th style="font-weight: normal">
                                                        {{ $task->description }}
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
    <div class="modal fade" id="viewImageModal">
        <div class="modal-dialog model-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <span id="modalCloseBtn" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </span>
                    <div id="taskImage">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        const slider = document.querySelector('ul.images');
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 1; //scroll-fast
            slider.scrollLeft = scrollLeft - walk;
        });

        $(function() {
            $('.taskImageListItem').click(function() {
                var image = $(this).attr('data-image');
                $('#taskImage').html('<img src="' + image + '" style="width:100%;">');
                $('#viewImageModal').modal('show');
            });
        });

        function collapse(key) {
            $(`.collapse`).removeClass('show');
            $(`#collapse${key}`).toggleClass('show');
        }
    </script>
@endpush
