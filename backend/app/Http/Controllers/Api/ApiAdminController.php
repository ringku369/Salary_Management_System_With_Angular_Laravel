<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Tmyon\JWTAuth\Facades\JWTAuth;

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





class ApiAdminController extends Controller
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

  public function getBranchForDD()
  {
    $query = Branch::select('id','name')->orderBy('id','asc')->get();
    $queryResult = $query->toArray();

    $data[] = [
      'value' => '0',
      'label' => 'Please Select Branch'
    ];
    foreach ($queryResult as $key => $value) {
      
      $data[] = [
        'value' => (string)$value['id'],
        'label' => $value['name']
      ];
    }
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }

  
  public function getBankForDD()
  {
    $query = Bank::select('id','name')->orderBy('id','asc')->get();
    $queryResult = $query->toArray();

    $data[] = [
      'value' => '0',
      'label' => 'Please Select Bank'
    ];
    foreach ($queryResult as $key => $value) {
      
      $data[] = [
        'value' => (string)$value['id'],
        'label' => $value['name']
      ];
    }
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }

  public function getRankForDD()
  {
    $query = Rank::select('id','name')->where('level','<=',6)->orderBy('id','asc')->get();
    $queryResult = $query->toArray();

    $data[] = [
      'value' => '0',
      'label' => 'Please Select Rank'
    ];
    foreach ($queryResult as $key => $value) {
      
      $data[] = [
        'value' => (string)$value['id'],
        'label' => $value['name']
      ];
    }
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }

  public function getUserForDD()
  {
    $query = User::select('id','name')->where('level',100)->orderBy('id','asc')->get();
    $queryResult = $query->toArray();

    $data[] = [
      'value' => '0',
      'label' => 'Please Select User'
    ];
    foreach ($queryResult as $key => $value) {
      
      $data[] = [
        'value' => (string)$value['id'],
        'label' => $value['name']
      ];
    }
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }

  


  // Rank crud area
  public function getRank()
  {

    $query = Rank::where(['status'=>1])->orderBy('id','asc')->get();
    $results = $query->toArray();

    return response()->json($results,200,[],JSON_PRETTY_PRINT);
  }

  public function createRank(Request $request)
  {
    $rules  =  array(
      'basic' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $basic = $request->basic;
    self::lastRankUpdate($basic);
    self::allRankUpdate();
    
    $returndata = ["Rank has been created successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT); 
  }



  private function allRankUpdate(){
    $query = Rank::select('id', 'level')->where(['status'=>1])->orderBy('id','desc')->get();
    $results = $query->toArray();

    foreach ($results as $key=>$value) {
      //$id = $value['id'];
      $level = $value['level'];

      $query = Rank::where(['level'=>$level])->first();
      $rank = $query->toArray();
      $basic = $rank['basic'];
      $basic = $basic + 5000;


      $rentv = ($basic*20)/100;
      $medicalv = ($basic*15)/100;
      $total = $basic + $rentv + $medicalv;

      $id = $level - 1;

      if ($id > 0 ) {
        $rank = Rank::find($id);
        $rank->basic = $basic;
        $rank->hrent = $rentv;
        $rank->medical = $medicalv;

        $rank->salary = $total;
        $rank->save();
      }

    }
  }

  private function lastRankUpdate($basic){
    $query = Rank::where(['level'=>6])->first();
    $results = $query->toArray();
    $id = $results['id'];


    $rentv = ($basic*20)/100;
    $medicalv = ($basic*15)/100;

    $total = $basic + $rentv + $medicalv;

    $rank = Rank::find($id);
    $rank->basic = $basic;
    $rank->hrent = $rentv;
    $rank->medical = $medicalv;

    $rank->salary = $total;
    $rank->save();
  }


  public function updateRank(Request $request)
  {
    $rules  =  array(
      'id' => 'required',
      'name' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $id = $request->get('id');
    $result = Rank::find($id);
    $result->name = $request->name;
    $result->save();
    //$update['name'] = $request->name;
    //$affected = DB::table('rankes')->where(['id'=>$request->id])->update($update);

    $returndata = ["Rank has been update successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }


  public function deleteRank($id)
  {
    $result = Rank::find($id);
    if ($result === null)
    {
      $returndata = ["There is no rank with this id"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = User::where('rank_id', $id)->count();

    if ($count > 0)
    {
      $returndata = ["This data can not be deleted due to related with other data"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $result->delete();
    //$affected = DB::table('rankes')->where(['id'=>$request->id])->delete();
    $returndata = ["Congratulations ! Data has been deleted successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
    
  }

  // Rank crud area

  // Branch crud area
  public function getBranch()
  {

    $query = Branch::orderBy('id','desc')->get();
    $results = $query->toArray();

    return response()->json($results,200,[],JSON_PRETTY_PRINT);
  }

  public function createBranch(Request $request)
  {
    $rules  =  array(
      'name' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $branch = Branch::create($request->all());
    $returndata = ["Branch has been created successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT); 
  }

  public function updateBranch(Request $request)
  {
    $rules  =  array(
      'id' => 'required',
      'name' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $id = $request->get('id');
    $result = Branch::find($id);
    $result->name = $request->name;
    $result->save();
    //$update['name'] = $request->name;
    //$affected = DB::table('branches')->where(['id'=>$request->id])->update($update);

    $returndata = ["Branch has been update successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }


  public function deleteBranch($id)
  {
    $result = Branch::find($id);
    if ($result === null)
    {
      $returndata = ["There is no branch with this id"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = Bank::where('branch_id', $id)->count();

    if ($count > 0)
    {
      $returndata = ["This data can not be deleted due to related with other data"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $result->delete();
    //$affected = DB::table('branches')->where(['id'=>$request->id])->delete();
    $returndata = ["Congratulations ! Data has been deleted successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
    
  }

  // Branch crud area


  // Bank crud area
  public function getBank()
  {

    $query = Bank::with('branch')->orderBy('id','desc')->get();
    $results = $query->toArray();

    return response()->json($results,200,[],JSON_PRETTY_PRINT);
  }

  public function createBank(Request $request)
  {

    //return $request->all();


    $rules  =  array(
      'branch' => 'required',
      'branch_id' => 'required',
      //'type' => 'required',
      'name' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $bank = Bank::create($request->all());
    if (@$bank->id) {
      $returndata = ["Bank has been created successfully"];
      return response()->json($returndata, 200,[],JSON_PRETTY_PRINT); 
    }else {
      $returndata = ["Something wend wrong !! please try again"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }


  }


  public function updateBank(Request $request)
  {
    $rules  =  array(
      'id' => 'required',
      'name' => 'required',
      'branch' => 'required',
      //'type' => 'required',
      'branch_id' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $id = $request->get('id');
    $result = Bank::find($id);
    $result->branch_id = $request->branch;
    //$result->type = $request->type;
    $result->name = $request->name;
    $result->save();
    //$update['name'] = $request->name;
    //$affected = DB::table('branches')->where(['id'=>$request->id])->update($update);

    $returndata = ["Bank has been update successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }


  public function deleteBank($id)
  {
    $result = Bank::find($id);
    if ($result === null)
    {
      $returndata = ["There is no branch with this id"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = User::where('bank_id', $id)->count();

    if ($count > 0)
    {
      $returndata = ["This data can not be deleted due to related with other data"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $result->delete();
    //$affected = DB::table('branches')->where(['id'=>$request->id])->delete();
    $returndata = ["Congratulations ! Data has been deleted successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
    
  }


  // Bank crud area




  // User crud area
  public function getUser()
  {

    /*$query = User::with('bank','rank')
      ->select('id','name','email','username','contact','profession','district','address','gender','rank_id','bank_id','balance','created_at','updated_at','acno')

      ->where(['level'=>100])
      ->orderBy('id','desc')
      ->get();
    $results = $query->toArray();*/

      $query = DB::table('users as t1')
                    ->select(
't1.id','t1.name','t1.email','t1.username','t1.contact','t1.profession','t1.district','t1.address','t1.type',
't1.gender','t1.rank_id','t1.bank_id','t1.balance','t1.created_at','t1.updated_at','t1.acno',
't2.name as rank','t3.name as bank','t4.name as branch'

                    )
                    ->join('ranks as t2', 't1.rank_id', '=', 't2.id')
                    ->join('banks as t3', 't1.bank_id', '=', 't3.id')
                    ->join('branches as t4', 't3.branch_id', '=', 't4.id')
                    ->where(['t1.level'=>100])
                    ->orderBy('t1.id','desc')
                    ->get();


    $results = json_decode(json_encode($query), True);

    return response()->json($results,200,[],JSON_PRETTY_PRINT);
  }

  public function createUser(Request $request)
  {

    //return $request->all();


    $rules  =  array(
      'name' => 'required|max:64',
      'email' => 'required|unique:users',
      'password' => 'required|confirmed|min:6',
      'contact' => 'required|max:16',
      'profession' => 'required|max:64',
      'district' => 'required|max:64',
      'gender' => 'required|max:16',
      'address' => 'required|max:256',
      'bank' => 'required',
      'type' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $user = User::select('username')->orderBy('id','desc')->first();
    $ainid = $user->username + 1;
    $username = $ainid;

    $request['roll'] = 'User';
    $request['level'] = 100;
    $request['username'] = $username;
    $request['acno'] = $username * 2;
    $request['bank_id'] = $request->bank;
    $request['rank_id'] = $request->rank;
    $request['type'] = $request->type;
    $request['parent_id'] = Auth::id();
    $request['password'] = bcrypt($request['password']);
    $request['remember_token'] = bcrypt($request['_token']);
    //return $request->all();


    $user = User::create($request->all());
    $returndata = ["User has been created successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT); 


  }


  public function updateUser(Request $request)
  {
    $rules  =  array(
      'id' => 'required',
      'name' => 'required|max:64',
      //'email' => 'required|unique:users',
      'contact' => 'required|max:16',
      'profession' => 'required|max:64',
      'district' => 'required|max:64',
      'gender' => 'required|max:16',
      'address' => 'required|max:256',
      'bank' => 'required',
      'rank' => 'required',
      'type' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $id = $request->get('id');
    $result = User::find($id);
    $result->bank_id = $request->bank;
    $result->rank_id = $request->rank;
    $result->name = $request->name;
    $result->contact = $request->contact;
    $result->profession = $request->profession;
    $result->district = $request->district;
    $result->gender = $request->gender;
    $result->address = $request->address;
    $result->type = $request->type;
    $result->save();
    //$update['name'] = $request->name;
    //$affected = DB::table('users')->where(['id'=>$request->id])->update($update);

    $returndata = ["User has been update successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }


  public function deleteUser($id)
  {
    $result = User::find($id);
    if ($result === null)
    {
      $returndata = ["There is no bank with this id"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = Deposit::where('user_id', $id)->count();

    if ($count > 0)
    {
      $returndata = ["This data can not be deleted due to related with other data"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $result->delete();
    //$affected = DB::table('bankes')->where(['id'=>$request->id])->delete();
    $returndata = ["Congratulations ! Data has been deleted successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
    
  }


  // User crud area




  
  // Deposit crud area
 

  private function DepositExe($request){

    $fn_transaction = function() use ($request)
    {
      try
      {

        $amount = $request['amount'];
        $remarks = $request['remarks'];
        $type = $request['type'];

        $query = User::select('id','bank_id')->where(['id'=>Auth::id()])->first();
        $bank_id = $query->bank_id;

        $count = Deposit::select('id','balance')->count();
        
        $data = [];

if ($type == 'Credit') {
        if ($count > 0) {
          $query = Deposit::select('id','balance')->orderBy('id','desc')->first();
          $balance = $query->balance;

          $data['user_id'] =  Auth::id();
          $data['bank_id'] =  $bank_id;
          $data['status'] =  1;
          $data['remarks'] =  $remarks;
          $data['debit'] =  0;
          $data['credit'] =  $amount;
          $data['balance'] =  $balance + $amount;
        }else{
          $data['user_id'] =  Auth::id();
          $data['bank_id'] =  $bank_id;
          $data['status'] =  1;
          $data['remarks'] =  $remarks;
          $data['debit'] =  0;
          $data['credit'] =  $amount;
          $data['balance'] =  0 + $amount;
        }
}else if($type == 'Debit'){
        if ($count > 0) {
          $query = Deposit::select('id','balance')->orderBy('id','desc')->first();
          $balance = $query->balance;

          $data['user_id'] =  Auth::id();
          $data['bank_id'] =  $bank_id;
          $data['status'] =  2;
          $data['remarks'] =  $remarks;
          $data['debit'] =  $amount;
          $data['credit'] =  0;
          $data['balance'] =  $balance - $amount;
        }else{
          $data['user_id'] =  Auth::id();
          $data['bank_id'] =  $bank_id;
          $data['status'] =  2;
          $data['remarks'] =  $remarks;
          $data['debit'] =  $amount;
          $data['credit'] =  0;
          $data['balance'] =  $balance - $amount;
        }
}

        
        
        $return = Deposit::create($data);
        $balance = $return->balance;
        $user = User::find(Auth::id());
        $user->balance = $balance;
        $user->save();
        // Transection 
      }
      catch(Exception $e)
      {
        return response()->json(['error'=>'Unable to fund transfer'], 400);
      }
    };

    return $return = DB::transaction($fn_transaction);
  }

  
 
  public function getDeposit()
  {

    $query = Deposit::with('bank')->orderBy('id','desc')->get();
    $results = $query->toArray();

    return response()->json($results,200,[],JSON_PRETTY_PRINT);
  }

  public function createDeposit(Request $request)
  {
    $rules  =  array(
      'amount' => 'required',
      'remarks' => 'required',
      'type' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    if ($request->type == 'Debit' || $request->type == 'Credit' ) {
      $returndata = self::DepositExe($request);
    }else{
      $returndata = ["You did something wrong! please try again"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    //return $request->all();

    $returndata = ["Deposit has been created successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT); 
  }

  public function updateDeposit(Request $request)
  {
    $rules  =  array(
      'id' => 'required',
      'name' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $id = $request->get('id');
    $result = Deposit::find($id);
    $result->name = $request->name;
    $result->save();
    //$update['name'] = $request->name;
    //$affected = DB::table('branches')->where(['id'=>$request->id])->update($update);

    $returndata = ["Deposit has been update successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }


  public function deleteDeposit($id)
  {
    $result = Deposit::find($id);
    $amount = $result->credit;
    $request['id'] = $id;
    $request['amount'] = $amount;
    $request['remarks'] = 'Amount Debited';

    $returndata = self::DepositDebitExe($request);


    //$affected = DB::table('branches')->where(['id'=>$request->id])->delete();
    $returndata = ["Congratulations ! Data has been debited same amount successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
    
  }

  // Deposit crud area








  public function getBalanceForAdmin()
  {

    /*$query = User::select('balance')->where(['id'=>Auth::id()])->first();
    $results = $query->toArray();*/


    /*$query = Deposit::select('balance')->where(['id'=>Auth::id()])->orderBy('id','desc')->first();
    $results = $query->toArray();*/

    $query = Deposit::select('balance')->orderBy('id','desc')->first();
    $results = $query->toArray();

    $data = [
          'balance' => $results['balance'],
          'coin' => $results['balance'] * 10
        ];
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }


  public function getUserProfile(Request $request)
  {

    $id = $request->user_id;

    /*$queryResult = User::with('bank','rank')->where(['id'=>Auth::id()])->first();
    $results = $queryResult->toArray();*/


    $query = User::with('bank','rank')
      ->select('id','name','email','username','contact','profession','district','address','gender',
        'rank_id','bank_id','balance','created_at','updated_at','acno','type')
      ->where(['id'=>$id])
      ->orderBy('id','desc')
      ->first();
    $results = $query->toArray();


    return response()->json($results,200,[],JSON_PRETTY_PRINT);
  }
  public function getSelfProfile()
  {

    $queryResult = User::with('bank','rank')->where(['id'=>Auth::id()])->first();
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
      'id' => 'required',
      'name' => 'required|max:64',
      //'email' => 'required|unique:users',
      'contact' => 'required|max:16',
      'profession' => 'required|max:64',
      'district' => 'required|max:64',
      'gender' => 'required|max:16',
      'address' => 'required|max:256',
      'bank' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);
    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $id = $request->get('id');
    $result = User::find($id);
    $result->bank_id = $request->bank;
    $result->name = $request->name;
    $result->contact = $request->contact;
    $result->profession = $request->profession;
    $result->district = $request->district;
    $result->gender = $request->gender;
    $result->address = $request->address;
    $result->save();


    $returndata = ["Profile has been updated successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);  
  }


  public function putSelfEmail(Request $request)
  {

    $rules  =  array(
      'id' => 'required',
      'email' => 'required|email|unique:users',
    );
    
    $validator = Validator::make( $request->all(),$rules);
    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $id = $request->get('id');
    $result = User::find($id);
    $result->email = $request->email;
    $result->save();


    $returndata = ["Profile has been updated successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);  
  }










  // user to user fund trasfer

  public function postFundTrToUser(Request $request)
  {

    $rules  =  array(
      'user' => 'required',
      'user_id' => 'required',
      'amount' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);
    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $user_id = $request['user_id'];
    $count = User::select('id')->where(['id'=>$user_id])->count();

    if ($count < 1) {
      $returndata = ["There is no account with this user id"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }


    if (Auth::id() == $user_id) {
      $returndata = ["You can not fund transer to same account, Try another accounts"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    
    $amount = $request->amount;
    $query = User::select('balance','name','email')->where(['id'=>Auth::id()])->first();
    $balance = $query->balance;
    $name = $query->name;
    $email = $query->email;

    $count = User::where(['id'=>Auth::id()])->where('balance','>=', $amount)->count();
    if ($count < 1) {
      $need = $amount - $balance;
      $returndata = ["You do not have sufficient balance, need more $".$need];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    /*$query = User::select('balance','name','email')->where(['id'=>$user_id])->first();
    $name = $query->name;
    $email = $query->email;
    $balance = $query->balance;
    $from_user_bal = $query->balance;*/
    
    // verifycode
    $verifycode = mt_rand(100000, 999999);
    
    $repaly = self::sendMailToUserForVaryfi($verifycode, $email, $name);
    // verifycode
    
    $ses_arr = [
      'user_id' => $user_id,
      'amount' => $amount,
      'verifycode' => $verifycode,
      'remarks' => $request->remarks
    ];

    /*$request['user_id'] = $user_id;
    $request['amount'] = $amount;
    $request['verifycode'] = $verifycode;
    $request['remarks'] = $request->remarks;

    */
   
   //return self:: postFundTrToUserConfirm($request);

   
    $returndata = ["Please check your email and user varification code to confirm fund transfer",$ses_arr];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }




  public function postFundTrToUserConfirm(Request $request)
  {

    $rules  =  array(
      'verifycode' => 'required',
      'amount' => 'required',
      'user_id' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    $verifycode = $request['verifycode'];
    $returndata = self::DepositDebitExe($request);

    $returndata = ["Fund transfer has been completed successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
  }


  private function DepositDebitExe($request){

    $fn_transaction = function() use ($request)
    {
      try
      {

        $user_id = $request['user_id'];
        $amount = $request['amount'];
        $remarks = "Balance Debited";

        $query = User::select('id','bank_id','balance')->where(['id'=>$user_id])->first();
        $bank_id = $query->bank_id;
        
        $request['bank_id'] = $bank_id;

        $data = [];


        $query = Deposit::select('id','balance','credit')->orderBy('id','desc')->first();
        $balance = $query->balance;

        $data['user_id'] =  $user_id;
        $data['bank_id'] =  $bank_id;
        $data['status'] =  2;
        $data['remarks'] =  $remarks;
        $data['debit'] =  $amount;
        $data['credit'] =  0;
        $data['isuser'] =  1;
        $data['balance'] =  $balance - $amount;


        $return = Deposit::create($data);
        $balance = $return->balance;
        $user = User::find(Auth::id());
        $user->balance = $balance;
        $user->save();

        //self::userFundCredit($request);
      }
      catch(Exception $e)
      {
        return response()->json(['error'=>'Unable to fund transfer'], 400);
      }
    };

    return $return = DB::transaction($fn_transaction);
  }




  private function userFundCredit($request){

    $user_id = $request['user_id'];
    $amount = $request['amount'];
    $bank_id = $request['bank_id'];
    $remarks = "Balance Credited";
    $count = Userfund::select('id','balance')->count();
    $data = [];

    if ($count > 0) {
      $query = Userfund::select('id','balance')->orderBy('id','desc')->first();
      $balance = $query->balance;

      $data['user_id'] =  $user_id;
      $data['bank_id'] =  $bank_id;
      $data['status'] =  1;
      $data['remarks'] =  $remarks;
      $data['debit'] =  0;
      $data['credit'] =  $amount;
      $data['balance'] =  $balance + $amount;
    }else{
      $data['user_id'] =  $user_id;
      $data['bank_id'] =  $bank_id;
      $data['status'] =  1;
      $data['remarks'] =  $remarks;
      $data['debit'] =  0;
      $data['credit'] =  $amount;
      $data['balance'] =  0 + $amount;
    }

    $return = Userfund::create($data);

    $query = Userfund::select(DB::raw('SUM(credit) AS amount'))
                     ->where(['user_id'=>$user_id])
                     ->first();
    $balance = $query->amount;

    $user = User::find($user_id);
    $user->balance = $balance;
    $user->save();

  }

  private function userToUserFTConfirmation($request){
    
    
    
    $fn_transaction = function() use ($request)
      {
        try
        {

          $query = User::select('balance','name','email')->where(['id'=>Auth::id()])->first();
          $name = $query->name;
          $email = $query->email;
          $from_user_bal = $query->balance;

          // Transection 
          $query = User::select('balance')->where(['id'=>$request['user_id']])->first();
          $to_user_bal = $query->balance;
          $to_user_up_bal = $to_user_bal + $request['amount'];
          $from_user_up_bal = $from_user_bal - $request['amount'];

          $affected = DB::table('users')->where('id', Auth::id())->update(['balance' => $from_user_up_bal]);

          $affected = DB::table('users')->where('id', $request['user_id'])->update(['balance' => $to_user_up_bal]);


          $userfund_arr['user_id'] = Auth::id();
          $userfund_arr['from_id'] = Auth::id();
          $userfund_arr['to_id'] = $request['user_id'];
          $userfund_arr['amount'] = $request['amount'];
          $userfund_arr['status'] = 2;
          


          $userfund_arr1['user_id'] = $request['user_id'];
          $userfund_arr1['to_id'] = Auth::id();
          $userfund_arr1['child_id'] = Auth::id();
          $userfund_arr1['amount'] = $request['amount'];
          $userfund_arr1['status'] = 6;
          $userfund_arr1['iscount'] = 1;
          Userfund::create($userfund_arr);
          Profit::create($userfund_arr1);

          // Transection 
        }
        catch(Exception $e)
        {
          return response()->json(['error'=>'Unable to fund transfer'], 400);
        }
      };

      return $return = DB::transaction($fn_transaction);


  }

  // user to user fund trasfer




  public function dateWiseFundTrnHistory(Request $request)
  {
    $rules  =  array(
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

    $result = self::AllTypeFundTransaction($fdate, $todate);

    return response()->json($result, 200,[],JSON_PRETTY_PRINT);

  }
  private function AllTypeFundTransaction($fdate,$todate){

    $query = Deposit::with('bank')
              ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
              ->orderBy('id','asc')
              ->get();
    return $results = $query->toArray();
  }

  public function dateWiseUserFundTrnHistory(Request $request)
  {
    $rules  =  array(
      'user' => 'required',
      'user_id' => 'required',
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
    $user_id = $request->user_id;

    $result = self::AllTypeUserFundTransaction($fdate, $todate, $user_id);

    return response()->json($result, 200,[],JSON_PRETTY_PRINT);

  }
  private function AllTypeUserFundTransaction($fdate,$todate, $user_id){

    $query = Userfund::with('bank')
              ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
              ->where(['user_id'=>$user_id])
              ->orderBy('id','asc')
              ->get();
    return $results = $query->toArray();
  }


  
  
  public function dateWiseEmployeeHistory(Request $request)
  {
    $rules  =  array(
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

    $result = self::GetAllEmployee($fdate, $todate, Auth::id());

    return response()->json($result, 200,[],JSON_PRETTY_PRINT);

  }


    private function GetAllEmployee($fdate,$todate){

    $query = DB::table('users as t1')
                    ->select(
                        't1.id','t1.name','t1.email','t1.username','t1.contact','t1.profession','t1.district','t1.address',
                        't1.gender','t1.rank_id','t1.bank_id','t1.balance','t1.created_at','t1.updated_at','t1.acno','t1.type',
                        't2.name as rank','t3.name as bank','t4.name as branch'
                      )
                    ->join('ranks as t2', 't1.rank_id', '=', 't2.id')
                    ->join('banks as t3', 't1.bank_id', '=', 't3.id')
                    ->join('branches as t4', 't3.branch_id', '=', 't4.id')
                    ->where(['t1.level'=>100])
                    ->whereBetween(DB::raw("DATE_FORMAT(t1.created_at,'%Y-%m-%d')"), [$fdate, $todate])
                    ->orderBy('t1.id','desc')
                    ->get();


    return $results = json_decode(json_encode($query), True);
  }


  public function getDashboardData()
  {

    $query = Deposit::select(DB::raw('SUM(debit) AS debit'))
                         ->where(['isuser'=>1])
                         ->first();
    $total_user_debit = $query->debit;

    $admincount = User::where(['level'=>500])->count();
    $usercount = User::where(['level'=>100])->count();
    $gradecount = Rank::where(['status'=>1])->count();

    $query = Deposit::select(DB::raw('SUM(debit) AS debit, SUM(credit) AS credit, SUM(credit - debit) AS balance'))
                         //->where(['user_id'=>$user_id])
                         ->first();
    $total_debit = $query->debit;
    $total_credit = $query->credit;
    $balance = $query->balance;

    $result['balance'] = $balance;
    $result['tcredit'] = $total_credit;
    $result['tdebit'] = $total_debit;

    $result['tselfdebit'] = $total_debit - $total_user_debit;
    $result['tuserdebit'] = $total_user_debit;

    $result['admincount'] = $admincount;
    $result['usercount'] = $usercount;
    $result['gradecount'] = $gradecount;
    
    
    

    return response()->json($result, 200,[],JSON_PRETTY_PRINT);

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

}
