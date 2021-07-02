<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Userfund extends Model
{
   //protected $fillable = []
  //protected $guarded = []
	public $timestamps = true;

  //protected table = 'tbl_user';
  //protected $primaryKey = 'user_id';
  
  protected $fillable = ['status','amount','user_id','from_id','to_id'];


  public function user(){
		return $this->belongsTo('\App\User')->select('id', 'name', 'username');
	}

	public function touser(){
		return $this->belongsTo('\App\User','to_id')->select('id',DB::raw('CONCAT(name,"-",username) as name'));
	}

}
