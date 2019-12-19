@extends('layouts.app') 
@section('style')
<link href="{{ asset('mycss/enterHeaderCss.css') }}" rel="stylesheet">
<link href="{{ asset('mycss/curiosity.css') }}" rel="stylesheet">
@endsection
 
@section('pageHeaders')
<title>{{ trans('home.rapletCuriosity') }}</title>
@endsection
 
@section('content')




<div class="container">
	<div class="row">

		<div class="col-md-3">
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

			<!-- Cards -->
			<div class="visualCuriosityContent">
				<div class="card-columns">

					@foreach($posts as $post)
					<div class="outherVisualCard">
							<a href="{{ route('word', ['slug' => $post->slug, '' => ''] )}}">
							<div class="card transitionSlow">
								<div class="curiosityImageHolder">
									<img class="card-img-top" src="{{url('storage/posts/'.$post->postmedia->image)}}" alt="raplet image">
								</div>
								<div class="card-body">
									<h6 class="card-title"><a href="{{ route('word', ['slug' => $post->slug, '' => ''] )}}">{{ $post->content }}</a>
									</h6>
									<!-- <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p> -->

									<div class="langsButtonDiv">
										<a href="{{ route('word', ['slug' => $post->slug, '' => ''] )}}">
													<button class="langsButtons transitionSlow"><i
																class="fas fa-globe-americas"></i></button>
												</a>
										<button class="langsButtons transitionSlow" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
										 aria-expanded="false">
													{{ trans('home.otherlanguages') }}&nbsp;&nbsp;<i
															class="fas fa-angle-down"></i>
												</button>

										<div class="dropdown-menu langs-dropdown" aria-labelledby="dropdownMenuButton">
											<h6 class="dropdown-header">
												<small>{{ trans('home.otherlanguages') }}</small>
											</h6>
											@foreach($langs as $lang)
											<a class="dropdown-item" href="{{ route('word', [ 'slug' => $post->slug, 'langname' => $lang->short_name] ) }}">{{ $lang->name }}</a>											@endforeach
										</div>
										<button class="noBackgroundBtns" data-toggle="tooltip" title="{{ trans('home.youCanSeeOtherNations')}}" data-placement="bottom">
													<i class="far fa-question-circle"></i>
												</button>
									</div>
									<p class="card-text">
										<small class="text-muted">
													<a href="{{ route('profile', $post->userprofile->slug) }}">
                                        <span>
                                            —&nbsp;&nbsp;&nbsp;<img class="roundimg"
                                                                    src="{{url('storage/profile/'. $post->userprofile->userImg)}}"
                                                                    alt="..." height="18px;"
                                                                    style="margin-bottom: 2px;">&nbsp;&nbsp;{{ $post->userprofile->name }}
                                        </span>
													</a>
												</small>
									</p>
								</div>
								<div class="cardTopDropdown">
									<button class=""><i class="fab fa-facebook-f"></i></button>
									<button class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
									<div class="dropdown-menu dropdown-menu-right">
										@if(Auth::check()) @if(Auth::id() == $post->user_id)
										<a href="{{ route('editingPostContnet', $post->id) }}" class="dropdown-item editPost" data-content_id="{{ $post->id }}">{{ trans('home.edit') }}</a>										@endif
										<a class="dropdown-item reportAnything" data-type="1" data-content_id="{{ $post->id }}">{{ trans('home.report') }}</a>										@else
										<a class="dropdown-item" href="#">{{ trans('home.plzLogin') }}</a> @endif
										<a class="dropdown-item disabled" href="#">{{ trans('home.share') }}</a>
									</div>
								</div>
							</div>
						</a>
						</div>
					@endforeach

				</div>
			</div>
			<br>
			<small>
					{{ $posts->appends(['curious' => $posts->currentPage()])->links() }}
				</small>
		</div>
	</div>
</div>




<div class="modal fade" id="reportModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-group">
					<label for="reportReason">{{ trans('home.choosReport') }}</label>
					<select class="form-control" name="reportREASON" id="reportREASON">
							<option value="{{ trans('home.insult') }}">{{ trans('home.insult') }}</option>
							<option value="{{ trans('home.spam') }}">{{ trans('home.spam') }}</option>
							<option value="{{ trans('home.racisim') }}">{{ trans('home.racism') }}</option>
							<option value="{{ trans('home.other') }}">{{ trans('home.other') }}</option>
						</select>
				</div>

				<input type="hidden" id="reportingID" value="" name="content_id">
				<input type="hidden" id="reportingTYPE" value="" name="type">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('home.close') }}</button>
				<button type="button" id="sendReport" class="btn btn-primary">{{ trans('home.submit') }}</button>
			</div>
		</div>
	</div>
</div>
@endsection
 
@section('script')
<script>
		var createComments = "{{ Route('createComments') }}";
</script>
@endsection