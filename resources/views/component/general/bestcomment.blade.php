<div class="bestCommentOuterDiv">
	<div class="postCommentOwnerAvatar">
		<a href="{{ route('profile', $comment->userprofile->slug) }}"><span><img
						class="roundimg"
						src="{{url('storage/profile/'. $comment->userprofile->userImg)}}"
						alt="..." height="28px;"></span></a>
	</div>
	<a href="{{ route('entry', $comment->slug) }}">
		<div class="transitionSlow commentContent"
		     id="commentContent{{ $comment->id }}">{!! nl2br(e($comment->content)) !!}</div>
	</a>
	@if(count($comment->commentlinks) > 0)
        {{ $items = json_decode($comment->commentlinks->links, true) }}
        @component('component.general.commentlinks', ['items' => $items])          
        @endcomponent
    @endif
	<div class="bestCommentInterract">
		@component('component.general.commentvote', ['comment' => $comment,  'voteUps' => null, 'voteDowns' => null])
		@endcomponent
	</div>
</div>