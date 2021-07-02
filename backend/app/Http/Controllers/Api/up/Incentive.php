<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Incentive extends Model
{
   //protected $fillable = []
  //protected $guarded = []
	public $timestamps = true;

  //protected table = 'tbl_user';
  //protected $primaryKey = 'user_id';
  
  protected $fillable = ['user_id','userrank_id','bmcount','amount'];

	

}
