<?php

	namespace raplet\Http\Controllers;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Cookie;
	use raplet\Http\Controllers\Controller;
	use raplet\Keeper;
	use raplet\Userprofile;
	use Illuminate\Support\Facades\DB;


	class UnAuthedController extends Controller
	{
		public function messageUnAuthed()
		{

			$userlastkeeper = DB::table('keeper_user')->where('user_ip', request()->ip())->orderBy('id', 'desc')->first();


			//this function handles only none logged in users
			$doesNeed = [0];
			$keeperType = [0, 1, 4];
			if (Cookie::get('lang_id') !== null) {
				$langID = Cookie::get('lang_id');
			} else {
				$langID = "2";
			}
			// getting the last keeper viewed by the visiting user

			//Visitor has seen some keepers before
			if ($userlastkeeper != null) {

				//check for the cookie
				if (Cookie::get('blockkeeper') !== null) {
					$success = "blocker cookie is blocking";// create cooke to delay next request
					$cookie = cookie('blockkeeper', '1', 120);
					return response()->json(['success' => $success])->cookie($cookie);
				} //check for the last database
				elseif (strtotime($userlastkeeper->created_at) > strtotime('-2 hours')) {
					$success = "0";// create cooke to delay next request
					$cookie = cookie('blockkeeper', '1', 120);
					return response()->json(['success' => $success])->cookie($cookie);
				}


				$finite = Keeper::where('status', '1')->whereIn('type', $keeperType)->whereIn('user_type', $doesNeed)->orderBy('id', 'desc')->first();

				// Checking to see if the last seen keeper is different than the last keeper of website
				if ($userlastkeeper->keeper_id < $finite->id) {
					$seenKeepers = DB::table('keeper_user')->where('user_ip', request()->ip())
						->pluck('keeper_id')->toArray();

					$notSeenKeepers = Keeper::whereNotIn('id', $seenKeepers)
						->whereIn('user_type', $doesNeed)->whereIn('type', $keeperType)->orderBy('id', 'asc')->first();

					if ($notSeenKeepers != null) {
						// get the keeper content in the native language
						$nativeKeeper = $notSeenKeepers->transspecific($langID);
						// NOT SEEN -> right join -> NATIVE
					} else {
						$nativeKeeper = null;
					}
					$success = "1";
					return response()->json(['notSeenKeepers' => $notSeenKeepers, 'nativeKeeper' => $nativeKeeper, "success" => $success]);
				}
				else{
					return null;
				}
			} //if visitor have not seen any keeper before we enter here
			else {
				$notSeenKeepers = Keeper::whereIn('user_type', $doesNeed)->orderBy('id', 'asc')->first();

				if ($notSeenKeepers != null) {
					// get the keeper content in the native language
					$nativeKeeper = $notSeenKeepers->transspecific($langID);
					$success = "1";
				} else {
					$success = "2";
					$notSeenKeepers = null;
					$nativeKeeper = null;
				}
				return response()->json(['notSeenKeepers' => $notSeenKeepers, 'nativeKeeper' => $nativeKeeper, "success" => $success]);
			}
		}

		public function visitorseekeeper(Request $request)
		{
			if (Auth::check()) {
				$success = "0";// create cooke to delay next request
				$cookie = cookie('blockkeeper', '1', 120);
				return response()->json(['success' => $success])->cookie($cookie);
			} //user is not logged in
			else {
				$userIP = request()->ip();
				$keeper = DB::table('keepers')->where('id', $request['viewedkeeper'])->first();
				$isitseen = DB::table('keeper_user')->where("keeper_id", $request['viewedkeeper'])
					->where("user_ip", $userIP)->first();

				//keeper doesn't excise or  user has already seen this keeper
				if ($isitseen != null && $keeper == null) {
					$success = "0";// create cooke to delay next request
					$cookie = cookie('blockkeeper', '1', 120);
					return response()->json(['success' => $success])->cookie($cookie);
				} //everything is according to the plan, insert new keeper - user relationship
				else {
					$timestamp = now();
					$userseenthekeeper = DB::table('keeper_user')->insert(
						['user_id' => "1", 'keeper_id' => $request['viewedkeeper'], 'user_ip' => $userIP, 'created_at' => $timestamp]
					);

					//inserting into db was not successful
					if (!$userseenthekeeper) {
						$success = "2";
						return response()->json(['success' => $success]);
					} //user now seen this page
					else {
						$success = "1";// create cooke to delay next request
						$cookie = cookie('blockkeeper', '1', 120);
						return response()->json(['success' => $success])->cookie($cookie);
					}
				}
			}

		}
	}
