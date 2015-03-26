<?php

namespace Liuyq\L5admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class L5adminController extends Controller
{
	public function aaa()
	{
		return 'aaa';
	}

	public function L5AdminLogin(){
		$data['url'] = Input::get('url');
		return view('login')->with($data);
	}

	public function L5AdminList(){
		$data['l5admin'] = L5admin::select('id','name','password','created_at')->where('status',1)->get();
		return view('list')->with($data);
	}

	public function L5AdminAdd(){
		return view('add');
	}

	public function L5AdminAddPost(){
		$validator = Validator::make(Input::all(),
			array('name'=>'required',
				  'password'=>'required'
				  ),
			array('name.required'=>'管理员名称不能为空',
				  'password.required'=>'密码不能为空'
				  ));
		if($validator->fails()) {
			return redirect('l5adminadd')
				   ->withErrors($validator)
				   ->withInput(Input::except('password'));
		}
		$name = Input::get('name');
		$password = Input::get('password');
		L5admin::create(array(
			'name'=>$name,
			'password'=>Hash::make($password),
			'status'=>1
		));
		return redirect(route('l5admin.list'));
	}

	public function L5AdminUpdate($id){
		$data['l5admin'] = L5admin::select('id','name','password')->where('id',$id)->where('status',1)->first();
		return view('update')->with($data);
	}

	public function L5AdminUpdatePost(){
		$id = Input::get('id');
		$validator = Validator::make(Input::all(),
			array('password'=>'required'),
			array('password.required'=>'密码不能为空'));
		if($validator->fails()) {
			return redirect(route('l5admin.update,$id')->withErrors($validator));
		}
		$password = Input::get('password');
		$l5admin = L5admin::where('id',$id)->where('status',1)->update(array('password'=>Hash::make($password)));
		return redirect(route('l5admin.list'));
	}

	public function L5AdminDel(){
		$l5adminId = Input::get('id');
		if(1 == $l5adminId){
			return response()->json('error'); 
		}
		$l5admin = L5admin::where('id',$l5adminId)->where('status',1)->update(array('status'=>2));
		return response()->json('success');
	}

	public function L5AdminLoginPost(){
		$validator = Validator::make(Input::all(),
		array('name'=>'required',
			  'password'=>'required'
			  ),
		array('name.required'=>'管理员名称不能为空',
			  'password.required'=>'密码不能为空'
			  ));
		if($validator->fails()) {
			return redirect(route('l5admin.login')
					->withErrors($validator)
					->withInput(Input::except('password')));
		}

		$name = Input::get('name');
		$password = Input::get('password');
		$l5adminlib = new L5adminLib;

		if(!$l5adminlib->checkPassword($name, $password)) {
			$error = array('password'=>'管理员名称或密码错误');
			return redirect(route('l5admin.login'))
				->withErrors($error)
				->withInput(Input::except('password'));
		}

		$l5adminlib->getL5adminByName($name);
		$l5adminlib->loginSuccess($l5adminlib->l5admin);
		$url = Input::get('url');

		return redirect($url);
	}

	public function L5AdminLogout(){
		$l5adminlib = new L5adminLib;
		$l5adminlib->logout();
		return redirect(route('l5admin.login'));
	}


}