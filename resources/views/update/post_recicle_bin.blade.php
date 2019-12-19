@extends('layouts.app')
@section('content')
	<div class="container">
		@if(count($logs) > 0)
			@foreach($logs as $log)
				@if(Auth::check())
					@if(Auth::user()->userprofile->role_id == '1' || Auth::user()->userprofile->role_id == '2')
						<div class="my-3 unavailableContent badExtream">
							<i class="fas powerDisabledStuff fa-power-off"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.unavailableContent') }}
							—
							<a href="{{ route('profile',$log->posts->logposts->userprofile->slug) }}">{{ "@".$log->posts->logposts->userprofile->slug }}</a>
							<span class="enablePost" data-post_id="{{ $log->posts->id }}"><i
										class="fas fa-power-off"></i>&nbsp;&nbsp;{{ trans('home.activate') }}</span>
						</div>

					@elseif(Auth::id() == $log->posts->user_id)
						<div class="my-3 unavailableContent badExtream">
							<i class="fas powerDisabledStuff fa-power-off"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.unavailableContent') }}
							—
							<a href="{{ route('profile',$log->posts->logposts->userprofile->slug) }}">{{ "@".$log->posts->logposts->userprofile->slug }}</a>
							<span class="enablePost" data-post_id="{{ $log->posts->id }}"><i
										class="fas fa-power-off"></i>&nbsp;&nbsp;{{ trans('home.activate') }}</span>
						</div>

					@else
						<div class="my-3 unavailableContent badExtream">
							<i class="fas powerDisabledStuff fa-power-off"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.unavailableContent') }}
						</div>
					@endif
				@endif
			@endforeach

	@else
		<p class="pl-5 text-muted">
			{{ trans('home.nothingtorecicle') }}
		</p>
	@endif
	</div>
@endsection