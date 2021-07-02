<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Profit extends Model
{
   //protected $fillable = []
  //protected $guarded = []
	public $timestamps = true;

  //protected table = 'tbl_user';
  //protected $primaryKey = 'user_id';
  
  protected $fillable = ['ds_id','ids_id','child_id','mt_id','status','amount','user_id','to_id'];

	public function user(){
		return $this->belongsTo('\App\User')->select('id', 'name', 'username');
	}

	public function dsponsor(){
		return $this->belongsTo('\App\User','ds_id')->select('id',DB::raw('CONCAT(name,"-",username) as name'));
	}

	public function idsponsor(){
		return $this->belongsTo('\App\User','ids_id')->select('id',DB::raw('CONCAT(name,"-",username) as name'));
	}

	public function child(){
		return $this->belongsTo('\App\User','child_id')->select('id',DB::raw('CONCAT(name,"-",username) as name'));
	}

	public function match(){
		return $this->belongsTo('\App\User','mt_id')->select('id',DB::raw('CONCAT(name,"-",username) as name'));
	}

	public function fund(){
		return $this->belongsTo('\App\User','to_id')->select('id',DB::raw('CONCAT(name,"-",username) as name'));
	}

}
