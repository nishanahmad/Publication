<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Majlis extends Model
{
	protected $fillable = ['name'];
	
	public function getName()
	{
		return $this->name;
	}

	public function members()
	{
		return $this->hasMany('App\Member', 'id');
	}
}
