@if(count($badges) > 0)
	<div class="postBadges">
		@foreach($badges as $badge)
			<button class="postBadged lingerContent translation4-{{$badge->id}}"
			        data-content_type="4" data-content_id="{{ $badge->id }}"
			        data-toggle="tooltip" title="raplet" data-placement="bottom"
			        id="granted{{$badge->id}}">{!! $badge->class !!}</button>
		@endforeach
	</div>
@endif