@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form id="register-form" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control" name="name"
                                        value="{{ old('name') }}" autocomplete="name" autofocus>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="surname"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text"
                                        class="form-control " name="surname"
                                        value="{{ old('surname') }}" autocomplete="surname" autofocus>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="date_of_birth"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Date of birth') }}</label>

                                <div class="col-md-6">
                                    <input id="date_of_birth" type="date"
                                        class="form-control "
                                        name="date_of_birth" value="{{ old('date_of_birth') }}" 
                                        autocomplete="date_of_birth" autofocus>
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control " name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control " name="password"
                                        required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button id="btn-form" type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    const regForm = document.getElementById('register-form');

    regForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const { date_of_birth, email, password, password_confirmation } = regForm.elements;

        if(!isValidEmail(email.value)) {
            alert("L'email inserita non è valida.");
            return;
        }

        if(!isStrongPassword(password.value)) {
            alert("La password inserita non è sicura!");
            return;
        }

        if(!isEqualPassword(password.value, password_confirmation.value)) {
            alert("Le password non corrispondono!");
            return;
        }

        if(!validateDateOfBirth(date_of_birth.valueAsDate)) {
            alert("La data di nascita inserita non è corretta.")
            return;
        }

        alert("Registration successful!");
          regForm.submit();          
          regForm.reset();

    })

    function validateDateOfBirth(dateOfBirth) {
        const currentDate = new Date();

        if(dateOfBirth >= currentDate || dateOfBirth == currentDate) {
            return false;
        }
        else {
            return true;
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

    function isStrongPassword(password) {
        return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/.test(password);
}

    function isEqualPassword(password, confirmPass) {
        if(confirmPass != password) {
            return false;
        }
        else {
            return true;
        }
    }
</script>
@endsection
