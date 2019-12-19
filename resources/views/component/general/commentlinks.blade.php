<div class="linkInsideCommentBox">
	@foreach ($items as $item)

	@if($item['type'] == "l")
	<li class="linklinks linkchains">
		<a href="{{ $item['url'] }}">
			<i class="fas fa-link"></i>&nbsp;&nbsp;
			{{ $item['text'] }}
		</a>
	</li>
	@elseif($item['type'] == "v")
	<li class="videolinks linkchains">
		<a href="{{ $item['url'] }}">
			<i class="fas fa-play"></i>&nbsp;&nbsp;
			{{ $item['text'] }}
		</a>
	</li>
	@elseif($item['type'] == "t")
	<li class="tolooklinks linkchains">
		<a href="{{ $item['url'] }}">
			<i class="fas fa-hashtag"></i>&nbsp;&nbsp;
			{{ $item['text'] }}
		</a>
	</li>
	@endif 

	@endforeach
</div>