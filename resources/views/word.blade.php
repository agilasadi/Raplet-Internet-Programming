@extends('layouts.app')

@section('style')
    <link href="{{ asset('mycss/wordOnlyCss.css') }}" rel="stylesheet">
@endsection


@section('pageHeaders')
    <title>{{ $post->content }}</title>

    <meta property="og:url" content="{{ route('word', $post->slug) }}"/>
    <!-- <meta property="og:type"          content="website" /> -->
    <meta property="og:title" content="{{ $post->content }} "/>


    @if(count($post->comments) > 0)
        <meta property="og:description" content="Raplet"/>
    @endif

    @if($post->type == 1)
        <meta property="og:image" content="{{url('storage/posts/'.$post->postmedia->image)}}"/>
    @else
        <meta property="og:image" content="{{url('storage/logo/'.'raplet.png')}}"/>
    @endif
@endsection



@section('content')

    <div id="navbarish">
        <div class="navbarish">
            <div class="explanatoryWordNav">
                <div class="row">
                    <div class="col-md-12">
                        <div class="rightSideOfWordNav">
                            <div class="explanetporyTagline scrollMyContent" data-mycontent="bodyDefiner">
                                <div class="specialArrowUp">
                                    <div class="primerySpecialArrowUp"><i class="fas fa-long-arrow-alt-up"></i></div>
                                    <i class="fas fa-long-arrow-alt-up"></i></div>
                                @if($post->type == 1)
                                    <img class="" src="{{url('storage/posts/'.$post->postmedia->image)}}" height="30px"
                                         alt="raplet image">
                                @endif
                                <a>{{ $post->content }}</a>
                            </div>
                            @if(Auth::check())
                                <button class="explanetoryAddCommentBtn transitionSlow scrollMyContent"
                                        data-mycontent="commentContent" id="commentPost" data-toggle="collapse"
                                        data-target="#commentCollapsArea" data-content_id="{{ $post->id }}"><i
                                            class="far fa-comment-alt"></i>&nbsp;&nbsp;{{ $post->entrycount }}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">


            <div class="col-md-3">
                @include('includes.today')
            </div>

            <div class="col-md-9">
                <div class="wordoutherHeader">


                    <div class="wordHeader">
                        <div class="postInterractOptionsDown">
                            <div class="btn-group">
                                <button type="button" class="interractWithPostInWord" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <a> <i class="fas fa-ellipsis-h"></i></a>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @if(Auth::check())
                                        @if(Auth::id() == $post->user_id)
                                            <a href="{{ route('editingPostContnet', $post->id) }}"
                                               class="dropdown-item editPost" data-content_id="{{ $post->id }}"><i
                                                        class="far fa-edit"></i>&nbsp;&nbsp;{{ trans('home.edit') }}
                                            </a>
                                            <a class="dropdown-item delete_post" data-post_id="{{ $post->id }}"><i
                                                        class="fas fa-power-off"></i>&nbsp;&nbsp;{{ trans('home.passivate') }}
                                            </a>
                                        @elseif(Auth::user()->userprofile->role_id == 1 || Auth::user()->userprofile->role_id == 2)
                                            <a class="dropdown-item delete_post" data-post_id="{{ $post->id }}"><i
                                                        class="fas fa-power-off"></i>&nbsp;&nbsp;{{ trans('home.passivate') }}
                                            </a>
                                            <a href="{{ route('editingPostContnet', $post->id) }}"
                                               class="dropdown-item editPost" data-content_id="{{ $post->id }}"><i
                                                        class="far fa-edit"></i>&nbsp;&nbsp;{{ trans('home.edit') }}
                                            </a>
                                        @endif

                                        <a class="dropdown-item reportAnything" data-type="1"
                                           data-content_id="{{ $post->id }}"><i
                                                    class="far fa-flag"></i>&nbsp;&nbsp;{{ trans('home.report') }}
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="#">{{ trans('home.plzLogin') }}</a>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <a href="{{ route('profile', $post->userprofile->slug) }}">
                            <div class="wordHeaderOwnerImage">
                                <img class="roundimg" src="{{url('storage/profile/'. $post->userprofile->userImg)}}"
                                     alt="...">
                            </div>
                        </a>

                        <div class="listTitleLines">
                            <a href="{{ route('profile', $post->userprofile->slug) }}">
                                <span class="bolderHeading">{{ $post->userprofile->name }}</span>
                                <span class="slimUserSlug">{{ "@".$post->userprofile->slug }}</span>
                            </a>


                        </div>

                    @if($post->type == 0)
                        <!-- Regular -->            <!-- Regular -->            <!-- Regular -->
                            <div class="col-md-12 noSidePadding">
                                <div content="" class="headlines">{{ $post->content }}</div>
                                <div class="langsButtonDiv">
                                    <a href="{{ route('word', ['slug' => $post->slug, '' => ''] )}}">
                                        <button class="langsButtons transitionSlow">
                                            <i class="fas fa-globe-americas"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('word', ['slug' => $post->slug, 'langname' => Config::get('app.locale')] )}}">
                                        <button class="langsButtons transitionSlow">{{ trans('home.langname') }}</button>
                                    </a>
                                    <a href="{{ route('word', [ 'slug' => $post->slug, 'langname' => 'en'] ) }}">
                                        <button class="langsButtons transitionSlow">English</button>
                                    </a>


                                    <button class="langsButtons transitionSlow" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ trans('home.otherlanguages') }}&nbsp;&nbsp;<i class="fas fa-angle-down"></i>
                                    </button>

                                    <div class="dropdown-menu langs-dropdown" aria-labelledby="dropdownMenuButton">
                                        <h6 class="dropdown-header">
                                            <small>{{ trans('home.otherlanguages') }}</small>
                                        </h6>
                                        @foreach($langs as $lang)
                                            <a class="dropdown-item"
                                               href="{{ route('word', [ 'slug' => $post->slug, 'langname' => $lang->short_name] ) }}">{{ $lang->name }}</a>
                                        @endforeach
                                    </div>
                                    @component('component.post.badges', ['badges' => $post->badges])
                                    @endcomponent
                                </div>

                                @component('component.post.post_interact_bar', ['post' => $post, 'badges' => $badges, 'likedpost' => $likedpost, 'postEditedBy' => $postEditedBy->userprofile->slug, 'editor_avatar' =>  $postEditedBy->userprofile->userImg])
                                @endcomponent
                            </div>
                    @elseif($post->type == 1)
                        <!-- Image -->            <!-- Image -->            <!-- Image -->
                            <div class="col-md-12">
                                <div class="row visualContentViewCard ">

                                    <div class="col-md-6 visualContentViewField">
                                        <img class="wordPostCompleteImage"
                                             src="{{url('storage/posts/'.$post->postmedia->image)}}" alt="raplet image">
                                    </div>
                                    <div class="col-md-6 visualContentViewSideField box-shadow">
                                        <div content="" class="headlines">{{ $post->content }}</div>
                                        <div class="langsButtonDiv">
                                            <a href="{{ route('word', ['slug' => $post->slug, '' => ''] )}}">
                                                <button class="langsButtons transitionSlow"><i
                                                            class="fas fa-globe-americas"></i></button>
                                            </a>
                                            <a href="{{ route('word', ['slug' => $post->slug, 'langname' => Config::get('app.locale')] )}}">
                                                <button class="langsButtons transitionSlow">{{ trans('home.langname') }}</button>
                                            </a>
                                            <a href="{{ route('word', [ 'slug' => $post->slug, 'langname' => 'en'] ) }}">
                                                <button class="langsButtons transitionSlow">English</button>
                                            </a>


                                            <button class="langsButtons transitionSlow" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                {{ trans('home.otherlanguages') }}&nbsp;&nbsp;<i
                                                        class="fas fa-angle-down"></i>
                                            </button>

                                            <div class="dropdown-menu langs-dropdown"
                                                 aria-labelledby="dropdownMenuButton">
                                                <h6 class="dropdown-header">
                                                    <small>{{ trans('home.otherlanguages') }}</small>
                                                </h6>
                                                @foreach($langs as $lang)
                                                    <a class="dropdown-item"
                                                       href="{{ route('word', [ 'slug' => $post->slug, 'langname' => $lang->short_name] ) }}">{{ $lang->name }}</a>
                                                @endforeach
                                            </div>
                                            @component('component.post.badges', ['badges' => $post->badges])
                                            @endcomponent
                                        </div>

                                        @component('component.post.post_interact_bar', ['post' => $post, 'badges' => $badges, 'likedpost' => $likedpost, 'postEditedBy' => $postEditedBy->userprofile->slug, 'editor_avatar' =>  $postEditedBy->userprofile->userImg])
                                        @endcomponent


                                    </div>


                                </div>
                            </div>
                        @endif

                        @if($post->postLastState()->exists())
                            @if($post->postLastState->log_type == '2')
                                <div class="postExtraQuality">
                                    <div class="goodQuality">
                                        <i class="fas fa-check"></i>&nbsp;&nbsp;{{ trans('home.verifiedBy') }} — <a
                                                href="{{ route('profile', $post->postLastState->userprofile->slug) }}">{{$post->postLastState->userprofile->name}}</a>
                                    </div>
                                </div>
                            @elseif($post->postLastState->log_type == '3')
                                <div class="postExtraQuality">
                                    <div class="badQualities">
                                        <i class="fas fa-copy"></i>&nbsp;&nbsp;{{ trans('home.duplicatedBy') }} — <a
                                                href="{{ route('profile', $post->postLastState->userprofile->slug) }}">{{$post->postLastState->userprofile->name}}</a>
                                    </div>
                                </div>
                            @endif
                        @endif


                        @if(Auth::check())
                            @if(Auth::user()->userprofile->role_id == '1' || Auth::user()->userprofile->role_id == '2')
                                <div class="badgingList">
                                    @if($post->postLastState()->exists())
                                        @if($post->postLastState->log_type == '2')
                                            <button class="checkSomethingOut transitionSlow checkSomethingOutActive"
                                                    data-toggle="tooltip" title="{{ trans('home.confirmOriginal')}}"
                                                    data-placement="right" data-is_featured_type="2"
                                                    data-content_id="{{ $post->id }}"><i class="fas fa-check"></i>
                                            </button>
                                            <button class="checkSomethingOut transitionSlow regulatePostis_featured"
                                                    data-toggle="tooltip" title="{{ trans('home.signAsDuplicate')}}"
                                                    data-placement="right" data-is_featured_type="3"
                                                    data-content_id="{{ $post->id }}"><i class="fas fa-copy"></i>
                                            </button>
                                        @elseif($post->postLastState->log_type == '3')
                                            <button class="checkSomethingOut transitionSlow regulatePostis_featured"
                                                    data-toggle="tooltip" title="{{ trans('home.confirmOriginal')}}"
                                                    data-placement="right" data-is_featured_type="2"
                                                    data-content_id="{{ $post->id }}"><i class="fas fa-check"></i>
                                            </button>
                                            <button class="checkSomethingOut transitionSlow checkSomethingOutActive"
                                                    data-toggle="tooltip" title="{{ trans('home.signAsDuplicate')}}"
                                                    data-placement="right" data-is_featured_type="3"
                                                    data-content_id="{{ $post->id }}"><i class="fas fa-copy"></i>
                                            </button>
                                        @endif
                                    @else
                                        <button class="checkSomethingOut transitionSlow regulatePostis_featured"
                                                data-toggle="tooltip" title="{{ trans('home.confirmOriginal')}}"
                                                data-placement="right" data-is_featured_type="2"
                                                data-content_id="{{ $post->id }}"><i class="fas fa-check"></i></button>
                                        <button class="checkSomethingOut transitionSlow regulatePostis_featured"
                                                data-toggle="tooltip" title="{{ trans('home.signAsDuplicate')}}"
                                                data-placement="right" data-is_featured_type="3"
                                                data-content_id="{{ $post->id }}"><i class="fas fa-copy"></i></button>
                                    @endif
                                    <button class="checkSomethingOut transitionSlow regulatePostis_featured"
                                            data-toggle="tooltip" title="{{ trans('home.banContent')}}"
                                            data-placement="right" data-is_featured_type="0"
                                            data-content_id="{{ $post->id }}"><i class="fas fa-ban"></i></button>

                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Comments section -->
                <!-- Comments section -->
                <!-- Comments section -->
                @component("component.post.wordCommentInput",["comments"=>$comments,"post"=>$post,"pageName"=>"word"])
                @endcomponent




            <!-- Comments -->
                <!-- Comments -->
                <!-- Comments -->
                <div id="vuecomments" class="wordCommentsSection">
                    <div class="newCommentBeenAdded"></div>
                    @if(count($comments) > 0)

                        @foreach($comments as $comment)
                            <div class="outherCommentDiv @if($loop->first && $loop->last) firstAndTheOnlyElement @elseif($loop->first) firstElementInTheLoop @elseif($loop->last) lastElementInTheLoop @endif">
                                <div class="commentEntirityBlock" id="theEntrieCommentInABox{{$comment->id}}">
                                    <div class="comment-field-circle">
                                        <div>
                                            <a href="{{ route('profile', $comment->userprofile->slug) }}">
                                                <img class="roundimg"
                                                     src="{{url('storage/profile/'. $comment->userprofile->userImg)}}">
                                            </a>
                                        </div>
                                        <!-- <button class="noBackgroundBtns"><i class="fas fa-share-alt"></i></button> -->
                                    </div>

                                    <div class="entireCommentContentContainer">
                                        <div class="listTitleLines">
                                            <a href="{{ route('profile', $comment->userprofile->slug) }}">
                                                <span class="bolderHeading">{{ $comment->userprofile->name }}</span>
                                                <span class="slimUserSlug">{{ "@".$comment->userprofile->slug }}</span>
                                            </a>
                                        </div>
                                        <a href="{{ route('entry', $comment->slug) }}">
                                            <div class="commentContent"
                                                 id="commentContent{{ $comment->id }}">{!! nl2br(e($comment->content)) !!}</div>
                                        </a>
                                        @if(count($comment->commentlinks) > 0)
                                            {{ $items = json_decode($comment->commentlinks->links, true) }}
                                            @component('component.general.commentlinks', ['items' => $items])
                                            @endcomponent
                                        @endif
                                    </div>
                                    <div class="commentInterract position-relative">
                                        @component('component.general.commentvote', ['comment' => $comment, 'voteUps' => $voteUps, 'voteDowns' => $voteDowns])
                                        @endcomponent
                                    </div>

                                    <div class="interractWithComment">
                                    <!--
                        <button class="noBackgroundBtns fb-share-button"><a><i class="fab fa-facebook-f" data-href="{{ route('entry', $comment->slug) }}"></i></a></button>
                        <button class="noBackgroundBtns"><a><i class="fab fa-twitter"></i></a></button>
                        -->
                                        <div class="btn-group d-inline">
                                            <button type="button" class="interractWithPostInWord" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"><i
                                                        class="fas fa-ellipsis-h"></i></button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(Auth::check())
                                                    <a class="dropdown-item reportAnything" data-type="2"
                                                       data-content_id="{{ $comment->id }}"><i class="far fa-flag"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.report') }}
                                                    </a>

                                                    @if(Auth::id() == $comment->user_id || Auth::user()->userprofile->role_id == 1 || Auth::user()->userprofile->role_id == 2)
                                                        <a class="dropdown-item editComment"
                                                           data-content_id="{{ $comment->id }}"><i
                                                                    class="far fa-edit"></i>&nbsp;&nbsp;{{ trans('home.edit') }}
                                                        </a>
                                                        <a class="dropdown-item deleteComment"
                                                           data-content_id="{{ $comment->id }}"><i
                                                                    class="far fa-trash-alt"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.delete') }}
                                                        </a>
                                                    @endif
                                                @else
                                                    <a class="dropdown-item" href="#">{{ trans('home.plzLogin') }}</a>
                                                @endif
                                                <a class="dropdown-item disabled" href="#">{{ trans('home.share') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @else
                        <p class="informingDevelopmentLine">{{ trans('home.whyNotCommentFirst') }}</p>
                    @endif
                </div>
                <small class="paginationButtons">

                    {{ $comments->fragment('wordcommentd')->links() }}
                </small>

            </div>

        </div>
    </div>

    <div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <textarea class="modelTextarea" id="commentToEdit"></textarea>
                </div>
                <div class="abslouteTextareaButtons">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('home.close') }}</button>
                    <button type="button" class="btn btn-primary updateTheComment">{{ trans('home.save') }}</button>
                </div>
                <input type="hidden" id="commentToEditID" value="" name="content_id">

            </div>
        </div>
    </div>

    <script src="{{ asset('myjs/scrollerspy.js') }}"></script>


    <script>

        $(document).ready(function () {
            $('.wordPostCompleteImage').previewModal();
        });

    </script>


