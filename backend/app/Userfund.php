<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userfund extends Model
{
   //protected $fillable = []
  //protected $guarded = []
	public $timestamps = true;

  //protected table = 'tbl_user';
  //protected $primaryKey = 'user_id';
  
  protected $fillable = ['user_id','debit','credit','balance','bank_id','remarks','status','isuser'];

  public function user(){
    //return $this->hasMany('\App\Product');
    return $this->belongsTo('\App\User')->select('name','id');
	}

  public function bank(){
    //return $this->hasMany('\App\Product');
    return $this->belongsTo('\App\Bank')->select('name','id');
	}
}
