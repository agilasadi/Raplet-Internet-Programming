@extends('layouts.app')

@section('style')
	<link href="{{ asset('mycss/enterHeaderCss.css') }}" rel="stylesheet">
@endsection
@section('pageHeaders')
	<title>{{ trans('home.rapletLocale') }} </title>
@endsection

@section('content')




	<div class="container">
		<div class="row">

			<div class="col-md-3 ">
				@include('includes.today')
			</div>

			<div class="col-md-9 no-s-p-o-m">
				<div class="col-md-12 noSidePadding">
					<div class="float-right">
						<div class="btn-group" role="group" aria-label="Basic example">

							<a class="btn btn-link btn-link-custom" role="button" href="{{ route('home') }}">
								{{ trans('home.langname') }}
							</a>

							<a class="btn btn-link btn-link-custom" role="button" href="{{ route('solarsystem') }}">
								<i class="fas fa-globe-africa"></i>
								<span class="hide-on-mobile">&nbsp;&nbsp;{{ trans('home.global') }}</span>
							</a>
							<a class="btn btn-link btn-link-custom" role="button" href="{{ route('curiosity') }}">
								<i class="far fa-images"></i>
								<span class="hide-on-mobile">&nbsp;&nbsp;{{ trans('home.visuals') }}</span>
							</a>
						</div>
					</div>

					<div>
						@if(Auth::check())
							<a class="btn btn-link btn-link-custom" role="button" href="{{ route('makePost') }}">
								<i class="fas fa-plus"></i>&nbsp;&nbsp;{{ trans('home.enterheader') }}
							</a>
						@else
							<a class="btn btn-link btn-link-custom" role="button" data-toggle="modal" href="#loginModel">
								<i class="fas fa-plus"></i>&nbsp;&nbsp;{{ trans('home.enterheader') }}
							</a>
						@endif
					</div>
				</div>

			@if($posts != '0')
					<div class="headersContainer mt-2 mb-3">
						@foreach($posts as $post)
							@component('component.general.post', ["post" => $post, "langs" => $langs, "selectedLang" => $selectedLang])
							@endcomponent
						@endforeach
					</div>
					<small>
						{{ $posts->fragment('homepaginator')->appends(['homepaginator' => $posts->currentPage()])->links() }}
					</small>
				@endif
			</div>
		</div>
	</div>
@endsection
@section('script')
	<script>
        var createComments = "{{ Route('createComments') }}";
	</script>
@endsection


