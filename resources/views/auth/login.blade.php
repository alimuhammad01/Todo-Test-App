@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <div class="loginScreen">
            <div class="loginBlock">
                <div class="logo">
                    ToDo
                </div>
                <div class="loginInner">
                    <h3>Log in to continue...</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label>
                                <input placeholder="Email address" class="form-control" type="email" name="email" :value="old('email')" required autofocus/>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input placeholder="Password" class="form-control" type="password" name="password" required autocomplete="current-password"/>
                            </label>
                        </div>
                        <div class="formFooter">
                            <button type="submit" class="loginBtn">Log in</button>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}>Forgot Password</a>
                        @endif
                                    </div>
                                </form>

                                <p>Don't have an account? <a href="#">Register</a></p>
                        </div>

                </div>
            </div>
        </div>
        <!-- LoginScreen end -->

    </div>
@endsection
