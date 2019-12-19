<div class="dividingSketch"></div>
<span class="tinyText">{{ trans('home.anyhelpful') }}</span>

<button class="interactive-bar-button transitionSlow @if(Auth::check()) @if(in_array($comment->id, $voteUps)) on @endif @endif like" id="likedbtn{{ $comment->id }}" data-content_id="{{ $comment->id }}">
	{{ trans('home.yes') }}&nbsp;
	<span id="likecount{{ $comment->id }}">{{ $comment->likecount }}</span>
</button>

<button class="interactive-bar-button transitionSlow @if(Auth::check())  @if(in_array($comment->id, $voteDowns)) on @endif @endif dislike mr-0" id="dislikedbtn{{ $comment->id }}" data-content_id="{{ $comment->id }}">
	{{ trans('home.no') }}&nbsp;
	<span id="dislikecount{{ $comment->id }}">{{ $comment->dislikecount }}</span>
</button>

<div class="timeForRight row">
	<div class="d-inline dateTimeDefiner">{{$comment->created_at }}</div>
</div>
