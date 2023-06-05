@extends('layouts.app')

@section('content')
    <form method="post">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">{{$title}}</h5>
                    </div>
                    <div class="card-body">
                        <x-input.text
                            :label="'Name'"
                            :name="'name'"
                            :value="$obj->name"
                        />

                        <div class="form-group">
                            <label for="form_email">Email</label>
                            <input
                                id="form_email"
                                name="form[email]"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{$obj->email}}"
                            >
                        </div>
                        @error('email')
                        <div class="invalid-feedback d-block" role="alert">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="form_password">Password</label>
                            <input
                                id="form_password"
                                name="form[password]"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                            >
                        </div>
                        @error('password')
                        <div class="invalid-feedback d-block" role="alert">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label for="form_confirm_password">Confirm password</label>
                            <input
                                id="form_confirm_password"
                                name="form[confirm_password]"
                                type="password"
                                class="form-control @error('confirm_password') is-invalid @enderror"
                            >
                        </div>
                        @error('confirm_password')
                        <div class="invalid-feedback d-block" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.edit.buttons')
    </form>
@endsection
