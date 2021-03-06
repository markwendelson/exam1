<!-- Register Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Register</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form id="register" method="POST" action="{{ route('postRegister') }}">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="reg_email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="reg_email" type="email" class="form-control @error('reg_email') is-invalid @enderror" name="reg_email" value="{{ old('reg_email') }}" required autocomplete="email">

                                            @error('reg_email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <span class="invalid-feedback" role="alert" id="error-email"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert" id="password-error">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }} required>

                                                <label class="form-check-label" for="terms">
                                                    {{ __('Terms and Conditions') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn-register" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('extra_scripts')
<script>
    $( document ).ready(function() {

        $('#reg_email').on('blur', function(e) {
            validateEmail(this)
        });

        var msg = document.getElementById('password-error')
        if (msg == null)
        return

        $('#exampleModal').modal().show()
    });

    function validateEmail(inputText)
    {
        var emailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(inputText.value.match(emailFormat)) {
            console.log($('#reg_email').val())
            let route = `{{ route('validate.email') }}`
            let params = {
                email: $('#reg_email').val()
            }

            axios.post(route, params)
            .then((response) => {
                console.log(response.data)
                if(response.data) {
                    $('#error-email').text("The email has already been taken.");
                    $('#error-email').show();
                    $('#btn-register').attr('disabled', 'disabled');
                } else {
                    $('#error-email').text("");
                    $('#error-email').hide();
                    $('#btn-register').removeAttr('disabled');
                }
            })
            return true;
        }
    }

</script>
@endsection
