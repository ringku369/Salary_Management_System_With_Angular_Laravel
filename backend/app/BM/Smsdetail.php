<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;



class Smsdetail extends Model
{
   //protected $fillable = []
  //protected $guarded = []
	public $timestamps = true;

  //protected table = 'tbl_user';
  //protected $primaryKey = 'user_id';
    
  protected $fillable = ['imei','product_id','brand_id','promo_id','promodetail_id','user_id','sno','wperiod','remarks','status','created_at','updated_at','mobile','isdw','dwday','dwcharge','twperiod'];
  //protected $guarded = [];

  public function user(){
    return $this->belongsTo('\App\User')->select('id','firstname','officeid');
  }

  public function replace(){
    return $this->hasMany('\App\Replace')->select('id','smsdetail_id','imei','sno',DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as rplsdate'));
  }

  public function brand(){
    return $this->belongsTo('\App\Brand')->select('id','name');
  }

  public function product(){
    return $this->belongsTo('\App\Product')->select('id','name','model');
  }

  public function promo(){
    return $this->belongsTo('\App\Promo')->select('id',DB::raw('DATE_FORMAT(sdate,"%m/%d/%Y") as sdate,DATE_FORMAT(edate,"%m/%d/%Y") as edate'));
  }

  public function promodetail(){
    return $this->belongsTo('\App\Promodetail')->select('id','details',DB::raw('DATE_FORMAT(sdate,"%m/%d/%Y") as sdate,DATE_FORMAT(edate,"%m/%d/%Y") as edate'));
  }



}
