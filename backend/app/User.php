<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Kalnoy\Nestedset\NodeTrait;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use NodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = true;
    protected $fillable = [
        'name', 'email', 'password','parent_id','remember_token','level','role','gender','bank_id','rank_id','acno','type',
        'refer_id','position','ismatch','status','contact','username','isposition','district','address','profession'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'email_verified_at' => 'datetime',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
      return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
      return [];
    }


    public function bank(){
        //return $this->hasMany('\App\Product');
        return $this->belongsTo('\App\Bank')->with('branch')->select('name','id','branch_id');
    }

    public function rank(){
        //return $this->hasMany('\App\Product');
        return $this->belongsTo('\App\Rank')->select('name','id','salary');
    }
}
