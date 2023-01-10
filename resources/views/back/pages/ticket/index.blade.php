@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Ticket</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Manage Tickets
                        <a href="{{ route('ticket.create') }}" class="btn btn-success btn-xs pull-right"><i
                                class="fa fa-user-plus" aria-hidden="true"></i>
                            Create Ticket
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Organization</th>
                                        <th> Problem Type</th>
                                        <th>Department</th>
                                        <th>Assigned To</th>
                                        <th>State</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ticket->organization->organizationname }}</td>
                                            <td>{{ $ticket->problemType->name }}</td>
                                            <td>{!! $ticket->department_name !!}</td>
                                            <td>{!! $ticket->assigned_user !!}</td>
                                            <td>{{ $ticket->state }}</td>
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
                                                    <span class="badge badge-info" style="background-color:gray;">Low</span>
                                                @elseif($ticket->priority === 1)
                                                    <span class="badge badge-secondary"
                                                        style="background-color:gray;">Lowest</span>
                                                @else
                                                    <span class="badge badge-secondary">N/A</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($ticket->status === 2)
                                                    <span class="badge badge-primary"
                                                        style="background-color:green;">Opened</span>
                                                @elseif($ticket->status === 1)
                                                    <span class="badge badge-warning"
                                                        style="background-color:blue;">{{ $ticket->status_text }}</span>
                                                @else
                                                    <span class="badge badge-success"
                                                        style="background-color:red;">Closed</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                <a href="{{ route('ticket.show', $ticket->id) }}">
                                                    <button class="btn btn-info btn-xs" data-toggle="tooltip"
                                                        data-placement="top" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </a>

                                                @if ($ticket->status)
                                                    <a href="{{ route('ticket.changeStateToSolved', $ticket->id) }}">
                                                        <button class="btn btn-success btn-xs" data-toggle="tooltip"
                                                            data-placement="top" title="Solved">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('ticket.transfer', $ticket->id) }}">
                                                        <button class="btn btn-info btn-xs" data-toggle="tooltip"
                                                            data-placement="top" title="Transfer">
                                                            <i class="fa fa-rocket"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('ticket.changeStateToSurvey', $ticket->id) }}"><button
                                                            class="btn btn-default btn-xs" data-toggle="tooltip"
                                                            data-placement="top" title="Survey">
                                                            <i class="fa fa-book"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                                <a href="{{ route('ticket.edit', $ticket->id) }}"><button
                                                        class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                        data-placement="top" title="Modify">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </button>
                                                </a>
                                                <span style="display:inline-block">
                                                    <form action="{{ route('ticket.destroy', $ticket->id) }}"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-danger btn-xs"
                                                            data-toggle="tooltip" data-placement="top" title="delete"
                                                            onclick="return confirm('Are you sure you want to delete?')">
                                                            <i class="fa fa-trash" aria-hidden="true"
                                                                style="color:white"></i>
                                                        </button>


                                                    </form>
                                                </span>

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- /.table-responsive -->
                        @if (Session()->has('success'))
                            <script>
                                alert(`{{ Session()->get('success') }}`)
                            </script>
                        @endif

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
@endsection
