@extends('layouts.app')

@section('style')
    <link href="{{ asset('mycss/entireRaplet.css') }}" rel="stylesheet">
@endsection
@section('pageHeaders')
    <title>{{ trans('home.entireRapletPosts') }} </title>
@endsection

@section('content')




    <div class="container">

        <div class="footerRapletBranding"> <img class="" src=" {{url('storage/logo/'.'raplet-solid.png')}}" alt="raplet" style="height: 25px; margin-top: -27px; margin-bottom: -23px; margin-right: 6px;">{{ trans('home.rapletSearchBeta') }}</div>


        <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="entirePostsContainer">
                <div class="entirePostsHeaders col-md-12">
                    <a>{{ trans('home.entireRapletPosts') }}</a>

                <button disabled class="filtertogleButton r-pull-right transitionSlow" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                    <i class="fas fa-filter"></i>&nbsp;&nbsp;{{ trans('home.filterResults') }}
                </button>

                </div>

                <div class="col-md-12 filtersContnet">
                    <div class="collapse collapseFilters" id="collapseFilters">

                        <div class="filterSelection">
                            <button class="rapletBtn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-indent"></i>&nbsp;&nbsp;{{ trans('home.categories') }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach($categories as $category)
                                <a class="dropdown-item" href="#">{{ trans('categories.'.$category->slug) }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="filterSelection">
                            <button class="rapletBtn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-image"></i>&nbsp;&nbsp;—&nbsp;&nbsp;<i class="fas fa-font"></i>&nbsp;&nbsp;{{ trans('home.posttype') }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#"><i class="far fa-image"></i>&nbsp;&nbsp;{{ trans('home.visuals') }}</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-font"></i>&nbsp;&nbsp;&nbsp;{{ trans('home.written') }}</a>
                                <a class="dropdown-item" href="#">{{ trans('home.abbreviation') }}</a>
                            </div>
                        </div>
                        <div class="filterSelection float-right">
                            <button class="rapletBtn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-sort-amount-down"></i>&nbsp;&nbsp;{{ trans('home.orderby') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp;{{ trans('home.orderByDateDesc') }}</a>
                                <a class="dropdown-item" href="#"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp;{{ trans('home.orderByDateAsc') }}</a>
                                <a class="dropdown-item" href="#"><i class="far fa-heart"></i>&nbsp;&nbsp;{{ trans('home.orderByLikecount') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 noSidePadding">
                @foreach($posts as $post)
                    <a href="{{ route('word', ['langname' => Config::get('app.locale'), 'slug' => $post->slug] )}}" style="display: block">
                    <div>
                        <div class="card transitionSlow">
                            <div class="card-body">
                                @if($post->type == 1)
                                   <div class="entireRapletCardPostImage">
                                       <img class="" src="{{url('storage/posts/'.$post->postmedia->image)}}" alt="raplet image">
                                   </div>
                                @endif
                                <div class="entireRapletCardPostText">
                                   <h5 class="card-title">{{ $post->content }}</h5>
                                    <a class="postCardUsername" href="{{ route('profile', $post->userprofile->slug) }}">{{ '@'.$post->userprofile->slug }}</a>
                                    <span class="chatButton"><i class="far fa-comment-alt"></i>&nbsp;&nbsp;{{ $post->entrycount }}</span>
                                    <span class="likeButton"><i class="fas fa-heart"></i>&nbsp;&nbsp;{{ $post->likecount }}</span>
                                </div>
                                    <span class="dateStickingTopRight dateButton"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp;{{ $post->created_at }}</span>
                            </div>
                        </div>
                    </div>
                    </a>
                @endforeach
                </div>
                <div class="col-md-12 paginatorHolderDiv">
                {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

