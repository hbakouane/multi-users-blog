@extends('layouts.basic')

@section('content')
    <div class="container-fluid onesection register-bg">
        <div class="container">
            <div class="centerTop">
                <form class="center register-form padded bg-light halfForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <br>
                    <h2 class="text-center text-dark font-weight-bolder">Welcome Back!</h2>
                    <br>
                    <div class="form-group">
                        <label>Username</label>
                        <input id="username" type="text" class="form-control input @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <a href="/register" class="text-dark">Don't have an account?</a><br><br>
                        <a href="{{ route('password.request') }}" class="text-dark">Forgot your password?</a>
                        <br><br>
                        <button type="submit" class="btn btn-main full-width">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
