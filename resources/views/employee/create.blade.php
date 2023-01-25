@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Employee</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('employees.store') }}">
                            @csrf

                            <div class="row mb-4">
                                <label for="name" class="col-md-2 col-form-label text-md-end">Employee Name</label>

                                <div class="col-md-8">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label for="email"
                                       class="col-md-2 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="phone_number"
                                       class="col-md-2 col-form-label text-md-end">Phone Number</label>

                                <div class="col-md-8">
                                    <input id="phone_number" type="text"
                                           class="form-control @error('phone_number') is-invalid @enderror"
                                           name="phone_number" value="{{ old('phone_number') }}" required autofocus>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="company_id"
                                       class="col-md-2 col-form-label text-md-end">Companies</label>

                                <div class="col-md-8">
                                    <select name="company_id" id="compay_id" class="form-control">
                                        @foreach($companies as $company)
                                        <option value="{{$company->id}}">
                                            {{$company->name}}
                                        </option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">
                                        create
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
