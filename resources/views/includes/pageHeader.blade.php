<div class="primeryNav">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container" style="position: relative">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="brandImage" src=" {{url('storage/logo/'.'raplet.png')}}" height="24px;" alt="raplet"
                     style="height: 39px;">
            </a>
            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
                <a class="separateNavName navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <span class="earlyVersion">beta-1</span>
            </div>


            <button class="mr-3 menuTogler menuMobileSide" type="button">
                &nbsp;<i class="fas fa-align-right"></i>&nbsp;
                {{ trans('home.recent') }}&nbsp;
            </button>
            <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
                <img class="" src="{{url('storage/icons/'.'menubars.svg')}}" alt="raplet">
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">


                <form class="form-inline searchBox" id="navbarSearchForm">

                    <input class="form-control transitionSlow searchingInputField mr-sm-2"
                           style="margin-right: 0!important;"
                           id="search" value="" type="search" autocomplete="off"
                           placeholder="{{ trans('home.search') }}">
                    <div id="searcheAutocompleteDiv" class="searcheAutocompleteDiv transitionSlow">
                        <div class="searchDropdownHeader">

                            <div class="float-right searchConnectionIcon" id="searchConnectionIcon">
                                <img class="" src="{{url('storage/icons/'.'Radio-1s-200px.svg')}}" alt="raplet">
                            </div>

                            <small class="searchBoxTittle"><i
                                    class="fas fa-search"></i>&nbsp;&nbsp;{{ trans('home.searchresults') }}
                                &nbsp;&nbsp;&nbsp;<i class="fas fa-long-arrow-alt-right"></i>&nbsp;&nbsp;<span
                                    id="searchingword" class="searchingword"></span>&nbsp;&nbsp;<span
                                    id="searchResultAutocompleteCount"
                                    class="searchingword"> ? </span> {{ trans('home.result') }}</small>
                        </div>

                        <div class="searchEntireAutocompleteResult">
                            <div class="searchNavPostResults"></div>
                            <div class="searchNavCommentResults"></div>
                            <div class="searchNavUserResults"></div>
                        </div>
                        <div class="footerRapletBranding">
                            <img src=" {{url('storage/logo/'.'raplet-solid.png')}}" alt="raplet"
                                 style="height: 25px; margin-top: -27px; margin-bottom: -23px; margin-right: 6px;">{{ trans('home.rapletSearchBeta') }}
                        </div>
                    </div>
                    <button type="button" disabled onclick="hardSearch()" id="searchSubmitButton"
                            class="transitionSlow searchSubmitButton"><i class="fas fa-search"></i></button>
                    <button type="button" id="btnAutocompleteClose"
                            class="transitionSlow searchSubmitButton"><i class="fas fa-times"></i></button>
                </form>


                <ul class="navbar-nav ml-auto dropdownWordBreake">


                    @if(Auth::check())
                        @if(Auth::guard('web')->check())

                            <li class="nav-item">
                                <a class="nav-link navJustIconLink iconedNavElement" data-target="">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown">

                                @if(Auth::user()->userprofile->notification_count != 0)
                                    <a class="nav-link notificationBell active-notification iconedNavElement"
                                       id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <i class="fas fa-bell">
                                            <button class="badge badge-primary"></button>
                                        </i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right notificationsDropdown"
                                         aria-labelledby="dropdown01">
                                        <h6 class="dropdown-header pl-3">
                                            {{ trans('home.rapletnotify') }}
                                            <div class="notification-loader position-absolute" id="notification-loader">
                                                <img src="{{url('storage/icons/'.'Radio-1s-200px.svg')}}" alt="raplet">
                                            </div>
                                        </h6>
                                        <div class="notificationContainer">
                                        </div>
                                        <a class="btn btn-outline-info btn-sm mt-2 ml-3" href="#" role="button">{{ trans('home.seeall') }}</a>
                                    </div>
                                @else
                                    <a class="nav-link notificationBell navJustIconLink disable-bell navJustIconLink disable-bell iconedNavElement"
                                       id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <i class="fas fa-bell">
                                            <button class="badge badge-primary"></button>
                                        </i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right notificationsDropdown"
                                         aria-labelledby="dropdown01">
                                        <h6 class="dropdown-header pl-3">
                                            {{ trans('home.rapletnotify') }}
                                            <div class="notification-loader position-absolute d-none"
                                                 id="notification-loader">
                                                <img src="{{url('storage/icons/'.'Radio-1s-200px.svg')}}" alt="raplet">
                                            </div>
                                        </h6>
                                        <div class="notificationContainer">
                                            <a class="dropdown-item text-black-50 pl-3">
                                                {{ trans('jsshared/title.nonotificationsyet') }}
                                            </a>
                                        </div>
                                        <a class="btn btn-outline-info btn-sm mt-2 ml-3" href="#" role="button">{{ trans('home.seeall') }}</a>
                                    </div>
                                @endif

                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link " href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(Auth::guard('web')->check())
                                        <img class="roundimg userProfileImage transitionSlow"
                                             src="{{url('storage/profile/'. Auth::user()->userprofile->userImg)}}"
                                             alt="...">
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right profileDropdownOnNav"
                                     aria-labelledby="navbarDropdown">
                                    @if(Auth::guard('web')->check())
                                        <a class="dropdown-item"
                                           href="{{ route('profile', Auth::user()->userprofile->slug) }}">
                                            <i class="fas fa-user-circle similarSizeBtn"></i>
                                            {{ trans('home.profile') }}
                                        </a>
                                    @endif
                                    <a href="{{ route('recicle_posts') }}" class="dropdown-item">
                                        <i class="fas fa-recycle similarSizeBtn"></i>
                                        {{ trans('home.recicle') }}
                                    </a>
                                    <a href="{{ route('editprofile') }}" class="dropdown-item">
                                        <i class="far fa-edit similarSizeBtn"></i>
                                        {{ trans('home.editprofile') }}
                                    </a>


                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt similarSizeBtn"></i>
                                        {{ trans('home.logout') }}
                                    </a>
                                    <a class="dropdown-item">
                                        {{ trans('home.NightMode') }}
                                        <span class="nightModeSpan">
                                               @if(isset($_COOKIE['nightMode']))
                                                @if($_COOKIE['nightMode']=="on")
                                                    <div class="toggle3 toggle3-on" id="toggle3" onclick="toggle3();">
                                                      <div class="circle3 circle3-on" id="circle3"></div>
                                                   </div>
                                                @else

                                                    <div class="toggle3" id="toggle3" onclick="toggle3();">
                                                       <div class="circle3" id="circle3"></div>
                                                   </div>
                                                @endif
                                            @else
                                                <div class="toggle3" id="toggle3" onclick="toggle3();">
                                                       <div class="circle3" id="circle3"></div>
                                                   </div>
                                            @endif

                                           </span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @else
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal"
                               data-target="#loginModel">{{ trans('home.signin') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal"
                               data-target="#registerModal">{{ trans('home.signup') }}</a>
                        </li>
                    @endif


                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="nav-scroller secondaryNav box-shadow">
    <div class="container">
        <div class="navbarBackground">
            <button type="button" id="secondaryNavbarRightScroll"
                    class="transitionSlow btnSecondaryNavbarScroll"><i class="fas fa-angle-right"></i></button>

            <button type="button" id="secondaryNavbarLeftScroll"
                    class="transitionSlow btnSecondaryNavbarScroll"><i class="fas fa-angle-left"></i></button>
        </div>


        <nav class="nav nav-underline sencondaryNavInner">
            <a class="nav-link acategory @if($category === 'null') active @endif"
               data-content_id="0"> {{ trans('home.general') }}</a>
            @foreach($cats as $cat)
                <a class="nav-link acategory @if($category != 'null')@if($category->id === $cat->id) active @endif @endif"
                   data-content_id="{{ $cat->id }}">{{$cat->name}}</a>
            @endforeach
        </nav>

    </div>
</div>

