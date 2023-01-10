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

        #surveyFeedBackData ul li {
            list-style: number;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Survey Info</h1>
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
                                                <div class="media-body">
                                                    <h3 class="text-light display-6" style="text-align: center;">
                                                        {{ $survey->organization->organizationname }}</h3>
                                                    <p class="text-light display-6" style="text-align: center;">
                                                        {{ $survey->organization->address }}</p>
                                                    <p class="text-light display-6" style="text-align: center;">Phone No :
                                                        {{ $survey->organization->phonenumber }}</p>
                                                    <p class="text-light display-6" style="text-align: center;">Vat :
                                                        {{ $survey->organization->pan_vat_number }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="images">
                                @foreach ($survey->images as $key => $image)
                                    <li class="surveyImageListItem" data-image="{{ $image }}">
                                        <img src="{{ $image }}">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <tbody style="font-size: 13px">
                                    <tr>
                                        <th>Survey By</th>
                                        <th style="font-weight: normal">
                                            {{ $survey->user->name }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Survey At</th>
                                        <th style="font-weight: normal">
                                            {{ $survey->survey_at }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Survey Date Time</th>
                                        <th style="font-weight: normal">
                                            {{ $survey->survey_date_time }}
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Survey Feedback</h4>
                                <div id="surveyFeedBackData">
                                    <ul>
                                        <li>
                                            <strong>How likely is it that you would recommend this company to a friend or
                                                colleague?</strong>
                                            <p>{{ $survey->feedback ? $survey->feedback->company_recommendation . ' Star' : 'N/A' }}
                                            </p>
                                        </li>
                                        <li>
                                            <strong>Overall, how satisfied or dissatisfied are you with our
                                                company?</strong>
                                            <p>{{ $survey->feedback->company_satisfaction ?? 'N/A' }}</p>
                                        </li>
                                        <li>
                                            <strong>What type of words would you use to describe our products?</strong>
                                            @if ($survey->feedback)
                                                @foreach (json_decode($survey->feedback->product_description) as $productDescription)
                                                    <p>{{ $productDescription ?? 'N/A' }}</p>
                                                @endforeach
                                            @else
                                                <p>{{ 'N/A' }}</p>
                                            @endif
                                        </li>
                                        <li>
                                            <strong>How well do our products meet your needs?</strong>
                                            <p>{{ $survey->feedback->meets_customer_needs ?? 'N/A' }}</p>
                                        </li>
                                        <li>
                                            <strong>How would you rate the quality of the product?</strong>
                                            <p>{{ $survey->feedback->product_quality ?? 'N/A' }}</p>
                                        </li>
                                        <li>
                                            <strong>How would you rate the value for money of the product?</strong>
                                            <p>{{ $survey->feedback->product_valuability ?? 'N/A' }}</p>
                                        </li>
                                        <li>
                                            <strong>How responsive have we been to your questions or concerns about our
                                                products?</strong>
                                            <p>{{ $survey->feedback->customer_service ?? 'N/A' }}</p>
                                        </li>
                                        <li>
                                            <strong>How long have you been a user of our Product?</strong>
                                            <p>{{ $survey->feedback->product_usage_since ?? 'N/A' }}</p>
                                        </li>
                                        <li>
                                            <strong>How likely are you to purchase any of our other products?</strong>
                                            <p>{{ $survey->feedback->want_other_products ?? 'N/A' }}</p>
                                        </li>
                                        <li>
                                            <strong>Do you have any other comments, questions, or concerns or any bug or
                                                problem in system?</strong>
                                            <p>{{ $survey->feedback->feedback ?? 'N/A' }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group pull-right">
                                    <h4>Representative</h4>
                                    <p>{{ $survey->representative_name }}</p>
                                    <img src="{{ $survey->signature_image }}" height="100" width="100">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <h4>Survey Location</h4>
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
                    <div id="surveyImage">
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
            $('.surveyImageListItem').click(function() {
                var image = $(this).attr('data-image');
                $('#surveyImage').html('<img src="' + image + '" style="width:100%;">');
                $('#viewImageModal').modal('show');
            });
        });

        var map;
        var marker = false;

        function getLocation() {
            navigator.geolocation.getCurrentPosition(showPosition);
        }

        function showPosition(position) {
            let lati = parseFloat(`{{ $survey->latitude }}`),
                long = parseFloat(`{{ $survey->longitude }}`);
            initMap(lati, long);
        }

        function initMap(lati, long) {
            var centerOfMap = new google.maps.LatLng(lati, long);
            var options = {
                center: {
                    lat: lati,
                    lng: long
                },
                zoom: 16
            };
            map = new google.maps.Map(document.getElementById('map'), options);
            var coords = {
                lat: lati,
                lng: long
            };
            addMaker(coords)

            function addMaker(coords) {
                marker = new google.maps.Marker({
                    position: coords,
                    map: map,
                    animation: google.maps.Animation.DROP
                });
            }
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBHZKZUHrAPqBKGEXz75yXj8fC0hqbqPg&callback=getLocation">
    </script>
@endpush
