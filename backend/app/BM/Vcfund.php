<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vcfund extends Model
{
   //protected $fillable = []
  //protected $guarded = []
	public $timestamps = true;

  //protected table = 'tbl_user';
  //protected $primaryKey = 'user_id';
  
  protected $fillable = ['status','amount','user_id'];

}
