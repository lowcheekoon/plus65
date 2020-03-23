@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lucky Draw (front end portal)</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div> 
                    @endif

                    <form method="POST" action="{{ url('draw') }}">
						@csrf
						
						<div class="form-group row">
                            <label for="drawno" class="col-md-4 col-form-label text-md-right">Draw No</label>

                            <div class="col-md-6">
								<span>{{ date('Ymd') }}</span>
                            </div>
                        </div>
						
						<div class="form-group row">
                            <label for="user" class="col-md-4 col-form-label text-md-right">User</label>

                            <div class="col-md-6">
								<input id="user" type="text" class="form-control @error('user') is-invalid @enderror" name="user" value="{{ old('user') }}" autofocus>

                                @error('user')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						
						<div class="form-group row">
                            <label for="winningNumber" class="col-md-4 col-form-label text-md-right">Winning Number</label>

                            <div class="col-md-6">
								@php
								$winningNumber = substr(str_shuffle('0123456789'),0,1) . substr(str_shuffle('0123456789'),0,1) . substr(str_shuffle('0123456789'),0,1) . substr(str_shuffle('0123456789'),0,1);
								@endphp
								<input id="winningNumber" type="text" class="form-control @error('winningNumber') is-invalid @enderror" name="winningNumber" value="{{ $winningNumber }}" required autofocus>

                                @error('winningNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						
						<div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
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
