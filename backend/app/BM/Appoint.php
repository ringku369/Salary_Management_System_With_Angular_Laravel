<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appoint extends Model
{
  
  //protected $fillable = []
  //protected $guarded = []
	public $timestamps = true;

  //protected table = 'tbl_user';
  //protected $primaryKey = 'user_id';
  
  protected $fillable = ['schedule_id','time','stime','sdate','status','name','email','contact','dob','note','carrier','iid'];




}
