<?php

	namespace raplet\Http\Controllers\Auth;

	use Cocur\Slugify\Slugify;
	use GuzzleHttp\Client;
	use Illuminate\Support\Facades\App;
	use Illuminate\Support\Facades\Auth;
	use raplet\Lang;
	use raplet\User;
	use raplet\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Foundation\Auth\RegistersUsers;
	use raplet\Userprofile;
	use Illuminate\Http\Request;
	use raplet\Userstat;


	class RegisterController extends Controller
	{
		/*
		|--------------------------------------------------------------------------
		| Register Controller
		|--------------------------------------------------------------------------
		|
		| This controller handles the registration of new users as well as their
		| validation and creation. By default this controller uses a trait to
		| provide this functionality without requiring any additional code.
		|
		*/

		use RegistersUsers;

		/**
		 * Where to redirect users after registration.
		 *
		 * @var string
		 */
		protected $redirectTo = '/home';

		/**
		 * Create a new controller instance.
		 *
		 * @return void
		 */
		public function __construct()
		{
			$this->middleware('guest');
		}

		/**
		 * Get a validator for an incoming registration request.
		 *
		 * @param  array $data
		 * @return \Illuminate\Contracts\Validation\Validator
		 */
		protected function validator(array $data)
		{
			return Validator::make($data, [
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:6|confirmed',
			]);

		}

		/**
		 * Create a new user instance after a valid registration.
		 *
		 * @param  array $data
		 * @return \raplet\User
		 */
		protected function create(array $data)
		{
			 return response()->json($this->invalid_request());
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password']),
//        ]);
		}

		public function createUser(Request $request)
		{
			 return response()->json($this->invalid_request());
//        $recapToken = $request['specialisedRecaptcha'];
//
//        if ($recapToken) {
//            $client = new Client();
//
//            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
//                "form_params" => array(
//                    'secret' => '6LcI21sUAAAAAMmfP9XouSlVwCYQYDc_17h32NcK',
//                    'response' => $recapToken
//                )
//            ]);
//
//            $results = json_decode($response->getBody()->getContents());
//
//
//            if ($results->success) {
//
//
//                // slug, name, email, about, password
//                $validator = Validator::make($request->all(), [
//                    'name' => 'required|string|max:150',
//                    'email' => 'required|string|email|max:255|unique:users',
//                    'password' => 'required|string|min:7|confirmed',
//                ]);
//
//                if ($validator->fails()) {
//
//                    return response()->json(['errors' => $validator->errors()->all()]);
//                }
//
//                $user = new User();
//
//                $user->name = $request['name'];
//                $user->email = $request['email'];
//                $user->password = bcrypt($request['password']);
//
//                $user->save();
//
//                $userslug = new Slugify();
//                $slug = $userslug->slugify($request['name']);
//
//                $userprofile = new Userprofile();
//
//                $locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
//                $lang = Lang::where('short_name', $locale)->first();
//
//                if (!$lang) {
//                    $newlang = new Lang();
//                    $newlang->name = 'Not supported yet (' . $locale . ')';
//                    $newlang->short_name = $locale;
//                    $newlang->slug = $locale;
//
//                    $newlang->save();
//                }
//
//                $lang = Lang::where('short_name', $locale)->first();
//
//                $slugcheck = Userprofile::where('slug', $slug)->exists();
//                while ($slugcheck){
//                    $slug =  $slug.$user->id;
//                    $slugcheck = Userprofile::where('slug', $slug)->exists();
//                }
//
//                $userprofile->name = $request['name'];
//                $userprofile->bio = '0';
//                $userprofile->slug = $slug;
//                $userprofile->user_id = $user->id;
//                $userprofile->lang_id = $lang->id;
//
//                $success = $userprofile->save();
//
//                $userstats = new Userstat();
//
//                $userstats->user_id = $user->id;
//                $userstats->save();
//
//                $message = trans('home.signupsuccessful');
//
//                Auth::login($user);
//                return response()->json(['user' => $user, 'success' => $success, 'message' => $message]);
//                // return redirect()->route('home');
//
//            } else {
//                $success = '0';
//                $message = trans('home.recaptchaunsucceed');
//                return response()->json(['success' => $success, 'message' => $message]);
//            }
//        }
//         else{
//             $success = '0';
//             $message = trans('home.recaptchamustbefilled');
//             return response()->json(['success' => $success, 'message' => $message]);
//         }
		}
	}
















