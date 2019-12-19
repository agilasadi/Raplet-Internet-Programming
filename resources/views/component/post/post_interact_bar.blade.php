<div class="interactWithAPost col-md-12 btn-group">
	<button class="interactive-bar-button border-none likepost @if(Auth::check()) @if( $likedpost === '1' ) likedHeart @endif @endif "
	        id="postlikesbtn{{ $post->id }}" data-content_id="{{ $post->id }}">
		<i class="fas fa-heart"></i>&nbsp;&nbsp;<span
				id="postlikes{{ $post->id }}">{{ $post->likecount }}</span>
	</button>
	<button class="transitionSlow commentpost" id="commentPost"
	        data-content_id="{{ $post->id }}"><i class="far fa-comment-alt"></i>&nbsp;&nbsp;{{ $post->entrycount }}
	</button>

	<div class="">
		<button type="button" class="interactive-bar-button border-none" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<b>+</b> <i class="fas fa-star"></i>
		</button>
		<div class="dropdown-menu dropdown-menu-lg-right px-3 pb-2">
			<h6 class="dropdown-header noSidePadding">{{ trans('home.badges') }}</h6>
			@foreach($badges as $badge)
				<button class="lexiconBadger mr-1 mb-1 lingerContent badginButton transitionSlow translation4-{{$badge->id}}"
				        data-toggle="tooltip" title="raplet" data-placement="bottom"
				        data-badge_type="1" data-badge_id="{{ $badge->id }}" data-content_type="4"
				        data-content_id="{{ $badge->id }}" data-post_id="{{ $post->id }}"
				        style="{{ $badge->badge_style }}">{!! $badge->class !!}</button>
			@endforeach
		</div>
	</div>
	@if($postEditedBy != null)
		<a style="float: right"
		   href="{{ route('profile', $postEditedBy) }}">
			<div class="wordHeaderEditerImage">
				<i class="fas fa-hammer"></i>
				<img class="roundimg"
				     src="{{url('storage/profile/'.$editor_avatar)}}"
				     alt="...">
				{{ "@".$postEditedBy }}
			</div>
		</a>
	@endif

</div>
