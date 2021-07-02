<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiAuthController;
//use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

use Redirect;
use Validator;
use Input;
use Session;
use Auth;
use Storage;
use File;
use DB;
use Mail;

use App\User;


class ApiGuestController extends Controller
{
	private $ApiAuthController;

	public function __construct()
  {
      $this->ApiAuthController = new ApiAuthController;
      date_default_timezone_set('America/New_York');
  }


	public function Test1(){
    //return "This is test";

    $query = User::select('id','name','email')->first();
	  $queryResult = $query->toArray();

    

    $query = User::select('id')->orderBy('id','desc')->first();
    $ainid = $query->id + 1;

    
    $statement = DB::select("show table status like 'users'");
    $ainid = $statement[0]->Auto_increment;
    $username = date('Y') + $ainid;

		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }


/*
  public function morningtimeschedules(Request $request)
  {
    
    $rules  =  array(
      'localDate' => 'required',
      'localTimeZone' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $localDate = $request['localDate'];
    $localTimeZone = $request['localTimeZone'];

    //date_default_timezone_set($localTimeZone);
    //date_default_timezone_set('America/New_York');

    if (strlen($localDate) == 9) {
      $strday = substr($localDate,8);
      $day = "0".$strday;
      $strym = substr($localDate,0,8);
      $localDate = $strym.$day;
    }

    if(date('Y-m-d') == $localDate){
      $time = date('H:i', time());
      $date = $localDate;
      $date = date_create($date);
      
    }else{
      $time = "00:00";
      $date = $localDate;
      $date = date_create($date);
    }

    // $date = date_create($date);

    // $queryResult = date_format($date,"l");
    
    // return response()->json($date,200,[],JSON_PRETTY_PRINT);


    // return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);

    // //$date = date_create("2020-12-05");

    
    
    // return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
    
    

    if(date_format($date,"l") == "Saturday"){

      $query = Schedule::select('id','name')
            ->whereNotIn('id',DB::table('appoints')->select('schedule_id')->where(['sdate'=>$date, 'status'=>1]))
            ->whereBetween('time',[$time,'11:50'])
            ->where(['level'=> 4, 'status'=>1])
            ->get();
      $queryResult = $query->toArray();
      
    }else{
      $query = Schedule::select('id','name')
            ->whereNotIn('id',DB::table('appoints')->select('schedule_id')->where(['sdate'=>$date, 'status'=>1]))
            ->whereBetween('time',[$time,'11:50'])
            ->where(['level'=>1, 'status'=>1])
            ->get();
      $queryResult = $query->toArray();
    }



    
    

    $data[] = [
      'date' => $date,
      'time' => $time
    ];
    
    //return response()->json($data,200,[],JSON_PRETTY_PRINT);
    return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);

  }

  public function noontimeschedules(Request $request)
  {
    
    $rules  =  array(
      'localDate' => 'required',
      'localTimeZone' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $localDate = $request['localDate'];
    $localTimeZone = $request['localTimeZone'];

    //date_default_timezone_set($localTimeZone);
    //date_default_timezone_set('America/New_York');

    if (strlen($localDate) == 9) {
      $strday = substr($localDate,8);
      $day = "0".$strday;
      $strym = substr($localDate,0,8);
      $localDate = $strym.$day;
    }

    if(date('Y-m-d') == $localDate){
      $time = date('H:i', time());
      $date = $localDate;
      $date = date_create($date);
      
    }else{
      $time = "00:00";
      $date = $localDate;
      $date = date_create($date);
    }

    if(date_format($date,"l")=="Saturday"){

      $query = Schedule::select('id','name')
            ->whereNotIn('id',DB::table('appoints')->select('schedule_id')->where(['sdate'=>$date, 'status'=>1]))
            ->whereBetween('time',[$time,'16:10'])
            ->where(['level'=>2, 'status'=>1])
            ->get();
      $queryResult = $query->toArray();
      
    }else{
      $query = Schedule::select('id','name')
            ->whereNotIn('id',DB::table('appoints')->select('schedule_id')->where(['sdate'=>$date, 'status'=>1]))
            ->whereBetween('time',[$time,'16:50'])
            ->where(['level'=>2, 'status'=>1])
            ->get();
      $queryResult = $query->toArray();
    }


    

    $data[] = [
      'date' => $date,
      'time' => $time
    ];

    return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);

  }

  public function eveningtimeschedules(Request $request)
  {
    
    $rules  =  array(
      'localDate' => 'required',
      'localTimeZone' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $localDate = $request['localDate'];
    $localTimeZone = $request['localTimeZone'];

    //date_default_timezone_set($localTimeZone);
    //date_default_timezone_set('America/New_York');

    if (strlen($localDate) == 9) {
      $strday = substr($localDate,8);
      $day = "0".$strday;
      $strym = substr($localDate,0,8);
      $localDate = $strym.$day;
    }

    if(date('Y-m-d') == $localDate){
      $time = date('H:i', time());
      $date = $localDate;
      $date = date_create($date);
      
    }else{
      $time = "00:00";
      $date = $localDate;
      $date = date_create($date);
    }

    if(date_format($date,"l")=="Saturday"){
      $query = Schedule::select('id','name')
            ->whereNotIn('id',DB::table('appoints')->select('schedule_id')->where(['sdate'=>$date, 'status'=>1]))
            ->whereBetween('time',[$time,'16:10'])
            ->where(['level'=>3, 'status'=>1])
            ->get();
      $queryResult = $query->toArray();
    }else{
      $query = Schedule::select('id','name')
              ->whereNotIn('id',DB::table('appoints')->select('schedule_id')->where(['sdate'=>$date, 'status'=>1]))
              ->whereBetween('time',[$time,'17:30'])
              ->where(['level'=>3, 'status'=>1])
              ->get();
      $queryResult = $query->toArray();
    }
    

    $data[] = [
      'date' => $date,
      'time' => $time
    ];

    return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);

  }

  public function bookedschedules(Request $request)
  {
    
    $rules  =  array(
      'name' => 'required',
      'email' => 'required|email',
      'contact' => 'required',
      'dob' => 'required',
      'note' => 'required',
      'carrier' => 'required',
      'iid' => 'required',
      'schedule_id' => 'required',
      'sdate' => 'required',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    // Checking ====
    $count = Schedule::where(['id' => $request['schedule_id']])->count();

    if($count == 0){
      $returndata = ["Sorry you did something wrong, Please try again..."];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $scheduledata = Schedule::where(['id' => $request['schedule_id']])->first();
    $time = $scheduledata->time;
    $stime = $scheduledata->name;

    $count = Appoint::where(['sdate' => $request['sdate'], 'time'=>$time, 'status'=>1])->count();

    if($count > 0){
      $returndata = ["Sorry there is no time slot, Please try again..."];
      return response()->json($error, 400,[],JSON_PRETTY_PRINT);
    }

    // Checking ====
  



    $dobarray = $request['dob'];
    $request['dob'] = $dobarray['year']. "-".$dobarray['month']. "-".$dobarray['day'];
    $request['time'] = $time;
    $request['stime'] = $stime;

    $this->sendMailToUser($request->all());
    $this->sendMailToAdmin($request->all());

    $appoint = Appoint::create($request->all());
			
    $returndata['success'] = ["Congratulations ! Booking Confirmation Successfully Placed"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);


  }
*/


