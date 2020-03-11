<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneBookLog extends Model
{
    //
	public $table 	= 'phonebooklog';
	public $id		= 'id';

	public $fillable = [
		'idFrom',
		'idTo',
		'transaction',
		'status'
	];

	public function from() {
		return $this->hasOne('App\Userspb','id','idFrom');
	}

	public function to() {
		return $this->hasOne('App\Userspb','id','idTo');
	}
}
