@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lucky Draw (Admin Panel)</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					
					@if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    
					<div class="form-group row">
                        <label for="prizeTypes" class="col-md-4 col-form-label text-md-right">Draw No</label>
						<div class="col-md-6">
							<span>{{ date('Ymd') }}</span>
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<table class="table">
								<thead>
									<tr>
										<th>1st Prize</th>
										<th>2nd Prize</th>
										<th>3rd Prize</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
										#1:
										@isset($results[1])
											{{ $results[1] }}
										@endisset
										</td>
										<td>
										#1:
										@isset($results[2])
											{{ $results[2] }}
										@endisset
										<br>
										#2:
										@isset($results[3])
											{{ $results[3] }}
										@endisset
										</td>
										<td>
										#1:
										@isset($results[4])
											{{ $results[4] }}
										@endisset
										<br>
										#2:
										@isset($results[5])
											{{ $results[5] }}
										@endisset
										<br>
										#3:
										@isset($results[6])
											{{ $results[6] }}
										@endisset
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-1"></div>
					</div>
					
					<form method="POST" action="{{ url('admin/draw') }}">
						@csrf
						
						<div class="form-group row">
                            <label for="prizeTypes" class="col-md-4 col-form-label text-md-right">Prize Types</label>

                            <div class="col-md-6">
								<select id="prizeTypes" name="prizeTypes" class="form-control @error('prizeTypes') is-invalid @enderror" required autofocus>
									<option>Please Select</option>
									<option value="4" {{ old('prizeTypes')=="4" ? "selected": "" }}>Third Prize 1st Winner</option>
									<option value="5" {{ old('prizeTypes')=="5" ? "selected": "" }}>Third Prize 2nd Winner</option>
									<option value="6" {{ old('prizeTypes')=="6" ? "selected": "" }}>Third Prize 3rd Winner</option>
									<option value="2" {{ old('prizeTypes')=="2" ? "selected": "" }}>Second Prize 1st Winner</option>
									<option value="3" {{ old('prizeTypes')=="3" ? "selected": "" }}>Second Prize 2nd Winner</option>
									<option value="1" {{ old('prizeTypes')=="1" ? "selected": "" }}>First Prize</option>
								</select>
                                
                                @error('prizeTypes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						
						<div class="form-group row">
                            <label for="randomly" class="col-md-4 col-form-label text-md-right">Generate Randomly</label>

                            <div class="col-md-6">
								<select id="randomly" name="randomly" class="form-control @error('randomly') is-invalid @enderror" required autofocus>
									<option>Please Select</option>
									<option value="no" {{ old('randomly')=="no" ? "selected": "" }}>No</option>
									<option value="yes" {{ old('randomly')=="yes" ? "selected": "" }}>Yes</option>
								</select>
                                
                                @error('randomly')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						
						<div class="form-group row">
                            <label for="winningNumber" class="col-md-4 col-form-label text-md-right">Winning Number</label>

                            <div class="col-md-6">
                                <input id="winningNumber" type="text" class="form-control @error('winningNumber') is-invalid @enderror" name="winningNumber" value="{{ old('winningNumber') }}" autofocus>

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
                                    Draw
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
