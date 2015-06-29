<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';

	/**
	 * The primary used by the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'user_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public static $shippingInformationRules = [
	'address_1' 	=> 'required|max:1000',
	'city' 			=> 'required|max:32',
	'mobile_number'	=> 'required|max:20',
	'zip_code'		=> 'required|max:6',
	'state_region'	=> 'required'
			];


	public static $changePasswordRules = [
	'password' => 'required|max:128|'
			];

	public static $closeAccountRules = [
	'close_account' => 'required|accepted'
			];

	public static function getVerificationToken($token)
	{
		return User::where('email_verification_token','=', $token)
		->select('user_id','email_verification_token')
		->first();

	}

	public function activate($token)
	{
		if($this->email_verification_token == $token)
		{
			$this->status = 'Verified';
			$this->is_activated = 1;
			$this->email_verification_token = NULL;
			$this->email_verification_token_expiration = NULL;
			if($this->save()){
				return true;
			}
			throw new \RuntimeException('Saving to database failed.');
		}

		return false;
	}

	public function watchLists()
	{
		return $this->hasMany('WatchList');
	}

	public function isWatchListed($id)
	{
		$isWatch = $this->watchLists()->where('auction_id', $id)->count();
		if($isWatch == 1){
			return true;
		}
		return false;
	}

	public function removeWatchList($id)
	{
		$watchList = $this->watchLists()->where('auction_id', $id);

		if($watchList->delete()){
			return true;
		}
		return false;

	}

	// --------------------------------------------------------------------

	public static function getOnline()
	{
		$rows = User::where('status', '=', 'Verified')
		->where('user_type', 'user')
		->where('is_activated', 1)
		->where('is_online', 'Yes')->get();
			
		return $rows;
	}


	// --------------------------------------------------------------------

	public static function isUser()
	{
		if(Auth::check()) {
			$id = Auth::user()->user_id;
			return (User::find($id)->user_type == 'user') ? TRUE : FALSE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	public static function getPicture($user_id ='')
	{
		$dir = 'uploads/images/user/';

		$user_id = ($user_id) ? $user_id : Auth::user()->user_id;

		$user = User::find($user_id);

		if(file_exists($dir.$user_id.'.jpg')) {
			$img = Request::root().'/'.$dir.$user_id.'.jpg';
		} else {
			$img = Request::root().'/'.$dir.'avatar.png';
		}

		return $img;
	}

	// --------------------------------------------------------------------
	public function selectUserByEmail($email)
	{
		return User::where('email', $email)->first();
	}

	public function selectUserByUsername($username)
	{
		return User::where('username', $username)->first();
	}


	public function updateUserPasswordByUsername($username, $password)
	{
		return User::where('username', $username)->update(array('password' => Hash::make($password)));
	}

}


