@extends('back.layouts.main')

@push('custom-styles')
    <style>
        table {
            font-size: 12px;
        }

        table thead {
            background: #1f89be;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $countdepartments }}</div>
                                <div>Total Department</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('department.index') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $countusers }}</div>
                                <div>Total User</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('user.index') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-globe fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $countorganizations }}</div>
                                <div>Total Organization</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('organization.index') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-th-list fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"> {{ $countopentickets }} / {{ $totalTickets }}</div>
                                <div>Tasks</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('ticket.index') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"> {{ $countopentickets }} / {{ $totalTickets }}</div>
                                <div>Open Ticket</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('tickets.opened') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $totalAssignedTickets }} / {{ $totalTickets }}</div>
                                <div>Assigned Ticket</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('tickets.assigned') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $totalTransferedTickets }} / {{ $totalTickets }}</div>
                                <div>Transfered Tickets</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('tickets.transfered') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{ $totalClosedTickets }} / {{ $totalTickets }}</div>
                                <div>Closed Ticket</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('tickets.closed') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-7">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Latest Tickets
                        <a href="{{ route('ticket.index') }}" class="btn btn-success btn-xs pull-right"><i
                                class="fa fa-eye" aria-hidden="true"></i>
                            View All Ticket
                        </a>
                    </div>
                    <div class="panel-body" style="min-height: 470px; max-height: 470px">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Ticket ID</th>
                                        <th>Organization</th>
                                        <th>Problem Type</th>
                                        <th>Priority</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestTickets as $ticket)
                                        <tr>
                                            <td style="font-weight: bold">
                                                <a
                                                    href="{{ route('ticket.show', $ticket->id) }}">#{{ $ticket->ticket_id }}</a>
                                            </td>
                                            <td>{{ $ticket->organization->organizationname }}</td>
                                            <td>{{ $ticket->problemtype->name }}</td>
                                            <td>
                                                @if ($ticket->priority === 5)
                                                    <span class="badge badge-danger"
                                                        style="background-color:red;">Highest</span>
                                                @elseif($ticket->priority === 4)
                                                    <span class="badge badge-warning"
                                                        style="background-color:yellow; color:black;">High</span>
                                                @elseif($ticket->priority === 3)
                                                    <span class="badge badge-primary"
                                                        style="background-color:green;">Medium</span>
                                                @elseif($ticket->priority === 2)
                                                    <span class="badge badge-info"
                                                        style="background-color:gray;">Low</span>
                                                @elseif($ticket->priority === 1)
                                                    <span class="badge badge-secondary"
                                                        style="background-color:gray;">Lowest</span>
                                                @else
                                                    <span class="badge badge-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if ($ticket->assigned_to)
                                                    <a href="{{ route('ticket.changeStateToSolved', $ticket->id) }}">
                                                        <button class="btn btn-success btn-xs" data-toggle="tooltip"
                                                            data-placement="top" title="Solved">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </a>
                                                @else
                                                    <a href="{{ route('ticket.transfer', $ticket->id) }}">
                                                        <button class="btn btn-info btn-xs" data-toggle="tooltip"
                                                            data-placement="top" title="Transfer / Assign">
                                                            <i class="fa fa-rocket"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                                <a href="{{ route('ticket.edit', $ticket->id) }}"
                                                    class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                    data-placement="top" title="Modify">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Latest Tasks
                        <a href="{{ route('task.index') }}" class="btn btn-success btn-xs pull-right"><i
                                class="fa fa-eye" aria-hidden="true"></i>
                            View All Tasks
                        </a>
                    </div>
                    <div class="panel-body" style="min-height: 470px; max-height: 470px">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Priority</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestTasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            <td>
                                                @if ($task->priority === 5)
                                                    <span class="badge badge-danger"
                                                        style="background-color:red;">Highest</span>
                                                @elseif($task->priority === 4)
                                                    <span class="badge badge-warning"
                                                        style="background-color:yellow; color:black;">High</span>
                                                @elseif($task->priority === 3)
                                                    <span class="badge badge-primary"
                                                        style="background-color:green;">Medium</span>
                                                @elseif($task->priority === 2)
                                                    <span class="badge badge-info"
                                                        style="background-color:gray;">Low</span>
                                                @elseif($task->priority === 1)
                                                    <span class="badge badge-secondary"
                                                        style="background-color:gray;">Lowest</span>
                                                @else
                                                    <span class="badge badge-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                <a href="{{ route('task.show', $task->id) }}">
                                                    <button class="btn btn-info btn-xs" data-toggle="tooltip"
                                                        data-placement="top" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('task.edit', $task->id) }}"><button
                                                        class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                        data-placement="top" title="Modify">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
