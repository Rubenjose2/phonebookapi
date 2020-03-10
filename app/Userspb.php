<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userspb extends Model
{
    public $table = 'userspb';
    public $index = 'id';

    public $fillable = [
    	'fullName',
		'address',
		'phoneNumber',
		'email',
		'status'
	];
}
