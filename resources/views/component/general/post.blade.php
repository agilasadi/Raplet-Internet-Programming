<div class="articleBox col-md-12 transitionSlow">

	<div class="articleRightBox">
		<a href="{{ route('profile',$post->userprofile->slug) }}">
			<div class="articleCardProfileImage">
				<img class="roundimg"
				     src="{{url('storage/profile/'.$post->userprofile->userImg)}}"
				     alt="raplet image">
			</div>
		</a>
		<div class="col-md-12 noPadding">
			<div class="position-relative">

				<div class="articleBaseDetail">
				<span class="articleAuthor">
					<a href="{{ route('profile',$post->userprofile->slug) }}">
						<b>{{$post->userprofile->name}}</b>
						<small>{{"@".$post->userprofile->slug }}</small>
					</a>
				</span>
					<span class="articleDate dateTimeDefiner">{{$post->created_at}}</span>
				</div>
				<div class="articleCardTitle">
					<a href="{{ route('word', ['slug' => $post->slug, 'langname' => Config::get('app.locale')] )}}"
					   id="postContent{{$post->id}}">{{$post->content }}</a>
				</div>


				<div class="langsButtonDiv">
					<a href="{{ route('word', ['slug' => $post->slug, '' => ''] )}}">
						<button class="langsButtons transitionSlow"><i
									class="fas fa-globe-americas"></i></button>
					</a>
					<a href="{{ route('word', ['slug' => $post->slug, 'langname' => Config::get('app.locale')] )}}">
						<button class="langsButtons transitionSlow">{{ trans('home.langname') }}</button>
					</a>
					<a href="{{ route('word', [ 'slug' => $post->slug, 'langname' => 'en'] ) }}">
						<button class="langsButtons transitionSlow">English</button>
					</a>


					<button class="langsButtons transitionSlow" type="button"
					        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
					        aria-expanded="false">
						{{ trans('home.otherlanguages') }}&nbsp;&nbsp;<i
								class="fas fa-angle-down"></i>
					</button>

					<div class="dropdown-menu langs-dropdown"
					     aria-labelledby="dropdownMenuButton">
						<h6 class="dropdown-header">
							<small>{{ trans('home.otherlanguages') }}</small>
						</h6>
						@foreach($langs as $lang)
							<a class="dropdown-item"
							   href="{{ route('word', [ 'slug' => $post->slug, 'langname' => $lang->short_name] ) }}">{{ $lang->name }}</a>
						@endforeach
					</div>
					<button class="noBackgroundBtns" data-toggle="tooltip"
					        title="{{ trans('home.youCanSeeOtherNations')}}"
					        data-placement="bottom">
						<i class="far fa-question-circle"></i>
					</button>
				</div>

			@if(count($post->comments->where('lang_id', $selectedLang->id)->where('is_featured', 1)) > 0)
			<div class="postCommentPointer"></div>
			</div>
				@component('component.general.bestcomment',["comment" => $post->bestComment])
				@endcomponent
			@else
			</div>
				<div style="margin-bottom: -3px;"></div>
			@endif


			<div class="interractWithPost">
				<!--
				<button class="noBackgroundBtns"><a><i class="fab fa-facebook-f"></i></a></button>
				<button class="noBackgroundBtns"><a><i class="fab fa-twitter"></i></a></button>
				-->
				<div class="btn-group">
					<button type="button" class="noBackgroundBtns" data-toggle="dropdown"
					        aria-haspopup="true" aria-expanded="false">
						<a><i class="fas fa-ellipsis-h"></i></a>
					</button>
					<div class="dropdown-menu dropdown-menu-right">
						@if(Auth::check())
							@if(Auth::id() == $post->user_id)
								<a href="{{ route('editingPostContnet', $post->id) }}"
								   class="dropdown-item editPost"
								   data-content_id="{{ $post->id }}">{{ trans('home.edit') }}</a>
							@endif
							<a class="dropdown-item reportAnything" data-type="1"
							   data-content_id="{{ $post->id }}">{{ trans('home.report') }}</a>
						@else
							<a class="dropdown-item"
							   href="#">{{ trans('home.plzLogin') }}</a>
						@endif
						<a class="dropdown-item disabled"
						   href="#">{{ trans('home.share') }}</a>
					</div>
				</div>
			</div>


		</div>

	</div>
</div>

