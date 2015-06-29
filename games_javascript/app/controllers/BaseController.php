<?php

class BaseController extends Controller {
	var $indexPacman = '';
	var $indexPuzzle = '';
	
	//DTR
	
	var $viewLogin = '';
	var $changePass = '';
	
	protected $user;
	protected $group;
	
	

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	
	
	public function pacmanIndex(){
		
		/*
		$bookList = $this->bookModel->get();
	
		return View::make($this->indexBook)
		->with('title', 'Index')
		->with('recordList', $bookList);
		*/
		return View::make($this->indexPacman)
		->with('title','pacman');
		
	}
	public function puzzleIndex(){
		return View::make($this->indexPuzzle)
		->with('title','puzzle');
	}
	
	//daily_time_n
	public function  viewLogin(){
		$user = $this->user->get();
		
		return View::make($this->viewLogin)
		->with('title','login_view')
		->with('user' , $user);
		
	}
	public function  changePass(){
		return View::make($this->changePass)
		->with('title','Change_Pass');
		
		//$user = $this->user->find($this->user_id);
		
		

	}
	public function postChangePassword() {
		$validator = Validator::make(Input::all(),
				array(
						'password' 		=> 'required',
						'old_password'	=> 'required|min:6',
						'password_again'=> 'required|same:password'
				)
		);
	
		if($validator->fails()) {
			return Redirect::route('change.pass')
			->withErrors($validator);
		} else {

				// passed validation
			
				// Grab the current user
				$user = User::find(Auth::user()->user_id);
			
				// Get passwords from the user's input
				$old_password 	= Input::get('old_password');
				$password 		= Input::get('password');
			
				// test input password against the existing one
				if(Hash::check($old_password, $user->getAuthPassword())){
					$user->password = Hash::make($password);
			
					// save the new password
					if($user->save()) {
						return Redirect::route('view.login')
						->with('global', 'Your password has been changed.');
					}
				} else {
					return Redirect::route('change.pass')
					->with('global', 'Your old password is incorrect.');
				}
			}
			
			/* fall back */
			return Redirect::route('change.pass')
			->with('global', 'Your password could not be changed.');
			
		}
	
	
	
}
