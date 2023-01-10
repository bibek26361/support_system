@extends('layout')

@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Reset Password</div>
                    <div class="card-body">

                        @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                        @endif

                        <form action="{{ route('user.forgot-password') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email" class="form-control" name="email" required autofocus>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset OTP
                                </button>
                            </div>
                        </form>

                    </div>

                    <div id="verifyOTPContainer" class="form-inpts checout-address-step" style="display: none">
                        <div class="form-title">
                            <h6>Enter 6 digit OTP</h6>
                        </div>
                        <div  class="form-group pos_rel">
                            <label class="control-label">
                                One Time Password (OTP) has been
                                sent to your mobile
                                <b id="mobile_no_verify"></b>, please enter
                                here to verify your mobile.
                            </label>
                            <ul class="code-alrt-inputs signup-code-list">
                                <li>
                                    <input id="code1" data-value="1" name="number" type="text" placeholder class="form-control input-md" maxlength="1">
                                </li>
                                <li>
                                    <input id="code2" data-value="2" name="number" type="text" placeholder class="form-control input-md" maxlength="1">
                                </li>
                                <li>
                                    <input id="code3" data-value="3" name="number" type="text" placeholder class="form-control input-md" maxlength="1">
                                </li>
                                <li>
                                    <input id="code4" data-value="4" name="number" type="text" placeholder class="form-control input-md" maxlength="1">
                                </li>
                                <li>
                                    <input id="code5" data-value="5" name="number" type="text" placeholder class="form-control input-md" maxlength="1">
                                </li>
                                <li>
                                    <input id="code6" data-value="6" name="number" type="text" placeholder class="form-control input-md" maxlength="1">
                                </li>
                            </ul>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <button id="resendOTPBtn" class="login-btn hover-btn" type="button">Resend
                                    Code</button>
                            </div>
                            <div class="col-sm-6">
                                <button id="verifyOTPBtn" class="login-btn hover-btn" type="button">Verify
                                    Now</button>
                            </div>
                        </div>
                    </div>
                    <div id="changePasswordContainer" class="form-inpts checout-address-step" style="display: none">
                        <form id="changePasswordForm" action="{{ route('user.change-password') }}" method="POST">
                            @csrf
                            <div class="form-title mb-3">
                                <h6>CHANGE PASSWORD</h6>
                            </div>

                            <div class="form-group pos_rel">
                                <input id="password" name="password" type="password" placeholder="Enter New Password" class="form-control lgn_input">
                                <i class="uil uil-padlock lgn_icon"></i>
                                <span class="text-danger password_err"></span>
                            </div>
                            <div class="form-group pos_rel">
                                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Enter Confirm Password" class="form-control lgn_input">
                                <i class="uil uil-padlock lgn_icon"></i>
                                <span class="text-danger password_confirmation_err"></span>
                            </div>
                            <button class="login-btn hover-btn" type="submit">Confirm Change
                                Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('custom-scripts')
<script src="{{ asset('back/vendor/jquery-3.2.1.min.js') }}"></script>
<script>
    $(function() {
            $('#code1, #code2, #code3, #code4, #code5, #code6').keypress(function(event) {
                let key = event.which;
                if (key >= 48 && key <= 57) {} else return false;
            });

            $('#code1, #code2, #code3, #code4, #code5, #code6').keyup(function(event) {
                let codePosition = $(this).data('value'),
                    value = $(this).val();
                if (codePosition === 6 && value.length)
                    $('#verifyOTPBtn').trigger('click');
                else {
                    if (value.length === 1) {
                        $(`#code${codePosition+1}`).focus();
                    }
                }

                if (event.keyCode === 8)
                    if (codePosition > 1)
                        $(`#code${codePosition-1}`).focus();
            });

            $('#verifyOTPBtn').click(function() {
                let code1 = $('#code1').val(),
                    code2 = $('#code2').val(),
                    code3 = $('#code3').val(),
                    code4 = $('#code4').val(),
                    code5 = $('#code5').val(),
                    code6 = $('#code6').val(),
                    otp = `${code1}${code2}${code3}${code4}${code5}${code6}`;

                $.ajax({
                    method: 'POST',
                    url: `{{ route('user.verify-process') }}`,
                    data: {
                        otp
                    },
                    dataType: 'json'
                }).then(function(responseData) {
                    let {
                        success
                    } = responseData;
                    if (success) {
                        // OTPVerifiedAlert();
                        window.open(`{{ url('/') }}`, '_SELF');
                    } else {
                        // invalidOTPAlert();
                    }
                });
            });
        });
    
</script>
@endpush