  public function sendMailToAdmin($request){

		$emailInformation = array(
      'from' => 'booking@kmucpa.com', 
			'from_name' => 'Keystone Medical',
			'to' => 'keystonemedicalurgentcare@gmail.com',
			//'to' => 'ringku369@gmail.com',
			'to_name' => 'Online Booking Notification',

		);


    $date = date_create($request['sdate']);
    $sdate = date_format($date,"m-d-Y");

    $date = date_create($request['dob']);
    $dob = date_format($date,"m-d-Y");

    $msgbody = "
    Booking Date - {$sdate}
    Booking Time - {$request['stime']}
    Name - {$request['name']}
    Phone No - {$request['contact']}
    Email - {$request['email']}
    Birthdate - {$dob}
    Insurance Carrier - {$request['carrier']}
    Insurance ID - {$request['iid']}
    Have you been to keystone medical urgent care before? - {$request['note']} 
    
    ";
		
		Mail::raw($msgbody, function ($message) use ($emailInformation) {
      $message->from($emailInformation['from'], $emailInformation['from_name']);
      $message->to($emailInformation['to'], $emailInformation['to_name']);
      $message->subject('Online Booking Notification');
    });
    
    //return "success";

	}


  public function sendMailToUser($request){

		$emailInformation = array(
      'from' => 'booking@kmucpa.com', 
			'from_name' => 'Keystone Medical',
			'to' => $request['email'],
			'to_name' => $request['name'],

		);

    $date = date_create($request['sdate']);
    $sdate = date_format($date,"m-d-Y");

    $date = date_create($request['dob']);
    $dob = date_format($date,"m-d-Y");

    $msgbody = "
    Booking Date - {$sdate}
    Booking Time - {$request['stime']}
    Name - {$request['name']}
    Phone No - {$request['contact']}
    Email - {$request['email']}
    Birthdate - {$dob}
    Insurance Carrier - {$request['carrier']}
    Insurance ID - {$request['iid']}
    Have you been to keystone medical urgent care before? - {$request['note']} 
    
    Keystone Medical Urgent Care
    
    1555 W. Street Road Warminster, PA 18974
    Phone: 215-293-9560

    ";
		
		Mail::raw($msgbody, function ($message) use ($emailInformation) {
      $message->from($emailInformation['from'], $emailInformation['from_name']);
      $message->to($emailInformation['to'], $emailInformation['to_name']);
      $message->subject('Keystone Medical-Online Booking');
    });
    
    //return "success";

	}


  public function sendmailtesting($request){

		$emailInformation = array(
      'from' => 'booking@kmucpa.com', 
			'from_name' => 'Keystone Medical',
			'to' => $request['email'],
			'to_name' => $request['name'],

		);


    $msgbody = "
    Booking Date - {date_format(date_create({$request['sdate']}),'d/m/Y')}
    Booking Time - {$request['stime']}
    Name - {$request['name']}
    Phone No - {$request['contact']}
    Email - {$request['email']}
    Birthdate - {$request['dob']}
    Insurance Carrier - {$request['carrier']}
    Insurance ID - {$request['iid']}
    Have you been to keystone medical urgent care before? - {$request['note']} 
    
    ";
		
		Mail::raw($msgbody, function ($message) use ($emailInformation) {
      $message->from($emailInformation['from'], $emailInformation['from_name']);
      $message->to($emailInformation['to'], $emailInformation['to_name']);
      $message->subject('Keystone Medical-Online Booking');
    });
    
    //return "success";

	}




}
