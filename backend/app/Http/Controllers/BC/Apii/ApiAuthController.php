<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;


use Redirect;
use Validator;
use Input;
use Session;
use Storage;
use File;
use DB;
use Mail;
//use Request;

use App\User;
use App\Schedule;
use App\Appoint;
use App\Userrank;




class ApiAuthController extends Controller
{
    
  public function __construct()
  {
    //date_default_timezone_set('America/New_York');
    //$this->middleware('auth:api', ['except' => ['login','test']]);
  }



  public function test()
  {
    return "This is test";
    //return route('api.login');
  }

  public function getRank(){
    $user = User::find(Auth::id());
    $user = User::with('userrank')->where('id',Auth::id())->first();
    $rank = $user['userrank']->name;
    return response()->json($rank,200,[],JSON_PRETTY_PRINT);
  }


  public function login(Request $request)
  {
    //return $request->all();
    
    $rules  =  array(
      'username' => 'required',
      'password' => 'required|min:1|max:50'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }



    $credentials1 = ['username'=> $request['username'],'password'=> $request['password'],'level' => 1000,'active' => 1];
    $credentials2 = ['username'=> $request['username'],'password'=> $request['password'],'level' => 500,'active' => 1];
    $credentials3 = ['username'=> $request['username'],'password'=> $request['password'],'level' => 100,'active' => 1];
    //$credentials4 = ['officeid'=> $request['username'],'password'=> $request['password'],'level' => 200,'active' => 1];

    if ($token = auth()->claims(['role'=>'Superadmin'])->attempt($credentials1)) {
      return $this->respondWithToken($token);
    }elseif($token = auth()->claims(['role'=>'Admin'])->attempt($credentials2)){
      return $this->respondWithToken($token);
    }elseif($token = auth()->claims(['role'=>'User'])->attempt($credentials3)){
      return $this->respondWithToken($token);
    }else {
      $returndata = ["username or password does not match, pls try again"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }
  }


  public function loginwithparameter($credentials)
  {
    if (! $token = auth()->attempt($credentials)) {
      $returndata = ["username or password does not match, pls try again"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
      //return response()->json(['error' => 'Wrong email or password, pls try again'], 400);
    }

    return $this->respondWithToken($token);
  }


  public function me()
  {
    $token = JWTAuth::getToken(); 
    $payload = JWTAuth::decode($token);

    return response()->json($payload);
    return response()->json(auth()->user());
  }


  public function logout()
  {
    auth()->logout();
    return response()->json(['message' => 'Successfully logged out']);
  }


  public function refresh()
  {
    return $this->respondWithToken(auth()->refresh());
  }


  protected function respondWithToken($token)
  {
    /*$userinfo = [
      'name' => auth()->user()->firstname . " " . auth()->user()->lastname,
      'email' => auth()->user()->email
    ];*/


    $user = User::find(Auth::id());

    $user = User::with('userrank')->where('id',Auth::id())->first();

    $rank = $user['userrank']->name;


    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      //'name' => auth()->user()->firstname . " " . auth()->user()->lastname,
      'name' => auth()->user()->name,
      'email' => auth()->user()->email,
      'username' => auth()->user()->username,
      'role' => [auth()->user()->role],
      'rank' => $rank,
      'balance' => auth()->user()->balance,
      'coin' => auth()->user()->balance * 10,
      'expires_in' => auth()->factory()->getTTL() * 524160 // min //  1440 min = 1 day, 524160 min = 364 day
    ]);
  }


  public function payload()
  {
    return auth()->payload();
  }



  public function authtestpost(Request $request)
  { 
    return $request->all();
    //return response()->json($request->email,200,[],JSON_PRETTY_PRINT);
  }



  public function userpasswordchange(Request $request)
  {

    $rules  =  array(
      'password' => 'required|min:3|max:50',
      'confirm_password' => 'required|min:3|max:50|same:password'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $udata['rawpassword'] = $request['password'];
    $udata['password'] = bcrypt($request['password']);

    $queryResult = DB::table('users')->where('id', auth()->user()->id)->update($udata);

    if ($queryResult > 0) {
      //$returndata['success'] = "Password has been changed successfully";
      //return response()->json($returndata,200);

      $returndata = ["Password has been changed successfully"];
      return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

    } else {
      $returndata = ["Something went wrong"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    return $queryResult;
  }



  public function userdetailsupdate(Request $request){
    $rules  =  array(
        'firstname' => 'required|min:2|max:35',
        'lastname' => 'required|min:2|max:35',
        //'email' => 'required|email',
        'contact' => 'required|min:11',
        'address' => 'required',
        'district_id' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $request = $request->except(['level']);
    $request = $request->except(['password']);
    $request = $request->except(['email']);
    $request['officeid'] = $request['contact'];
    $queryResult = User::where('id', Auth::id())->update($request);

    if ($queryResult > 0) {
      $returndata = ["User information has been updated successfully"];
      return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

    } else {
      $returndata = ["Something went wrong"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

  }



  public function userdetails(){
    //http://localhost:8012/php/angular&laravel/randr/backend/api/login
    //http://localhost:8012/php/Angular&Laravel/randr/backend/api/login
    //return Auth::id(); 

    $query = User::where('id',Auth::id())->first();
    $queryResult = $query->toArray();
    return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }

  public function getappointeditems(){
    
    $query = Appoint::select('name','email','contact','carrier','iid','stime','note',DB::raw('DATE_FORMAT(sdate,"%m-%d-%Y") as sdate, DATE_FORMAT(dob,"%D %b %Y") as dob'))
                  ->where(['status'=>1, 'sdate'=>date('Y-m-d')])
                  ->orderBy('time', 'asc')
                  ->get();

    $queryResult = $query->toArray();
    return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }

  public function cancelappointeitem(Request $request){
    $rules  =  array(
      'id' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);
    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $Appointupdate = Appoint::find($request['id']);
    $Appointupdate->status = 0;
    $Appointupdate->save();

    $returndata['success'] = ["This item has been canceled successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
  }

  public function deleteappointeitem(Request $request){
    $rules  =  array(
      'id' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);
    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $count = Appoint::where(['id'=>$request['id']])->count();

    if ($count == 0)
    {
      $returndata = ["There is no item with this request"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $queryResult = DB::table('appoints')->where(['id'=>$request['id']])->delete();
    if ($queryResult > 0) {
      $returndata['success'] = ["This product has been deleted successfully"];
      return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

    }
  }

  public function getappointeitemwithdate(Request $request){
    $rules  =  array(
      'fdp' => 'required',
      'tdp' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);
    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $fdparray = $request['fdp'];
    $fdp = $fdparray['year']. "-".$fdparray['month']. "-".$fdparray['day'];

    $tdparray = $request['tdp'];
    $tdp = $tdparray['year']. "-".$tdparray['month']. "-".$tdparray['day'];


    $query = Appoint::select('name','email','contact','carrier','iid','stime','note',DB::raw('DATE_FORMAT(sdate,"%m-%d-%Y") as sdate, DATE_FORMAT(dob,"%D %b %Y") as dob'))
                      ->where(['status'=>1])
                      ->whereBetween('sdate',[$fdp,$tdp])
                      //->orderBy('time', 'asc')
                      ->orderBy('sdate', 'asc')
                      ->get();

    $queryResult = $query->toArray();
    return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);


    // //$returndata['success'] = ["Congratulations ! Booking Confirmation Successfully Placed"];
    // $returndata['success'] = [$fdp, $tdp];
    // return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }







}
