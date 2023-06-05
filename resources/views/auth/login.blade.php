@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-lg-4 col-md-6 ml-auto mr-auto">
            <form class="form" method="post" action="{{ route('login') }}">
                @csrf
                <div class="card card-login">
                    <div class="card-header">
                        <img draggable="false" src="{{asset('img/bike-login.jpg')}}" alt="">
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password" required
                                   autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" href="" class="btn btn-primary btn-lg btn-block mb-3">
                            Log in
                        </button>
                        <div class="pull-right">
                            <div class="col-md-8 offset-md-4">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
