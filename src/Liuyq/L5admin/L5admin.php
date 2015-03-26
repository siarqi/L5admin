<?php

namespace Liuyq\L5admin;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class L5admin extends Eloquent {
	protected $table = 'l5admin_administrators';
	protected $fillable = array('name', 'password', 'status');
}