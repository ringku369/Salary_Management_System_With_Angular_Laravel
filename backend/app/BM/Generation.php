<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
   //protected $fillable = []
  //protected $guarded = []
	public $timestamps = true;

  //protected table = 'tbl_user';
  //protected $primaryKey = 'user_id';
  
  protected $fillable = ['my','ta', 'dta','status','rowstatus'];

}
