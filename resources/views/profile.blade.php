@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Profile</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

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
                                            <input id="reg_email" type="email" class="form-control @error('reg_email') is-invalid @enderror" name="reg_email" value="{{ $user->email }}" required autocomplete="email">

                                            @error('reg_email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <span class="invalid-feedback" role="alert" id="error-email"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12 offset-md-4">
                                            <button type="submit" id="btn-update" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Change Password</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <form action="POST" onsubmit="event.preventDefault()">

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Old Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required>

                                        @error('old_password')
                                            <span class="invalid-feedback" role="alert" id="password-error">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
                                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12 offset-md-4">
                                        <button type="submit" id="btn-change-password" class="btn btn-primary">Change Password</button>
                                    </div>
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
@section('extra_scripts')
<script>
$( document ).ready(function() {

    $('#reg_email').on('blur', function(e) {
        validateEmail(this)
    });

    $('#btn-update').on('click', function(e) {
        console.log('update')
        let route = `{{ route('profile.update') }}`
        let params = {
            name: $('#name').val(),
            email: $('#reg_email').val()
        }

        axios.post(route, params)
        .then((response) => {
            if(response.data.status == "success") {
                alert('success')
            } else {
                alert('failed')
            }
        })
    });

    $('#btn-change-password').on('click', function(e) {
        console.log('change password')
        let route = `{{ route('profile.changepassword') }}`
        let params = {
            old_password: $('#old_password').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val()
        }

        if(params.old_password == "" || params.password == "" || params.password_confirmation == "")
        return

        if(params.password != params.password_confirmation)
        return

        axios.post(route, params)
        .then((response) => {
            if(response.data.status == "success") {
                alert('success')
            } else {
                alert('failed')
            }
        })
    });

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
