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

        #otherTicketList {
            min-height: 500px;
            max-height: 500px;
            overflow-y: scroll;
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
                <h1 class="page-header">Ticket Information</h1>
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
                                                <h3 class="text-light" style="margin-bottom: 3px; text-align: center;">
                                                    {{ $ticket->organization->organizationname }}</h3>
                                                <p class="text-light" style="margin-bottom: 3px; text-align: center;">
                                                    {{ $ticket->organization->address }}</p>
                                                <p class="text-light" style="margin-bottom: 3px; text-align: center;">
                                                    Contact No :
                                                    {{ $ticket->organization->phonenumber }}
                                                    - {{ $ticket->organization->mobilenumber }}</p>
                                                <p class="text-light" style="text-align: center;">PAN/VAT No. :
                                                    {{ $ticket->organization->pan_vat_number }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <ul class="images">
                                                @foreach ($ticket->images as $key => $image)
                                                    <li class="ticketImageListItem" data-image="{{ $image }}">
                                                        <img src="{{ $image }}">
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="table-responsive table-responsive-data2"
                                                style="background-color:white;">
                                                <table class="table table-bordered table-data2">
                                                    <tbody style="font-size: 13px">
                                                        <tr>
                                                            <th>Ticket ID</th>
                                                            <th style="font-weight: normal">
                                                                #{{ $ticket->ticket_id }}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Problem Type</th>
                                                            <th style="font-weight: normal">
                                                                {{ $ticket->problemtype->name }}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Problem Category</th>
                                                            <th style="font-weight: normal">
                                                                {{ $ticket->problemCategory ? $ticket->problemCategory->name : '-' }}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Priority</th>
                                                            <th style="font-weight: normal">
                                                                @if ($ticket->priority === 5)
                                                                    <span class="badge badge-danger"
                                                                        style="background-color:red;">Highest</span>
                                                                @elseif($ticket->priority === 4)
                                                                    <span class="badge badge-warning"
                                                                        style="background-color:yellow;color:black;">High</span>
                                                                @elseif($ticket->priority === 3)
                                                                    <span class="badge badge-primary"
                                                                        style="background-color:green;">Medium</span>
                                                                @elseif($ticket->priority === 2)
                                                                    <span class="badge badge-info"
                                                                        style="background-color:blue;">Low</span>
                                                                @elseif($ticket->priority === 1)
                                                                    <span class="badge badge-secondary"
                                                                        style="background-color:gray;">Lowest</span>
                                                                @else
                                                                    <span class="badge badge-secondary">N/A</span>
                                                                @endif
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Department</th>
                                                            <th style="font-weight: normal">
                                                                {{ $ticket->department_name }}
                                                                <span class="pull-right">
                                                                    <a
                                                                        href="tel:{{ $ticket->department_number }}">{{ $ticket->department_number }}</a>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Assigned To</th>
                                                            <th style="font-weight: normal">
                                                                {!! $ticket->assigned_to !!}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Status</th>
                                                            <th style="font-weight: normal">
                                                                @if ($ticket->status === 2)
                                                                    <span class="badge badge-primary"
                                                                        style="background-color:green;">Opened</span>
                                                                @elseif($ticket->status === 1)
                                                                    <span class="badge badge-warning"
                                                                        style="background-color:blue;">Assigned</span>
                                                                @else
                                                                    <span class="badge badge-success"
                                                                        style="background-color:red;">Closed</span>
                                                                @endif
                                                                <span class="pull-right">
                                                                    {{ $ticket->action_at }}
                                                                </span>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Issued Date Time</th>
                                                            <th style="font-weight: normal">
                                                                {{ $ticket->issued_date_time }}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Issued At</th>
                                                            <th style="font-weight: normal">
                                                                {{ $ticket->issued_at }}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Details</th>
                                                            <th style="font-weight: normal">
                                                                {{ $ticket->details }}
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <span id="countRemarks"
                                                        onclick="getTicketRemarks(`{{ $ticket->ticket_id }}`)"
                                                        style="cursor: pointer; font-weight: bold; color: green">
                                                        {{ $ticket->total_remarks }}
                                                    </span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="pull-right">
                                                        <input type="checkbox" name="audience" id="audience"
                                                            value="1">
                                                        <label style="cursor: pointer" for="audience">
                                                            Share with Public
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top: 5px">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <textarea class="form-control" id="description" rows="1"
                                                                placeholder="Remark as {{ ucwords(Auth::user()->name) }}"></textarea>
                                                            <div onclick="addRemark(`{{ $ticket->ticket_id }}`)"
                                                                class="input-group-addon"
                                                                style="background: #1b7ac7; color: #fff; cursor: pointer">
                                                                Send
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="pull-right">
                                                <a
                                                    href="{{ route('ticket.edit', $ticket->id) }}"class="btn btn-primary btn-xs"><i
                                                        class="fa fa-edit"></i>
                                                    Modify</a>
                                                <a href="{{ route('ticket.transfer', $ticket->id) }}"
                                                    class="btn btn-info btn-xs"><i class="fa fa-rocket"></i> Assign /
                                                    Transfer</a>
                                                <a href="{{ route('ticket.changeStateToSolved', $ticket->id) }}"
                                                    class="btn btn-success btn-xs"><i class="fa fa-check"></i>
                                                    Solved</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="card">
                                                <div class="card-header"
                                                    style="background-color: #CC471B; color: #fff; padding: 10px">
                                                    <i class="mr-2 fa fa-align-justify"></i>
                                                    <strong class="card-title" v-if="headerText">Previous Ticket</strong>
                                                </div>
                                                <div class="card-body">
                                                    <div id="otherTicketList">
                                                        <div class="panel-group" id="accordion">
                                                            @foreach ($listTickets as $key => $listTicket)
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading">
                                                                        <h4 class="panel-title"
                                                                            style="font-size: 13px; color:grey;border-style:solid 2px silver; cursor:pointer;">
                                                                            <a onclick="collapse('{{ $key }}')"
                                                                                data-parent="#accordion">
                                                                                {{ $listTicket->problemtype->name }}
                                                                                <span class="text-success">[Ticket
                                                                                    #{{ $listTicket->ticket_id }}]</span>
                                                                            </a>
                                                                            <a href="{{ route('ticket.show', $listTicket->id) }}"
                                                                                class="pull-right">
                                                                                <span class="text-success">[View Full
                                                                                    Info]</span>
                                                                            </a>
                                                                        </h4>
                                                                    </div>

                                                                    <div id="collapse{{ $key }}"
                                                                        class="panel-collapse collapse"
                                                                        style="margin-bottom: 15px">
                                                                        <div class="panel-body">
                                                                            <div
                                                                                class="table-responsive table-responsive-data2">
                                                                                <table
                                                                                    class="table table-bordered table-data2">
                                                                                    <tbody style="font-size: 13px">
                                                                                        <tr>
                                                                                            <th>Problem Type</th>
                                                                                            <th
                                                                                                style="font-weight: normal">
                                                                                                {{ $listTicket->problemtype->name }}
                                                                                            </th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Problem Category</th>
                                                                                            <th
                                                                                                style="font-weight: normal">
                                                                                                {{ $listTicket->problemCategory ? $listTicket->problemCategory->name : '-' }}
                                                                                            </th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Problem Priority</th>
                                                                                            <th
                                                                                                style="font-weight: normal">
                                                                                                @if ($ticket->priority === 5)
                                                                                                    <span
                                                                                                        class="badge badge-danger"
                                                                                                        style="background-color:red;">Highest</span>
                                                                                                @elseif($ticket->priority === 4)
                                                                                                    <span
                                                                                                        class="badge badge-warning"
                                                                                                        style="background-color:yellow;color:black;">High</span>
                                                                                                @elseif($ticket->priority === 3)
                                                                                                    <span
                                                                                                        class="badge badge-primary"
                                                                                                        style="background-color:green;">Medium</span>
                                                                                                @elseif($ticket->priority === 2)
                                                                                                    <span
                                                                                                        class="badge badge-info"
                                                                                                        style="background-color:blue;">Low</span>
                                                                                                @elseif($ticket->priority === 1)
                                                                                                    <span
                                                                                                        class="badge badge-secondary"
                                                                                                        style="background-color:gray;">Lowest</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge badge-secondary">N/A</span>
                                                                                                @endif
                                                                                            </th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Assigned To</th>
                                                                                            <th
                                                                                                style="font-weight: normal">
                                                                                                {!! $listTicket->assigned_to !!}
                                                                                            </th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Status</th>
                                                                                            <th
                                                                                                style="font-weight: normal">
                                                                                                @if ($ticket->status === 2)
                                                                                                    <span
                                                                                                        class="badge badge-primary"
                                                                                                        style="background-color:green;">Opened</span>
                                                                                                @elseif($ticket->status === 1)
                                                                                                    <span
                                                                                                        class="badge badge-warning"style="background-color:blue;">Assigned</span>
                                                                                                @else
                                                                                                    <span
                                                                                                        class="badge badge-success"
                                                                                                        style="background-color:red;">Closed</span>
                                                                                                @endif
                                                                                            </th>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Details</th>
                                                                                            <th
                                                                                                style="font-weight: normal">
                                                                                                {{ $listTicket->details }}
                                                                                            </th>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="viewImageModal">
            <div class="modal-dialog model-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <span id="modalCloseBtn" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </span>
                        <div id="ticketImage">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showTicketRemarksModal">
            <div class="modal-dialog model-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-comment"></i> Remarks</h4>
                    </div>
                    <div class="modal-body">
                        <div id="userRemarkList">
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
                $('.ticketImageListItem').click(function() {
                    var image = $(this).attr('data-image');
                    $('#ticketImage').html('<img src="' + image + '" style="width:100%;">');
                    $('#viewImageModal').modal('show');
                });
            });

            function collapse(key) {
                let isShown = $(`#collapse${key}`).hasClass('show');
                $(`.collapse`).removeClass('show');
                if (isShown === false)
                    $(`#collapse${key}`).toggleClass('show');
            }

            function addRemark(ticket_id) {
                let description = $('#description').val(),
                    audience = $('#audience').is(':checked') ? 1 : 0;
                $.ajax({
                    method: 'POST',
                    url: `{{ route('tickets.addRemark') }}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        ticket_id,
                        description,
                        audience
                    },
                    dataType: 'JSON',
                }).then(function(response) {
                    let {
                        success,
                        total_remarks,
                        data
                    } = response;
                    if (success) {
                        $('#description').val('');
                        $('#countRemarks').text(total_remarks);
                    }
                });
            }

            function getTicketRemarks(ticketId) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('tickets.remarks') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ticket_id: ticketId
                    },
                    dataType: 'json'
                }).then(function(responseData) {
                    let {
                        success,
                        data
                    } = responseData;
                    if (success) {
                        $('#showTicketRemarksModal').modal('show');
                        $('#userRemarkList').html('');
                        $.each(data, function(key, value) {
                            if (value.is_my_remark) {
                                $('#userRemarkList').prepend(
                                    `<h5 class="text-success">
                                        <img src="${value.user_image}" style="height: 30px; width: 30px; border-radius: 50%; margin-right: 10px">
                                        <strong>${value.user} <i class="fa fa-${value.audience ? 'globe' : 'lock'}" style="color: #000; font-size: 8px"></i></strong>
                                        <span> - ${value.description}</span>
                                        <small class="pull-right">${value.created_at}</small>
                                    </h5>`
                                );
                            } else {
                                $('#userRemarkList').prepend(
                                    `<h5>
                                        <img src="${value.user_image}" style="height: 30px; width: 30px; border-radius: 50%; margin-right: 10px">
                                        <strong>${value.user} <i class="fa fa-${value.audience ? 'globe' : 'lock'}" style="color: #000; font-size: 8px"></i></strong>
                                        <span> - ${value.description}</span>
                                        <small class="pull-right">${value.created_at}</small>
                                    </h5>`
                                );
                            }
                        });
                    } else {
                        alert('Something went wrong');
                    }
                });
            }
        </script>
    @endpush
