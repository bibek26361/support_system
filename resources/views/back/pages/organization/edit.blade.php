@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Create Organization</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Modify Organization
                            <a href="{{ route('organization.index') }}">
                                <button type="button" class="btn btn-warning btn-xs pull-right"><i
                                        class="fa fa-hand-point-left" aria-hidden="true"></i>
                                    Back To Organization List
                                </button>
                            </a>
                        </div>
                        <form action="{{ route('organization.update', $organization->id) }}" method="post"
                            enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Organization Type</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <select name="organization_type_id" class="form-control ">
                                                            <option value="">Select Organization Type</option>

                                                            @foreach ($organizationtypes as $organizationtype)
                                                                <option value="{{ $organizationtype->id }}"
                                                                    {{ $organizationtype->id == $organization->organization_type_id ? 'selected' : '' }}>
                                                                    {{ $organizationtype->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Organization Name:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="organizationname"
                                                            value="{{ $organization->organizationname }}"
                                                            placeholder="Enter contact number" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Address:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="address"
                                                            value="{{ $organization->address }}"
                                                            placeholder="Enter contact number" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Mobile Number</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="mobilenumber"
                                                            value="{{ $organization->mobilenumber }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="phonenumber"
                                                            value="{{ $organization->phonenumber }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>PAN_VAT_Number</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="pan_vat_number"
                                                            value="{{ $organization->pan_vat_number }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Representative Name</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="representativename"
                                                            value="{{ $organization->representativename }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Security Key <span class="text-danger">*</span>
                                                        @if ($errors->has('security_key'))
                                                            <span class="error text-danger">
                                                                {{ $errors->first('security_key') }}</span>
                                                        @endif
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-key"></i>
                                                        </div>
                                                        <input type="password" class="form-control" name="security_key"
                                                            minlength="9" maxlength="9"
                                                            placeholder="Enter 9 Digits Security Key">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>System Base Url</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-globe"></i>
                                                        </div>
                                                        <input type="url" class="form-control" name="system_base_url"
                                                            value="{{ $organization->system_base_url }}"
                                                            placeholder="Enter System Base URL" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>

                                                        <select class="form-control" name="status" id="status">
                                                            <option value="1"
                                                                {{ $organization->status ? 'selected' : '' }}>
                                                                Active</option>
                                                            <option value="0"
                                                                {{ $organization->status ? '' : 'selected' }}>
                                                                Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top:50px;">
                                                <div class="form-group">
                                                    <h4 style="margin: 0">Select a location!</h4>
                                                    <small style="margin: 0; float: right">Your current location is
                                                        marked.</small>
                                                    </h3>
                                                    <p>Click on a location on the map to locate the branch. Drag the marker
                                                        to
                                                        change location.</p>
                                                    <div id="map"></div>
                                                    <style>
                                                        #map {
                                                            height: 285px;
                                                            width: 100%;
                                                        }

                                                        #map:hover {
                                                            box-shadow: 0 0 1px 1px;
                                                        }
                                                    </style>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-6">
                                                        <label>Latitude <span class="required">*</span></label>
                                                        <input type="text" class="form-control" id="lat"
                                                            name="latitude" value="{{ $organization->latitude }}"
                                                            readonly>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Longitude <span class="required">*</span></label>
                                                        <input type="text" class="form-control" id="lng"
                                                            name="longitude" value="{{ $organization->longitude }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
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
    <script src="{{ asset('back/js/map-edit.js') }}"></script>


    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBHZKZUHrAPqBKGEXz75yXj8fC0hqbqPg&callback=getLocation">
    </script>
@endpush
