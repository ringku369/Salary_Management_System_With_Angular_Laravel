<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;


use Redirect;
use Validator;
use Input;
use Session;
use Auth;

use App\User;
use App\Setting;


class AuthController extends Controller
{
	
	protected $loginPath = '/';



	public static $code;
	public static $currency;
	public static $timezone;
	public static $contact;
	public static $vat;
	public static $semail;
	public static $favicon;
	public static $logo;


	public function __construct(){
	  //$this->middleware('auth');
		
		//return Auth::guard('web')->user()->level;

	  $settingCount = Setting::count();
	  $settingResult = Setting::first();
	  $settings = $settingResult->toArray();

	  self::$code = $settings['code'];
	  self::$currency = $settings['currency'];
	  self::$timezone = $settings['timezone'];
	  self::$vat = $settings['vat'];
	  self::$contact = $settings['contact'];
	  self::$semail = $settings['semail'];
	  self::$favicon = $settings['favicon'];
	  self::$logo = $settings['logo'];

	  date_default_timezone_set(self::$timezone);

	}




	public function LoginView(){

		$_SESSION['favicon'] = self::$favicon;
		$_SESSION['logo'] = self::$logo;
		

		$settingCount = Setting::count();
	  $settingResult = Setting::first();
	  $settings = $settingResult->toArray();

	  return "Auth Page";
		return view('extra.login',['settings'=>$settings]);
	}

public function LoginViewStore(Request $request){
		//print_r($request->all());

		$this->validate($request,['email'=>'required|max:55','password'=>'required']);
		
		
		$admindata['active'] = true;
		$admindata['level'] = 500;
		$admindata['email'] = $request->email;
		$admindata['password'] = $request->password;

		$topmanagement['active'] = true;
		$topmanagement['level'] = 400;
		$topmanagement['email'] = $request->email;
		$topmanagement['password'] = $request->password;

		$midmanagement['active'] = true;
		$midmanagement['level'] = 300;
		$midmanagement['email'] = $request->email;
		$midmanagement['password'] = $request->password;

		$retailerdata['active'] = true;
		$retailerdata['level'] = 200;
		$retailerdata['username'] = $request->email;
		$retailerdata['password'] = $request->password;

		$salesdata['active'] = true;
		$salesdata['level'] = 150;
		$salesdata['email'] = $request->email;
		$salesdata['password'] = $request->password;

		$distributor['active'] = true;
		$distributor['level'] = 100;
		$distributor['email'] = $request->email;
		$distributor['password'] = $request->password;

		$tso['active'] = true;
		$tso['level'] = 10;
		$tso['email'] = $request->email;
		$tso['password'] = $request->password;

		$huawei['active'] = true;
		$huawei['level'] = 1000;
		$huawei['email'] = $request->email;
		$huawei['password'] = $request->password;

		

		
		if (Auth::guard('web')->attempt($admindata)) {

			return redirect()->route('admin.dashboard');

		}elseif (Auth::guard('web')->attempt($topmanagement)) {

			return redirect()->route('topmanagement.dashboard');

		}elseif (Auth::guard('web')->attempt($midmanagement)) {

			return redirect()->route('midmanagement.dashboard');

		}elseif (Auth::guard('web')->attempt($retailerdata)) {

			return redirect()->route('retailer.dashboard');

		}elseif (Auth::guard('web')->attempt($distributor)) {

			return redirect()->route('distributor.dashboard');

		}elseif (Auth::guard('web')->attempt($tso)) {

			return redirect()->route('tso.dashboard');
			
			//$error = "username or password invalide, please try again...";
			//return redirect()->back()->withErrors($error);
		}elseif (Auth::guard('web')->attempt($huawei)) {

			return redirect()->route('huawei.dashboard');

			//$error = "username or password invalide, please try again...";
			//return redirect()->back()->withErrors($error);

		}else{

			$error = "username or password invalide, please try again...";
			return redirect()->back()->withErrors($error);
			
		}




	}

	public function Ses(){
		//return Auth::guard('web')->user()->email;
	}

	public function Logout(Request $request){
    $request->session()->regenerate(true);
    Auth::guard('web')->logout();
		//Session::forget(['region_id','territory_id','distributor_id','date','fdate','todate']);
		$request->session()->flush();
		Session::flush();

    $request->session()->invalidate();

    $request->session()->regenerateToken();
    
		return redirect()->route('auth.login');
	}



	public function RegistrationView(){
		return view('extra.registration');
	}


	public function RegistrationViewStore(RegFormData $request){
		$request['remember_token'] = $request['_token'];
		$request['password'] = bcrypt($request['password']);
		User::create($request->all());
		//Session::flash('success','Data inserted successfully');
		//return redirect()->back();
 
		return redirect()->back()->with('success','Data inserted successfully');

	}





//======================= ForgetPassword Area ============================
	
	public function ForgetPasswordLink($link){
		session_start();

		if (!$link) {
			return redirect()->route('auth.customer.login')->withErrors('Something  went wrong ...');
		}


		$remember_token = $link;

		$count = User::where(['remember_token'=>$remember_token])->count();

		if ($count < 1) {
			return redirect()->route('auth.customer.login')->withErrors('There is no user account according this token');
		} else {
			$user = User::where(['remember_token'=>$remember_token])->first();

			$userid = $user->id;
			$email = $user->email;
			$remember_token = $user->remember_token;

			$_SESSION["userid"] = $userid;

			return view('guest.resetPassword');
		}
		

	}



	public function ForgetPassword(Request $request){
		$this->validate($request,['email'=>'required|max:55']);

		//dd($request);

		$email = $request['email'];

		$count = User::where(['email'=>$email])->count();
		if ($count < 1) {

			return redirect()->back()->withErrors("There is no user account according this email address")->withInput();
		} else {
			$user = User::where(['email'=>$email])->first();

			$email = $user->email;
			$remember_token = $user->remember_token;

			$link = route('guest.forgetPasswordLink',[$remember_token]);
//============================================================

		$semail = self::$semail;

		$emailInformation = array(

			'from' => $semail, 
			'from_name' => 'Japan Parts',
			'to' => $email,
			'to_name' => 'Japan Parts',

		);



		$msgbody = "To reset your password clik this link {$link} ";
		


		Mail::raw($msgbody, function ($message) use ($emailInformation) {
		    $message->from($emailInformation['from'], $emailInformation['from_name']);
		    $message->to($emailInformation['to'], $emailInformation['to_name']);
				$message->subject('Reset Password In Japan Parts User Account');
		});

//============================================================


			return redirect()->back()->with('success','Email sent successfully, to reset password please check your email address ...');

		}

		
	  
	
	}




	public function ForgetPasswordChange(Request $request){
		session_start();

		if (!isset($_SESSION["userid"])) {
      return redirect()->route('guest.forgetPasswordChange')->withErrors('There are no user found');
    }



		$id = $_SESSION["userid"];

		//dd($request->all());


  	$user = User::find($id);


		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request, [
        '_token' => 'required',
        'password' => 'required|min:3|max:200',
        'confirm_password' => 'required|min:3|max:200|same:password',
      ]);	

			$user->remember_token = $request['_token'];
			$user->password = bcrypt($request['password']);
      $user->save();

		}

		unset($_SESSION["userid"]);

    return redirect()->route('auth.customer.login')->with('success', 'Password has been updated successfully');

	}


//======================= ForgetPassword Area ============================







	


}
