@extends('layouts.app')

@section('content')
    @if(\App\Models\User::count() === 0)
        <div class="container">
            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="card card-login">
                        <div class="card-header">
                            <img draggable="false" src="{{asset('img/bike-login.jpg')}}" alt="">
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">
                                    {{ __('Name') }}
                                </label>

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                >

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    {{ __('Email Address') }}
                                </label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                >

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">
                                    {{ __('Password') }}
                                </label>

                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autocomplete="new-password"
                                >
                                @error('password')

                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">
                                    {{ __('Confirm Password') }}
                                </label>

                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password"
                                >
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" href="" class="btn btn-primary btn-lg btn-block mb-3">
                                Register Super Admin
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
