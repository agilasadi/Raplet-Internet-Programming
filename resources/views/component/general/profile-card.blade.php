<div class="profile-card box-shadow">
	<div class="text-center">
		<div class="profile-card-image py-4">
			<img class="roundimg" src="{{url('storage/profile/'.$profile->userImg)}}" alt="{{ $profile->name }}">
		</div>
		<div class="profile-card-name profile-card-slug">
			<h3 class="margin-bottom-none">{{$profile->name}}</h3>
			<span>{{"@".$profile->slug}}</span>
		</div>

		@if($profile->bio !== "0")
		<div class="user-card-bio">
			<p class="margin-bottom-none">
				{{ $profile->bio }}
			</p>
		</div>
		@endif

		<div class="profile-card-reputation">
			<h3 class="margin-bottom-none py-3">{{ $profile->reputation }}</h3>
		</div>
		@if($badges != null && $badges->count() > 0)
		<div class="profile-card-badges px-2 pt-2 pb-3">
			@foreach($badges as $badge)
				<button class="profile-card-badge" data-toggle="tooltip" title="x{{$badge->count}}" data-placement="left" id="granted{{$badge->badges->id}}">
					{!! $badge->badges->class !!}
				</button>
			@endforeach
		</div>
		@endif

		<div class="profile-card-stats col-md-12 noSidePadding row">
			<div class="profile-card-stat col-3 noSidePadding">
				<span class="card-stat-title">{{ trans('home.header') }}</span>
				<h6 class="card-stat-amount margin-bottom-none bolder">{{ $stat->headercount }}</h6>
			</div>
			<div class="profile-card-stat col-3 noSidePadding">
				<span class="card-stat-title">{{ trans('home.comment') }}</span>
				<h6 class="card-stat-amount margin-bottom-none bolder">{{ $stat->entrycount }}</h6>
			</div>
			<div class="profile-card-stat col-3 noSidePadding">
				<span class="card-stat-title">{{ trans('home.liked') }}</span>
				<h6 class="card-stat-amount margin-bottom-none bolder">{{ $stat->likecount }}</h6>
			</div>
			<div class="profile-card-stat col-3 noSidePadding">
				<span class="card-stat-title">{{ trans('home.liking') }}</span>
				<h6 class="card-stat-amount margin-bottom-none bolder">{{ $stat->likercount }}</h6>
			</div>
		</div>
	</div>
</div>