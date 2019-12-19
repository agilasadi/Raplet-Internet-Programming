<div class="bg-white rounded noMarginTop sideHEadersBox" id="sideBox">
    <h6 class="border-gray pb-2 mb-0 sideSpaceHeader">{{ trans('home.recent') }} <small>@if($category != 'null'){{ trans('categories.'.$category->slug) }} @endif</small><button class="transitionSlow menuTogler noSidePadding SideMenuCloser float-right"><i class="fas fa-times"></i></button></h6>

    <div class="innerSideHeaders paginatingSidePostsField endless-pagination" data-next-page="@if($posts->nextPageUrl() != null ){{ url($posts->nextPageUrl()) }}@endif">
    @foreach($posts as $post)
    <div class="media position-relative pt-3">
        <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
        <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray boxesOfHeaders">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="text-gray-dark sideCardHeaders">
                    <a href="{{ route('word', ['langname' => Config::get('app.locale'), 'slug' => $post->slug] )}}" id="postContent{{$post->id}}" @if($post->type == 1) title="{{ trans('home.avisualpost') }}" @endif>
                        @if($post->type == 1)
                            <i class="far fa-image"></i>&nbsp;&nbsp;
                        @endif
                        <span class="sideHeaderContent">{{ substr($post->content,0,55) }}@if(strlen($post->content) > 55)...@endif</span>
                    </a>
                </div>
            </div>
            <span class="d-block"><a href="{{ route('profile',$post->userprofile->slug) }}">{{"@".$post->userprofile->slug }}</a></span>
        </div>
        <div class="counterConteiner">
        <a class="entryCountForToday">@if($post->entrycount > 9)9+@else{{ $post->entrycount }}@endif</a>
        </div>
    </div>
    @endforeach
    </div>

    <div class="paginatorButton transitionSlow">
        <a class="listAllThePostsBtn" href="{{ route('entireRaplet') }}"><i class="far fa-file-alt"></i></a>
        @if($posts->total() > 15)
        <button class="float-right getMoreResultsButton transitionSlow" id="moreSideLoaderAnchor">{{ trans('home.showmore') }}</button>
        @endif
    </div>

</div>