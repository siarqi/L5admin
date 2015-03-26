<?php

namespace Liuyq\L5admin;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class L5adminLib {

	public $adminStatus = ['normal'=>1, 'block'=>2];
	public $l5admin;

	public function __construct()
    {

    }

	public function checkLogin() {
        return Session::has('L5adminInfo')?True:False;
	}

	public function loginSuccess($l5admin)
    {
        if($l5admin){
            @Session::forget('L5adminInfo');
            Session::put('L5adminInfo', array('id'=>(string)($l5admin->id), 'name'=>$l5admin->name));
            return True;
        }
        return False;
    }

    public function logout()
    {
        @Session::flush();
        return True;
    }

    public function getL5adminByName($name)
    {
        $this->l5admin = L5admin::where('name', $name)->where('status', $this->adminStatus['normal'])->first();
        return $this;
    }

    public function checkPassword($name, $password)
    {
        $this->getL5adminByName($name);
        if(!empty($this->l5admin))
            return Hash::check($password, $this->l5admin->password);
        else
            return False;
    }

    public function getL5adminInfo()
    {
        if(Session::has('L5adminInfo')){
            return Session::get('L5adminInfo');
        }
        return False;
    }

    public function getFirstL5admin()
    {
    	$l5admin = $this->getL5adminInfo();
        if($l5admin) {
        	$super_l5admin = L5admin::find(1);
        	return $l5admin['name'] == $super_l5admin->name?True:False;
        }
        return False;
    }

}