<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="{{url('storage/logo/'.'raplet.png')}}"/>


	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">


	<!-- Scripts -->
	<script src="{{ asset('myjs/jquery-3.3.1.min.js') }}"></script>
<!-- <script src="{{ asset('js/app.js') }}" ></script> -->


	<!-- Fonts -->
	<link rel="dns-prefetch" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

	<!-- Styles -->
<!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet">  -->
	<link href="{{ asset('mycss/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('mycss/searchautocomplete.css') }}" rel="stylesheet">
	<link href="{{ asset('mycss/floatingLabel.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('mycss/all.min.css') }}" rel="stylesheet"> -->


	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css"
	      integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
	<link href="{{ asset('mycss/plugin/jquery.toast.css')}}" rel="stylesheet">
	<link href="{{ asset('mycss/main.css') }}" rel="stylesheet">
	<link href="{{ asset('mycss/raplet.css') }}" rel="stylesheet">
	<link href="{{ asset('mycss/rapletmessinger.css') }}" rel="stylesheet">

	@if(isset($_COOKIE['nightMode']))
		@if($_COOKIE['nightMode']=="on")
			<link class="nightModeStyle" href="{{ asset('mycss/rapletNightMode.css') }}" rel="stylesheet">
		@else
			<link class="nightModeStyle" disabled href="{{ asset('mycss/rapletNightMode.css') }}" rel="stylesheet">
		@endif
	@else
		<link class="nightModeStyle" disabled href="{{ asset('mycss/rapletNightMode.css') }}" rel="stylesheet">
	@endif

	@yield('style')
	@if(Auth::check())
	@else
		<script src='https://www.google.com/recaptcha/api.js'></script>
	@endif
	@yield('pageHeaders')

</head>
<body id="bodyDefiner">
<div class="rapletIsLoading"><img class="" src="{{url('storage/icons/'.'Radio-1s-200px.svg')}}" alt="raplet"></div>

<div id="fb-root"></div>
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>


@include('includes.messages')

