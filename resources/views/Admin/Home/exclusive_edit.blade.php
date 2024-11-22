@extends('Master.main')
@section('title')
    Rider
@endsection
@section('content')
    <div class="container-fluid" style="margin-left: 20px;">
        <div class="row">
            <h1 style="text-align: center">Exclusive Edit</h1>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-8" style="margin-top: 20px">
                <div class="">
                    <form method="post" action="{{ route('exclusive.update', ['id' => $data->id]) }}">
                        @csrf
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label class="login2 pull-right pull-right-pro">
                                        Name <span class="table-project-n">*</span>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" value="{{ $data->name }}" name="name" autocomplete="name"
                                        class="form-control" placeholder="User Name" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label class="login2 pull-right pull-right-pro">
                                        Email <span class="table-project-n">*</span>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input id="email" type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ $data->email }}" required autocomplete="email" placeholder="User Email">
                                    @error('email')
                                        <span class="invalid-feedback help-block small" role="alert">
                                            <strong style="color:red;">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label class="login2 pull-right pull-right-pro">
                                        Mobile <span class="table-project-n">*</span>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="number" value="{{ $data->mobile }}" name="mobile" class="form-control"
                                        placeholder="User Mobile" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-inner">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label class="login2 pull-right pull-right-pro">
                                        Role <span class="table-project-n">*</span>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <select name="role" class="form-control" required>
                                        <option value="">Select User Role</option>
                                        @if (Auth::user()->role == 1)
                                            <option value="2" {{ $data->role == '2' ? 'selected' : '' }}>Admin</option>
                                            <option value="4" {{ $data->role == '4' ? 'selected' : '' }}>Manager
                                            </option>
                                        @endif
                                        @if (Auth::user()->role == 8)
                                            <option value="18" {{ $data->role == '18' ? 'selected' : '' }}>Hub Incharge
                                            </option>
                                        @endif
                                        @if (Auth::user()->role == 1)
                                            <option value="6" {{ $data->role == '6' ? 'selected' : '' }}>Accounts
                                            </option>
                                            <option value="16" {{ $data->role == '16' ? 'selected' : '' }}>Call Center
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <button type="submit" class="button0 btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </div>
@endsection
