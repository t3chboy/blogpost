<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{	
	protected $table = 'post';

     protected $fillable = [
    'title',
    'content',
	'created_by',
	'updated_by'
  ];
}
