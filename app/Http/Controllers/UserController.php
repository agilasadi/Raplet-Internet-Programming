<?php

	namespace raplet\Http\Controllers;

	use Carbon\Carbon;
	use Cocur\Slugify\Slugify;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use raplet\Keeper;
	use raplet\Like;
	use raplet\Listeners\postLog;
	use raplet\Logs;
	use raplet\User;
	use raplet\Userbadges;
	use raplet\Userprofile;
	use raplet\Badge;
	use raplet\Rank;
	use Illuminate\Validation\Rule;
	use Illuminate\Support\Facades\DB;
	use raplet\Userstat;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Facades\Hash;
	use raplet\Vote;
	use Illuminate\Support\Facades\Session;
	use Illuminate\Support\Facades\Cookie;


	class UserController extends Controller
	{
		public function profile($slug)
		{
			$is_featured = [0, 4];

			$user = Userprofile::where('slug', $slug)->firstOrFail();

			$logs = Logs::where('user_id', $user->user_id)->whereNotIn('log_type', $is_featured)->orderBy('id', 'desc')->paginate(25, ["*"], 'profilelogs');
			$acuiredBadges = Userbadges::where('user_id', $user->user_id)->with('badges')->get();

			if (Auth::check())
			{
				$commentVoteUp = Vote::select('comment_id')->where('user_id', Auth::id())->where('vote', 1)->get();
				$commentVoteDown = Vote::select('comment_id')->where('user_id', Auth::id())->where('vote', 0)->get();
				$likes = Like::select('post_id')->where('user_id', Auth::id())->get();


				if (!$commentVoteUp)
				{
					$commentVoteUp = "null";
				}
				if (!$commentVoteDown)
				{
					$commentVoteDown = "null";
				}
				if (!$likes)
				{
					$likes = '0';
				}

				$likeArr = array_flatten($likes->toArray());
				$voteUps = array_flatten($commentVoteUp->toArray());
				$voteDowns = array_flatten($commentVoteDown->toArray());


				if (Auth::user()->userprofile->role_id != 4)
				{
					if (Auth::user()->userprofile->role_id == '1')
					{
						$badges = Badge::where('badge_type', '0')->get();
						$ranks = Rank::all();
					}
					elseif (Auth::user()->userprofile->role_2 == '2')
					{
						$badges = Badge::where('badge_type', '0')->get();
						$ranks = Rank::where('id', '!=', '1')->get();
					}
					else
					{
						$badges = null;
						$ranks = 'null';
					}
				}
				else
				{
					$badges = null;
					$ranks = 'null';
				}

			}
			else
			{
				$voteUps = 'null';
				$voteDowns = 'null';
				$likeArr = '0';

				$badges = null;
				$ranks = 'null';
			}


			//$activities = $posts->merge($comments)->sortBy('created_at');
			//$activities = array_merge($posts->toArray(), $comments->toArray());
			return view('profile', ['user' => $user, 'voteUps' => $voteUps, 'voteDowns' => $voteDowns,
				'likeArr' => $likeArr, 'logs' => $logs, 'badges' => $badges,
				'ranks' => $ranks, 'acuiredBadges' => $acuiredBadges]);
		}

		public function editprofile()
		{

			if (Auth::check())
			{
				return view('update.editprofile');
			}
			else
			{
				$message = trans('home.plzLogin');
				Session::flash('message', $message);
				return redirect('home');
			}

		}

		public function userStats($id)
		{
			$user = User::find($id);
			if (count($user) > 0)
			{
				if (count($user->userstat) > 0)
				{
					$success = '1';
					return response()->json(['userstat' => $user->userstat, 'success' => $success]);
				}
				else
				{
					$userstat = new Userstat();

					$userstat->user_id = $id;
					$userstat->entrycount = '0';
					$userstat->headercount = '0';
					$userstat->likecount = '0';
					$userstat->likercount = '0';
					$userstat->voteupcount = '0';
					$userstat->votedown = '0';
					$userstat->reporting = '0';
					$userstat->reported = '0';
					$userstat->secretpoint = '0';

					$userstat->save();


					$success = '1';
					return response()->json(['userstat' => $userstat, 'success' => $success]);
				}
			}
			else
			{
				$message = trans('home.thereisnosuchdata');
				$success = '0';
				return response()->json(['message' => $message, 'success' => $success]);
			}

		}


		public function uploadProfileImage(Request $request)
		{

			if (Auth::check())
			{

				$userprofile = Userprofile::where('user_id', Auth::id())->first();


				if (isset($_POST["userImg"]))
				{
					$data = $_POST["userImg"];

					$image_array_1 = explode(";", $data);
					$image_array_2 = explode(",", $image_array_1[1]);

					$readyfile = base64_decode($image_array_2[1]);

					$filename = $userprofile->name . $userprofile->id . time() . '.jpg';

					file_put_contents('storage/profile/' . $filename, $readyfile);

					if ($userprofile->userImg != 'profile.jpg')
					{
						rename('storage/profile/' . $userprofile->userImg, storage_path() . 'storage/deletedProfile/' . $userprofile->userImg);
					}

					$userprofile->userImg = $filename;
					$userprofile->update();

					return response()->json(['res' => $filename]);
				}
				else
				{
					return response()->json(['res' => $userprofile->userImg]);
				}

			}

		}

		//slug: slug,
		//name: name,
		//email: email,
		//about: about,
		//password: password,
		//password_confirmation: passwordConfirm,
		//oldpassword: oldpassword,
		//_token: token

		public function updateProfile(Request $request)
		{// slug, name, email, about, password

			if (Auth::check())
			{
				$user = Auth::user();
				if ($request['oldpassword'] != null)
				{
					if (Hash::check($request->oldpassword, auth()->user()->password))
					{
						if ($request['password'] === $request['password_confirmation'])
						{

							$passValidator = Validator::make($request->all(), [
								'password' => ['required', 'min:7', 'max:40'],

							]);
							if ($passValidator->fails())
							{
								return response()->json(['errors' => $passValidator->errors()->all()]);
							}

							$user->password = password_hash($request->password, PASSWORD_DEFAULT);
						}
						else
						{


							///return the password confirm does not match message
							$success = '0';
							$message = trans('home.passwordNotMAtch');
							return response()->json(['success' => $success, 'message' => $message]);
						}
					}
					else
					{
						///return the old password and the new password does not match

						$success = '0';
						$message = trans('home.passwordWasNotEnteredCorrect');
						return response()->json(['success' => $success, 'message' => $message]);

					}
				}


				$validator = Validator::make($request->all(), [
					'slug' => ['required', 'min:2', 'max:60'],
					'name' => ['required', 'min:2', 'max:60'],
					'email' => ['required', 'min:8', 'max:60', Rule::unique('users')->ignore(Auth::id())],
					'bio' => ['max:240'],
				]);

				if ($validator->fails())
				{
					return response()->json(['errors' => $validator->errors()->all()]);
				}
				if (empty($request['bio']) || trim($request['bio']) == '')
				{
					$shortinfo = "0";
				}
				else
				{
					$shortinfo = $request['bio'];
				}

				$user->name = $request['name'];
				$user->email = $request['email'];

				$user->save();

				$userslug = new Slugify();
				$slug = $userslug->slugify($request['slug']);

				$slugCheck = Userprofile::where('slug', $slug)->where('user_id', '!=', Auth::id())->first();
				if (count($slugCheck) > 0)
				{
					$success = '0';
					$message = '@' . $slug . trans('home.thisslugisuserd');
					return response()->json(['success' => $success, 'message' => $message]);
				}

				$userprofile = Userprofile::where('user_id', $user->id)->first();

				$userprofile->slug = $slug;
				$userprofile->name = $request['name'];
				$userprofile->bio = $shortinfo;

				$userprofile->save();

				$success = '1';
				$message = trans('home.updatesuccessful');
				$profilelink = route('profile', $userprofile->slug);
				return response()->json(['success' => $success, 'message' => $message, 'profilelink' => $profilelink]);
			}
			else
			{
				//need to loge in first
				$success = '0';
				$message = trans('home.plzLogin');
				return response()->json(['success' => $success, 'message' => $message]);
			}
		}

		public function getNewMessageServiceUrl()
		{
			if (Cookie::get('blockkeeper') !== null)
			{
				$success = "0";// create cooke to delay next request
				$cookie = cookie('blockkeeper', '1', 120);
				return response()->json(['success' => $success])->cookie($cookie);
			}

			//this function handles only logged in users
			if (Auth::check())
			{
				$doesNeed = [0, 4, Auth::user()->userprofile->role_id]; // this determent which message ths user needs to see
				$keeperType = [0, 1, 4]; //this is the message types we show in messenger for now
				if (Cookie::get('lang_id') !== false)
				{ //we will need lang_id in next stage
					$langID = Cookie::get('lang_id');
				}
				else
				{
					$langID = Auth::user()->userprofile->lang_id;
					$setlangid = Cookie::forever('lang_id', Auth::user()->userprofile->lang_id);
				}


				$userlastkeeper = DB::table('keeper_user')->where('user_id', Auth::id())->orderBy('id', 'desc')->first()->created_at;

				// getting the last keeper viewed by the logged in user

				//User has seen some keepers before
				if ($userlastkeeper != null)
				{

					if (strtotime($userlastkeeper->created_at) > strtotime('-2 hours'))
					{
						$success = "0"; //delay the user request with cookie
						$cookie = cookie('blockkeeper', '1', 120);
						return response()->json(['success' => $success])->cookie($cookie);
					}


					$finite = Keeper::where('status', '1')->whereIn('type', $keeperType)->whereIn('user_type', $doesNeed)->orderBy('id', 'desc')->first();

					// Checking to see if the last seen keeper is different than the last keeper of website
					if ($userlastkeeper->keeper_id < $finite->id)
					{
						$seenKeepers = DB::table('keeper_user')->where('user_id', Auth::id())
							->pluck('keeper_id')->toArray();

						$notSeenKeepers = Keeper::whereNotIn('id', $seenKeepers)
							->whereIn('user_type', $doesNeed)->orderBy('id', 'asc')->first();
						if ($notSeenKeepers != null)
						{
							// get the keeper content in the native language
							$nativeKeeper = $notSeenKeepers->transspecific($langID);
							$success = "1";
						}
						else
						{
							$success = "0";// delay by cookie
							$notSeenKeepers = null;
							$nativeKeeper = null;
						}
						// NOT SEEN -> right join -> NATIVE
						return response()->json(['notSeenKeepers' => $notSeenKeepers, 'nativeKeeper' => $nativeKeeper, 'success' => $success]);
					}
					else
					{
						$success = "0";// create cooke to delay next request
						$cookie = cookie('blockkeeper', '1', 120);
						return response()->json(['success' => $success])->cookie($cookie);
					}
				} //if user have not seen any keeper before ----> we enter here
				else
				{
					// Checking to see if the last seen keeper is different than the last keeper of website
					$notSeenKeepers = Keeper::whereIn('user_type', $doesNeed)->whereIn('type', $keeperType)->orderBy('id', 'asc')->first();
					$success = "1";

					if ($notSeenKeepers != null)
					{
						// get the keeper content in the native language
						$nativeKeeper = $notSeenKeepers->transspecific($langID);
					}
					else
					{
						$success = "0";
						$nativeKeeper = null;
					}

					return response()->json(['notSeenKeepers' => $notSeenKeepers, 'nativeKeeper' => $nativeKeeper, "success" => $success]);
				}
			}
			else
			{
				$success = "0";// create cooke to delay next request
				$cookie = cookie('blockkeeper', '1', 120);
				return response()->json(['success' => $success])->cookie($cookie);
			}
		}

		public function userseekeeper(Request $request)
		{
			if (Auth::check())
			{
				$userID = Auth::id();
				$userIP = $request->ip();
				$keeper = DB::table('keepers')->where('id', $request['viewedkeeper'])->first();
				$isitseen = DB::table('keeper_user')->where("keeper_id", $request['viewedkeeper'])
					->where("user_id", $userID || "user_ip", $userIP)->first();

				//keeper doesn't excise or  user has already seen this keeper
				if ($isitseen != null && $keeper == null)
				{
					$success = "0";// create cooke to delay next request
					$cookie = cookie('blockkeeper', '1', 120);
					return response()->json(['success' => $success])->cookie($cookie);
				} //everything is according to the plan, insert new keeper - user relationship
				else
				{
					$timestamp = now();
					$userseenthekeeper = DB::table('keeper_user')->insert(
						['user_id' => $userID, 'keeper_id' => $request['viewedkeeper'], 'user_ip' => $userIP, 'created_at' => $timestamp]
					);

					//inserting into db was not successful
					if (!$userseenthekeeper)
					{
						$success = "2";
						return response()->json(['success' => $success]);
					} //user now seen this page
					else
					{
						$success = "1";
						$cookie = cookie('blockkeeper', '1', 120);
						return response()->json(['success' => $success])->cookie($cookie);
					}
				}
			} //user is not logged in
			else
			{
				$success = "0";// create cooke to delay next request
				$cookie = cookie('blockkeeper', '1', 120);
				return response()->json(['success' => $success])->cookie($cookie);
			}
		}
	}
