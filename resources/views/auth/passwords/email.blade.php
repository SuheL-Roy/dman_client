@extends('FrontEnd.loginMaster')
@section('title')
    Forget Password
@endsection
@section('content')
    <style>
        .btn-success {
            color: #fff;
            background-color: var(--primary);
            border-color: var(--primary);
        }

        button:hover {
            color: #111110 !important;
            background: var(--scolor) !important;
            text-decoration: none;
        }
    </style>
    <section class="container">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <form action="{{ route('password.email') }}" method="POST"
                style="margin-top:190px; margin-bottom:124px; border: 1px solid var(--primary); 
            padding: 30px; border-radius: 1%; box-shadow: 5px 7px var(--primary);">
                @csrf
                <h3 class="text-center" style="color: var(--primary);"><b>Forget Password</b></h3>
                <br><br>
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label class="control-label" for="email">E-Mail Address</label>
                        <input id="email" type="email" name="email" required autofocus
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback help-block small" role="alert">
                                <strong style="color: var(--primary);">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-block btn-success">
                        Send Password Reset Link
                    </button>
                </div>
                <br>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </section>
@endsection


{{-- var(--primary) --}}
