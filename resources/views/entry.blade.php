@extends('layouts.app')

@section('pageHeaders')
<title>{!! nl2br(e($comment->content)) !!}</title>

<meta property="og:url"           content="{{ route('entry', $comment->slug) }}" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="{{$comment->post->content }}" />
<meta property="og:description"   content="{!! nl2br(e($comment->content)) !!}" />
<meta property="og:image"         content="{{url('storage/logo/'.'raplet.png')}}" />
<meta property="fb:app_id"        content="252046678971687">
@endsection

@section('content')
    <div class="container">
        <div class="row">


        <div class="col-md-3 ">
                @include('includes.today')
            </div>

    <div class="col-md-9">

        <div class="commentEntirityBlock" id="theEntrieCommentInABox{{$comment->id}}">


            <div class="commentCardPostTitle">
                @if($comment->post->is_featured !== 4 && $comment->post->is_featured !== 0)
                    @if($comment->post->type == 1)
                    <a href="{{ route('word', ['slug' => $comment->post->slug, '' => ''] )}}" title="{{ trans('home.avisualpost') }}" id="postContent{{$comment->post->id}}">
                        <i class="far fa-image"></i>
                    @else
                    <a href="{{ route('word', ['slug' => $comment->post->slug, '' => ''] )}}" id="postContent{{$comment->post->id}}">
                    @endif
                        {{$comment->post->content }}
                    </a>
                @else
                    <div class="disabledCardContent">
                        <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('home.thisPostDeactivated')}}" id="postContent{{$comment->post->id}}">## {{ trans('home.unAccesableContent') }} ##</a>
                    </div>
                @endif
            </div>

            <div class="entireCommentContentContainer profilepagecomments">
                <div class="commentContentStandAlone">
                <div class="commentContent" id="commentContent{{ $comment->id }}">{!! nl2br(e($comment->content)) !!}</div>
                @if(count($comment->commentlinks) > 0)
                    {{ $items = json_decode($comment->commentlinks->links, true) }} 
                    @component('component.general.commentlinks', ['items' => $items])
                    @endcomponent
                @endif
                </div>
            </div>
            <div class="commentInterract">
                <button class="interactive-bar-button @if(Auth::check()) @if(in_array($comment->id, $voteUps)) on @endif @endif like" id="likedbtn{{ $comment->id }}" data-content_id="{{ $comment->id }}"><i class="fas fa-chevron-up"></i>&nbsp;&nbsp;<span id="likecount{{ $comment->id }}">{{ $comment->likecount }}</span></button>
                <button class="interactive-bar-button @if(Auth::check())  @if(in_array($comment->id, $voteDowns)) on @endif @endif dislike" id="dislikedbtn{{ $comment->id }}" data-content_id="{{ $comment->id }}"><i class="fas fa-chevron-down"></i>&nbsp;&nbsp;<span id="dislikecount{{ $comment->id }}">{{ $comment->dislikecount }}</span></button>
                <a href="{{ route('profile', $comment->userprofile->slug) }}"><span><img class="roundimg" src="{{url('storage/profile/'. $comment->userprofile->userImg)}}" alt="..." height="18px;"></span></a>
                <div class="float-right row">
                    <div class="d-inline dateTimeDefiner"> {{ $comment->created_at }} </div>
                    <div class="btn-group dropup d-inline">
                        <button type="button" class="noBackgroundBtns dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @if(Auth::check())
                                <a class="dropdown-item reportAnything" data-type="2" data-content_id="{{ $comment->id }}"><i class="far fa-flag"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.report') }}</a>

                                @if(Auth::id() == $comment->user_id)
                                    <a class="dropdown-item editComment" data-content_id="{{ $comment->id }}"><i class="far fa-edit"></i>&nbsp;&nbsp;{{ trans('home.edit') }}</a>
                                    <a class="dropdown-item deleteComment" data-content_id="{{ $comment->id }}"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.delete') }}</a>
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

        <div class="informingDevelopmentLine"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;{{ trans('home.underconstruction') }}</div>
    </div>

    </div>
    </div>

    <div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <textarea class="modelTextarea" id="commentToEdit"></textarea>
                </div>
                <div class="abslouteTextareaButtons">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('home.close') }}</button>
                    <button type="button" class="btn btn-primary updateTheComment">{{ trans('home.save') }}</button>
                </div>
                <input type="hidden" id="commentToEditID" value="" name="content_id">

            </div>
        </div>
    </div>




@endsection
@section('script')
    <script>
            var likePost = "{{ Route('likePost') }}";
    </script>
@endsection
