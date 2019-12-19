
@foreach($posts as $post)
    <div class="media text-muted pt-3">
        <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
        <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <div class="d-flex justify-content-between align-items-center w-100">
                <strong class="text-gray-dark sideCardHeaders">
                    <a href="{{ route('word', ['langname' => Config::get('app.locale'), 'slug' => $post->slug] )}}" id="postContent{{$post->id}}" @if($post->type == 1) title="{{ trans('home.avisualpost') }}" @endif>
                        @if($post->type == 1)
                            <i class="far fa-image"></i>&nbsp;&nbsp;
                        @endif
                        {{ substr($post->content,0,55) }}@if(strlen($post->content) > 55)...@endif
                    </a>
                </strong>
                <a class="">@if($post->entrycount > 9)9+@else{{ $post->entrycount }}@endif</a>
            </div>
            <span class="d-block"><a href="{{ route('profile',$post->userprofile->slug) }}">{{$post->userprofile->name }}</a></span>
        </div>
    </div>
@endforeach