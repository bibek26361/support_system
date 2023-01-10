@extends('back.layouts.main')
@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Modify survey</h1>
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

                                    <form action="{{ route('surveys.update', $survey->id) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')



                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class=" form-group">

                                                    <label>Organization:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-building"></i>
                                                        </div>
                                                        <select name="organization_id" class="form-control select2 ">
                                                            <option value="">Select Organization Type</option>
                                                            @foreach ($organizations as $organization)
                                                                <option value="{{ $organization->id }}"
                                                                    {{ $organization->id == $survey->organization_id ? 'selected' : '' }}>
                                                                    {{ $organization->organizationname }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Representative Name</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>

                                                        <input type="text" class="form-control"
                                                            name="representative_name"
                                                            value="{{ $survey->representative_name }}"required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">

                                                    <label>Feedback</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-pen"></i>
                                                        </div>


                                                        <input type="text" class="form-control" name="feedback"
                                                            value="{{ $survey->feedback }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Signature Image</label><br>
                                                    <img src="{{ asset('public/images/surveys') }}/{{ $survey->signature_image }}"
                                                        height="80" width="80"><br><br>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-image"></i>
                                                        </div>

                                                        <input type="file" class="form-control" name="signature_image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <h4 style="margin: 0">Select a location!</h4>
                                                <small style="margin: 0; float: right">User Survey location is
                                                    marked.</small>
                                                </h3>
                                                <p>Click on a location on the map to locate the branch. Drag the marker to
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
                                                        name="latitude" value="{{ $survey->latitude }}"
                                                        placeholder="Enter Latitude" readonly>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Longitude <span class="required">*</span></label>
                                                    <input type="text" class="form-control" id="lng"
                                                        name="longitude" value="{{ $survey->longitude }}"
                                                        placeholder="Enter Longitude" readonly>
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



    <script src="{{ asset('back/js/map-edit.js') }}"></script>


    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBHZKZUHrAPqBKGEXz75yXj8fC0hqbqPg&callback=getLocation">
    </script>
@endpush
