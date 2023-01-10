@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manage Organizations</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            Create Organization
                            <a href="{{ route('organization.index') }}">
                                <button type="button" class="btn btn-warning btn-xs pull-right"><i
                                        class="fa fa-hand-point-left" aria-hidden="true"></i>
                                    Back To Organization List
                                </button>
                            </a>
                        </div>
                        <form action="{{ route('organization.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Organization Type <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <select name="organization_type_id" class="form-control">
                                                            <option value="">Select Organization Type</option>
                                                            @foreach ($organizationtypes as $organizationtype)
                                                                <option value="{{ $organizationtype->id }}"
                                                                    {{ old('organization_type_id') == $organizationtype->id ? 'selected' : '' }}>
                                                                    {{ $organizationtype->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Organization Name <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-globe"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="organizationname"
                                                            value="{{ old('organizationname') }}"
                                                            placeholder="Enter Address"
                                                            placeholder="Enter Organization Name" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Address <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-location"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="address"
                                                            value="{{ old('address') }}" placeholder="Enter Address"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Mobile Number <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-mobile"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="mobilenumber"
                                                            value="{{ old('mobilenumber') }}"
                                                            placeholder="Enter Mobile Number" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Phone Number <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="phonenumber"
                                                            value="{{ old('phonenumber') }}"
                                                            placeholder="Enter Phone Number" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>PAN_VAT_Number <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-receipt"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="pan_vat_number"
                                                            value="{{ old('pan_vat_number') }}"
                                                            placeholder="Enter PAN/VAT Number" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Representative Name <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user-tag"></i>
                                                        </div>
                                                        <input type="text" class="form-control" name="representativename"
                                                            value="{{ old('representativename') }}"
                                                            placeholder="Enter Representative Name" required>
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
                                                            placeholder="Enter Security Key" required>
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
                                                            value="{{ old('system_base_url') }}"
                                                            placeholder="Enter System Base URL" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Status <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="margin-top:10px;">
                                            <div class="form-group">
                                                <h4 style="margin: 0">Select a location!</h4>
                                                <small style="margin: 0; float: right">Your current location is
                                                    marked.</small>
                                                </h3>
                                                <p>Click on a location on the map to locate the organization. Drag the
                                                    marker to
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
                                                        name="latitude" placeholder="Enter Latitude" readonly>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Longitude <span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="lng"
                                                        name="longitude" placeholder="Enter Longitude" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <a href="{{ route('organization.index') }}" class="btn btn-danger">Close</a>
                                <button type="submit" class="btn btn-success">Save</button>
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
    <script src="{{ asset('back/js/map.js') }}"></script>


    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBHZKZUHrAPqBKGEXz75yXj8fC0hqbqPg&callback=getLocation">
    </script>
@endpush