<div class="wholeBody">
	<div id="app">
	@include('includes.pageHeader')


	<!-- main content -->
		<!-- main content -->
		<!-- main content -->

		<div class="mainContent">
			@yield('content')

		</div>


		@if(!Auth::check())
			<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
			     aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
									class="fas fa-times"></i></button>
						<div class="modal-body registerationModels row">
							<div class="text-center col-md-12">
								<img class="mb-4" src="{{url('storage/logo/'.'raplet.png')}}" alt="" width="72" height="72">
								<h1 class="modelHeadLine h3 mb-3 font-weight-normal">{{ trans('home.signup') }}</h1>
								<p class="informationLineForBlue"><a>{{trans('home.terms')}}</a></p>
							</div>

							<div class="col-md-12 ">
								<div class="row">

									<div class="col-md-6 offset-3">


										<div class="socialLoginDiv">
											<div class="informingDevelopmentLine">
												<p style="color:#41b883;">{{ trans('home.socialmediaregister') }}</p>
											</div>

											<a class="btn myLightBtn btn-light btn-block shadowingBtn"
											   href="{{url('/social-register/facebook')}}" id="facebookLogin">
												<img class="" src=" {{url('storage/logo/'.'f-logo.png')}}" alt="facebook">&nbsp;&nbsp;{{ trans('home.facebookLogin') }}
											</a>

											<a class="btn myLightBtn btn-light btn-block shadowingBtn"
											   href="{{url('/social-register/google')}}" id="googleLogin">
												<img class="" src=" {{url('storage/logo/'.'g-logo.png')}}" alt="google"></i>
												&nbsp;&nbsp;{{ trans('home.googleLogin') }}
											</a>

											<a class="btn myLightBtn btn-light btn-block shadowingBtn twitterLogin"
											   href="{{url('/social-register/twitter')}}" id="twitterLogin">
												<img class="" src=" {{url('storage/logo/'.'t-logo.png')}}" alt="twitter">&nbsp;&nbsp;{{ trans('home.twitterLogin') }}
											</a>

											<div class="informingDevelopmentLine">
												<p>
													<i class="fas fa-info-circle"></i>&nbsp;&nbsp;{{ trans('home.socialmedianotshared') }}
												</p>
											</div>

										</div>
									</div>

								</div>
							</div>
							<div class="text-center col-md-12">
								<p class="informingDevelopmentLine">&copy; {{ config('app.name', 'Raplet') }}
									<small>2019</small>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="loginModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
			     aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
									class="fas fa-times"></i></button>
						<div class="modal-body registerationModels row">

							<div class="text-center col-md-12">
								<img class="mb-4" src="{{url('storage/logo/'.'raplet.png')}}" alt="" width="72" height="72">
								<h1 class="modelHeadLine h3 mb-3 font-weight-normal">{{ trans('home.signin') }}</h1>
								<p class="informationLineForBlue"><a>{{trans('home.terms')}}</a></p>
							</div>

							<div class="col-md-12 ">
								<div class="row">

									<div class="col-md-6">


										<div class="socialLoginDiv">
											<div class="informingDevelopmentLine">
												<p style="color:#41b883;">{{ trans('home.socialmediaregister') }}</p>
											</div>


											<a class="btn myLightBtn btn-light btn-block shadowingBtn"
											   href="{{url('/social-register/facebook')}}" id="facebookLogin">
												<img class="" src=" {{url('storage/logo/'.'f-logo.png')}}" alt="facebook">&nbsp;&nbsp;{{ trans('home.facebookLogin') }}
											</a>

											<a class="btn myLightBtn btn-light btn-block shadowingBtn"
											   href="{{url('/social-register/google')}}" id="googleLogin">
												<img class="" src=" {{url('storage/logo/'.'g-logo.png')}}" alt="google"></i>
												&nbsp;&nbsp;{{ trans('home.googleLogin') }}
											</a>

											<a class="btn myLightBtn btn-light btn-block shadowingBtn twitterLogin"
											   href="{{url('/social-register/twitter')}}" id="twitterLogin">
												<img class="" src=" {{url('storage/logo/'.'t-logo.png')}}" alt="twitter">&nbsp;&nbsp;{{ trans('home.twitterLogin') }}
											</a>

											<div class="informingDevelopmentLine">
												<p>
													<i class="fas fa-info-circle"></i>&nbsp;&nbsp;{{ trans('home.socialmedianotshared') }}
												</p>
											</div>

										</div>
									</div>
									<div class="col-md-6">
										<form class="form-signin" data-enter="logUserIn">


											<div class="form-label-group">
												<input type="email" id="loginMail"
												       class="form-control requiredLogIn enterTrigger"
												       data-content="{{ trans('home.email') }}"
												       placeholder="{{ trans('home.email') }}" required autofocus>
												<label for="loginMail">{{ trans('home.email') }}</label>
											</div>

											<div class="form-label-group">
												<input type="password" id="loginPassword"
												       class="form-control requiredLogIn enterTrigger"
												       data-content="{{ trans('home.password') }}"
												       placeholder="{{ trans('home.password') }}" required>
												<label for="loginPassword">{{ trans('home.password') }}</label>
											</div>


											<div class="checkbox mb-3">
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="remember"
													       id="remember" {{ old('remember') ? 'checked' : '' }}>
													<label class="custom-control-label"
													       for="remember">{{ trans('home.remember') }}</label>
												</div>
											</div>
											<div class="modelFormButtons">
												<div class="customLightAnchor">
													<a class="btn btn-lg btn-primary btn-block shadowingBtn"
													   onclick="logUserIn()" id="logUserIn">{{ trans('home.signin') }}</a>
												</div>
												<br>
												<div class="customDarkAnchor noBackgroundCenterBtn">
													<a href="{{ url('password/reset') }}"><i class="fas fa-key"></i>&nbsp;&nbsp;{{ trans('home.resetPassword') }}
													</a>
												</div>
												<p class="mt-5 mb-3 text-center informingDevelopmentLine">
													&copy; {{ config('app.name', 'Raplet') }}
													<small>2019</small>
												</p>
											</div>
										</form>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif

	</div>
</div>

