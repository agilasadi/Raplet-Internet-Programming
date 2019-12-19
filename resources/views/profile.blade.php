@extends('layouts.app')

@section('style')
    <link href="{{ asset('mycss/profile.css') }}" rel="stylesheet">

@endsection
@section('pageHeaders')
    <title>{{ $user->name }}</title>
@endsection

@section('content')

    <div class="container">
        <div class="row">

            <div class="col-md-3 ">
                <div class="col-md-12 profile-card-outer noSidePadding">
                    @component('component.general.profile-card', ['profile' => $user, 'stat' => $user->userstat, 'badges' => $acuiredBadges])
                    @endcomponent
                </div>
            </div>

            <div class="col-md-6">
                @if(Auth::id() === $user->user_id)
                    @if(Auth::user()->userprofile->role_id == '1' || Auth::user()->userprofile->role_id == '2')
                        <div class="moderateAndBadgeBox col-md-12">
                            @if($user->role_id == '1')
                                Admin
                            @elseif($user->role_id == "2")
                                @if(Auth::user()->userprofile->role_id == "1")
                                    <button class="rapletBtn" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $user->role->name }}&nbsp;&nbsp;<i class="fas fa-caret-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach($ranks as $rank)
                                            <a class="dropdown-item aNewRoleAsign" data-role_id="{{$rank->id}}"
                                               data-user_id="{{ $user->user_id }}">{{$rank->name}}</a>
                                        @endforeach
                                    </div>
                                @else
                                    Moderator
                                @endif
                            @else
                                @if($user->user_id == Auth::id())
                                    <button class="rapletBtn">
                                        {{ $user->role->name }}
                                    </button>
                                @else
                                    <button class="rapletBtn" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $user->role->name }}&nbsp;&nbsp;<i class="fas fa-caret-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach($ranks as $rank)
                                            <a class="dropdown-item aNewRoleAsign" data-role_id="{{$rank->id}}"
                                               data-user_id="{{ $user->user_id }}">{{$rank->name}}</a>
                                        @endforeach
                                    </div>
                                @endif

                                <strong class="bumpedText">{{ trans('home.badges') }}&nbsp;</strong>
                                @foreach($badges as $badge)
                                    <button class="checkSomethingOut lexiconBadger transitionSlow">{!! $badge->class !!}</button>
                                @endforeach
                            @endif


                            @foreach($badges as $badge)
                                <button class="checkSomethingOut lexiconBadger transitionSlow">{!! $badge->class !!}</button>
                            @endforeach
                        </div>
                    @endif
                @endif



                @if($logs!=null)
                    <div id="logContainer">
                        @foreach($logs as $log)
                            @if($log->content_type === 1)
                                @if($log->log_type === 5 || $log->log_type === 7)


                                    @if($log->posts->is_featured != 0 && $log->posts->is_featured  != 4)
                                        @component('component.general.ppost', ["post" => $log->posts, "langs" => $langs])
                                        @endcomponent


                                    @elseif($log->posts->is_featured == 0 )
                                        @if(Auth::check())
                                            @if(Auth::user()->userprofile->role_id == '1' || Auth::user()->userprofile->role_id == '2')
                                                <div class="mb-3 unavailableContent badExtream">
                                                    <i class="powerDisabledStuff fas fa-ban"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.unavailableContent') }}
                                                    —
                                                    <a href="{{ route('profile',$log->posts->logposts->userprofile->slug) }}">{{ "@".$log->posts->logposts->userprofile->slug }}</a>
                                                    <span class="enablePost" data-post_id="{{ $log->posts->id }}"><i
                                                                class="fas fa-circle-notch"></i>&nbsp;&nbsp;{{ trans('home.activate') }}</span>
                                                </div>
                                            @elseif(Auth::user()->id == $log->posts->user_id)
                                                <div class="mb-3 unavailableContent badExtream">
                                                    <i class="fas powerDisabledStuff fa-power-off"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.unavailableContent') }}
                                                    —
                                                    <a href="{{ route('profile',$log->posts->logposts->userprofile->slug) }}">{{ "@".$log->posts->logposts->userprofile->slug }}</a>
                                                </div>
                                            @endif
                                        @endif
                                    @endif


                                @elseif($log->log_type === 2)
                                    <div class="extreamLog goodExtream mb-3"><i class="fas fa-check"></i>&nbsp;&nbsp;
                                        <a class="boldish"
                                           href="{{ route('word', ['slug' =>$log->posts->slug, '' => ''] )}}">
                                            {{ substr($log->posts->content,0,110) }}@if(strlen($log->posts->content) > 110)
                                                ...@endif
                                        </a>
                                        {{ trans('home.verifiedBy') }} — <a
                                                href="{{ route('profile', $log->posts->logposts->userprofile->slug) }}">{{$log->posts->logposts->userprofile->name}}</a>
                                    </div>

                                @elseif($log->log_type === 3)
                                    <div class="extreamLog badExtream mb-3"><i class="fas fa-copy"></i>&nbsp;&nbsp;
                                        <a class="boldish"
                                           href="{{ route('word', ['slug' =>$log->posts->slug, '' => ''] )}}">
                                            {{ substr($log->posts->content,0,110) }}@if(strlen($log->posts->content) > 110)
                                                ...@endif
                                        </a>
                                        {{ trans('home.duplicatedBy') }} — <a
                                                href="{{ route('profile', $log->posts->logposts->userprofile->slug) }}">{{$log->posts->logposts->userprofile->name}}</a>
                                    </div>
                                @endif

                            @elseif($log->content_type === 2) <!-- Comments -->
                            @if($log->comments->is_featured !== 0 && $log->comments->is_featured  !== 4)


                                <div class="commentEntirityBlock" id="theEntrieCommentInABox{{$log->comments->id}}">


                                    <div class="commentCardPostTitle">
                                        @if($log->comments->post->is_featured !== 4 && $log->comments->post->is_featured !== 0)
                                            <a href="{{ route('word', ['slug' => $log->comments->post->slug, '' => ''] )}}"
                                               id="postContent{{$log->comments->post->id}}">{{$log->comments->post->content }}</a>

                                        @else
                                            <div class="disabledCardContent">
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                   title="{{ trans('home.thisPostDeactivated')}}"
                                                   id="postContent{{$log->comments->post->id}}"><i
                                                            class="fas fa-power-off"></i>&nbsp;&nbsp;{{ trans('home.unavailableContent') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="entireCommentContentContainer profilepagecomments">
                                        <div class="commentContentStandAlone">
                                            <a href="{{ route('entry', $log->comments->slug) }}">
                                                <div class="commentContent"
                                                     id="commentContent{{ $log->comments->id }}">{!! nl2br(e($log->comments->content)) !!}</div>
                                            </a>
                                            @if($log!=null&&$log->comments!=null&&$log->comments->commentlinks!=null)
                                                {{ $items = json_decode($log->comments->commentlinks->links, true) }}
                                                @component('component.general.commentlinks', ['items' => $items])
                                                @endcomponent
                                            @endif
                                        </div>
                                    </div>
                                    <div class="commentInterract">
                                        <button class="interactive-bar-button @if(Auth::check()) @if(in_array($log->comments->id, $voteUps)) on @endif @endif like"
                                                id="likedbtn{{ $log->comments->id }}"
                                                data-content_id="{{ $log->comments->id }}"><i
                                                    class="fas fa-chevron-up"></i>&nbsp;&nbsp;<span
                                                    id="likecount{{ $log->comments->id }}">{{ $log->comments->likecount }}</span>
                                        </button>
                                        <button class="interactive-bar-button @if(Auth::check())  @if(in_array($log->comments->id, $voteDowns)) on @endif @endif dislike"
                                                id="dislikedbtn{{ $log->comments->id }}"
                                                data-content_id="{{ $log->comments->id }}"><i
                                                    class="fas fa-chevron-down"></i>&nbsp;&nbsp;<span
                                                    id="dislikecount{{ $log->comments->id }}">{{ $log->comments->dislikecount }}</span>
                                        </button>
                                        <a href="{{ route('profile', $log->comments->userprofile->slug) }}"><span><img
                                                        class="roundimg"
                                                        src="{{url('storage/profile/'. $log->comments->userprofile->userImg)}}"
                                                        alt="..." height="18px;"></span></a>
                                        <div class="float-right row">
                                            <div class="d-inline dateTimeDefiner"> {{ $log->comments->created_at }} </div>
                                            <div class="btn-group dropup d-inline">
                                                <button type="button" class="noBackgroundBtns dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"></button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(Auth::check())
                                                        <a class="dropdown-item reportAnything" data-type="2"
                                                           data-content_id="{{ $log->comments->id }}"><i
                                                                    class="far fa-flag"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.report') }}
                                                        </a>

                                                        @if(Auth::id() == $log->comments->user_id)
                                                            <a class="dropdown-item editComment"
                                                               data-content_id="{{ $log->comments->id }}"
                                                               data-post_id="{{ $log->comments->post_id }}"><i
                                                                        class="far fa-edit"></i>&nbsp;&nbsp;{{ trans('home.edit') }}
                                                            </a>
                                                            <a class="dropdown-item deleteComment"
                                                               data-content_id="{{ $log->comments->id }}"><i
                                                                        class="far fa-trash-alt"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.delete') }}
                                                            </a>
                                                        @endif
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
                            @endif
                            @endif
                        @endforeach
                    </div>

                @else
                    @if(Auth::check())
                        @if(Auth::id() == $user->user_id)
                            <p class="informingDevelopmentLine">{{ trans('home.whyNotConterbute') }}</p>
                        @else
                            <p class="informingDevelopmentLine">{{ trans('home.userHasNoData') }}</p>
                        @endif
                    @else
                        <p class="informingDevelopmentLine">{{ trans('home.userHasNoData') }}</p>
                    @endif
                @endif

                <smaall>
                    {{ $logs->fragment('profilelogs')->appends(['profilelogs' => $logs->currentPage()])->links() }}
                </smaall>
            </div>
            <div class="col-md-3">
                @include('includes.today')
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content bg-transparent">
                @component("component.post.commentInput",["comments"=>$comments,"post"=>$post,"pageName"=>"profile"])
                @endcomponent

            </div>
        </div>
    </div>


@endsection

@if(Auth::check())
    @if(Auth::user()->userprofile->role_id == '1' || Auth::user()->userprofile->role_id == '2')
@section('script')
    <script src="{{ asset('myjs/authed/word.js') }}" defer></script>
    <script src="{{ asset('myjs/authed/linker.js') }}" defer></script>
    <script>
        var lang = '{{$locale}}';
        var moderateUser = '{{ route('moderateUser') }}';
        var createComments = "{{ route('createComments') }}";
        var tolooklinksRoute = '{{ route('profile','') }}';

    </script>
    <script src="{{ asset('myjs/moderator/moderate.js') }}"></script>
@endsection
@endif
@endif

