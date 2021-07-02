<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests\ClassName;
//use App\Http\Controllers\AuthController;

use App\Http\Requests\FormWithoutFileData;
use App\Http\Requests\FormWithFileData;

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

/*
use App\User;
use App\Retailer;
use App\Setting;
use App\Brand;
use App\Cat;
use App\Product;
use App\Specification;
use App\Stock;



use App\Promo;
use App\Promodetail;

use App\Promort;
use App\Promortdetail;
use App\Promortretailer;
use App\Promortkey;
use App\Promortsmsdetail;

use App\Smsdetail;
use App\Dwdetail;

use App\Replace;
use App\Sr;


use App\Purchase;
use App\Sale;
use App\Preturn;


use App\Division;
use App\District;
use App\Upazila;
use App\Middistrict;
use App\Tsoupazila;*/


class AdminController extends Controller
{
	

	public static $code;
	public static $currency;
	public static $timezone;
	public static $contact;
	public static $vat;
	public static $semail;
	public static $favicon;
	public static $logo;
	//public static $requestRetailerCount;


	public function __construct(){
	  //$this->middleware('auth')->except(['Test']);
		
		//return Auth::user()->level;
		session_start();
	  //$settingCount = Setting::count();
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



  

	protected function security(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
	}

  public function DashboardView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}

		//$_SESSION['favicon'] = self::$favicon;
		//$_SESSION['logo'] = self::$logo;

    return "Admin Page";
		return redirect(route('admin.content'));

	  return view('admin.dashboard');
	}

  public function ContentView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //return Session::all();
    //return Auth::id();

	  $user_id = Session::get('user_id');
	  $fdate = Session::get('fdate');
	  $todate = Session::get('todate');
	  $ssdata = [];
		if ($user_id) {
			
			$ssdata['fdate'] = $fdate;
			$ssdata['todate'] = $todate;
			$ssdata['user_id'] = $user_id;

			$query = Register::where(['status'=>1])
							->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate,$todate])
							->orderBy('id','desc')
							->get();
	  	$results = $query->toArray();

		}else{
			$query = Register::where(['status'=>1])->orderBy('id','desc')->take(100)->get();
	  	$results = $query->toArray();
		}

		
	  return view('admin.content',['ssdata'=>$ssdata,'results'=>$results]);
	}

	public function ContentDestroy($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$result = Register::find($id);
		
  	//$productCount = Product::where('brand_id', $id)->count();
  	$productCount = 0;

		if ($result === null) {
			$returndata = ["There are no data with this id"];
  		return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);

		}else{
  		if ($productCount > 0) {
				$returndata = ["This Data can not be deleted becouse of related with others data"];
  			return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);

			}else{
				$result->delete();
				$returndata['success'] = ["Congratulations ! Data has been deleted successfully"];
  			return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
			}
		}
	}


  public function ContentOneView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}

		

		$user_id = Session::get('user_id');
	  $fdate = Session::get('fdate');
	  $todate = Session::get('todate');
	  $ssdata = [];

		if ($user_id) {
			
			$ssdata['fdate'] = $fdate;
			$ssdata['todate'] = $todate;
			$ssdata['user_id'] = $user_id;

			$query = Register::where(['status'=>2])
							->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate,$todate])
							->orderBy('id','desc')
							->get();
	  	$results = $query->toArray();

		}else{
			$query = Register::where(['status'=>2])->take(100)->orderBy('id','desc')->get();
	  	$results = $query->toArray();
		}


	  return view('admin.contentOne',['ssdata'=>$ssdata,'results'=>$results]);
	}


	public function ContentOneDestroy($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$result = Register::find($id);
		
  	//$productCount = Product::where('brand_id', $id)->count();
  	$productCount = 0;

		if ($result === null) {
			$returndata = ["There are no data with this id"];
  		return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);

		}else{
  		if ($productCount > 0) {
				$returndata = ["This Data can not be deleted becouse of related with others data"];
  			return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);

			}else{
				$result->delete();
				$returndata['success'] = ["Congratulations ! Data has been deleted successfully"];
  			return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
			}
		}
	}



	  public function ContentSearchViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());


    Session::forget(['user_id','fdate','todate']);

    $this->validate($request, [
      'user_id' => 'required',
      'fdate' => 'required',
      'todate' => 'required'
    ]);

		$request['fdate'] = date_format(date_create($request->get('fdate')),"Y-m-d");
		$request['todate'] = date_format(date_create($request->get('todate')),"Y-m-d");
    

    $user_id = $request->get('user_id');
    $fdate =  $request->get('fdate');
    $todate = $request->get('todate');
    
    Session::put(['user_id'=>$user_id,'fdate'=>$fdate,'todate'=>$todate]);

  	return redirect(route('admin.content'));


  }

	  public function ContentOneSearchViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());


    Session::forget(['user_id','fdate','todate']);

    $this->validate($request, [
      'user_id' => 'required',
      'fdate' => 'required',
      'todate' => 'required'
    ]);

		$request['fdate'] = date_format(date_create($request->get('fdate')),"Y-m-d");
		$request['todate'] = date_format(date_create($request->get('todate')),"Y-m-d");
    

    $user_id = $request->get('user_id');
    $fdate =  $request->get('fdate');
    $todate = $request->get('todate');
    
    Session::put(['user_id'=>$user_id,'fdate'=>$fdate,'todate'=>$todate]);

  	return redirect(route('admin.contentOne'));


  }


}