@if(!Auth::check())
	<div class="selectLang" id="langSelectorSpace">
		<div class="selectLangInnerDiv">
			<h3 class="selectLangHeader">{{ trans('home.selectLang') }}</h3>
			<p>{{ trans('home.seems') }}</p>

			<button class="langsButtons transitionSlow selectedlang resetpageclass"> {{ trans('home.langname') }}</button>

			<p>{{ trans('home.wannachange') }}</p>
			<div class="langsButtonDiv">
				@foreach($langs as $lang)
					<button class="langsButtons transitionSlow permaLangSelector"
					        data-content_id="{{ $lang->id }}"> {{ $lang->name }} </button>
				@endforeach
			</div>
		</div>
	</div>
@else


	<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ trans('home.abouttodelete') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="letterspacedLarg">{{ trans('home.suretodelete') }}</div>
					<input class="form-control" id="commentToDelete" type="text" placeholder="Readonly input here…"
					       readonly>
					<input id="commentToDeleteID" hidden>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('home.cancel') }}</button>
					<button type="button" id="deleteAComment" class="btn btn-secondary"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;{{ trans('home.delete') }}
					</button>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="reportModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	     aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div class="form-group">
						<label for="reportREASON">{{ trans('home.choosReport') }}</label>
						<select class="form-control" name="reportREASON" id="reportREASON">
							<option value="{{ trans('home.insult') }}">{{ trans('home.insult') }}</option>
							<option value="{{ trans('home.spam') }}">{{ trans('home.spam') }}</option>
							<option value="{{ trans('home.racism') }}">{{ trans('home.racism') }}</option>
							<option value="{{ trans('home.other') }}">{{ trans('home.other') }}</option>
						</select>
					</div>

					<input type="hidden" id="reportingID" value="" name="content_id">
					<input type="hidden" id="reportingTYPE" value="" name="type">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('home.close') }}</button>
					<button type="button" id="sendReport" class="btn btn-primary">{{ trans('home.submit') }}</button>
				</div>
			</div>
		</div>

	</div>

@endif


<div class="footerOuterDiv">
	<div class="footer col-12 noSidePadding">
		<div class="container">
			<a class="rapletFooterBrand" href="{{ url('/') }}">
				{{ config('app.name', 'Raplet') }} <span style="font-size: 14px"> &copy; 2019</span>
			</a>
			<div class="btn-group dropup">
				<button type="button" class="rapletLangDropup transitionSlow" data-toggle="dropdown"
				        aria-haspopup="true" aria-expanded="false">
					{{ trans('home.langname') }}&nbsp;&nbsp;<i class="fas fa-caret-up"></i>
				</button>
				<div class="dropdown-menu">
					@foreach($langs as $lang)
						<a class="dropdown-item permaLangSelector"
						   data-content_id="{{ $lang->id }}">{{ $lang->name }}</a>
					@endforeach
				</div>
			</div>
			<a class="float-right" href="{{ route('termsAndPolicy') }}">
				{{ trans('home.termsAndPolicy') }}
			</a>
		</div>
	</div>
</div>

<div class="rapletmessengers">
	<div class="modal fade" id="messengermodel" tabindex="-1" role="dialog" aria-labelledby="messengermodel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="messagemodellabel"></h5>
				</div>
				<div class="modal-body messagemdoelbody" id="messagingcontent">

				</div>
				<div class="messengerbtns">
					<a id="messagelink" target="_blank" class="messagelink transitionSlow"></a>
				</div>
				<div class="modal-footer displaynone" id="regularmsgfooter">
					<button type="button" class="btn btn-link" data-dismiss="modal">{{ trans('home.close') }}</button>
					<button type="button" class="btn btn-primary iapprovethis">{{ trans('home.ok') }}</button>
				</div>
				<div class="modal-footer displaynone" id="termsacceptfooter">
					<button type="button" class="btn btn-primary iapprovethis">
						<i class="fas fa-check"></i>&nbsp;&nbsp;{{ trans('home.acceptnewterm') }}</button>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
    var showmore = '{{ trans('home.showmore') }}';
    var showless = '{{ trans('home.showless') }}';

    var monthsTranslationArr = [
        '{{trans('home.january')}}',
        '{{trans('home.february')}}',
        '{{trans('home.march')}}',
        '{{trans('home.april')}}',
        '{{trans('home.may')}}',
        '{{trans('home.june')}}',
        '{{trans('home.july')}}',
        '{{trans('home.august')}}',
        '{{trans('home.september') }}',
        '{{trans('home.october')}}',
        '{{trans('home.november')}}',
        '{{trans('home.december')}}'

    ];
    var daysAgo = '{{ trans('home.daysago') }}';
    var hoursAgo = '{{ trans('home.hoursago') }}';
    var minsAgo = '{{ trans('home.minsAgo') }}';
    var justNow = '{{ trans('home.justNow-low') }}';

    var headingTransName = '{{ trans('home.headers') }}';
    var entryTransName = '{{ trans('home.entries') }}';
    var userTransName = '{{ trans('home.users') }}';

