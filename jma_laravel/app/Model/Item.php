<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class Item extends Model
{	
	protected $table = 'notification_items';
    public $fillable = ['title','description'];
}
