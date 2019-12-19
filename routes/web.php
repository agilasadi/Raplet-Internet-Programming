<?php

	/*
	|--------------------------------------------------------------------------
	| Web Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register web routes for your application. These
	| routes are loaded by the RouteServiceProvider within a group which
	| contains the "web" middleware group. Now create something great!
	|
	*/


	Route::group(['middleware' => ['basicUser']], function () {
		Route::get('/', function () {
			return redirect()->route('home');
		});

		Auth::routes();

		Route::get('login', function () {
			return redirect()->route('home');
		})->name('login');
		Route::get('register', function () {
			return redirect()->route('home');
		})->name('register');


		Route::get('/', 'HomeController@index')->name('home');
		Route::get('/solarsystem', 'HomeController@solarsystem')->name('solarsystem');
		Route::get('/curiosity', 'PostmediaController@curiosity')->name('curiosity');
		Route::get('/entireRaplet', 'HomeController@entireRaplet')->name('entireRaplet');

		Route::get('/profile/{slug}', 'UserController@profile')->name('profile');
		Route::get('/editprofile', 'UserController@editprofile')->name('editprofile');
		Route::post('authed/update_password', 'Authed\UserController@update_password')->name('update_password');


		Route::get('/social-register/{provider}', 'SocialAuthController@redirect_to_provider')->name('redirect_to_provider');
		Route::get('/social-register/{provider}/callback', 'SocialAuthController@handle_provider_callback')->name('handle_provider_callback');


		Route::post('langCreate', 'LangController@langCreate')->name('langCreate');
		Route::post('setNewLang', 'LangController@setNewLang')->name('setNewLang');

		Route::get('messageUnAuthed', 'UnAuthedController@messageUnAuthed')->name('messageUnAuthed');
		Route::get('getNewMessageServiceUrl', 'UserController@getNewMessageServiceUrl')->name('getNewMessageServiceUrl');

		Route::get('visitorseekeeper', 'UnAuthedController@visitorseekeeper')->name('visitorseekeeper');
		Route::get('userseekeeper', 'UserController@userseekeeper')->name('userseekeeper');

		Route::resource('lang', 'LangController');

		Route::post('createComments', 'CommentController@createComments')->name('createComments');
		Route::post('editComments', 'CommentController@editComments')->name('editComments');
		Route::post('deleteComments', 'CommentController@deleteComments')->name('deleteComments');
		Route::get('entry/{slug}', 'CommentController@entry')->name('entry');

//		Route::post('createUser', 'Auth\RegisterController@createUser')->name('createUser');
		Route::post('updateProfile', 'UserController@updateProfile')->name('updateProfile');


		Route::get('/editingPostContnet/{id}', 'PostController@editingPostContnet')->name('editingPostContnet');
		Route::get('/postPaginator/', 'PostController@postPaginator')->name('postPaginator');

		Route::get('makePost', 'PostController@makePost')->name('makePost');
		Route::get('recicle_posts/{slug?}', 'PostController@recicle_posts')->name('recicle_posts');


		//for admins
		Route::post('postCreate', 'PostController@postCreate')->name('postCreate');

		Route::post('createPost', 'PostController@createPost')->name('createPost');
		Route::post('postEdit', 'PostController@postEdit')->name('postEdit');
		Route::post('delete_post', 'PostController@delete_post')->name('delete_post');
		Route::post('enablePost', 'PostController@enablePost')->name('enablePost');


		Route::post('addHeaderAsLinking', 'CommentController@addHeaderAsLinking')->name('addHeaderAsLinking');

		Route::post('navSearch', 'SearchController@navSearch')->name('navSearch');
		Route::post('checkSearch', 'SearchController@checkSearch')->name('checkSearch');
		Route::get('search/{searched}/{type?}', 'SearchController@search')->name('search');


		Route::post('reportCreate', 'PostController@reportCreate')->name('reportCreate');


		Route::post('likePost', 'InterractController@likePost')->name('likePost');

		Route::post('likeComment', 'InterractController@likeComment')->name('likeComment');
		Route::post('dislikeComment', 'InterractController@dislikeComment')->name('dislikeComment');


//		Route::post('urlNotifyseen', 'InterractController@urlNotifyseen')->name('urlNotifyseen');

		Route::post('/uploadProfileImage', 'UserController@uploadProfileImage')->name('uploadProfileImage');


		Route::post('catSelector', 'CatController@catSelector')->name('catSelector');

		// ===> Check moderator inside the middleware instead of checking it in each of the function
		Route::group(['middleware' => 'moderator'], function (){
            Route::post('moderateUser', 'ModeratorController@moderateUser')->name('moderateUser');
            Route::post('badgeContent', 'ModeratorController@badgeContent')->name('badgeContent');
            Route::post('edit_post_is_featured', 'ModeratorController@edit_post_is_featured')->name('edit_post_is_featured');
            Route::post('verify_duplicate_ban', 'ModeratorController@verify_duplicate_ban')->name('verify_duplicate_ban');
        });

		Route::post('rapletTranslator', 'LangController@rapletTranslator')->name('rapletTranslator');

		Route::get('termsAndPolicy', 'HomeController@termsAndPolicy')->name('termsAndPolicy');
		Route::get('/w/{slug}/{langname?}', 'PostController@word')->name('word');
	});
	Route::group(['middleware' => 'auth'], function () {
		Route::get('get_notifications', 'Authed\NotificationController@get_notifications')->name('get_notifications');
	});

	Route::prefix('admin')->group(function () {
		Route::post('submitNewRole', 'AdminController@submitNewRole')->name('submitNewRole');

		//category
		Route::post('submitNewCategory', 'CategoryController@create')->name('submitNewCategory');
		Route::post('softDeleteCategory', 'CategoryController@delete')->name('softDeleteCategory');
		Route::post('forceDeleteCategory', 'CategoryController@forceDelete')->name('forceDeleteCategory');
		Route::post('updateCategory', 'CategoryController@update')->name('updateCategory');
		Route::post('restoreCategory', 'CategoryController@restore')->name('restoreCategory');

		Route::get('indexCategories', 'CategoryController@index')->name('indexCategories');
		Route::get('restore_view', 'CategoryController@restore_view')->name('restore_view');

		Route::post('makeItAdmin', 'AdminController@makeItAdmin')->name('makeItAdmin');

		Route::post('createBadge', 'AdminController@createBadge')->name('createBadge');
		Route::post('createBadgeTranslation', 'AdminController@createBadgeTranslation')->name('createBadgeTranslation');


		Route::get('/', 'AdminController@index')->name('admin.dashboard');
		Route::get('badgeCreator', 'AdminController@badgeCreator')->name('badgeCreator');
		Route::get('badgelist', 'AdminController@badgelist')->name('badgelist');
		Route::get('badgetranslations', 'AdminController@badgetranslations')->name('badgetranslations');

		Route::get('keeperCreatePage', 'AdminController@keeperCreatePage')->name('keeperCreatePage');
		Route::get('keeperEditPage/{id?}', 'AdminController@keeperEditPage')->name('keeperEditPage');

		Route::post('createNewKeeper', 'AdminController@createNewKeeper')->name('createNewKeeper');
		Route::post('editTheKeeper', 'AdminController@editTheKeeper')->name('editTheKeeper');

		Route::post('createAKT', 'KeeperController@createAKT')->name('createAKT');
		Route::post('updateAKT', 'KeeperController@updateAKT')->name('updateAKT');

		Route::get('termstranslations/{id?}', 'AdminController@termstranslations')->name('termstranslations');
		Route::post('termstranslate', 'AdminController@termstranslate')->name('termstranslate');

		Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
		Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	});

