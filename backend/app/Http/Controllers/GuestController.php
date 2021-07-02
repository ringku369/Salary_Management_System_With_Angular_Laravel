<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Redirect;
use Validator;
use Input;
use Session;
use Auth;
use Storage;
use File;
use DB;
use Hash;
use Mail;

use App\User;
use App\Setting;
use App\Register;

class GuestController extends Controller
{

  public function Verify(){
    $query = User::select('id','name','email')->first();
    $queryResult = $query->toArray();

    return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);

  	return redirect()->route('guest.verifySamsungProduct');
  }


  public function HomeView(){
    return "Home Page";
    return view('guest.dashboard');
  }
  public function AboutUsView(){
    return view('guest.aboutUs');
  }
  
  public function TraningView(){
    return view('guest.traning');
  }
  
  public function PropertyInspectionView(){
    return view('guest.propertyInspection');
  }
  
  public function RehabRenovationView(){
    return view('guest.rehabRenovation');
  }

  public function StructuralRehabView(){
    return view('guest.structuralRehab');
  }

  public function EnvironmentalView(){
    return view('guest.environmental');
  }

  public function TrashOutsView(){
    return view('guest.trashOuts');
  }

  public function RepairsView(){
    return view('guest.repairs');
  }
  
  public function LawnView(){
    return view('guest.lawn');
  }

  public function RoofingView(){
    return view('guest.roofing');
  }



  public function RegisterStore(Request $request){
		
		$rules  =  array(
      'name'=>'required|max:128',
			'email'=>'required|unique:users|max:56',
			'contact'=>'required|max:16',
			'company'=>'required|max:128',
			'address'=>'required|max:256',
			'area'=>'required|max:128',
			'experience'=>'required|max:512',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $request['status'] = 1;
		Register::create($request->all());

		//$returndata = ["email or password does not match, pls try again"];
    //return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);


    $this->sendMailToUser1($request->all());
    $this->sendMailToAdmin1($request->all());

		$returndata['success'] = ["Congratulations ! Your Vendor Signup Successfully Placed"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
	}

  public function SubscribeStore(Request $request){
		
		$rules  =  array(
      'name'=>'required|max:128',
			'email'=>'required|max:56',
			'contact'=>'required|max:16',
			'subject'=>'required|max:256',
			'experience'=>'required|max:512',
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $request['status'] = 2;

		Register::create($request->all());

		//$returndata = ["email or password does not match, pls try again"];
    //return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);

    $this->sendMailToUser($request->all());
    $this->sendMailToAdmin($request->all());


		//sleep(5);
		$returndata['success'] = ["Congratulations ! Your Query Successfully Placed"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
	}


public function sendMailToAdmin($request){

    $emailInformation = array(
      'from' => 'info@rnrpp.com', 
      'from_name' => 'rnrpp website',
      'to' => 'info@rnrpp.com',
      'to_name' => 'rnrpp website',

    );


    $msgbody = "
    Name - {$request['name']}
    Phone No - {$request['contact']}
    Email - {$request['email']}
    subject - {$request['subject']}
    Message - {$request['experience']}
    
    ";
    
    Mail::raw($msgbody, function ($message) use ($emailInformation) {
      $message->from($emailInformation['from'], $emailInformation['from_name']);
      $message->to($emailInformation['to'], $emailInformation['to_name']);
      $message->subject('Query From Website Notification');
    });
    
    //return "success";

  }


  public function sendMailToUser($request){

    $emailInformation = array(
      'from' => 'info@rnrpp.com', 
      'from_name' => 'rnrpp website',
      'to' => $request['email'],
      'to_name' => $request['name'],

    );


    $msgbody = "
    Name - {$request['name']}
    Phone No - {$request['contact']}
    Email - {$request['email']}
    subject - {$request['subject']}
    Message - {$request['experience']}
    
    ";
    
    Mail::raw($msgbody, function ($message) use ($emailInformation) {
      $message->from($emailInformation['from'], $emailInformation['from_name']);
      $message->to($emailInformation['to'], $emailInformation['to_name']);
      $message->subject('Query From Website');
    });
    
    //return "success";

  }

public function sendMailToAdmin1($request){

		$emailInformation = array(
      'from' => 'info@rnrpp.com', 
      'from_name' => 'rnrpp website',
      'to' => 'info@rnrpp.com',
      'to_name' => 'rnrpp website',

    );


    $msgbody = "
    Name - {$request['name']}
    Email - {$request['email']}
    Phone No - {$request['contact']}
    Company - {$request['company']}
    Address - {$request['address']}
    Coverage Area - {$request['area']}
    Experience - {$request['experience']}
    
    ";
    
    Mail::raw($msgbody, function ($message) use ($emailInformation) {
      $message->from($emailInformation['from'], $emailInformation['from_name']);
      $message->to($emailInformation['to'], $emailInformation['to_name']);
      $message->subject('Query From Website Notification');
    });
    
    //return "success";

	}


  public function sendMailToUser1($request){

		$emailInformation = array(
      'from' => 'info@rnrpp.com', 
			'from_name' => 'rnrpp website',
			'to' => $request['email'],
			'to_name' => $request['name'],

		);


    $msgbody = "
    Name - {$request['name']}
    Email - {$request['email']}
    Phone No - {$request['contact']}
    Company - {$request['company']}
    Address - {$request['address']}
    Coverage Area - {$request['area']}
    Experience - {$request['experience']}
    
    ";
		
		Mail::raw($msgbody, function ($message) use ($emailInformation) {
      $message->from($emailInformation['from'], $emailInformation['from_name']);
      $message->to($emailInformation['to'], $emailInformation['to_name']);
      $message->subject('Query From Website');
    });
    
    //return "success";

	}
// DontWorry =======================================
}
