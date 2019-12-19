<?php

	namespace raplet;

	use Illuminate\Notifications\Notifiable;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Database\Eloquent\Model as Eloquent;


	class User extends Authenticatable
	{
		use Notifiable;

		protected $table = 'users';
        protected $content_type = "0";

		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'name', 'email', 'password',
		];

		/**
		 * The attributes that should be hidden for arrays.
		 *
		 * @var array
		 */
		protected $hidden = [
			'password', 'remember_token',
		];

		public function userprofile()
		{
			return $this->hasOne('raplet\Userprofile');
		}

		public function userstat()
		{
			return $this->hasOne('raplet\Userstat');
		}

		public function votes()
		{
			return $this->hasMany(Vote::class);
		}

		public function comments()
		{
			return $this->hasMany(Comment::class);
		}

		public function posts()
		{
			return $this->hasMany(Post::class);
		}

		public function badges()
		{
			return $this->belongsToMany(Badge::class);
		}

		public function notifications()
		{
			return $this->hasMany(Notifications::class);
		}

		protected $events = [
			'created' => Events\NewUser::class
		];


		public function ownersNotSeenKeeper($query, int $property_id)
		{
			return $query->whereDoesntHave('properties', function ($q) use ($property_id)
			{
				$q->where('properties.id', $property_id);
			});
		}

		public function identities()
		{
			return $this->hasMany(SocialIdentity::class);
		}

	}
