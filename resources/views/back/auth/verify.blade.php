@extends('layout')

@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verify OTP</div>
                    <div class="card-body">
                        <div class="col-lg-6 pad-left-0">
                            <div class="login-modal-right">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="login" role="tabpanel">
                                        <h5 class="heading-design-h5" style="font-size: 18px; color: #333; font-weight: 500; line-height: 1.2; margin-block-start: 1em; margin-block-end: 1em;  margin-inline-start: 0px; margin-inline-end: 0px; font-weight: bold; display:block">
                                            Enter 6 digit OTP</h5>
                                        <label class="control-label">
                                            One Time Password (OTP) has been
                                            sent to your mobile

                                        </label>
                                        <ul class="code-alrt-inputs signup-code-list">
                                            <li>
                                                <input id="code1" data-value="1" name="number" type="text" placeholder class="form-control input-md" maxlength="1" autofocus required>
                                            </li>
                                            <li>
                                                <input id="code2" data-value="2" name="number" type="text" placeholder class="form-control input-md" maxlength="1" required>
                                            </li>
                                            <li>
                                                <input id="code3" data-value="3" name="number" type="text" placeholder class="form-control input-md" maxlength="1" required>
                                            </li>
                                            <li>
                                                <input id="code4" data-value="4" name="number" type="text" placeholder class="form-control input-md" maxlength="1" required>
                                            </li>
                                            <li>
                                                <input id="code5" data-value="5" name="number" type="text" placeholder class="form-control input-md" maxlength="1" required>
                                            </li>
                                            <li>
                                                <input id="code6" data-value="6" name="number" type="text" placeholder class="form-control input-md" maxlength="1" required>
                                            </li>
                                        </ul>
                                    </div>
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
                        </div>



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