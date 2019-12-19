@extends('layouts.app')


@section('style')
<link href="{{ asset('mycss/profile.css') }}" rel="stylesheet">
<link href="{{ asset('mycss/croppie.css') }}" rel="stylesheet">
@endsection



@section('pageHeaders')
<title>{{ trans('home.rapletEditUser') }} {{ Auth::user()->name }}</title>
@endsection



@section('content')


<div class="container">
	<div class="row">

		<div class="col-md-3 ">
	@include('includes.today')
		</div>

		<div class="col-md-9">
			<div class="my-3 p-3 bg-white editableprofile box-shadow">
				<div class="card my-3">
					<div class="card-body">
						<h5 class="card-title">{{ trans("home.changeProfileImg") }}</h5>
						<label for="upload_image"><img class="roundimg" height="120px;" width="120px"
								src="{{url('storage/profile/'.Auth::user()->userprofile->userImg)}}"></label></label>
						<input type="file" name="upload_image" id="upload_image" accept="image/*" hidden />
						<div id="uploaded_image"></div>
					</div>
				</div>



				@if(session()->has('verify-message'))
					<div class="alert alert-success">
						{{ session()->get('verify-message') }}
					</div>
				@endif


				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">{{ trans('home.username') }}</span>
					</div>
					<input type="text" id="updateUsername" class="form-control requiredUpdate"
						data-content="{{ trans('home.username') }}" placeholder="{{ trans('home.username') }}"
						value="{{ Auth::user()->userprofile->name }}">
				</div>


				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text">@url</span>
					</div>
					<input type="text" id="updateSlug" class="form-control requiredUpdate"
						data-content="{{ trans('home.slug') }}" aria-label="Username"
						value="{{ Auth::user()->userprofile->slug }}">
				</div>



				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">{{ trans('home.about') }}</span>
					</div>
					<textarea class="form-control" id="updateAbout" data-content="{{ trans('home.about') }}"
						aria-label="With textarea">
							@if( Auth::user()->userprofile->bio !== "0")
								{{ Auth::user()->userprofile->bio }}
							@endif
						</textarea>
				</div>
				<br>

				@if(Auth::user()->verify == "1")
				<p>
					<a class="" data-toggle="collapse" href="#collapsePassInfo" role="button" aria-expanded="false">
						{{ trans('home.password') }} & {{ trans('home.email') }}
					</a>
				</p>
				<div class="collapse" id="collapsePassInfo">
					<div class="card card-body">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">{{ trans('home.email') }}</span>
							</div>
							<input type="text" class="form-control requiredUpdate" id="updateEmail"
								data-content="{{ trans('home.email') }}" placeholder="{{ trans('home.email') }}"
								value="{{ Auth::user()->email }}" aria-label="Recipient's username"
								aria-describedby="basic-addon2">
						</div>


						<div class="form-group row">
							<label for="inputPassword"
								class="col-sm-2 col-form-label">{{ trans('home.password') }}</label>
							<div class="col-sm-10">
								<input type="password" class="form-control"
									data-content="{{ trans('home.oldpassword') }}" id="oldPassword"
									placeholder="{{ trans('home.password') }}">
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword"
								class="col-sm-2 col-form-label">{{ trans('home.newpassword') }}</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="updatePassword"
									placeholder="{{ trans('home.newpassword') }}">
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword"
								class="col-sm-2 col-form-label">{{ trans('home.confirm-password') }}</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="confirmEditPassword"
									placeholder="{{ trans('home.confirm-password') }}">
							</div>
						</div>
						
					</div>
					<br>
					
				</div>
				@else
				<form method="POST" action="{{ route('update_password') }}">
					@csrf
					<input type="text" class="form-control requiredUpdate hidden" hidden id="updateEmail" value="{{ Auth::user()->email }}">

					<small class="text-muted"><i class="fas fa-lock"></i> {{ trans('home.create-password-to-login') }}</small>
					
					<div class="form-group pt-3">
						<label for="exampleInputPassword1">{{ trans('home.password') }}</label>
						<input type="password" class="form-control" id="verify_password" name="verify_password" placeholder="{{ trans('home.password') }}" value="{{ old('new-password') }}">
						@if ($errors->has("verify_password"))
							<div class="invalid-feedback d-block">
								{{ $errors->first("verify_password") }}
							</div>
						@endif
					</div>
					
					<div class="form-group">
						<label for="new-password-confirm">{{ trans('home.confirm-password') }}</label>
						<input type="password" class="form-control" id="verify_password_confirmation" name="verify_password_confirmation" placeholder="{{ trans('home.confirm-password') }}" value="{{ old('new-password-confirm') }}">
						@if ($errors->has("verify_password_confirmation"))
						<div class="invalid-feedback d-block">
							{{ $errors->first("verify_password_confirmation") }}
						</div>
						@endif
					</div>

					<button type="submit" class="btn btn-light btn-sm">{{ trans('home.create') }}</button>
				</form>
				<hr>
				@endif
				<div class="input-group">
					<button id="updateProfile" class="btn btn-primary shadowingBtn">{{ trans('home.save') }}</button>
					<a href="{{ route('profile', Auth::user()->userprofile->slug) }}">
						<button type="button" class="btn btn-link">{{ trans('home.cancel') }}</button>
					</a>
				</div>


			</div>
		</div>
	</div>
</div>


<div id="uploadimageModal" class="modal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 text-center noSidePadding">
						<div id="profile_img" style="width:auto; margin-top:30px"></div>
					</div>
					<div class="col-md-12 text-center">
						<br />
						<button class="btn btn-primary crop_image shadowingBtn"><i class="fa fa-upload"
								aria-hidden="true"></i>&nbsp;&nbsp;{{ trans('home.save') }}
						</button>
						<button type="button" class="btn btn-default shadowingBtn" data-dismiss="modal">{{ trans('home.cancel') }}
						</button>

					</div>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection



@section('script')
<script src="{{ asset('myjs/plugin/croppie.js') }}"></script>
<script src="{{ asset('myjs/authed/editprofile.js') }}"></script>
<script>
	var uploadProfileImage = '{{ route("uploadProfileImage") }}';
        var updateProfile = '{{ route("updateProfile") }}';
        var required = '{{ trans("home.required") }}';
        var passwordNotMAtch = '{{ trans("home.passwordNotMAtch") }}';
</script>
@endsection