@endsection

@if(Auth::check())
@section('script')
    <script>
        var lang = '{{$locale}}';

        var tolooklinksRoute = '{{ route('word','') }}';
        var likePost = "{{ route('likePost') }}";
        var createComments = "{{ route('createComments') }}";
        var addHeaderAsLinking = "{{ route('addHeaderAsLinking') }}";
        var badgeContent = '{{ route('badgeContent') }}';

        var reporterTrans = "{{ trans('home.report') }}";
        var editerTrans = "{{ trans('home.edit') }}";
        var deleterTrans = "{{ trans('home.delete') }}";
        var shareTrans = "{{ trans('home.share') }}";

    </script>
    <script src="{{ asset('myjs/authed/word.js') }}" defer></script>
    <script src="{{ asset('myjs/authed/linker.js') }}" defer></script>
    <script src="{{ asset('myjs/authed/badger.js') }}"></script>


    @if(Auth::user()->userprofile->role_id == '2' || Auth::user()->userprofile->role_id == '1')
        <script>
            var edit_post_is_featured = '{{ route('edit_post_is_featured') }}';
            var verify_duplicate_ban = '{{ route('verify_duplicate_ban') }}';
        </script>
        <script src="{{ asset('myjs/moderator/moderate.js') }}"></script>
    @endif
@endsection

@endif
