<?php

	namespace raplet\Http\Controllers;

	use Cocur\Slugify\Slugify;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Cookie;
	use Laravel\Socialite\Facades\Socialite;
	use raplet\SocialIdentity;
	use raplet\User;
	use raplet\Userprofile;
	use raplet\Userstat;


	class SocialAuthController extends Controller
	{

		public function redirect_to_provider($provider)
		{
			return Socialite::driver($provider)->redirect();
		}

		public function handle_provider_callback($provider)
		{
			$url = url()->previous();
			try
			{
				$user = Socialite::driver($provider)->user();
			}
			catch (\Exception $e)
			{
				// todo handle exception when registration is not successful.
				 return response()->json($this->invalid_request());
			}

			$authUser = $this->findOrCreateUser($user, $provider);
			Auth::login($authUser, true);

			return redirect($url);
			//todo redirect user back where it was
		}


		public function findOrCreateUser($providerUser, $provider)
		{
			$account = SocialIdentity::where('provider_name', $provider)
				->where('provider_id', $providerUser->id)
				->first();

			if ($account)
			{
				return $account->user;
			}
			else
			{
				$user = User::where('email', $providerUser->email)->first();

				if (!$user)
				{
					if (Cookie::get('lang_id') != null)
					{
						$user = User::create([
							'email' => $providerUser->email,
							'name' => $providerUser->name,
							'password' => str_random(40)
						]);

						// ======================== User detail objects =========================
						//=======================================================================

						// ================== User Slug & avatar preparation ====================
						$user_slug = new Slugify();
						$slug = $user_slug->slugify($providerUser->name);

						$slug_check = Userprofile::where('slug', $slug)->exists();
						while ($slug_check)
						{
							$slug = $slug . $user->id;
							$slug_check = Userprofile::where('slug', $slug)->exists();
						}

						$fileContents = file_get_contents($providerUser->getAvatar());
						$file_name_to_store = $slug . $user->id . ".jpg";
						file_put_contents('storage/profile/' . $file_name_to_store, $fileContents);
						// ---------------- User Slug & avatar preparation end -----------------

						//================== Userprofile =====================
						Userprofile::create([
							'user_id' => $user->id,
							'userImg' => $file_name_to_store,
							'slug' => $slug,
							'name' => $providerUser->name,
							'bio' => '0',
						]);
						//todo Location should be added to userprofile

						//================== Userstat =====================
						Userstat::create([
							'user_id' => $user->id,
						]);

						//============ User social identity ===============
						//Create a new identity for the newly created user
						$user->identities()->create([
							'provider_id' => $providerUser->id,
							'provider_name' => $provider,
						]);

					}
					else
					{
						// todo inform user to allow cookies, otherwise we can not register it
						 return response()->json($this->invalid_request());
					}
				}


				return $user;
			}
		}
	}
