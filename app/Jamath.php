<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jamath extends Model
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
