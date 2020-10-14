@extends('layouts.basic')

@section('content')
<div class="container-fluid onesection register-bg">
     <div class="container">
         <div class="centerTop">
             <form class="center register-form padded bg-light halfForm" method="POST" action="{{ route('register') }}">
                 @csrf
                 <br>
                 <h2 class="text-center text-dark font-weight-bolder">Register</h2>
                 <br>

                 <div class="form-group">
                     <label>Full Name</label>
                     <input id="name" type="text" class="form-control input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                     @error('name')
                     <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label>Username</label>
                     <input id="username" type="text" oninput="checkUsername(this.value)" class="form-control input @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" >
                     <span id="username_warning" class="text-danger">Username cannot contain white space</span>
                     @error('username')
                     <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label>Email</label>
                     <input id="email" type="email" class="form-control input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                     @error('email')
                     <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label>Password</label>
                     <input id="password" type="password" class="form-control input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                     @error('password')
                     <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                     @enderror
                 </div>

                 <div class="form-group">
                     <label>Confirm Password</label>
                     <input id="password-confirm" type="password" class="form-control input" name="password_confirmation" required autocomplete="new-password">
                 </div>

                 <div class="form-group mb-0">
                     <button id="submit" type="submit" class="btn btn-main full-width">
                         {{ __('Register') }}
                     </button>
                 </div>
                 <br>
                 <a href="/login" class="text-dark">Already have an account?</a><br><br>
             </form>
         </div>
     </div>
</div>
@endsection
