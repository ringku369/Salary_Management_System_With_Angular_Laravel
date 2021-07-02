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
use App\Profit;
use App\Userfund;
use App\Vcfund;





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



  


  public function dateWiseSelfDLUser(Request $request)
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


    $fdate = $request->fdate;
    $todate = $request->todate;

    /*$count = User::where(['parent_id'=>Auth::id()])->count();

    if ($count > 1) {
      $returndata = ["You can not be direct sponsor more than 2 accounts"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }*/

    $queryResult = User::select('id','username','name','email','district','profession','address','gender','_lft','_rgt','parent_id','created_at','contact',
      DB::raw('(CASE WHEN position = 0 THEN "N/A" WHEN position = 1 THEN "Left" ELSE "Right" END) AS position'),
      DB::raw('(select CONCAT(t1.name, "-", t1.username) from users as t1 where t1.id = users.parent_id) as parent'),
      DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as date")


    )
    
    ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
    ->orderBy('id','desc')
    ->descendantsAndSelf(Auth::id())
    ->toFlatTree(Auth::id());
        
    $results = $queryResult->toArray();
    return response()->json($results,200,[],JSON_PRETTY_PRINT);

  }

  public function dateWiseSelfProfit(Request $request)
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


    $fdate = $request->fdate;
    $todate = $request->todate;
    $queryResult = Profit::with('user','dsponsor','child')

      ->select('id','user_id','ds_id','ids_id','child_id','amount','status','created_at', DB::raw('(CASE WHEN status = 1 THEN "Membership" WHEN status = 2 THEN "Direct Sponsor " WHEN status = 3 THEN "Reference" WHEN status = 4 THEN "Team Performance" WHEN status = 5 THEN "Generation" ELSE "Fund Transfer" END) AS incometype'),
        DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as date")
      )
      
      ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
      ->where(['user_id'=>Auth::id()])
      ->orderBy('id','desc')->get();
        
    $results = $queryResult->toArray();
    return response()->json($results,200,[],JSON_PRETTY_PRINT);

  }
  public function dateWiseSelfTransaction(Request $request)
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


    $fdate = $request->fdate;
    $todate = $request->todate;
    $queryResult = Userfund::with('user','touser')

      ->select('id','user_id','from_id', 'to_id', 'amount','created_at', DB::raw('(CASE WHEN status = 1 THEN "Creating Account" ELSE "Fund Transfer" END) AS status')
      )
      
      ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
      ->where(['user_id'=>Auth::id()])
      ->orderBy('id','desc')->get();
        
    $results = $queryResult->toArray();
    return response()->json($results,200,[],JSON_PRETTY_PRINT);

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

    $queryResult = User::select('name','email','username','contact','profession','district','address','gender')->where(['id'=>Auth::id()])->first();
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

    //return $request->all();

    $affected = DB::table('users')->where('id', Auth::id())->update($request->all());


    $returndata = ["Profile has been updated successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);  
  }


  public function getTree()
  {

    $queryResult = User::select('id','name','username','contact','parent_id','_lft','_rgt','gender',
        'refer_id','ismatch','status','isposition','district','address','profession')->orderBy('position','asc')->descendantsAndSelf(Auth::id())->take(60)->toTree();
    $results = $queryResult->toArray();
    return response()->json($results,200,[],JSON_PRETTY_PRINT);
  }

  public function getSelfTree()
  {
    $email = Auth::user()->email;

    $queryResult = User::select('id','name','username','contact','parent_id','_lft','_rgt','gender',
        'refer_id','ismatch','status','isposition','district','address','profession')->where(['email'=>$email])->orderBy('position','asc')->descendantsAndSelf(Auth::id())->take(60)->toTree();
    $results = $queryResult->toArray();
    return response()->json($results,200,[],JSON_PRETTY_PRINT);
  }



  

  public function getTreeByID(Request $request)
  {

    $rules  =  array(
      'id' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    $id = $request->id;

    $queryResult = User::select('id','name','username','contact','parent_id','_lft','_rgt','gender',
        'refer_id','ismatch','status','isposition','district','address','profession')->orderBy('position','asc')->descendantsAndSelf($id)->toTree()->take(60);
    $results = $queryResult->toArray();
    return response()->json($results,200,[],JSON_PRETTY_PRINT);
  }




  public function getDownlinkUser()
  {
    $query = User::select('id','name','username','contact','parent_id','_lft','_rgt','ismatch')->orderBy('id','desc')->descendantsAndSelf(Auth::id())->toFlatTree(Auth::id());
    $queryResult = $query->toArray();

    $data[] = [
      'value' => '0',
      'label' => 'Please Select'
    ];
    foreach ($queryResult as $key => $value) {
      
      if ($value['ismatch'] == 0 ) { 
        $data[] = [
          'value' => (string)$value['id'],
          'label' => $value['name'] . ' - '. $value['username']. ' - '. $value['contact']
        ];
      }
    }
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }

  public function getDownlinkallUser()
  {
    $query = User::select('id','name','username','contact','parent_id','_lft','_rgt')->orderBy('ismatch','desc')->descendantsAndSelf(Auth::id())->toFlatTree();
    $queryResult = $query->toArray();

    $data[] = [
      'value' => '0',
      'label' => 'Please Select'
    ];
    foreach ($queryResult as $key => $value) {
      
      $data[] = [
        'value' => (string)$value['id'],
        'label' => $value['name'] . ' - '. $value['username']. ' - '. $value['contact']
      ];
    }
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }

  public function getAllLinkUser()
  {
    $query = User::select('id','name','username','contact')->orderBy('id','asc')->get();
    $queryResult = $query->toArray();

    $data[] = [
      'value' => '0',
      'label' => 'Please Select'
    ];
    foreach ($queryResult as $key => $value) {
      
      $data[] = [
        'value' => (string)$value['id'],
        'label' => $value['name'] . ' - '. $value['username']. ' - '. $value['contact']
      ];
    }
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }


  public function getAdminLinkUser()
  {
    $query = User::select('id','name','username','contact')->where('level','>=',500)->orderBy('id','asc')->get();
    $queryResult = $query->toArray();

    $data[] = [
      'value' => '0',
      'label' => 'Please Select'
    ];
    foreach ($queryResult as $key => $value) {
      
      $data[] = [
        'value' => (string)$value['id'],
        'label' => $value['name'] . ' - '. $value['username']
      ];
    }
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }



  public function getSingleUser()
  {
    
    $returndata = ["permission denied"];
    return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);


    $query = User::orderBy('id','desc')->descendantsAndSelf(Auth::id())->toFlatTree(Auth::id());
    $queryResult = $query->toArray();

    $data[] = [
      'value' => '0',
      'label' => 'Please Select'
    ];
    foreach ($queryResult as $key => $value) {
      
      if ($value['ismatch'] == 0 ) { 
        $data[] = [
          'value' => (string)$value['id'],
          'label' => $value['name'] . ' - '. $value['username']. ' - '. $value['contact']
        ];
      }
    }
    return response()->json($data,200,[],JSON_PRETTY_PRINT);
  }

  public function createUser(Request $request)
  {

    //return $request->all();


    $rules  =  array(
      'user' => 'required',
      'user_id' => 'required',
      'name' => 'required',
      //'username' => 'required|unique:users',
      'email' => 'required',
      'mobile' => 'required',
      'position' => 'required',
      'password' => 'required|confirmed|min:6'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $count = User::where(['id'=>$request->user_id])->where('balance','>=',10)->count();

    if ($count < 1) {
      $returndata = ["You do not have sufficient balance, should have minimum $10"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = User::where(['parent_id'=>$request->user_id])->count();

    if ($count > 1) {
      $returndata = ["You can not be direct sponsor more than 2 accounts"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = User::where(['parent_id'=>$request->user_id,'position'=> $request->position])->count();

    if ($count > 0) {
      $returndata = ["Please change this position item"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }


    //transaction
    $fn_transaction = function() use ($request)
      {
        try
        {
          // Transection 
          if ($request->position == 1) {
            $userdata_arr['isposition'] = 'L';
          } else {
            $userdata_arr['isposition'] = 'R';
          }


          // For Username
          //$statement = DB::select("show table status like 'users'");
          //$ainid = $statement[0]->Auto_increment;

          $user = User::select('username')->orderBy('id','desc')->first();
          $ainid = $user->username + 1;
          $username = $ainid;



          //$username = $request->username;

          $userdata_arr['roll'] = 'User';
          $userdata_arr['level'] = 100;
          $userdata_arr['username'] = $username;
          $userdata_arr['position'] = $request->position;
          $userdata_arr['name'] = $request->name;
          $userdata_arr['email'] = $request->email;
          $userdata_arr['contact'] = $request->mobile;
          $userdata_arr['parent_id'] = $request->user_id;
          $userdata_arr['refer_id'] = $request->user_id;
          $userdata_arr['password'] = bcrypt($request['password']);
          $userdata_arr['remember_token'] = bcrypt($request['_token']);
          $cuser = User::create($userdata_arr);

          $count = User::where(['parent_id'=>$request->user_id])->count();

          //============
          if ($count > 1) {
            $user = User::find($request->user_id);
            $user->ismatch = 1;
            $user->save();

            //For Matching Balance
            //
            /*$result = User::where(['parent_id'=>$request->user_id])->first();


            $profmt_arr['user_id'] = $request->user_id;
            $profmt_arr['mt_id'] = $request->user_id;
            $profmt_arr['ds_id'] = $result->id;
            $profmt_arr['ids_id'] = $cuser->id;
            $profmt_arr['child_id'] = $cuser->id;
            $profmt_arr['amount'] = 3;
            $profmt_arr['status'] = 4;

            $cprofmt = Profit::create($profmt_arr);*/

          }

        

        //============
          $user1 = User::find($request->user_id);
          $cbalance = $user1->balance;
          $user1->balance = $cbalance - 10;
          $user1->save();
        //============
          //For Opening Balance
          $profob_arr['child_id'] = $cuser->id;
          $profob_arr['user_id'] = $cuser->id;
          $profob_arr['amount'] = 0.5;
          $profob_arr['status'] = 1;

          //For User Funding
          $userfund_arr['user_id'] = $request->user_id;
          $userfund_arr['to_id'] = $cuser->id;
          $userfund_arr['amount'] = 10;
          $userfund_arr['status'] = 1;

          //For User Funding
          $vcfund_arr['user_id'] = $cuser->id;
          $vcfund_arr['amount'] = 1;
          $vcfund_arr['status'] = 1;

          $vcfund_arr1['user_id'] = $cuser->id;
          $vcfund_arr1['amount'] = 1;
          $vcfund_arr1['status'] = 2;

          //For Direct Sponsor
           $profds_arr['user_id'] = $request->user_id;
          $profds_arr['ds_id'] = $request->user_id;
          $profds_arr['child_id'] = $cuser->id;
          $profds_arr['amount'] = 2;
          $profds_arr['status'] = 2;

          Vcfund::create($vcfund_arr);
          Vcfund::create($vcfund_arr1);
          Userfund::create($userfund_arr);
          Profit::create($profob_arr);
          Profit::create($profds_arr);
         
               

          // Transection 
        }
        catch(Exception $e)
        {
          return response()->json(['error'=>'Unable to fund transfer'], 400);
        }
      };

      $return = DB::transaction($fn_transaction);
    //transaction

    $returndata = ["Proccess has been completed successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);  


    
  }



  public function postIndirectSponsor(Request $request)
  {

    //return $request->all();


    $rules  =  array(
      'user' => 'required',
      'user_id' => 'required',
      'name' => 'required',
      //'username' => 'required|unique:users',
      'email' => 'required',
      'mobile' => 'required',
      'position' => 'required',
      'password' => 'required|confirmed|min:6'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $count = User::where(['id'=>Auth::id()])->where('balance','>=',10)->count();

    if ($count < 1) {
      $returndata = ["You do not have sufficient balance, should have minimum $10"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = User::where(['parent_id'=>$request->user_id])->count();

    if ($count > 1) {
      $returndata = ["You can not be direct sponsor more than 2 accounts"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = User::where(['parent_id'=>$request->user_id,'position'=> $request->position])->count();

    if ($count > 0) {
      $returndata = ["Please change this position item"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }
    //============

     //transaction
    $fn_transaction = function() use ($request)
      {
        try
        {
          // Transection 
          if ($request->position == 1) {
            $userdata_arr['isposition'] = 'L';
          } else {
            $userdata_arr['isposition'] = 'R';
          }


          // For Username
          //$statement = DB::select("show table status like 'users'");
          //$ainid = $statement[0]->Auto_increment;

          $user = User::select('username')->orderBy('id','desc')->first();
          $ainid = $user->username + 1;
          $username = $ainid;

          $userdata_arr['roll'] = 'User';
          $userdata_arr['level'] = 100;
          $userdata_arr['username'] = $username;
          $userdata_arr['position'] = $request->position;
          $userdata_arr['name'] = $request->name;
          $userdata_arr['email'] = $request->email;
          $userdata_arr['contact'] = $request->mobile;
          $userdata_arr['parent_id'] = $request->user_id;
          $userdata_arr['refer_id'] = Auth::id();
          $userdata_arr['password'] = bcrypt($request['password']);
          $userdata_arr['remember_token'] = bcrypt($request['_token']);
          $cuser = User::create($userdata_arr);

          $count = User::where(['parent_id'=>$request->user_id])->count();

          //============
            if ($count > 1) {
              $user = User::find($request->user_id);
              $user->ismatch = 1;
              $user->save();

              //For Matching Balance
              //
              /*$result = User::where(['parent_id'=>$request->user_id])->first();


              $profmt_arr['user_id'] = $request->user_id;
              $profmt_arr['mt_id'] = $request->user_id;
              $profmt_arr['ds_id'] = $result->id;
              $profmt_arr['ids_id'] = $cuser->id;
              $profmt_arr['child_id'] = $cuser->id;
              $profmt_arr['amount'] = 3;
              $profmt_arr['status'] = 4;

              $cprofmt = Profit::create($profmt_arr);*/

            }

          

          //============
            $user1 = User::find(Auth::id());
            $cbalance = $user1->balance;
            $user1->balance = $cbalance - 10;
            $user1->save();
          //============
            //For Opening Balance
            $profob_arr['child_id'] = $cuser->id;
            $profob_arr['user_id'] = $cuser->id;
            $profob_arr['amount'] = 0.5;
            $profob_arr['status'] = 1;

            //For User Funding
            $userfund_arr['user_id'] = Auth::id();
            $userfund_arr['to_id'] = $cuser->id;
            $userfund_arr['amount'] = 10;
            $userfund_arr['status'] = 1;


            //For User Funding
            $vcfund_arr['user_id'] = $cuser->id;
            $vcfund_arr['amount'] = 1;
            $vcfund_arr['status'] = 1;

            //For User Funding
            $vcfund_arr1['user_id'] = $cuser->id;
            $vcfund_arr1['amount'] = 1;
            $vcfund_arr1['status'] = 2;

            //For Indirect Sponsor
            $profds_arr['user_id'] = Auth::id();
            $profds_arr['ids_id'] = Auth::id();
            $profds_arr['child_id'] = $cuser->id;
            $profds_arr['amount'] = 2;
            $profds_arr['status'] = 3;

            Vcfund::create($vcfund_arr);
            Vcfund::create($vcfund_arr1);
            Userfund::create($userfund_arr);
            Profit::create($profob_arr);
            Profit::create($profds_arr);

          // Transection 
        }
        catch(Exception $e)
        {
          return response()->json(['error'=>'Unable to fund transfer'], 400);
        }
      };

      $return = DB::transaction($fn_transaction);
    //transaction

    $returndata = ["Proccess has been completed successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);   




    $returndata = ["Proccess has been completed successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
  }



  public function postDirectSponsor(Request $request)
  {

    //return $request->all();


    $rules  =  array(
      //'user' => 'required',
      //'user_id' => 'required',
      'name' => 'required',
      //'username' => 'required|unique:users',
      'email' => 'required',
      'mobile' => 'required',
      'position' => 'required',
      'password' => 'required|confirmed|min:6'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $count = User::where(['id'=>Auth::id()])->where('balance','>=',10)->count();

    if ($count < 1) {
      $returndata = ["You do not have sufficient balance, should have minimum $10"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = User::where(['parent_id'=>Auth::id()])->count();

    if ($count > 1) {
      $returndata = ["You can not be direct sponsor more than 2 accounts"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = User::where(['parent_id'=>Auth::id(),'position'=> $request->position])->count();

    if ($count > 0) {
      $returndata = ["Please change this position item"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    

    
      

       //transaction
    $fn_transaction = function() use ($request)
      {
        try
        {
          // Transection 
          if ($request->position == 1) {
            $userdata_arr['isposition'] = 'L';
          } else {
            $userdata_arr['isposition'] = 'R';
          }


          // For Username
          //$statement = DB::select("show table status like 'users'");
          //$ainid = $statement[0]->Auto_increment;

          $user = User::select('username')->orderBy('id','desc')->first();
          $ainid = $user->username + 1;
          $username = $ainid;

          $userdata_arr['roll'] = 'User';
          $userdata_arr['level'] = 100;
          $userdata_arr['username'] = $username;
          $userdata_arr['position'] = $request->position;
          $userdata_arr['name'] = $request->name;
          $userdata_arr['email'] = $request->email;
          $userdata_arr['contact'] = $request->mobile;
          $userdata_arr['parent_id'] = Auth::id();
          $userdata_arr['refer_id'] = Auth::id();
          $userdata_arr['password'] = bcrypt($request['password']);
          $userdata_arr['remember_token'] = bcrypt($request['_token']);
          $cuser = User::create($userdata_arr);

          $count = User::where(['parent_id'=>Auth::id()])->count();

          //============
            if ($count > 1) {
              $user = User::find(Auth::id());
              $user->ismatch = 1;
              $user->save();

              //For Matching Balance
              //
              /*$result = User::where(['parent_id'=>Auth::id()])->first();


              $profmt_arr['user_id'] = Auth::id();
              $profmt_arr['mt_id'] = Auth::id();
              $profmt_arr['ds_id'] = $result->id;
              $profmt_arr['ids_id'] = $cuser->id;
              $profmt_arr['child_id'] = $cuser->id;
              $profmt_arr['amount'] = 3;
              $profmt_arr['status'] = 4;

              $cprofmt = Profit::create($profmt_arr);*/

            }

          

          //============
            $user1 = User::find(Auth::id());
            $cbalance = $user1->balance;
            $user1->balance = $cbalance - 10;
            $user1->save();
          //============
            //For Opening Balance
            $profob_arr['child_id'] = $cuser->id;
            $profob_arr['user_id'] = $cuser->id;
            $profob_arr['amount'] = 0.5;
            $profob_arr['status'] = 1;

            //For User Funding
            $userfund_arr['user_id'] = Auth::id();
            $userfund_arr['to_id'] = $cuser->id;
            $userfund_arr['amount'] = 10;
            $userfund_arr['status'] = 1;

            //For User Funding
            $vcfund_arr['user_id'] = $cuser->id;
            $vcfund_arr['amount'] = 1;
            $vcfund_arr['status'] = 1;

            //For User Funding
            $vcfund_arr1['user_id'] = $cuser->id;
            $vcfund_arr1['amount'] = 1;
            $vcfund_arr1['status'] = 2;

            //For Direct Sponsor
             $profds_arr['user_id'] = Auth::id();
            $profds_arr['ds_id'] = Auth::id();
            $profds_arr['child_id'] = $cuser->id;
            $profds_arr['amount'] = 2;
            $profds_arr['status'] = 2;

            Vcfund::create($vcfund_arr);
            Vcfund::create($vcfund_arr1);
            Userfund::create($userfund_arr);
            Profit::create($profob_arr);
            Profit::create($profds_arr);

          // Transection 
        }
        catch(Exception $e)
        {
          return response()->json(['error'=>'Unable to fund transfer'], 400);
        }
      };

      $return = DB::transaction($fn_transaction);
    //transaction


    $returndata = ["Proccess has been completed successfully"];
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

    $count = User::select('id')->where(['username'=>$request['user']])->count();

    if ($count < 1) {
      $returndata = ["There is no account with this user id"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $user = User::select('id','name','email')->where(['username'=>$request['user']])->first();
    $user_id = $user->id;

    if (Auth::id() == $user_id) {
      $returndata = ["You can not fund transer to same account, Try another accounts"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    
    $amount = $request->amount;
    $query = User::select('balance','name','email')->where(['id'=>Auth::id()])->first();
    $name = $query->name;
    $email = $query->email;
    $balance = $query->balance;
    $from_user_bal = $query->balance;

    $count = User::where(['id'=>Auth::id()])->where('balance','>=', $amount)->count();
    if ($count < 1) {
      $need = $amount - $balance;
      $returndata = ["You do not have sufficient balance, need more $".$need];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }


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
   
    $returndata = ["Please check your email and user varification code to confirm fund transfer",$ses_arr];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }


  private function sendMailToUserForVaryfi($verifycode,$toemail,$toname){

    $emailInformation = array(
      'from' => 'vizzclub@gmail.com', 
      'from_name' => 'Vizz Club Non Profitable Organization',
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
      $message->subject('For Fund Transfer Varification Message');
    });


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
    $returndata = self::userToUserFTConfirmation($request);

    $returndata = ["Fund transfer has been completed successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
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




  // user to admin fund trasfer

  public function postFundTrToAdmin(Request $request)
  {

    $rules  =  array(
      'user' => 'required',
      'user_id' => 'required',
      'amount' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    /*$request['user'] = 2022;

    $count = User::select('id')->where(['username'=>$request['user']])->count();

    if ($count < 1) {
      $returndata = ["There is no account with this user id"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }*/

    $user = User::select('id','name','email')->where(['id'=>$request['user_id']])->first();
    $user_id = $user->id;

    if (Auth::id() == $user_id) {
      $returndata = ["You can not fund transer to same account, Try another accounts"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    
    $amount = $request->amount;
    $query = User::select('balance','name','email')->where(['id'=>Auth::id()])->first();
    $name = $query->name;
    $email = $query->email;
    $balance = $query->balance;
    $from_user_bal = $query->balance;

    $count = User::where(['id'=>Auth::id()])->where('balance','>=', $amount)->count();
    if ($count < 1) {
      $need = $amount - $balance;
      $returndata = ["You do not have sufficient balance, need more $".$need];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }


    // verifycode
    $verifycode = mt_rand(100000, 999999);
    
    $repaly = self::sendMailToAdminForVaryfi($verifycode, $email, $name);
    // verifycode
    
    $ses_arr = [
      'user_id' => $user_id,
      'amount' => $amount,
      'verifycode' => $verifycode,
      'remarks' => $request->remarks
    ];
   
    $returndata = ["Please check your email and user varification code to confirm fund transfer",$ses_arr];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }


  private function sendMailToAdminForVaryfi($verifycode,$toemail,$toname){

    $emailInformation = array(
      'from' => 'vizzclub@gmail.com', 
      'from_name' => 'Vizz Club Non Profitable Organization',
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
      $message->subject('For Fund Transfer Varification Message');
    });


  }

  public function postFundTrToAdminConfirm(Request $request)
  {

    $rules  =  array(
      'verifycode' => 'required',
      'amount' => 'required',
      'user_id' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    //$request['user'] = 2022;
    //$request['user_id'] = 1; 

    $verifycode = $request['verifycode'];
    $returndata = self::userToAdminFTConfirmation($request);

    $returndata = ["Fund transfer has been completed successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
  }



  private function userToAdminFTConfirmation($request){
      
      

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
          $userfund_arr1['child_id'] = Auth::id();
          $userfund_arr1['to_id'] = Auth::id();
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

  // user to admin fund trasfer















  public function createUser1(Request $request)
  {

    return $request->all();
    
    $rules  =  array(
      'user_id' => 'required',
      'fdate' => 'required',
      'sno' => 'required',
      'mobile' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }
//===============
    $user_id = $request->user_id;
    $sno = $request->sno;
    $mobile = $request->mobile;
    $fdate = $request->fdate;




    $stockcount = Stock::where(['sno'=>$sno])->count(); 
    if ($stockcount < 1) {
      $returndata = ["IMEI or SNO is not valid"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $smscount = Smsdetail::where(['sno'=>$sno])->count(); 
    if ($smscount > 0) {
      $returndata = ["This IME/SNO has already been sold!!"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $smscount = Smsdetail::where(['sno'=>$sno])->count(); 

    if ($smscount < 1) {
      $data1['created_at'] = date_format(date_create($fdate),"Y-m-d H:i:s");
  //---------------------------------------
      $productResult = DB::table('stocks')->select('id','product_id','brand_id',
        'wperiod','imei')->where(['sno'=>$sno])->first();
      $productdata = json_decode(json_encode($productResult), True);
      
      $data1['product_id'] = $productdata['product_id'];
      $data1['brand_id'] = $productdata['brand_id'];
      $data1['wperiod'] = $productdata['wperiod'];
      $data1['imei'] = $productdata['imei'];
      $data1['user_id'] = $user_id;
      $data1['sno'] = $sno;
  //---------------------------------------
      
      $data1['mobile'] = $mobile;
      $data1['promo_id'] = 0;
      $data1['promodetail_id'] = 0;
      $data1['status'] = 0;


  //----------------------------------------
      $dwcount = Dwdetail::where(['sno'=>$sno, 'status' => 0])->count();  

      if ($dwcount > 0) {
        DB::table('dwdetails')->where('sno', $sno)->update(['status' => 1]);
        
        $dwdetail = Dwdetail::where(['sno'=>$sno])->first();
        $dwday = $dwdetail->dwday;
        $dwcharge = $dwdetail->dwcharge;
        
        $mobileno = $dwdetail->mobile;
        $data1['iswar'] = 1;
        $data1['isdw'] = 1;
        $data1['dwday'] = $dwday;
        $data1['dwcharge'] = $dwcharge;
        $data1['twperiod'] = $wperiod + $dwday;

      }

      Smsdetail::create($data1);
      //----------------------------------------
    } 
    $returndata = ["Proccess has been completed successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
  }



  public function binaryMatchingReport(){
    $user_id = Auth::id();
    //=========
    $ldata_arr = [];
    $rdata_arr = [];
    
    //Left Users Tree
    $lcount = User::select('id')->where(['position'=>1,'parent_id'=> $user_id])->count();

    if ($lcount > 0 ) {
      $tuser = User::select('id')->where(['position'=>1,'parent_id'=> $user_id])->first();
      $tid = $tuser->id;
      $queryResult = User::select('id','name','username','bmcount',
        DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as date")
      )->descendantsAndSelf($tid)->toFlatTree();
      $users = $queryResult->toArray();
      
      foreach ($users as $key=>$user) {
        $ldata_arr[] = [
          'user_id' => $user['id'],
          'name' => $user['name'] . " - ". $user['username'],
          'amount' => 3,
          'date' => $user['date'],
          'status' => 'Match',
        ];
      }

    } else {
      $ldata_arr[] = [
        'user_id' => '-',
        'name' => '-',
        'amount' => 0,
        'date' => '-',
        'status' => 'Unmatch',
      ];
    }
    //Left Users Tree
    
    //Right Users Tree
    $rcount = User::select('id')->where(['position'=>2,'parent_id'=> $user_id])->count();

    if ($rcount > 0 ) {
      $tuser = User::select('id')->where(['position'=>2,'parent_id'=> $user_id])->first();
      $tid = $tuser->id;
      $queryResult = User::select('id','name','username','bmcount',
        DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as date")
      )->descendantsAndSelf($tid)->toFlatTree();
      $users = $queryResult->toArray();
      
      foreach ($users as $key=>$user) {
        $rdata_arr[] = [
          'user_id' => $user['id'],
          'name' => $user['name'] . " - ". $user['username'],
          'amount' => 3,
          'date' => $user['date'],
          'status' => 'Match',
        ];
      }

    } else {
      $rdata_arr[] = [
        'user_id' => '-',
        'name' => '-',
        'amount' => 0,
        'date' => '-',
        'status' => 'Unmatch',
      ];
    }
    //Right Users Tree

    $report_arr = [];

    //dd($ldata_arr);
    //dd(count($ldata_arr). '-'. count($rdata_arr));
    //
    

    if ($lcount == 0 && $rcount == 0) {
      $report_arr[] = [
        'luser' => '-',
        'ruser' => '-',
        'amount' => 0,
        'date' => '-',
        'status' => 'Unmatch',
      ];
    } else {

      if (count($ldata_arr) >= count($rdata_arr) && count($ldata_arr) > 0) {
        
        foreach ($ldata_arr as $key=>$arr) {
          if (count($rdata_arr) > $key ) {
            $report_arr[] = [
              'luser' => $arr['name'],
              'ruser' => $rdata_arr[$key]['name'],
              'amount' => 3,
              'date' => $arr['date'],
              'status' => 'Match',
            ];
          } else {
            $report_arr[] = [
              'luser' => $arr['name'],
              'ruser' => '-',
              'amount' => 0,
              'date' => '-',
              'status' => 'Unmatch',
            ];
          }
        }

      } else {
        foreach ($rdata_arr as $key=>$arr) {
          if (count($ldata_arr) > $key ) {
            $report_arr[] = [
              'luser' => $ldata_arr[$key]['name'],
              'ruser' => $arr['name'],
              'amount' => 3,
              'date' => $arr['date'],
              'status' => 'Match',
            ];
          } else {
            $report_arr[] = [
              'luser' => $arr['name'],
              'ruser' => '-',
              'amount' => 0,
              'date' => '-',
              'status' => 'Unmatch',
            ];
          }
        }
      }

    }
    //=========


    return response()->json($report_arr,200,[],JSON_PRETTY_PRINT);
  }


}
