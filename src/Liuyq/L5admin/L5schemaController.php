<?php

namespace Liuyq\L5admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Liuyq\L5admin\L5admin;

class L5schemaController extends Controller
{

	public function up()
	{
		Schema::create('l5admin_administrators', function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name', 255);
			$table->string('password', 255);
			$table->integer('status');
			$table->timestamps();
		});

		L5admin::create(array(
			'name'=>'admin',
			'password'=>Hash::make('123'),
			'status'=>1
		));

		return 'ctb ok';
	}

	public function down()
	{
		Schema::dropIfExists('l5admin_administrators');
	}
	
}
