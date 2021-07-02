<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Session\Middleware\StartSession;


use Redirect;
use Validator;
use Input;
use Session;
use Storage;
use File;
use DB;
use Mail;
use Auth;
//use Request;

use App\User;
use App\Rabk;
use App\Branch;
use App\Bank;
use App\Rank;
use App\Deposit;
use App\Userfund;




class ApiUserController extends Controller
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



  
  public function getBalanceForUser()
  {

    $query = User::select('balance')->where(['id'=>Auth::id()])->first();
    $results = $query->toArray();

    $data = [
          'balance' => $results['balance'],
          'coin' => $results['balance'] * 10
        ];
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }


  public function getSelfProfile()
  {

    $queryResult = User::with('bank')->select('name','email','username','contact','profession','district','address','gender','bank_id')->where(['id'=>Auth::id()])->first();
    $results = $queryResult->toArray();
    return response()->json($results,200,[],JSON_PRETTY_PRINT);
  }

  public function putSelfPassword(Request $request)
  {

    $rules  =  array(
      //'current_password' => 'required||min:6',
      'password' => 'required|min:6',
      'confirm_password' => 'required|min:6|max:200|same:password',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $user = User::where(['id' => Auth::id()])->first();
    $name = $user->name;
    $email = $user->email;
    // verifycode
    $verifycode = mt_rand(100000, 999999);
    
    $repaly = self::sendMailToUserForVaryfi($verifycode, $email, $name);
    // verifycode
    
    $ses_arr = [
      'password' => $request->password,
      'verifycode' => $verifycode
    ];
   
    $returndata = ["Please check your email and user varification code to confirm fund transfer",$ses_arr];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }

  public function putSelfPasswordConfirmation(Request $request)
  {
    $rules  =  array(
      'password' => 'required|min:6'
    );

    $affected = DB::table('users')->where('id', Auth::id())->update(['password'=> bcrypt($request['password'])]);

    $returndata = ["Password has been updated successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT); 


  }
  public function putSelfProfile(Request $request)
  {

    $rules  =  array(
      'name' => 'required|max:64',
      'contact' => 'required|max:16',
      'profession' => 'required|max:64',
      'district' => 'required|max:64',
      'gender' => 'required|max:16',
      'address' => 'required|max:256',
    );
    
    $validator = Validator::make( $request->all(),$rules);
    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    //return $request->all();


    $id = Auth::id();
    $result = User::find($id);
    //$result->bank_id = $request->bank;
    $result->name = $request->name;
    $result->contact = $request->contact;
    $result->profession = $request->profession;
    $result->district = $request->district;
    $result->gender = $request->gender;
    $result->address = $request->address;
    $result->save();
    //$affected = DB::table('users')->where('id', Auth::id())->update($request->all());


    $returndata = ["Profile has been updated successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);  
  }


  
  private function sendMailToUserForVaryfi($verifycode,$toemail,$toname){

    $emailInformation = array(
      'from' => 'vizzclub@gmail.com', 
      'from_name' => 'Message For OTP Code',
      'to' => $toemail,
      'to_name' => $toname,
    );

    $msgbody = "
      Hello {$toname} :)  
      Your varification code is {$verifycode}
    ";
    
    Mail::raw($msgbody, function ($message) use ($emailInformation) {
      $message->from($emailInformation['from'], $emailInformation['from_name']);
      $message->to($emailInformation['to'], $emailInformation['to_name']);
      $message->subject('Varification Message For Fund Transferring or Changing Password');
    });


  }



  public function dateWiseUserFundTrnHistory(Request $request)
  {
    $rules  =  array(
      //'user' => 'required',
      //'user_id' => 'required',
      'fdate' => 'required|min:6',
      'todate' => 'required|min:6',
    );
    
    $validator = Validator::make( $request->all(),$rules);
    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    //return $request->all();
    //
    $fdate = $request->fdate;
    $todate = $request->todate;
    $user_id = Auth::id();

    $result = self::AllTypeUserFundTransaction($fdate, $todate, $user_id);

    return response()->json($result, 200,[],JSON_PRETTY_PRINT);

  }
  private function AllTypeUserFundTransaction($fdate,$todate, $user_id){

    $query = Userfund::with('bank')
              ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
              ->where(['user_id'=>$user_id])
              ->orderBy('id','desc')
              ->get();
    return $results = $query->toArray();
  }


  public function getDashboardData()
  {

    

    $query = Userfund::select(DB::raw('SUM(debit) AS debit, SUM(credit) AS credit, SUM(credit - debit) AS balance'))
                         ->where(['user_id'=>Auth::id()])
                         ->first();
    $total_debit = $query->debit;
    $total_credit = $query->credit;
    $balance = $query->balance;

    $result['balance'] = $balance;
    $result['tcredit'] = $total_credit;
    $result['tdebit'] = $total_debit;

    
    return response()->json($result, 200,[],JSON_PRETTY_PRINT);

  }

}
