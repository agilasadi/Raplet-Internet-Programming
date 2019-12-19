@extends('layouts.app')

@section('style')
    <link href="{{ asset('mycss/searchpage.css') }}" rel="stylesheet">
@endsection

@section('pageHeaders')
    <title>{{ trans('home.rapletSearch') }} {{ $searched }}</title>
@endsection

@section('content')


    <div class="container">
        <div class="row">

            <div class="col-md-3 ">
                @include('includes.today')
            </div>

            <div class="col-md-9">
                <ul class="nav justify-content-end navPills tabs" id="myTab" role="tablist">
                    <li class="nav-item selectingSearchTab">
                        <a class=" nav-link" id="home-tab" data-toggle="tab" href="#users" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-users"></i>&nbsp;&nbsp;{{ trans('home.users') }}&nbsp;</a>
                    </li>
                    <li class="nav-item selectingSearchTab">
                        <a class=" nav-link " id="contact-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="contact" aria-selected="false"><i class="far fa-comment-alt"></i>&nbsp;&nbsp;{{ trans('home.entries') }}&nbsp;</a>
                    </li>
                    <li class="nav-item selectingSearchTab">
                        <a class=" nav-link active" id="profile-tab" data-toggle="tab" href="#headers" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-language"></i>&nbsp;&nbsp;{{ trans('home.headers') }}&nbsp;</a>
                    </li>
                </ul>

                <div class="tab-content my-3 shadow-sm rounded bg-white " id="myTabContent">

                    <div class="searchDropdownHeader">
                        <small class="searchBoxTittle"><i class="fas fa-search"></i>&nbsp;&nbsp;{{ trans('home.searchresults') }}&nbsp;&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>&nbsp;&nbsp;<span id="searchingword" class="searchingword">{{ $searched }}</span>&nbsp;&nbsp;<span id="searchResultAutocompleteCount" class="searchingword"> {{ $count }} </span> {{ trans('home.result') }}</small>
                    </div>
                    <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="home-tab">

                        <div class="p-3">
                                <h6 class="border-bottom border-gray pb-2 mb-0">
                                    <i class="fas fa-users"></i>&nbsp;&nbsp;{{ trans('home.users') }}<small class="informingDevelopmentLine"> {{ $users->total()}}&nbsp;{{ trans('home.total') }}</small>
                                </h6>
                            </a>
                            @foreach($users as $user)
                                <a href="{{ route('profile', $user->slug) }}">
                                <div class="media text-muted pt-3">
                                    <img src="{{url('storage/profile/'.$user->userImg)}}" alt="" width="32px" class="mr-2 rounded">
                                    <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <h6 class="text-gray-dark">{{ $user->name }}<small> •&nbsp;{{ $user->reputation }}</small></h6>
                                            <a href="#">{{ $user->reputation }}</a>
                                        </div>
                                        <span class="d-block">@ {{ $user->slug }}</span>
                                    </div>
                                </div>
                                </a>
                            @endforeach
                            <small class="d-block text-right mt-3">
                            {{ $users->fragment('users')->appends(['p1' => $posts->currentPage(), 'p2' => $comments->currentPage(), 'p3' => $users->currentPage()])->links() }}
                            </small>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="p-3">
                            <h6 class="border-bottom border-gray pb-2 mb-0"><i class="far fa-comment-alt"></i>&nbsp;&nbsp;{{ trans('home.entries') }}<small class="informingDevelopmentLine"> {{ $comments->total()}}&nbsp;{{ trans('home.total') }}</small></h6>
                        @foreach($comments as $comment)
                            <div class="media text-muted pt-3">
                                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <span class="d-block">
                                            <a href="{{ route('word', ['slug' => $comment->post->slug, '' => ''] )}}">
                                                {{ substr($comment->post->content,0,110) }}@if(strlen($comment->post->content) > 110)...@endif
                                               </a></span>
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <a href="{{ route('entry', $comment->slug) }}">
                                          <strong class="text-gray-dark commentContent">{!! nl2br(e($comment->content)) !!}</strong>
                                        </a>
                                        <a href="#">{{ $comment->likecount }}</a>
                                    </div>
                                    <span class="d-block"><a href="{{ route('profile', $comment->userprofile->slug) }}">@ {{ $comment->userprofile->name }}</a></span>
                                </div>
                            </div>
                        @endforeach
                            <small class="d-block text-right mt-3">
                                {{ $comments->fragment('comments')->appends(['p1' => $posts->currentPage(), 'p2' => $comments->currentPage(), 'p3' => $users->currentPage()])->links() }}
                            </small>
                        </div>
                    </div>

                    <div class="tab-pane fade show active" id="headers" role="tabpanel" aria-labelledby="profile-tab">

                        <div class="p-3">
                            <h6 class="border-bottom border-gray pb-2 mb-0"><i class="fas fa-language"></i>&nbsp;&nbsp;{{ trans('home.headers') }}<small class="informingDevelopmentLine"> {{ $posts->total()}}&nbsp;{{ trans('home.total') }}</small></h6>
                            @foreach($posts as $post)
                                <div class="media text-muted pt-3">
                                    @if($post->type == 1)
                                        <div class="searchedPostImages">
                                        <img src="{{url('storage/posts/'.$post->postmedia->image)}}" alt="" width="32px" class="mr-2 rounded">
                                        </div>
                                    @endif
                                    <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <strong class="text-gray-dark"><a href="{{ route('word', ['slug' => $post->slug, '' => ''] )}}">{{ substr($post->content,0,80) }}@if(strlen($post->content) > 80)...@endif </a></strong></strong>
                                            <a><i class="far fa-heart"></i>&nbsp;&nbsp;{{ $post->likecount }}</a>
                                        </div>
                                        <span class="d-block"><a href="{{ route('profile', $post->userprofile->slug) }}">@ {{ $post->userprofile->name }}</a></span>

                                        @if($post->entrycount > 0)
                                            <div class="bestCommentOuterDiv">
                                                <a href="{{ route('entry', $post->bestCommentGlobal->slug) }}"><div class="commentContent transitionSlow" id="commentContent{{ $post->bestCommentGlobal->id }}">{{ $post->bestCommentGlobal->userprofile->name }} - '  {{ substr($post->bestCommentGlobal->content,0,110) }}@if(strlen($post->bestCommentGlobal->content) > 110)...@endif '</div></a>

                                                @if(count($post->bestCommentGlobal->commentlinks) > 0)
                                                    <div class="linkInsideCommentBox">{!! $post->bestCommentGlobal->commentlinks->links !!}</div>
                                                @endif
                                            </div>
                                        @else
                                            <span style="color: #bc7683">
                                                {{ trans('home.whyNotCommentFirst') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <small class="d-block text-right mt-3">
                            {{ $posts->fragment('posts')->appends(['p1' => $posts->currentPage(), 'p2' => $comments->currentPage(), 'p3' => $users->currentPage()])->links() }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="informingDevelopmentLine" style="padding-bottom: 15px; "><img class="" src=" {{url('storage/logo/'.'raplet-solid.png')}}" alt="raplet" style="height: 25px; margin-top: -27px; margin-bottom: -23px; margin-right: 6px;">{{ trans('home.rapletSearchBeta') }}</div>

            </div>
        </div>
    </div>
@endsection