</script>
<script src="{{ asset('myjs/plugin/jquery.toast.js')}}"></script>
<script src="{{ asset('myjs/popper.min.js') }}"></script>
<script src="{{ asset('myjs/bootstrap.min.js') }}"></script>
<script src="{{ asset('myjs/login.js') }}"></script>
<script src="{{ asset('myjs/langselector.js') }}"></script>
<script src="{{ asset('myjs/main.js') }}"></script>
<script src="{{ asset('myjs/raplet.js') }}"></script>
<script src="{{ asset('myjs/swipeDetection.js') }}"></script>
@yield('script')


@if(Auth::check())
	@if(Auth::guard('web')->check())
		<script src="{{ asset('myjs/authed/reportContent.js') }}" defer></script>
		<script src="{{ asset('myjs/authed/interractWithPost.js') }}"></script>
		<script src="{{ asset('myjs/authed/interractWithComment.js') }}" defer></script>
		<script src="{{ asset('myjs/authed/rapletNightMode.js') }}"></script>
		<script src="{{ asset('myjs/authed/notifier.js') }}"></script>
		<script src="{{ asset('myjs/translations/'.Config::get('app.locale').'/title.js') }}"></script>

		<script>
            var langCheck = '{{Auth::user()->userprofile->lang_id}}';

            var likeComment = "{{ route('likeComment') }}";
            var dislikeComment = "{{ route('dislikeComment') }}";

            var delete_post = "{{ route('delete_post') }}";
            var enablePost = "{{ route('enablePost') }}";
            var editComments = "{{ route('editComments') }}";
            var deleteComments = "{{ route('deleteComments') }}";
					{{--var urlNotifyseen = '{{ route("urlNotifyseen") }}';--}}
            var get_notifications = '{{ route("get_notifications") }}';

            var getNewMessageServiceUrl = "{{ route('getNewMessageServiceUrl') }}";
            var keeperapproval = "{{ route('userseekeeper') }}";

            var reportCreate = "{{ route('reportCreate') }}";

            var headerPage = "{{ route('word', '') }}";
		</script>
	@endif

@else
	<script>
        var keeperapproval = "{{ route('visitorseekeeper') }}";
        var getNewMessageServiceUrl = "{{ route('messageUnAuthed') }}";
        var passConfirmMessage = '{{ trans('home.passwordNotMAtch') }}';
        var loginSuccss = '{{ trans('home.loginsuccessfull') }}';
        var noSuchUser = '{{ trans('home.nosuchuser') }}';

        var loginUnsuccessfull = '{{ trans('home.loginunsuccessfull') }}';

        var required = '{{ trans('home.required') }}';

        var loginUser = '{{ route('login') }}';
	</script>
@endif
<script>

    var token = '{{ Session::token() }}';
    var setNewLang = '{{ route('setNewLang') }}';
    var navSearch = '{{ route("navSearch") }}';
    var checkSearch = "{{ route('checkSearch') }}";
    var catSelector = "{{ route('catSelector') }}";
    var rapletTranslator = "{{ route('rapletTranslator') }}";
</script>

<script src="{{ asset('myjs/translations/'.Config::get('app.locale').'/name.js') }}"></script>
<script src="{{ asset('myjs/rapletsearcher.js') }}" defer></script>
<script src="{{ asset('myjs/catSelector.js') }}" defer></script>
<script src="{{ asset('myjs/languageLoader.js') }}"></script>
<script src="{{ asset('asar-tools/asar-humanoid-datetime/asar-humanoid-datetime.js') }}"></script>
<script src="{{ asset('asar-tools/asar-preview-modal/asar-preview-modal.js') }}"></script>

<script src="{{ asset('myjs/rapletMessinger.js') }}" defer></script>

</body>
</html>
