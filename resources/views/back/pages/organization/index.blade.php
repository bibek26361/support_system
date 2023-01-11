@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Organizations</h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        Manage Organizations
                        <a href="{{ route('organization.create') }}">
                            <button type="button" class="btn btn-success btn-xs pull-right" text-right><i
                                    class="fa fa-user-plus" aria-hidden="true"></i>
                                Create Organization</button>
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Address</th>
                                        <th>Mobile No</th>
                                        <th>Pan/Vat No.</th>
                                        <th>Representative Name</th>
                                        <th>Any Desk Number</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($organizations as $organization)
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $organization->organizationname }}</td>
                                        <td>{{ $organization->organizationtype->name }}</td>
                                        <td>{{ $organization->address }}</td>
                                        <td>{{ $organization->mobilenumber }}</td>
                                        <td>{{ $organization->pan_vat_number }}</td>
                                        <td>{{ $organization->representativename }}</td>
                                        <td>{{ $organization->anydesk_no }}</td>
                                        <td>
                                            @if ($organization->status)
                                                <span class="badge badge-success"
                                                    style="background-color:green;">Active</span>
                                            @else
                                                <span class="badge badge-danger"
                                                    style="background-color:red;">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($organization->api_key == '')
                                                <a href="{{ route('organization.generate-api-key', $organization->id) }}">
                                                    <button type="button"
                                                        class="btn btn-primary btn-rounded btn-xs my-0"><i
                                                            class="fa fa-key fa-fw"></i>
                                                        Generate API Key
                                                    </button>
                                                </a>
                                            @else
                                                <button type="button" class="btn btn-info btn-xs viewOrganizationDetails"
                                                    data-securitykey="{{ $organization->security_key }}"
                                                    data-apikey="{{ $organization->api_key }}"
                                                    data-systembaseurl="{{ $organization->system_base_url }}"
                                                    data-organizationname="{{ $organization->organizationname }}">
                                                    <i class="fa fa-eye fa-fw"></i> View
                                                </button>
                                            @endif
                                            <a href="{{ route('organization.tickets', $organization->id) }}">
                                                <button type="button" class="btn btn-primary btn-rounded btn-xs my-0"><i
                                                        class="fa fa-receipt fa-fw"></i>
                                                    Tickets
                                                </button>
                                            </a>
                                            <a href="{{ route('organization.edit', $organization->id) }}">
                                                <button type="button" class="btn btn-primary btn-rounded btn-xs my-0"><i
                                                        class="fa fa-edit fa-fw"></i>
                                                    Modify
                                                </button>
                                            </a>
                                            <span style="display:inline-block">
                                                <form action="{{ route('organization.destroy', $organization->id) }}"
                                                    method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-xs"
                                                        onclick="return confirm('Are you sure you want to delete?')">
                                                        <i class="fas fa-trash" aria-hidden="true" style="color:white"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </span>
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if (Session()->has('success'))
                            <script>
                                alert(`{{ Session()->get('success') }}`)
                            </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="viewOrganizationDetailModal">
        <div class="modal-dialog model-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-info-circle"></i> <span
                            id="organizationName"></span> Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-bordered table-hover">
                                <tr>
                                    <th>Api Key</th>
                                    <td id="organizationApiKey"></td>
                                </tr>
                                <tr>
                                    <th>System Base URL</th>
                                    <td id="organizationSystemBaseUrl"></td>
                                </tr>
                                <tr>
                                    <th>Security Key</th>
                                    <td id="organizationSecuritykey"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        $(function() {
            $(document).on('click', '.viewOrganizationDetails', function() {
                let organizationName = $(this).attr('data-organizationname'),
                    apiKey = $(this).attr('data-apikey'),
                    securitykey = $(this).attr('data-securitykey'),
                    systemBaseUrl = $(this).attr('data-systembaseurl');
                $('#organizationName').text(`${organizationName}'s `);
                $('#organizationApiKey').text(apiKey);
                $('#organizationSystemBaseUrl').text(systemBaseUrl);
                $('#organizationSecuritykey').text(securitykey);
                $('#viewOrganizationDetailModal').modal();
            });
        });
    </script>
@endpush
