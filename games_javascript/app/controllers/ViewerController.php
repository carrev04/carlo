<?php

class ViewerController extends BaseController {

	var $viewLogin = 'DTR.time_view';
	var $changePass = 'DTR.change_pass';
	
	public function __construct(User $user)
	{
		//MODEL 	
		$this->user  = $user;
	
		$this->user_id = (Auth::check()) ? Auth::user()->user_id : '';
	}
	
}
