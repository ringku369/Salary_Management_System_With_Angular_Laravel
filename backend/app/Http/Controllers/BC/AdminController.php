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
use App\Tsoupazila;


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
	  $this->middleware('auth')->except(['Test']);
		
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

		//dd(sha1('123123'));


//=====================
		$requestRetailerCount = User::where(['active'=> 0,'status'=> 0,'level'=>200])->orderBy('id','desc')->count();

		$_SESSION['requestRetailerCount'] = $requestRetailerCount;

//=====================
//=====================
	$returnCount = Preturn::where('status','<=', 2)->count();
	$_SESSION['returnCount'] = $returnCount;
//=====================



		$_SESSION['favicon'] = self::$favicon;
		$_SESSION['logo'] = self::$logo;


		$data['totalSale'] = Smsdetail::select('id')->count();
		$data['monthlySale'] = Smsdetail::select('id')->where(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"),date("Y-m") )->count();
		$data['todaySale'] = Smsdetail::select('id')->where(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"),date("Y-m-d") )->count();


//==================dayinmonthchartdata====================

$d=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));

  $datalist = [];
  for($d=1; $d<=31; $d++)
  {
    $time=mktime(12, 0, 0, date('m'), $d, date('Y'));          
    if (date('m', $time)==date('m')) {
      $count = Smsdetail::select('id')->where(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"),date('Y-m-d', $time))->count();

      $dayinmonthchartdata[] = ['year' => date('Y', $time), 'month' => date('m', $time), 'day' => date('d', $time), 'sale' => $count];

    }      
          
  }

//dd($dayinmonthchartdata);


//==================dayinmonthchartdata====================


//==================monthinyearchartdata====================

  $marray = ['01','02','03','04','05','06','07','08','09','10','11','12'];

  foreach ($marray as $key => $marray_val) {
  	
  	$count = Smsdetail::select('id')->where(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"),date("Y-$marray_val") )->count();

  	$monthinyearchartdata[] = ['year' => date('Y'), 'month' => $marray_val, 'sale' => $count];
  }


	//dd($monthinyearchartdata);
//==================monthinyearchartdata====================

//==================monthlytopproductchart====================
  $monthlytopproductchart = DB::table('smsdetails as t1')
  					->select(
  						DB::raw('COUNT(t1.product_id) as sale'), DB::raw('(SELECT name FROM products WHERE id = t1.product_id) as product')
  					)
  					->where(DB::raw("DATE_FORMAT(t1.created_at,'%Y-%m')"),date("Y-m") )
  					->groupBy('product_id')
  					->take(5)
  					->orderBy(DB::raw('COUNT(t1.product_id)'), 'desc')
  					->get();


  //dd($monthlytopproductchart);
//==================monthlytopproductchart====================

//==================monthlytopretailerchart====================
  $monthlytopretailerchart = DB::table('smsdetails as t1')
  					->select(
  						DB::raw('COUNT(t1.user_id) as sale'), DB::raw('(SELECT CONCAT(SUBSTRING(firstname,1,15), "-", officeid)  FROM users WHERE id = t1.user_id) as user')
  					)
  					->where(DB::raw("DATE_FORMAT(t1.created_at,'%Y-%m')"),date("Y-m") )
  					->groupBy('user_id')
  					->take(5)
  					->orderBy(DB::raw('COUNT(t1.user_id)'), 'desc')
  					->get();


  //dd($monthlytopretailerchart);
//==================monthlytopretailerchart====================

//==================todaybrandwisesalechart====================

		$brandResult = Brand::select('name','id')->get();
	  $brands = $brandResult->toArray();


	  foreach ($brands as $key => $value) {
	  	$brand_id = $value['id'];
	  	$name = $value['name'];

  	$sale = Smsdetail::select('id')->where('brand_id',$brand_id)->where(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"),date("Y-m-d") )->count();

  	$todaybrandwisesalechart[] = ['name'=>$name, 'sale' => $sale];

	  }


//==================todaybrandwisesalechart====================


//==================monthlybrandwisesalechart====================

		$brandResult = Brand::select('name','id')->get();
	  $brands = $brandResult->toArray();


	  foreach ($brands as $key => $value) {
	  	$brand_id = $value['id'];
	  	$name = $value['name'];

  	$sale = Smsdetail::select('id')->where('brand_id',$brand_id)->where(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"),date("Y-m") )->count();

  	$monthlybrandwisesalechart[] = ['name'=>$name, 'sale' => $sale];

	  }


//dd($color_code_array[$index[rand(0,9)]]);

//==================monthlybrandwisesalechart====================




//==================monthlytopproductsalechart====================
  $monthlytopproductsalechart = DB::table('sales as t1')
  					->select(
  						DB::raw('COUNT(t1.product_id) as sale'), DB::raw('(SELECT name FROM products WHERE id = t1.product_id) as product')
  					)
  					->where(DB::raw("DATE_FORMAT(t1.created_at,'%Y-%m')"),date("Y-m") )
  					->groupBy('product_id')
  					->take(5)
  					->orderBy(DB::raw('COUNT(t1.product_id)'), 'desc')
  					->get();


  //dd($monthlytopproductsalechart);
//==================monthlytopproductsalechart====================

//==================monthlytopdistributorchart====================
  $monthlytopdistributorchart = DB::table('sales as t1')
  					->select(
  						DB::raw('COUNT(t1.user_id) as sale'), DB::raw('(SELECT CONCAT(SUBSTRING(firstname,1,18), "-", officeid)  FROM users WHERE id = t1.user_id) as user')
  					)
  					->where(DB::raw("DATE_FORMAT(t1.created_at,'%Y-%m')"),date("Y-m") )
  					->groupBy('user_id')
  					->take(5)
  					->orderBy(DB::raw('COUNT(t1.user_id)'), 'desc')
  					->get();


  //dd($monthlytopdistributorchart);
//==================monthlytopdistributorchart====================




//==================================

$level1Data = [];

//===================================================================


$productResult = Product::with('cat','brand')->select('id','name','model','cat_id','brand_id')->orderBy('id','desc')->get();
$products = $productResult->toArray();
//dd($products);

$level1Data = [];
foreach ($products as $key => $productValue) {
  $product_id = $productValue['id'];
  $pdt = $productValue['name'];
  $model = $productValue['model'];
  $brand = $productValue['brand']['name'];
  $cat = $productValue['cat']['name'];


  $ndpr = Stock::where(['product_id'=>$product_id])->count();

  $purchaseResult = Purchase::select(DB::raw('SUM(quantity) as quantity'))->where(['product_id'=>$product_id])->first();
	$purchases = $purchaseResult->toArray();
	
	$ndsl = $purchases['quantity'];

	$ndst = $ndpr - $ndsl;

	$dpr = $ndsl;

	$dsl = Sale::where(['product_id'=>$product_id])->count();
	$dst = $dpr - $dsl;

	$tsl = Smsdetail::where(['product_id'=>$product_id])->count();
	$rst = $dsl-$tsl;

	$dmsl = Sale::where(['product_id'=>$product_id])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date('Y-m-d',strtotime(date("Y-m-d") . "-1 month")),date("Y-m-d")])
								->count();

	$dwsl = Sale::where(['product_id'=>$product_id])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date('Y-m-d',strtotime('last sunday')),date('Y-m-d',strtotime('last sunday'.'+6 days'))])
								->count();

	$dwsl1 = $dwsl;

	$ddlysl = Sale::where(['product_id'=>$product_id])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date("Y-m-d"),date("Y-m-d")])
								->count();

	$cmsl = Smsdetail::where(['product_id'=>$product_id])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date('Y-m-d',strtotime(date("Y-m-d") . "-1 month")),date("Y-m-d")])
								->count();


	$cwsl = Smsdetail::where(['product_id'=>$product_id])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date('Y-m-d',strtotime('last sunday')),date('Y-m-d',strtotime('last sunday'.'+6 days'))])
								->count();

	$cwsl1 = $cwsl;
								
	$cdlysl = Smsdetail::where(['product_id'=>$product_id])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date("Y-m-d"),date("Y-m-d")])
								->count();



if ($cwsl1 == 0) {
	$cdos = $rst/1;
}else{
	$cwsl1 = ceil($cwsl1/7);
	$cdos = $rst/$cwsl1;
}


if ($cwsl1 == 0) {
	$ddos = $dst/1;
}else{
	$cwsl1 = ceil($cwsl1/7);
	$ddos = $dst/$cwsl1;
}	
		
			

 	$level1Data[]=[
 		'pdt'=>$pdt,
 		'cat'=>$cat,
 		'brand'=>$brand,
 		'ndpr'=>$ndpr,
 		'ndsl'=>$ndsl,
 		'ndst'=>$ndst,
 		'dpr'=>$dpr,
 		'dsl'=>$dsl,
 		'dst'=>$dst,
 		'tsl'=>$tsl,
 		'rst'=>$rst,
 		'ddlysl'=>$ddlysl,
 		'dwsl'=>$dwsl,
 		'dmsl'=>$dmsl,
 		'cdlysl'=>$cdlysl,
 		'cwsl'=> $cwsl,
 		'cmsl'=>$cmsl,
 		'ddos'=>round($ddos),
 		'cdos'=>round($cdos),
 	];

}
//dd($level1Data);
//==================================

//==========================================================================


	  return view('admin.dashboard',['data' => $data, 'level1Data'=>$level1Data,'dayinmonthchartdata'=>$dayinmonthchartdata, 'monthinyearchartdata'=>$monthinyearchartdata,'monthlytopproductchart'=>$monthlytopproductchart,'monthlytopretailerchart'=>$monthlytopretailerchart,'todaybrandwisesalechart'=>$todaybrandwisesalechart,'monthlybrandwisesalechart'=>$monthlybrandwisesalechart,
	  	'monthlytopproductsalechart' => $monthlytopproductsalechart, 'monthlytopdistributorchart' => $monthlytopdistributorchart]);
	}

public function Test(){ 
//==================================

$requestUserCount = User::with('division','district','upazila')->where(['active'=> 0,'status'=> 0,'level'=>200])->orderBy('id','desc')->count();


$userResult = User::with('division','district','upazila')->where(['active'=> 0,'status'=> 0,'level'=>200])->orderBy('id','desc')->take(5)->get();
$users = $userResult->toArray();


dd($requestUserCount);


$data['startday'] = date('Y-m-d',strtotime('last sunday')); 
$data['endday'] =date('Y-m-d',strtotime('last sunday'.'+6 days')); 

dd($data);

$productResult = Product::select('id','name','model')->where(['brand_id'=>2])->orderBy('id','desc')->get();
$products = $productResult->toArray();

$level1Data = [];
foreach ($products as $key => $productValue) {
  $product_id = $productValue['id'];
  $pdt = $productValue['name'];
  $model = $productValue['model'];

  $ndpr = Stock::where(['product_id'=>$product_id,'brand_id'=>2])->count();
  //$ndsl = Purchase::where(['product_id'=>$product_id,'brand_id'=>2])->count();


	$purchaseResult = Purchase::select(DB::raw('SUM(quantity) as quantity'))->where(['product_id'=>$product_id,'brand_id'=>2])->first();
	$purchases = $purchaseResult->toArray();
	$ndsl = $purchases['quantity'];

	$ndst = $ndpr - $ndsl;

	$dpr = $ndsl;
	$dsl = Sale::where(['product_id'=>$product_id,'brand_id'=>2])->count();
	$dst = $dpr = $dsl;

	$tsl = Smsdetail::where(['product_id'=>$product_id,'brand_id'=>2])->count();
	$rst = $dst-$tsl;

	$ddlysl = Sale::where(['product_id'=>$product_id,'brand_id'=>2])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date("Y-m-d"),date("Y-m-d")])
								->count();

	$dwsl = Sale::where(['product_id'=>$product_id,'brand_id'=>2])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date('Y-m-d',strtotime(date("Y-m-d") . "-1 week")),date("Y-m-d")])
								->count();

	$dmsl = Sale::where(['product_id'=>$product_id,'brand_id'=>2])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date('Y-m-d',strtotime(date("Y-m-d") . "-1 month")),date("Y-m-d")])
								->count();

	$cdlysl = Smsdetail::where(['product_id'=>$product_id,'brand_id'=>2])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date("Y-m-d"),date("Y-m-d")])
								->count();

	$cwsl = Smsdetail::where(['product_id'=>$product_id,'brand_id'=>2])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date('Y-m-d',strtotime(date("Y-m-d") . "-1 week")),date("Y-m-d")])
								->count();

	$cmsl = Smsdetail::where(['product_id'=>$product_id,'brand_id'=>2])
								->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [date('Y-m-d',strtotime(date("Y-m-d") . "-1 month")),date("Y-m-d")])
								->count();



if ($ddlysl == 0) {
	$ddos = $dst/1;
}else{
	$ddos = $dst/$ddlysl;
}

if ($cdlysl == 0) {
	$cdos = $rst/1;
}else{
	$cdos = $rst/$cdlysl;
}						
			

 	$level1Data[]=[
 		'pdt'=>$pdt,
 		'ndpr'=>$ndpr,
 		'ndsl'=>$ndsl,
 		'ndst'=>$ndst,
 		'dpr'=>$dpr,
 		'dsl'=>$dsl,
 		'dst'=>$dst,
 		'tsl'=>$tsl,
 		'rst'=>$rst,
 		'ddlysl'=>$ddlysl,
 		'dwsl'=>$dwsl,
 		'dmsl'=>$dmsl,
 		'cdlysl'=>$cdlysl,
 		'cwsl'=>$cwsl,
 		'cmsl'=>$cmsl,
 		'ddos'=>$ddos,
 		'cdos'=>$cdos,
 	];

}
dd($level1Data);
//==================================
	
}
	// User =======================================
  


// ajax code ===============

	public function DistrictSelectBoxOnDivisionWithAjax($id){
    //if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $districtResult = District::where('division_id', $id)->get();
    return $districts = $districtResult->toArray();
  }


	public function UpazilaSelectBoxOnDistrictWithAjax($id){
    //if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $upazilaResult = Upazila::where('district_id', $id)->get();
    return $upazilas = $upazilaResult->toArray();
  }

  public function DistrictSelectBoxOnRetailerWithAjax($id){
    //if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $userResult = User::where(['district_id'=>$id,'level'=>200])->get();
    return $users = $userResult->toArray();
  }

  public function UpazilaSelectBoxOnRetailerWithAjax($id){
    //if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $userResult = User::where(['upazila_id'=>$id,'level'=>200])->get();
    return $users = $userResult->toArray();
  }

  public function Dontworryimeikeyup($imei=null){
    //if (Auth::user()->level != 500) { return redirect()->route('logout');}
    //$userResult = User::where(['upazila_id'=>$id,'level'=>200])->get();
    //return $users = $userResult->toArray();
	
		$count = Dwdetail::where(['sno' => $imei])->count();

		if ($count > 0) {
			return $arrayName = array('dwdublicate' =>1,'dwstatus' =>0,'slstatus' =>0,'wperiod' =>0,'product'=>null,'dwcharge'=>0,'dwday' =>0,'dwduration' =>0);
		}else{

			$count = Stock::where(['sno' => $imei])->count();
			if ($count > 0) {
				$stockResult = Stock::where(['sno' => $imei])->first();
		    	$stocks = $stockResult->toArray();
		    	$product_id = $stocks["product_id"];
		    	

		    	$count = Product::where(['id' => $product_id, 'dwstatus' => 1])->count();

		    	if ($count > 0) {
		    		$productResult = Product::where(['id' => $product_id, 'dwstatus' => 1])->first();
		    		$products = $productResult->toArray();

		    		$product = $products["name"] . " - ". $products["model"];
		    		$dwcharge = $products["dwcharge"];
		    		$dwday = $products["dwday"];
		    		$dwduration = $products["dwduration"];
		    		

					$count = Smsdetail::where(['sno' => $imei])->count();

					if ($count > 0) {

						$smsdetailResult = Smsdetail::where(['sno' => $imei])->first();
		    		$smsdetails = $smsdetailResult->toArray();
		    		$created_at = $smsdetails["created_at"];

						$date1 = strtotime(date_format(date_create($created_at),"Y-m-d"));
						$date2 = strtotime(date_format(date_create(date("Y-m-d h:i:s")),"Y-m-d"));
						$wperiod = ($date2 - $date1)/86400;

						return $arrayName = array('dwdublicate' =>0,'dwstatus' =>1,'slstatus' =>1,'wperiod' =>$wperiod,'product'=>$product,'dwcharge'=>$dwcharge,'dwday' =>$dwday,'dwduration' =>$dwduration);
					}else{
						return $arrayName = array('dwdublicate' =>0,'dwstatus' =>1,'slstatus' =>0,'wperiod' =>0,'product'=>$product,'dwcharge'=>$dwcharge,'dwday' =>$dwday,'dwduration' =>$dwduration);
					}

		    		
		    	}else{
		    		return $arrayName = array('dwdublicate' =>0,'dwstatus' =>0,'slstatus' =>0,'wperiod' =>0,'product'=>null,'dwcharge'=>0,'dwday' =>0,'dwduration' =>0);
		    	}
			}else{
				return $arrayName = array('dwdublicate' =>0,'dwstatus' =>0,'slstatus' =>0,'wperiod' =>0,'product'=>null,'dwcharge'=>0,'dwday' =>0,'dwduration' =>0);
			}
		}
	

    

    
  }



// ajax code ===============

  public function SingleUser($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		
		$requestRetailerCount = User::where(['active'=> 0,'status'=> 0,'level'=>200])->orderBy('id','desc')->count();

		$_SESSION['requestRetailerCount'] = $requestRetailerCount;

		//$userCount = User::count();
	  
	  //$userResult = User::with('territory')->get();
	  /*$userResult = User::with('retailer')->where('level','!=',200)->orderBy('level','desc')->get();
	  $users = $userResult->toArray();

		$userResult = User::select('id','firstname','officeid')->where('level',200)->orderBy('id','desc')->get();
	  $retailers = $userResult->toArray();*/

	  $users = User::with('retailer','sr','division','district','upazila','middistrict','tsoupazila')->where('id',$id)->where('level','!=',200)->orderBy('level','desc')->paginate(1);

		//dd($users);



	  $userResult = User::select('id','firstname','officeid')->where('level',200)->orderBy('id','desc')->get();
	  $retailers = $userResult->toArray();

	  $userResult = User::select('id','firstname','officeid')->where('level',50)->orderBy('id','desc')->get();
	  $srs = $userResult->toArray();


	  $divisionResult = Division::get();
	  $divisions = $divisionResult->toArray();

	  $districtResult = District::get();
	  $districts = $districtResult->toArray();

	  $upazilaResult = Upazila::get();
	  $upazilas = $upazilaResult->toArray();



  	return view('admin.singleuser',['users'=>$users,'retailers'=>$retailers,'srs'=>$srs,
  		'divisions'=>$divisions,'districts'=>$districts,'upazilas'=>$upazilas]);

  }


  public function UserView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		
		$requestRetailerCount = User::where(['active'=> 0,'status'=> 0,'level'=>200])->orderBy('id','desc')->count();

		$_SESSION['requestRetailerCount'] = $requestRetailerCount;


		//$userCount = User::count();
	  
	  //$userResult = User::with('territory')->get();
	  /*$userResult = User::with('retailer')->where('level','!=',200)->orderBy('level','desc')->get();
	  $users = $userResult->toArray();

		$userResult = User::select('id','firstname','officeid')->where('level',200)->orderBy('id','desc')->get();
	  $retailers = $userResult->toArray();*/

	  $users = User::with('retailer','sr','division','district','upazila')->where('level','!=',200)->where('level','!=',50)->where('level','!=',500)->orderBy('level','desc')->paginate(200);


	  $userResult = User::select('id','firstname','officeid')->where('level',200)->orderBy('id','desc')->get();
	  $retailers = $userResult->toArray();

	  $divisionResult = Division::get();
	  $divisions = $divisionResult->toArray();

	  $districtResult = District::get();
	  $districts = $districtResult->toArray();

	  $upazilaResult = Upazila::get();
	  $upazilas = $upazilaResult->toArray();


//dd($divisions);

  	return view('admin.user',['users'=>$users,'retailers'=>$retailers,
  		'divisions'=>$divisions,'districts'=>$districts,'upazilas'=>$upazilas]);

  }







  public function UserViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$statement = DB::select("show table status like 'users'");
		$ainid = $statement[0]->Auto_increment;


		//dd($request->all());
//========================================================================================
  		$this->validate($request, [
        //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        'firstname' => 'required|min:2|max:50',
        //'lastname' => 'required|min:1|max:50',
        'email' => 'required|email|unique:users',
        'officeid' => 'required|unique:users',
        'password' => 'required|min:3|max:20',
        'confirm_password' => 'required|min:3|max:20|same:password',
        'contact' => 'required|numeric|min:1',
        'level' => 'required'
      ]);	

/*if ($request['level'] == 300) {
  		$this->validate($request, [
        'retailers' => 'required'
      ]);	
}*/
      //dd($request->all());

      	$image = $request->file('image');
				
			  if (!is_null($image)) {
			  	$this->validate($request, [
		          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
		        ]);	


			  $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
				Storage::put($image_name, file_get_contents($image));
			  }else{
			  	$image_name = NULL;
			  }

			  $request['remember_token'] = $request['_token'];
				$request['password'] = bcrypt($request['password']);
			  $request['photo'] = $image_name;
			  //$request['region_id'] = NULL;
			  //$request['territory_id'] = NULL;
			  //$request['distributor_id'] = NULL;
			  
$retailers = $request->retailers;
$districts = $request->districts;
$upazilas = $request->upazilas;
		  	

		  	$parent = User::create($request->all());  

		  	$user_id = $parent->id;

		  	if ($request['level'] == 100) {

					foreach ($retailers as $key => $retailer) {
										
						$user = User::where('id',$retailer)->take(1)->first();

						$data['user_id'] = $user_id;
						$data['retailer_id'] = $user->id;
						$data['name'] = $user->firstname;
						$data['email'] = $user->email;
						$data['officeid'] = $user->officeid;
						Retailer::create($data);


					}

		  		
		  	}


		  	if ($request['level'] == 300) {

					foreach ($districts as $key => $district) {
										
						$count = Middistrict::where(['district_id'=>$district, 'user_id'=>$user_id])->count();
						if ($count < 1) {
						 	$dataResult = District::where('id',$district)->take(1)->first();

							$data1['user_id'] = $user_id;
							$data1['district_id'] = $dataResult->id;
							$data1['name'] = $dataResult->name;
							$data1['bn_name'] = $dataResult->bn_name;
							Middistrict::create($data1);

						} 
						
					}

		  		
		  	}


		  	if ($request['level'] == 10) {

					foreach ($upazilas as $key => $upazila) {
										
						$count = Tsoupazila::where(['upazila_id'=>$upazila, 'user_id'=>$user_id])->count();
						if ($count < 1) {
						 	$dataResult = Upazila::where('id',$upazila)->take(1)->first();

							$data1['user_id'] = $user_id;
							$data1['upazila_id'] = $dataResult->id;
							$data1['name'] = $dataResult->name;
							$data1['bn_name'] = $dataResult->bn_name;
							Tsoupazila::create($data1);

						} 
						
					}

		  		
		  	}

			return redirect()->back()->with('success', 'Data has been inserted successfully');

//========================================================================================


 
  }


  public function AddDistrict(Request $request){
  	if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$this->validate($request, [
        'user_id' => 'required',
        'districts' => 'required',
      ]);	

			$user_id = $request->user_id;
			$districts = $request->districts;


			foreach ($districts as $key => $district) {
						
				$count = Middistrict::where(['district_id'=>$district, 'user_id'=>$user_id])->count();

				if ($count > 0) {
					return redirect()->back()->withErrors("Same district can not be added")->withInput();
				}


			}

			foreach ($districts as $key => $district) {
								
				$count = Middistrict::where(['district_id'=>$district, 'user_id'=>$user_id])->count();
				if ($count < 1) {
				 	$dataResult = District::where('id',$district)->take(1)->first();

					$data1['user_id'] = $user_id;
					$data1['district_id'] = $dataResult->id;
					$data1['name'] = $dataResult->name;
					$data1['bn_name'] = $dataResult->bn_name;
					Middistrict::create($data1);

				} 
				
			}

		return redirect()->back()->with('success', 'Data has been inserted successfully');

	}




  public function deleteDistrict($id){
  	if (Auth::user()->level != 500) { return redirect()->route('logout');}

  	if ($id == null) {
			return redirect()->back()->withErrors("Retailer can not be deleted")->withInput();
		}


		/*$count = Sale::where(['retailer_id'=>$id])->count();
		
		if($count > 0 ){
			return redirect()->back()->withErrors('This user can not be deleted due to related to other data');
		}*/



		DB::table('middistricts')->where('id', $id)->delete();

		return redirect()->back()->with('success', 'Data has been deleted successfully');

	}




  public function AddUpazila(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $this->validate($request, [
        'user_id' => 'required',
        'upazilas' => 'required',
      ]); 

      $user_id = $request->user_id;
      $upazilas = $request->upazilas;
//dd($upazilas);

      foreach ($upazilas as $key => $upazila) {
            
        $count = Tsoupazila::where(['upazila_id'=>$upazila, 'user_id'=>$user_id])->count();

        if ($count > 0) {
          return redirect()->back()->withErrors("Same upazila can not be added")->withInput();
        }


      }

      foreach ($upazilas as $key => $upazila) {
                
        $count = Tsoupazila::where(['Upazila_id'=>$upazila, 'user_id'=>$user_id])->count();
        if ($count < 1) {
          $dataResult = Upazila::where('id',$upazila)->take(1)->first();

          $data1['user_id'] = $user_id;
          $data1['upazila_id'] = $dataResult->id;
          $data1['name'] = $dataResult->name;
          $data1['bn_name'] = $dataResult->bn_name;
          Tsoupazila::create($data1);

        } 
        
      }

    return redirect()->back()->with('success', 'Data has been inserted successfully');

  }




  public function deleteUpazila($id){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    if ($id == null) {
      return redirect()->back()->withErrors("Retailer can not be deleted")->withInput();
    }


    /*$count = Sale::where(['retailer_id'=>$id])->count();
    
    if($count > 0 ){
      return redirect()->back()->withErrors('This user can not be deleted due to related to other data');
    }*/



    DB::table('tsoupazilas')->where('id', $id)->delete();

    return redirect()->back()->with('success', 'Data has been deleted successfully');

  }






  public function AddRetailer(Request $request){
  	if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$this->validate($request, [
        'user_id' => 'required',
        'retailers' => 'required',
      ]);	

			$user_id = $request->user_id;
			$retailers = $request->retailers;


			foreach ($retailers as $key => $retailer) {
						
				$count = Retailer::where(['user_id' => $user_id, 'retailer_id' => $retailer])->count();

				if ($count > 0) {
					return redirect()->back()->withErrors("Same retailer can not be added")->withInput();
				}


			}

			foreach ($retailers as $key => $retailer) {
						
				$user = User::where('id',$retailer)->take(1)->first();

				$data['user_id'] = $user_id;
				$data['retailer_id'] = $user->id;
				$data['name'] = $user->firstname;
				$data['email'] = $user->email;
				$data['officeid'] = $user->officeid;
				
				Retailer::create($data);


			}

		return redirect()->back()->with('success', 'Data has been inserted successfully');

	}




  public function deleteRetailer($id){
  	if (Auth::user()->level != 500) { return redirect()->route('logout');}

  	if ($id == null) {
			return redirect()->back()->withErrors("Retailer can not be deleted")->withInput();
		}


		$count = Sale::where(['retailer_id'=>$id])->count();
		
		if($count > 0 ){
			return redirect()->back()->withErrors('This user can not be deleted due to related to other data');
		}



		DB::table('retailers')->where('id', $id)->delete();

		return redirect()->back()->with('success', 'Data has been deleted successfully');

	}







//================CheckRetailerView=======================

  
  public function CheckRetailerView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $requestRetailerCount = User::where(['active'=> 0,'status'=> 0,'level'=>200])->orderBy('id','desc')->count();

		$_SESSION['requestRetailerCount'] = $requestRetailerCount;


    $userCount = User::count();
    
    $officeid = Session::get('officeid');

    $ssdata = [];
    $totalamount = [];
    $retailers = [];

if ($officeid) {
  
$ssdata['officeid'] = $officeid;

$count1 = User::where(['level'=>200,'email'=>$officeid])->count();
$count2 = User::where(['level'=>200,'officeid'=>$officeid])->count();

if ($count1 > 0) {
	$retailers = User::with('division','district','upazila')->where(['level'=>200,'email'=>$officeid])->paginate(1);
}elseif ($count2 > 0) {
	$retailers = User::with('division','district','upazila')->where(['level'=>200,'officeid'=>$officeid])->paginate(1);
}else{
	$retailers = [];
}

//dd($retailers);

}

	  $divisionResult = Division::get();
	  $divisions = $divisionResult->toArray();

	  $districtResult = District::get();
	  $districts = $districtResult->toArray();

	  $upazilaResult = Upazila::get();
	  $upazilas = $upazilaResult->toArray();


//Session::forget(['user_id','fdate','todate']);

    return view('admin.checkRetailer',
    	['ssdata'=>$ssdata,'retailers'=>$retailers,
    	'totalamount'=>$totalamount,'divisions'=>$divisions, 'districts'=>$districts, 
    	'upazilas'=>$upazilas]);

  }


  public function CheckRetailerViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());


    Session::forget(['officeid']);

    $this->validate($request, [
      'officeid' => 'required'
    ]);


    //dd($request->all());

    $officeid = $request->get('officeid');
    
    Session::put(['officeid'=>$officeid]);

  return redirect(route('admin.user.CheckRetailer'));


  }

//================CheckRetailerView=======================





  public function UserUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		$id = $request->get('id');
  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request, [
        //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        'firstname' => 'required|min:2|max:50',
        //'lastname' => 'required|min:1|max:50',
        //'officeid' => 'required|unique:users',
        'contact' => 'required|numeric|min:1',
      ]);	


	  	//dd($request->all());


	  	$image = $request->file('image');


	  	$division_id = $request->get('division_id');
	  	$district_id = $request->get('district_id');
	  	$upazila_id = $request->get('upazila_id');
			//$attachment = $request->file('attachment');

		  if (!is_null($image)) {

				$this->validate($request, [
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        ]);
// for deleting file =======================
				File::delete('storage/app/' . $user['photo']);
// for deleting file =======================

			  $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
				Storage::put($image_name, file_get_contents($image));
			//=================================================================
				$user->firstname = $request->get('firstname');
				$user->lastname = $request->get('lastname');
				//$user->email = $request->get('email');
				//$user->officeid = $request->get('officeid');
				$user->contact = $request->get('contact');
				$user->photo = $image_name;

				$user->division_id = $division_id;
				$user->district_id = $district_id;
				$user->upazila_id = $upazila_id;

	      $user->save();

			//=================================================================

			  }else{
			  	//$image_name = NULL;

			//=================================================================
				$user->firstname = $request->get('firstname');
				$user->lastname = $request->get('lastname');
				//$user->email = $request->get('email');
				//$user->officeid = $request->get('officeid');
				$user->contact = $request->get('contact');
				
				$user->division_id = $division_id;
				$user->district_id = $district_id;
				$user->upazila_id = $upazila_id;



	      $user->save();

			//=================================================================

			  }

		return redirect()->back()->with('success', 'Data has been updated successfully');	  
 
  }

 
  }




  public function UserDontWorryInactive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];
  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
			$user->isdw = false;
  		$user->save();
  		return redirect()->back()->with('success', 'Data has been inactivated successfully');
		}

  }

  public function UserDontWorryActive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];
  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
			$user->isdw = true;
  		$user->save();
			return redirect()->back()->with('success', 'Data has been activated successfully');
		}

	
  }






  public function UserInactive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];

  	

  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
			$user->active = false;
  		$user->save();
  
			return redirect()->back()->with('success', 'Data has been inactivated successfully');
		}

  }

  public function UserActive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];

  	

  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
			$user->active = true;
  		$user->save();

  		

			return redirect()->back()->with('success', 'Data has been activated successfully');
		}

	
  }





  public function UserDisable(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];

  	

  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
			$user->dist_return = false;
  		$user->save();
			return redirect()->back()->with('success', 'Data has been inactivated successfully');
		}

  }

  public function UserEnable(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];

  	

  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
			$user->dist_return = true;
  		$user->save();
			return redirect()->back()->with('success', 'Data has been activated successfully');
		}
	
  }





  public function UpdateEmail(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}    
    
    //dd($request->all());

    $id = $request->get('id');
    $user = User::find($id);
    
    if ($user === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      $this->validate($request, [
        'email' => 'required|email|min:3|max:100|unique:users'
      ]); 

      $user->email = $request['email'];
      $user->save();

    }

    return redirect()->back()->with('success', 'Email has been updated successfully');

  }

  public function UpdateAlternativeEmail(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}    
    
    //dd($request->all());

    $id = $request->get('id');
    $user = User::find($id);
    
    if ($user === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      $this->validate($request, [
        'alemail' => 'required|email|min:3|max:100|unique:users'
      ]); 

      $user->alemail = $request['alemail'];
      $user->save();

    }

    return redirect()->back()->with('success', 'Email has been updated successfully');

  }




  public function UpdatePassword(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}	  
		
		//dd($request->all());

		$id = $request->get('id');
  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request, [
        'password' => 'required|min:3|max:200',
        'confirm_password' => 'required|min:3|max:200|same:password',
      ]);	

			$user->password = bcrypt($request['password']);
      $user->save();

		}

    return redirect()->back()->with('success', 'Password has been updated successfully');

  }

  public function UpdateOfficeid(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}	  
		
		//dd($request->all());

		$id = $request->get('id');
  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request, [
        'officeid' => 'required|min:3|max:200|unique:users',
        'confirm_officeid' => 'required|min:3|max:200|same:officeid',
      ]);	

//====================

	$count = Retailer::where(['retailer_id' => $id])->count();
	if ($count > 0) {
		DB::table('retailers')->where('retailer_id', $id)->update(['officeid' => $request['officeid']]);
	}
	
//====================
			$user->officeid = $request['officeid'];
      $user->save();

		}

    return redirect()->back()->with('success', 'Retailer ID has been updated successfully');

  }



  public function UserDestroy($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		$user = User::find($id);
		$smsdetailCount = Smsdetail::where(['user_id'=>$id])->count();
		$retailerCount = Retailer::where(['user_id'=>$id])->count();
		$srCount = Sr::where(['user_id'=>$id])->count();

		$middistrictCount = Middistrict::where(['user_id'=>$id])->count();


		$retailerCount2 = Retailer::where(['retailer_id'=>$id])->count();
		$srCount2 = Sr::where(['sr_id'=>$id])->count();


		



		if($smsdetailCount > 0 || $retailerCount > 0 || $srCount > 0 || $retailerCount2 > 0 || $srCount2 > 0 || $middistrictCount > 0 ){
			return redirect()->back()->withErrors('This user can not be deleted due to related to other data');
		}

		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{

			$photo = $user->photo;

			if (!is_null($photo)) {
				// for deleting file =======================
					File::delete('storage/app/' . $user['photo']);
				// for deleting file =======================
			}
//====================================
			
			$retailerCount1 = Retailer::where(['retailer_id'=>$id])->count();
			if ($retailerCount1 > 0) {
				DB::table('retailers')->where('retailer_id', $id)->delete();
			}
			
			$srCount1 = Sr::where(['sr_id'=>$id])->count();
			if ($srCount1 > 0) {
				DB::table('srs')->where('sr_id', $id)->delete();
			}
//====================================
			

	  	$user->delete();
			return redirect()->back()->with('success', 'Data has been deleted successfully');
		}
		

 
  }


/*

  public function TsoUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}	  
		$distributor_id = $request->get('distributor_id');
		$user_id = $request->get('id');

		foreach ($distributor_id as $key => $value) {
			$distuser = Distuser::where(['id'=>$value,'user_id'=>$user_id])->count();
	  	if ($distuser > 0) {
				return redirect()->back()->withErrors('Distributor is already added, please try again... ');
			}
	  }


	  $this->validate($request,['distributor_id'=>'required','id'=>'required']);
			

    foreach ($distributor_id as $key => $value) {
  		Distuser::create([
        'id' => $value,
        'user_id' => $user_id,
      ]);
  	}

    return redirect()->back()->with('success', 'Data has been added successfully');

  }


  public function TsodistDestroy($did){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		$distuser = Distuser::where(['did'=>$did])->get();

		if ($distuser === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{

	  	distuser::where(['did'=>$did])->delete();
			return redirect()->back()->with('success', 'Data has been deleted successfully');
		}
		

 
  }
*/

// User =======================================





// Setting =======================================
  
  public function SettingView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
		//$settingCount = Setting::count();
	  
	  $settingResult = Setting::orderBy('id','desc')->get();
	  $settings = $settingResult->toArray();

  	return view('admin.setting',['settings'=>$settings]);

  }

  public function SettingUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$id = $request->get('id');
  	$setting = Setting::find($id);
		
		if ($setting === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request,['currency'=>'required','code'=>'required','timezone'=>'required','hotline'=>'required','contact'=>'required','vat'=>'required','semail'=>'required']);

//==================================


			$image = $request->file('image');
			//$attachment = $request->file('attachment');

		  if (!is_null($image)) {

				$this->validate($request, [
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        ]);
// for deleting file =======================
				File::delete('storage/app/' . $setting['favicon']);
// for deleting file =======================

			  $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
				Storage::put($image_name, file_get_contents($image));
			//=================================================================
				$setting->favicon = $image_name;			 

			}

//==================================
//==================================


			$image = $request->file('image1');
			//$attachment = $request->file('attachment');

		  if (!is_null($image)) {

				$this->validate($request, [
          'image1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        ]);
// for deleting file =======================
				File::delete('storage/app/' . $setting['logo']);
// for deleting file =======================

			  $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
				Storage::put($image_name, file_get_contents($image));
			//=================================================================
				$setting->logo = $image_name;			 

			}

//==================================


			$setting->currency = $request->get('currency');
			$setting->code = $request->get('code');
			$setting->timezone = $request->get('timezone');
			$setting->hotline = $request->get('hotline');
			$setting->contact = $request->get('contact');
			$setting->vat = $request->get('vat');
			$setting->semail = $request->get('semail');
      $setting->save();


      return redirect()->back()->with('success', 'Data has been updated successfully');
		}

 
  }


// Setting =======================================






// Brand =======================================
  
  public function BrandView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
		//$brandCount = Brand::count();
	  
	  //$brandResult = Brand::with('territory')->get();
	  $brandResult = Brand::orderBy('id','desc')->get();
	  $brands = $brandResult->toArray();

	 //dd($brands);

  	return view('admin.brand',['brands'=>$brands]);

  }

  public function BrandViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$this->validate($request,['name'=>'required']);

  	Brand::create($request->all());
  	
		return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }

  public function BrandUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$id = $request->get('id');
  	$brand = Brand::find($id);
		
		if ($brand === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request,['name'=>'required']);
			$brand->name = $request->get('name');
      $brand->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
		}

 
  }

  public function BrandDestroy($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$brand = Brand::find($id);
		
  	$productCount = Product::where('brand_id', $id)->count();
  	//$product = Product::where('brand_id', $id)->get();

		if ($brand === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
  		if ($productCount > 0) {
				return redirect()->back()->withErrors('This Data can not be deleted becouse of related with product information');
			}else{
				$brand->delete();
				return redirect()->back()->with('success', 'Data has been deleted successfully');
			}


		}
		

 
  }


// Brand =======================================



// Cat =======================================
  
  public function CatView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
		//$catCount = Cat::count();
	  
	  //$catResult = Cat::with('territory')->get();
	  $catResult = Cat::orderBy('id','desc')->get();
	  $cats = $catResult->toArray();

	 //dd($cats);

  	return view('admin.cat',['cats'=>$cats]);

  }

  public function CatViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$this->validate($request,['name'=>'required']);

  	Cat::create($request->all());
  	
		return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }

  public function CatUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$id = $request->get('id');
  	$cat = Cat::find($id);
		
		if ($cat === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request,['name'=>'required']);
			$cat->name = $request->get('name');
      $cat->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
		}

 
  }

  public function CatDestroy($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$cat = Cat::find($id);
		
  	$productCount = Product::where('cat_id', $id)->count();
  	//$product = Product::where('cat_id', $id)->get();

		if ($cat === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
  		if ($productCount > 0) {
				return redirect()->back()->withErrors('This Data can not be deleted becouse of related with product information');
			}else{
				$cat->delete();
				return redirect()->back()->with('success', 'Data has been deleted successfully');
			}


		}
		

 
  }


// Cat =======================================



// Product =======================================
  
  public function ProductView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
		//$productCount = Product::count();
		$productResult = Product::with('brand','cat')->orderBy('id','desc')->get();
	  $products = $productResult->toArray();

//==================

		$brandResult = Brand::orderBy('id','desc')->get();
	  $brands = $brandResult->toArray();

		$catResult = Cat::orderBy('id','desc')->get();
	  $cats = $catResult->toArray();


//==================

	 //dd($products);

  	return view('admin.product',['products'=>$products,'brands'=>$brands,'cats'=>$cats]);

  }

  public function ProductViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$this->validate($request,[
  		'brand_id'=>'required',
  		'cat_id'=>'required',
  		'name'=>'required',
  		'model'=>'required',
  	]);

//file upload and update----------------


  $image = $request->file('image');
	if (!is_null($image)) {
  	$this->validate($request, [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
      ]);	


  $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
	Storage::put($image_name, file_get_contents($image));
  }else{
  	$image_name = NULL;
  }

//file upload and update----------------
$request['photo'] = $image_name;
//dd($request);
//dd($request->all());


  	Product::create($request->all());
  	
		return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }

  public function ProductUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		


  	$id = $request->get('id');
  	$product = Product::find($id);
		
		if ($product === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request,['brand_id'=>'required','cat_id'=>'required','name'=>'required','model'=>'required']);


//file upload and update----------------

  $image = $request->file('image');


  if (!is_null($image)) {
    $this->validate($request, [
      'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
    ]);
// for deleting file =======================
    File::delete('storage/app/' . $product->photo);
// for deleting file =======================
    $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
    Storage::put($image_name, file_get_contents($image));
  //=================================================================
   $product->photo = $image_name;    

  }

//file upload and update----------------


			$product->brand_id = $request->get('brand_id');
			$product->cat_id = $request->get('cat_id');
			$product->name = $request->get('name');
			$product->model = $request->get('model');
			$product->details = $request->get('details');
			$product->dwcharge = $request->get('dwcharge');
			$product->dwday = $request->get('dwday');
			$product->dwduration = $request->get('dwduration');
      $product->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
		}

 
  }

  public function ProductDestroy($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$product = Product::find($id);
		
  	//$productCount = 0;
  	$stockCount = Stock::where('product_id', $id)->count();
  	$smsdetailCount = Smsdetail::where('product_id', $id)->count();
  	$promodetailCount = Promodetail::where('product_id', $id)->count();
  	$specificationCount = Specification::where('product_id', $id)->count();

		if ($product === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
  		if ($stockCount > 0 || $smsdetailCount > 0 || $promodetailCount > 0 || $specificationCount > 0) {
				return redirect()->back()->withErrors('This Data can not be deleted due to related with other data');
			}else{
				// for deleting file =======================
			    File::delete('storage/app/' . $product->photo);
				// for deleting file =======================
				$product->delete();
				return redirect()->back()->with('success', 'Data has been deleted successfully');
			}


		}
		

 
  }



  public function ProductDontWorryInactive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];
  	$user = Product::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
			$user->dwstatus = false;
  		$user->save();
  		return redirect()->back()->with('success', 'Data has been inactivated successfully');
		}

  }

  public function ProductDontWorryActive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];
  	$user = Product::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
			$user->dwstatus = true;
  		$user->save();
			return redirect()->back()->with('success', 'Data has been activated successfully');
		}

	
  }

// Product =======================================





// Specification =======================================
  
  public function SpecificationView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    //$specificationCount = Specification::count();
    
    //$specificationResult = Specification::with('territory')->get();
    $specifications = Specification::with('product')->select('id','product_id','name','specificationdetails','created_at')->orderBy('id','desc')->paginate(500);
    //$specifications = $specificationResult->toArray();

		$productResult = Product::orderBy('id','desc')->get();
	  $products = $productResult->toArray();



   //dd($specifications);

    return view('admin.specification',['specifications'=>$specifications,'products'=>$products]);

  }

  public function SpecificationViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $this->validate($request,['name'=>'required','product_id'=>'required']);

    Specification::create($request->all());
    
    return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }

  public function SpecificationUpdate(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $id = $request->get('id');
    $specification = Specification::find($id);
    
    if ($specification === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      $this->validate($request,['name'=>'required','product_id'=>'required']);
      $specification->product_id = $request->get('product_id');
      $specification->name = $request->get('name');
      $specification->specificationdetails = $request->get('specificationdetails');
     //$specification->details = $request->get('details');
      $specification->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
    }

 
  }

  public function SpecificationDestroy($id){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $specification = Specification::find($id);
    
    $productCount = 0;
    //$productCount = Product::where('specification_id', $id)->count();
    //$product = Product::where('specification_id', $id)->get();

    if ($specification === null) {
      return redirect()->back()->withErrors('There are no data with this id');

    }else{
      if ($productCount > 0) {
        return redirect()->back()->withErrors('This Data can not be deleted becouse of related with product information');
      }else{
        $specification->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully');
      }


    }
    

 
  }


// Specification =======================================






// Stock =======================================
  
  public function StockView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    
    //$stockResult = Stock::with('territory')->get();
    $stocks = Stock::select('id','product_id','brand_id','imei','sno','wperiod','created_at')->with('product','brand')->orderBy('id','desc')->paginate(500);
    //$stocks = $stockResult->toArray();

   	$productResult = Product::orderBy('id','desc')->get();
	  $products = $productResult->toArray();


    return view('admin.stock',['stocks'=>$stocks,'products'=>$products]);

  }

  public function StockViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $this->validate($request,['product_id'=>'required']);

    $product_id = $request['product_id'];
    $imeis = $request['imeis'];
    $snos = $request['snos'];
    $wperiods = $request['wperiods'];



if ($imeis == null || $snos == null || $wperiods == null) {
	return redirect()->back()->withErrors("Please select add more option")->withInput();
}


foreach ($imeis as $key => $imei) {
	if ($imei == null ) {
		return redirect()->back()->withErrors("Please select IMEI No")->withInput();
	}

	if ($snos[$key] == null ) {
		return redirect()->back()->withErrors("Please select serial No")->withInput();
	}

	if ($wperiods[$key] == null ) {
		return redirect()->back()->withErrors("Please select warranty period")->withInput();
	}



}

foreach ($imeis as $key => $imei) {
	

	$request['product_id'] = $product_id;
	$request['imei'] = $imei;
	$request['sno'] = $snos[$key];
	$request['wperiod'] = $wperiods[$key];
	Stock::create($request->all());

}


//dd(count($imeis));



    
    
    return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }

  public function StockUpdate(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $id = $request->get('id');
    $stock = Stock::find($id);
    
    if ($stock === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      $this->validate($request,['product_id'=>'required','imei'=>'required','sno'=>'required','wperiod'=>'required']);
      $stock->product_id = $request->get('product_id');
      $stock->imei = $request->get('imei');
      $stock->sno = $request->get('sno');
      $stock->wperiod = $request->get('wperiod');
      $stock->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
    }

 
  }

  public function StockDestroy($id){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $stock = Stock::find($id);
    
    $productCount = 0;
    //$productCount = Product::where('stock_id', $id)->count();
    //$product = Product::where('stock_id', $id)->get();

    if ($stock === null) {
      return redirect()->back()->withErrors('There are no data with this id');

    }else{
      if ($productCount > 0) {
        return redirect()->back()->withErrors('This Data can not be deleted becouse of related with product information');
      }else{
        $stock->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully');
      }


    }
    

 
  }


// Stock =======================================





// Promo =======================================
  
  public function SinglePromo($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
	  
	  //$promoResult = Promo::with('territory')->get();
	  $promos = Promo::with('promodetail')->select('id','name','status','sdate as sdate1','edate as edate1','created_at',DB::raw('DATE_FORMAT(sdate,"%D %b %Y") as sdate,DATE_FORMAT(edate,"%D %b %Y") as edate'))->where('id',$id)->orderBy('id','desc')->paginate(1);
	  //$promos = $promoResult->toArray();


		$productResult = Product::orderBy('id','desc')->get();
	  $products = $productResult->toArray();


	 //dd($promos);

  	return view('admin.singlepromo',['promos'=>$promos,'products'=>$products]);

  }

  public function PromoView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
	  
	  //$promoResult = Promo::with('territory')->get();
	  $promos = Promo::select('id','name','status','sdate as sdate1','edate as edate1','created_at',DB::raw('DATE_FORMAT(sdate,"%D %b %Y") as sdate,DATE_FORMAT(edate,"%D %b %Y") as edate'))->orderBy('id','desc')->paginate(100);
	  //$promos = $promoResult->toArray();


		$productResult = Product::orderBy('id','desc')->get();
	  $products = $productResult->toArray();


	 //dd($promos);

  	return view('admin.promo',['promos'=>$promos,'products'=>$products]);

  }

  public function PromoViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
		$this->validate($request,[
			'name'=>'required',
			'sdate'=>'required',
			'edate'=>'required',
			'status'=>'required',
		]);


		$sdate = $request['sdate'];
		$edate = $request['edate'];
		$status = $request['status'];


		$products = $request['products'];
    $amounts = $request['amounts'];
    $quantites = $request['quantites'];
    $limits = $request['limits'];
    $details = $request['details'];



		if ($products == null || $amounts == null || $quantites == null || $limits == null || $details == null) {
			return redirect()->back()->withErrors("Please select add more option")->withInput();
		}


		foreach ($products as $key => $product) {
			if ($product == null ) {
				return redirect()->back()->withErrors("Please select product")->withInput();
			}

			if ($amounts[$key] == null ) {
				return redirect()->back()->withErrors("Please select amount")->withInput();
			}

			if ($quantites[$key] == null ) {
				return redirect()->back()->withErrors("Please select quantity")->withInput();
			}

			if ($limits[$key] == null ) {
				return redirect()->back()->withErrors("Please select limit per day")->withInput();
			}

			if ($details[$key] == null ) {
				return redirect()->back()->withErrors("Please select details")->withInput();
			}



		}



		$request['status'] = $status;

		$promo = Promo::create($request->all());

		foreach ($products as $key => $value) {
//=============
		$query = Product::select('id','brand_id')->where('id', $value)->take(1)->first();
    $queryresults = json_decode(json_encode($query), True);
    $brand_id = $queryresults['brand_id'];
//=============
			$data['promo_id'] = $promo->id;
			$data['product_id'] = $value;
			$data['brand_id'] = $brand_id;
			$data['amount'] = $amounts[$key];
			$data['quantity'] = $quantites[$key];
			$data['limitperday'] = $limits[$key];
			$data['details'] = $details[$key];
			$data['sdate'] = $sdate;
			$data['edate'] = $edate;
			$data['status'] = $status;

			Promodetail::create($data);
		}

		return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }

  public function PromoUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$id = $request->get('id');
  	$promo = Promo::find($id);
		
		if ($promo === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request,['name'=>'required','sdate'=>'required','edate'=>'required']);
			$promo->name = $request->get('name');
			$promo->sdate = $request->get('sdate');
			$promo->edate = $request->get('edate');
//--------------------
			DB::table('promodetails')->where('promo_id', $id)->update(['sdate' => $request->get('sdate'),'edate'=>$request->get('edate')]);
//--------------------

      $promo->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
		}

 
  }

  public function PromoDestroy($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$promo = Promo::find($id);
		
  	$productCount = 0;
  	//$productCount = Product::where('promo_id', $id)->count();
  	//$product = Product::where('promo_id', $id)->get();

		if ($promo === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
  		if ($productCount > 0) {
				return redirect()->back()->withErrors('This Data can not be deleted becouse of related with product information');
			}else{
			
//----------------------
				DB::table('promodetails')->where('promo_id', $id)->delete();
//----------------------

				$promo->delete();
				return redirect()->back()->with('success', 'Data has been deleted successfully');
			}


		}
		

 
  }

  public function PromoDetailsDestroy($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$promodetail = Promodetail::find($id);
		
  	$productCount = 0;
  	//$productCount = Product::where('promo_id', $id)->count();
  	//$product = Product::where('promo_id', $id)->get();

		if ($promodetail === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
  		if ($productCount > 0) {
				return redirect()->back()->withErrors('This Data can not be deleted becouse of related with product information');
			}else{
				$promodetail->delete();
				return redirect()->back()->with('success', 'Data has been deleted successfully');
			}


		}
		

 
  }

  public function PromoDetailsUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$id = $request->get('id');
  	//$promodetail = Promodetail::where('id',$id)->count();
  	$promodetail = Promodetail::find($id);
		//dd($promodetail);
  	//dd($request->all());


		if ($promodetail === null) {

			return redirect()->back()->withErrors('There are no data with this id');

		}else{
	  	$this->validate($request,[
	  		'product_id'=>'required',
	  		'amount'=>'required',
	  		'quantity'=>'required',
	  		'limitperday'=>'required'
	  	]);
			$promodetail->product_id = $request->get('product_id');
			$promodetail->amount = $request->get('amount');
			$promodetail->quantity = $request->get('quantity');
			$promodetail->limitperday = $request->get('limitperday');
			$promodetail->details = $request->get('details');
      $promodetail->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
		}

 
  }



  public function ChangeActiveStatus(Request $request){
		
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$this->validate($request,['id'=>'required','status'=>'required']);

  	$id = $request->get('id');
  	$status = $request->get('status');

  	if ($status == 1) { $status = 0;}else{ $status = 1;}
			$promo = Promo::find($id);
		if ($promo === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$promo->status = $status;
      $promo->save();
//---------------------
	DB::table('promodetails')->where('promo_id', $id)->update(['status' => $status]);

//---------------------

      return redirect()->back()->with('success', 'Data has been updated successfully');
		}

	}


  public function changeActiveStatusPromoDetails(Request $request){
		
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$this->validate($request,['id'=>'required','status'=>'required']);

  	$id = $request->get('id');
  	$status = $request->get('status');

  	if ($status == 1) { $status = 0;}else{ $status = 1;}
			$promodetail = Promodetail::find($id);
		if ($promodetail === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$promodetail->status = $status;
      $promodetail->save();

      return redirect()->back()->with('success', 'Data has been updated successfully');
		}

	}








// Promo =======================================



// Promort =======================================
  
  public function SinglePromort($id){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    
    //$promortResult = Promort::with('territory')->get();
    $promorts = Promort::with('promortdetail','promortretailer')->select('id','name','status','sdate as sdate1','edate as edate1','created_at',DB::raw('DATE_FORMAT(sdate,"%D %b %Y") as sdate,DATE_FORMAT(edate,"%D %b %Y") as edate'))->where('id',$id)->orderBy('id','desc')->paginate(1);
    //$promorts = $promortResult->toArray();


		$userResult = User::select('id','firstname','officeid')->where('level',200)->orderBy('id','desc')->get();
	  $users = $userResult->toArray();

	  //dd($promorts);

    return view('admin.singlepromort',['promorts'=>$promorts, 'users'=>$users]);

  }

  public function PromortView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    
    //$promortResult = Promort::with('territory')->get();
    $promorts = Promort::select('id','name','status','sdate as sdate1','edate as edate1','created_at',DB::raw('DATE_FORMAT(sdate,"%D %b %Y") as sdate,DATE_FORMAT(edate,"%D %b %Y") as edate'))->orderBy('id','asc')->paginate(100);
    //$promorts = $promortResult->toArray();


		$userResult = User::select('id','firstname','officeid')->where('level',200)->orderBy('id','desc')->get();
	  $users = $userResult->toArray();

	  //dd($promorts);

    return view('admin.promort',['promorts'=>$promorts]);

  }

  public function PromortViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $this->validate($request,[
      'name'=>'required',
      'sdate'=>'required',
      'edate'=>'required',
      'status'=>'required',
    ]);


//dd($request->all());

    $sdate = $request['sdate'];
    $edate = $request['edate'];
    $status = $request['status'];


    //$users = $request['users'];
    //$amounts = $request['amounts'];
    $quantites = $request['quantites'];
    $limits = $request['limits'];
    $details = $request['details'];



    if ($quantites == null || $limits == null || $details == null) {
      return redirect()->back()->withErrors("Please select add more option")->withInput();
    }


    foreach ($details as $key => $value) {
    
      if ($value == null ) {
        return redirect()->back()->withErrors("Please select details")->withInput();
      }

      if ($quantites[$key] == null ) {
        return redirect()->back()->withErrors("Please select quantity")->withInput();
      }

      if ($limits[$key] == null ) {
        return redirect()->back()->withErrors("Please select limit per day")->withInput();
      }

      



    }



    $request['status'] = $status;

    $promort = Promort::create($request->all());

    foreach ($details as $key => $value) {

      $data['promort_id'] = $promort->id;
      //$data['user_id'] = $value;
      //$data['amount'] = $value;
      
      $data['details'] = $value;
      $data['quantity'] = $quantites[$key];
      $data['limitperday'] = $limits[$key];
      
      $data['sdate'] = $sdate;
      $data['edate'] = $edate;
      $data['status'] = $status;

      Promortdetail::create($data);
    }

    return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }

  public function PromortUpdate(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $id = $request->get('id');
    $promort = Promort::find($id);
    
    if ($promort === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      $this->validate($request,['name'=>'required','sdate'=>'required','edate'=>'required']);
      $promort->name = $request->get('name');
      $promort->sdate = $request->get('sdate');
      $promort->edate = $request->get('edate');
//--------------------
      DB::table('promortdetails')->where('promort_id', $id)->update(['sdate' => $request->get('sdate'),'edate'=>$request->get('edate')]);
//--------------------

      $promort->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
    }

 
  }

  public function PromortDestroy($id){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $promort = Promort::find($id);
    
    $userCount = 0;
    $userCount = Promortsmsdetail::where('promort_id', $id)->count();
    //$user = User::where('promort_id', $id)->get();

    if ($promort === null) {
      return redirect()->back()->withErrors('There are no data with this id');

    }else{
      if ($userCount > 0) {
        return redirect()->back()->withErrors('This Data can not be deleted becouse of related with user information');
      }else{
      
//----------------------
        DB::table('promortdetails')->where('promort_id', $id)->delete();
        DB::table('promortretailers')->where('promort_id', $id)->delete();
//----------------------

        $promort->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully');
      }


    }
    

 
  }

  public function PromortDetailsDestroy($id){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $promortdetail = Promortdetail::find($id);
    
    $userCount = 0;
    $userCount = Promortsmsdetail::where('promortdetail_id', $id)->count();
    //$user = User::where('promort_id', $id)->get();

    if ($promortdetail === null) {
      return redirect()->back()->withErrors('There are no data with this id');

    }else{
      if ($userCount > 0) {
        return redirect()->back()->withErrors('This Data can not be deleted becouse of related with user information');
      }else{
        $promortdetail->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully');
      }


    }
    
 
  }

  public function PromortRetailerDestroy($id){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $promortretailer = Promortretailer::find($id);
    
    $userCount = 0;
    //$userCount = User::where('promort_id', $id)->count();
    //$user = User::where('promort_id', $id)->get();

    if ($promortretailer === null) {
      return redirect()->back()->withErrors('There are no data with this id');

    }else{
      if ($userCount > 0) {
        return redirect()->back()->withErrors('This Data can not be deleted becouse of related with user information');
      }else{
        $promortretailer->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully');
      }


    }
    
 
  }

  public function PromortDetailsUpdate(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $id = $request->get('id');
    //$promortdetail = Promortdetail::where('id',$id)->count();
    $promortdetail = Promortdetail::find($id);
    //dd($promortdetail);
    //dd($request->all());


    if ($promortdetail === null) {

      return redirect()->back()->withErrors('There are no data with this id');

    }else{
      $this->validate($request,[
        //'user_id'=>'required',
        //'amount'=>'required',
        'quantity'=>'required',
        'limitperday'=>'required',
        'details'=>'required'
      ]);
      //$promortdetail->user_id = $request->get('user_id');
      //$promortdetail->amount = $request->get('amount');
      $promortdetail->quantity = $request->get('quantity');
      $promortdetail->limitperday = $request->get('limitperday');
      $promortdetail->details = $request->get('details');
      $promortdetail->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
    }

 
  }

  public function PromortDetailsAdd(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $this->validate($request,[
        'promort_id'=>'required',
        'quantity'=>'required',
        'limitperday'=>'required',
        'details'=>'required'
      ]);
		
		$query = Promort::where(['id'=>$request->promort_id])->first();
		$promorts = $query->toArray();

		$request['sdate'] = $promorts['sdate'];
		$request['edate'] = $promorts['edate'];


    	$request['status'] = 1;
      Promortdetail::create($request->all());

      return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }

  public function PromortRetailerAdd(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    	$this->validate($request,[
        'promort_id'=>'required',
        'users'=>'required'
      ]);

    	//dd($request->all());

    	$users = $request->users;
    	$promort_id = $request->promort_id;
    	$data['promort_id'] = $request->promort_id;
      foreach ($users as $key => $value) {

      	$count = Promortretailer::where(['user_id'=>$value, 'promort_id' => $promort_id])->count();

      	if ($count < 1) {
      		$data['user_id'] = $value;
					Promortretailer::create($data);
      	}

				
	    }


      return redirect()->back()->with('success', 'Data has been inserted successfully');
  }



  public function ChangeActiveStatusPromort(Request $request){
    
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
//dd($request->all());

    $this->validate($request,['id'=>'required','status'=>'required']);

    $id = $request->get('id');
    $status = $request->get('status');

    if ($status == 1) { $status = 0;}else{ $status = 1;}
      $promort = Promort::find($id);
    if ($promort === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      $promort->status = $status;
      $promort->save();
//---------------------
  DB::table('promortdetails')->where('promort_id', $id)->update(['status' => $status]);
//---------------------

      return redirect()->back()->with('success', 'Data has been updated successfully');
    }

  }


  public function ChangeActiveStatusPromortDetails(Request $request){
    
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
//dd($request->all());

    $this->validate($request,['id'=>'required','status'=>'required']);

    $id = $request->get('id');
    $status = $request->get('status');

    if ($status == 1) { $status = 0;}else{ $status = 1;}
      $promortdetail = Promortdetail::find($id);
    if ($promortdetail === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      $promortdetail->status = $status;
      $promortdetail->save();

      return redirect()->back()->with('success', 'Data has been updated successfully');
    }

  }








// Promort =======================================


// Promortkey =======================================
  
  public function PromortkeyView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    //$promortkeyCount = Promortkey::count();
    
    //$promortkeyResult = Promortkey::with('territory')->get();
    $promortkeyResult = Promortkey::orderBy('id','desc')->get();
    $promortkeys = $promortkeyResult->toArray();

   //dd($promortkeys);

    return view('admin.promortkey',['promortkeys'=>$promortkeys]);

  }

  public function PromortkeyViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $this->validate($request,['name'=>'required']);

    Promortkey::create($request->all());
    
    return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }

  public function PromortkeyUpdate(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $id = $request->get('id');
    $promortkey = Promortkey::find($id);
    
    if ($promortkey === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      $this->validate($request,['name'=>'required']);
      $promortkey->name = $request->get('name');
      $promortkey->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
    }

 
  }

  public function PromortkeyDestroy($id){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $promortkey = Promortkey::find($id);
    
    $productCount = Promortsmsdetail::where('promortkey_id', $id)->count();
    //$product = Product::where('promortkey_id', $id)->get();

    if ($promortkey === null) {
      return redirect()->back()->withErrors('There are no data with this id');

    }else{
      if ($productCount > 0) {
        return redirect()->back()->withErrors('This Data can not be deleted becouse of related with product information');
      }else{
        $promortkey->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully');
      }


    }
    

 
  }


  public function PromortkeyInactive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];

  	

  	$user = Promortkey::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
			$user->status = false;
  		$user->save();
  
			return redirect()->back()->with('success', 'Data has been inactivated successfully');
		}

  }

  public function PromortkeyActive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];

  	

  	$user = Promortkey::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
			$user->status = true;
  		$user->save();

  		

			return redirect()->back()->with('success', 'Data has been activated successfully');
		}



	
  }


// Promortkey =======================================




// Upload1 =======================================
  
  public function Upload1View(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
		

  	return view('admin.upload1');

  }

  public function Upload1ViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	//$this->validate($request,['type'=>'required']);

  	$type = $request->type;
//==================================
		$image = $request->file('csv_file');
		
	  if (!is_null($image)) {

			$this->validate($request, [
        'csv_file' => 'required|mimes:csv,txt|max:200000',
      ]);

		 // $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
			//Storage::put($image_name, file_get_contents($image));
		//================================================================= 

		}


/*		if ($type != 5) {
			return redirect()->back()->withErrors('Only bulk stock can be uploaded');
		}*/

//==================================

if ($type == 1) {
// for brand-------------------
/*//======================
	$count = Brand::count();
	if ($count > 0) {
		return redirect()->back()->withErrors("Process can not be completed due to data has already been stored.")->withInput();
	}
//======================*/
  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));

		foreach ($csv_data as $key => $value) {
			$data1['name'] = $value[0];
			Brand::create($data1);
		}
// for brand-------------------
} else if($type == 2){
//======================
/*	$count = Cat::count();
	if ($count > 0) {
		return redirect()->back()->withErrors("Process can not be completed due to  data has already been stored.")->withInput();
	}*/
//======================

// for category-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));


		foreach ($csv_data as $key => $value) {
			$data1['name'] = $value[0];
			Cat::create($data1);
		}


// for category-------------------
} else if($type == 3) {
// for product-------------------
/*//======================
	$count = Product::count();
	if ($count > 0) {
		return redirect()->back()->withErrors("Process can not be completed due to data has already been stored.")->withInput();
	}
//======================*/
  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
		
		foreach ($csv_data as $key => $value) {
			$product = $value[0];
			$model = $value[1];
			$cat = $value[3];
			$brand = $value[2];
			
			

//---------------------------------------
		$brandResult = DB::table('brands')->select('id','name')->where(['name'=>$brand])->take(1)->first();
		$branddata = json_decode(json_encode($brandResult), True);

		$data1['brand_id'] = $branddata['id'];
		
//---------------------------------------
//---------------------------------------
		$catResult = DB::table('cats')->select('id','name')->where(['name'=>$cat])->take(1)->first();
		$catdata = json_decode(json_encode($catResult), True);
		

		$data1['cat_id'] = $catdata['id'];
//---------------------------------------
//---------------------------------------
		$data1['name'] = $product;
		$data1['model'] = $model;
		Product::create($data1);
//---------------------------------------

		}
// for product-------------------

}else if($type == 4){

/*//======================
	$count = Specification::count();
	if ($count > 0) {
		return redirect()->back()->withErrors("Process can not be completed due to  data has already been stored.")->withInput();
	}
//======================*/



// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
		
		foreach ($csv_data as $key => $value) {
			$name = $value[0];
			$specificationdetails = $value[1];
			$model = $value[2];
			$brand = $value[3];
			
			

//---------------------------------------
		$productResult = DB::table('products')->select('id','name')->where(['model'=>$model])->take(1)->first();
		$productdata = json_decode(json_encode($productResult), True);
		

		$data1['product_id'] = $productdata['id'];
//---------------------------------------

//---------------------------------------
		$brandResult = DB::table('brands')->select('id','name')->where(['name'=>$brand])->take(1)->first();
		$branddata = json_decode(json_encode($brandResult), True);

		$data1['brand_id'] = $branddata['id'];
		
//---------------------------------------

//---------------------------------------
		$data1['name'] = $name;
		$data1['specificationdetails'] = $specificationdetails;
		Specification::create($data1);
//---------------------------------------

		}
// for product specification-------------------

}else if($type == 5){

/*//======================
	$count = Stock::count();
	if ($count > 0) {
		return redirect()->back()->withErrors("Process can not be completed due to  data has already been stored.")->withInput();
	}
//======================*/


// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
		
		foreach ($csv_data as $key => $value) {

			$data1['imei'] = $value[1];
			$data1['sno'] = $value[3];

			
//---------------------------------------
		$model = $value[5];

		$productResult = DB::table('products')->select('id','name','brand_id')->where(['model'=>$model])->take(1)->first();
		$productdata = json_decode(json_encode($productResult), True);
		

		$data1['product_id'] = $productdata['id'];
		$data1['brand_id'] = $productdata['brand_id'];
//---------------------------------------

			//$data1['details'] = $value[6];
			$data1['wperiod'] = $value[6];
			
			Stock::create($data1);
//---------------------------------------

		}
// for product specification-------------------

}else if($type == 6){

/*//======================
	$count = User::where('id','!=',2)->count();
	if ($count > 0) {
		return redirect()->back()->withErrors("Process can not be completed due to data has already been stored.")->withInput();
	}
//======================*/


// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
		
		$rowCount = 0;
		$officedata = [];
		foreach ($csv_data as $key => $value) {
			$officeid = $value[0];
			$count = User::where(['officeid'=>$officeid])->count();
			if ($count > 0) {
				//return redirect()->back()->withErrors("Process can not be completed due to same Retailer id  : $officeid.")->withInput();
				$officedata[] = $officeid;
        $rowCount += 1;


			}
		}

		//----------------
			if ($rowCount > 0 ) {
			  $officedata_implode = implode(", ", $officedata);
			  return redirect()->back()->withErrors("Process can not be completed due to same Retailer CODE  : </br> $officedata_implode")->withInput();
			}
		//----------------



		foreach ($csv_data as $key => $value) {
			
			$data1['officeid'] = $value[0];
			$data1['password'] = Hash::make($value[0]);
			$data1['firstname'] = $value[1];
			$data1['contact'] = $value[2];
			$data1['email'] = $value[3];
			$data1['level'] = 200;




			User::create($data1);
//---------------------------------------

		}
// for product specification-------------------

}else if($type == 7){

/*//======================
	$count = User::where('id','!=',2)->count();
	if ($count > 0) {
		return redirect()->back()->withErrors("Process can not be completed due to data has already been stored.")->withInput();
	}
//======================*/


// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
		
		foreach ($csv_data as $key => $value) {



			//$data['imei'] = $value[1];
			$sno = $value[1];
			$data1['sno'] = $value[1];

			$product = $value[2];
			$model = $value[3];

$smscount = Smsdetail::where(['sno'=>$sno])->count(); 

if ($smscount < 1) {
	# code...

//---------------------------------------
		$productResult = DB::table('products')->select('id','name','brand_id')->where(['model'=>$model])->take(1)->first();
		$productdata = json_decode(json_encode($productResult), True);
		
		$data1['product_id'] = $productdata['id'];
		$data1['brand_id'] = $productdata['brand_id'];
//---------------------------------------
		

			$date1 = strtotime(date_format(date_create($value[5]),"Y-m-d"));
			$date2 = strtotime(date_format(date_create($value[6]),"Y-m-d"));
			$wperiod = ($date2 - $date1)/86400;
			$data1['wperiod'] = ($date2 - $date1)/86400;
			

			$officeid = $value[7];

//--------------------------------------
		$userResult = DB::table('users')->select('id')->where(['officeid'=>$officeid])->first();
		$userdata = json_decode(json_encode($userResult), True);

		$data1['user_id'] = $userdata['id'];
//--------------------------------------

			
			$data1['created_at'] = date_format(date_create($value[4]),"Y-m-d H:i:s");
			$data1['updated_at'] = date_format(date_create($value[6]),"Y-m-d H:i:s");

			$data1['mobile'] = $value[9];

			$data1['promo_id'] = 0;
			$data1['promodetail_id'] = 0;

			$data1['status'] = 0;


//----------------------------------------
		$dwcount = Dwdetail::where(['sno'=>$sno, 'status' => 0])->count();  

		if ($dwcount > 0) {
			DB::table('dwdetails')->where('sno', $sno)->update(['status' => 1]);
			
			$dwdetail = Dwdetail::where(['sno'=>$sno])->first();    
			



			$sno = $dwdetail->sno;
	    $dwday = $dwdetail->dwday;
	    $dwcharge = $dwdetail->dwcharge;
	    
	    $mobileno = $dwdetail->mobile;

	    //=======================================
	    	$msg = "Thank you, your don't worry offer is approvd. Your Warranty is extended for " .$dwday.  " days";
	    	//self::send_msg($mobileno,$msg);

	    //=======================================


	    $data1['iswar'] = 1;
			$data1['isdw'] = 1;
			$data1['dwday'] = $dwday;
			$data1['dwcharge'] = $dwcharge;
			$data1['twperiod'] = $wperiod + $dwday;

		}

Smsdetail::create($data1);
//dd($data1);
//----------------------------------------
		


}


//---------------------------------------

		}
// for product specification-------------------




}else if($type == 8){

/*//======================
	$count = User::where('id','!=',2)->count();
	if ($count > 0) {
		return redirect()->back()->withErrors("Process can not be completed due to data has already been stored.")->withInput();
	}
//======================*/


// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
		
		foreach ($csv_data as $key => $value) {



			$sno = $value[2];
			
//---------------------------------------

		$count = DB::table('smsdetails')->select('id')->where(['sno' => $sno])->count();
		if ($count < 1) {
			return redirect()->back()->withErrors("Serial No Not Found")->withInput();
		}


		$smsdetailResult = DB::table('smsdetails')->select('id')->where(['sno'=>$sno,'status' => 0])->take(1)->first();
		$smsdetaildata = json_decode(json_encode($smsdetailResult), True);
		
		$id = $smsdetaildata['id'];

//---------------------------------------
		

			$data1['remarks'] = $value[5];
			$data1['status'] = 1;
			
			DB::table('smsdetails')->where('id', $id)->update($data1);
//---------------------------------------

		}
// for product specification-------------------




}
else if($type == 9){

/*//======================
	$count = User::where('id','!=',2)->count();
	if ($count > 0) {
		return redirect()->back()->withErrors("Process can not be completed due to data has already been stored.")->withInput();
	}
//======================*/


// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
		
		foreach ($csv_data as $key => $value) {



	$distributor = $value[0];
	$retail = $value[1];
			
//---------------------------------------

	

		$disresult = DB::table('users')->select('id')->where(['officeid'=>$distributor])->take(1)->first();
		$disdata = json_decode(json_encode($disresult), True);
		
		$disid = $disdata['id'];

		$retailresult = DB::table('users')->select('id','firstname','email','officeid')->where(['officeid'=>$retail])->take(1)->first();
		$retaildata = json_decode(json_encode($retailresult), True);
		
		$rid = $retaildata['id'];
		$firstname = $retaildata['firstname'];
		$email = $retaildata['email'];
		$officeid = $retaildata['officeid'];

//---------------------------------------
		

			$data1['retailer_id'] = $rid;
			$data1['user_id'] = $disid;
			$data1['name'] = $firstname;
			$data1['email'] = $email;
			$data1['officeid'] = $officeid;

			
			Retailer::create($data1);
//---------------------------------------

		}
// for product specification-------------------




}

else if($type == 10){


// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
		
		foreach ($csv_data as $key => $value) {



	$distributor = $value[0];
	$sno = $value[1];
			
//---------------------------------------
		$count2 = DB::table('purchases')->select('id')->where(['sno'=>$sno])->count();
		if ($count2 > 0) {
			return redirect()->back()->withErrors("Duplicate serial no :  $sno can not be taken")->withInput();
		}	
	
		$count = DB::table('users')->select('id')->where(['officeid'=>$distributor])->count();
			
		if ($count < 1) {
			return redirect()->back()->withErrors("There is no user with this dstributor $distributor")->withInput();
		}		

		$count1 = DB::table('stocks')->select('id')->where(['sno'=>$sno])->count();
		if ($count1 < 1) {
			return redirect()->back()->withErrors("There is no more product in stock with this sno $sno")->withInput();
		}
//---------------------------------------

	}
// for product specification-------------------
		


		foreach ($csv_data as $key => $value) {



	$distributor = $value[0];
	$sno = $value[1];
			
//---------------------------------------




		$disresult = DB::table('users')->select('id')->where(['officeid'=>$distributor])->take(1)->first();
		$disdata = json_decode(json_encode($disresult), True);

		$disid = $disdata['id'];

		$stockresult = DB::table('stocks')->select('id','product_id','imei','sno','brand_id')->where(['sno'=>$sno])->take(1)->first();
		$stockdata = json_decode(json_encode($stockresult), True);
		
		$stock_id = $stockdata['id'];
		$product_id = $stockdata['product_id'];
		$brand_id = $stockdata['brand_id'];
		$imei = $stockdata['imei'];
		$sno = $stockdata['sno'];



		if ($imei == "") {
			$imei = NULL;
		}

//---------------------------------------
		

			$data1['stock_id'] = $stock_id;
			$data1['user_id'] = $disid;
			$data1['product_id'] = $product_id;
			$data1['brand_id'] = $brand_id;
			$data1['imei'] = $imei;
			$data1['sno'] = $sno;

			
			Purchase::create($data1);
//---------------------------------------

		}
// for product specification-------------------




}

else if($type == 11){


// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
	

//===============================================
	foreach ($csv_data as $key => $value) {



		$retailer = $value[0];
		$sno = $value[1];
	
	$created_at = date_format(date_create($value[2]),"Y-m-d H:i:s");
	$updated_at = date_format(date_create($value[2]),"Y-m-d H:i:s");	

//dd($created_at);

		//$created_at = date_format(date_create($value[2]),"Y-m-d H:i:s");
		//$updated_at = date_format(date_create($value[2]),"Y-m-d H:i:s");
			
	//---------------------------------------
			$count1 = DB::table('stocks')->select('id')->where(['sno'=>$sno])->count();
			$count2 = DB::table('sales')->select('id')->where(['sno'=>$sno])->count();
			$count3 = DB::table('users')->select('id')->where(['officeid'=>$retailer,'level'=>200])->count();

			$count4 = DB::table('purchases')->select('id')->where(['sno'=>$sno])->count();
			
			if ($count1 > 0 && $count2 < 1 && $count3 > 0 && $count4 > 0) {
			
				$query = User::where(['officeid'=>$retailer,'level'=>200])->first();
				$users = $query->toArray();
				$user_id = $users['id'];


				$count5 = DB::table('retailers')->select('id')->where(['retailer_id'=>$user_id])->count();

				if ($count5 > 0) {
					$query = Purchase::where(['sno'=>$sno])->first();
					$purchases = $query->toArray();
					$distributor_id = $purchases['user_id'];


					$query = Retailer::where(['retailer_id'=>$user_id])->first();
					$retailers = $query->toArray();
					$retailer_id = $retailers['id'];
					$user_id = $retailers['retailer_id'];

					$stockresult = DB::table('stocks')->select('id','product_id','imei','sno','brand_id')->where(['sno'=>$sno])->take(1)->first();
					$stockdata = json_decode(json_encode($stockresult), True);
					
					$stock_id = $stockdata['id'];
					$product_id = $stockdata['product_id'];
					$brand_id = $stockdata['brand_id'];
					$imei = $stockdata['imei'];
					$sno = $stockdata['sno'];


					$data3['created_at'] = $created_at;
					$data3['updated_at'] = $updated_at;
					$data3['user_id'] = $distributor_id;
					$data3['ruser_id'] = $user_id;
					$data3['retailer_id'] = $retailer_id;

					$data3['stock_id'] = $stock_id;
					$data3['product_id'] = $product_id;
					$data3['brand_id'] = $brand_id;
					$data3['imei'] = $imei;
					$data3['sno'] = $sno;

					Sale::create($data3);

				}


			}	
	//---------------------------------------

	}

//===============================================

//====smsdetails ==========

		foreach ($csv_data as $key => $value) {

	$retaileid = $value[0];
	$sno = $value[1];
			
	$created_at = date_format(date_create($value[2]),"Y-m-d H:i:s");
	$updated_at = date_format(date_create($value[2]),"Y-m-d H:i:s");	
//---------------------------------------





	$count1 = DB::table('stocks')->select('id')->where(['sno'=>$sno])->count();
	$count2 = DB::table('sales')->select('id')->where(['sno'=>$sno])->count();
	$count3 = DB::table('users')->select('id')->where(['officeid'=>$retaileid,'level'=>200])->count();

	$count4 = DB::table('smsdetails')->select('id')->where(['sno'=>$sno])->count();


if ($count1 > 0 && $count2 > 0 && $count3 > 0 && $count4 < 1) {
	# code...




		$queryresult = DB::table('users')->select('id','contact')->where(['officeid'=>$retaileid])->take(1)->first();
		$users = json_decode(json_encode($queryresult), True);

		$retailer_id = $users['id'];
		$mobile = $users['contact'];

		$stockresult = DB::table('stocks')->select('id','product_id','imei','sno','brand_id','wperiod')->where(['sno'=>$sno])->take(1)->first();
		$stockdata = json_decode(json_encode($stockresult), True);
		
		$stock_id = $stockdata['id'];
		$product_id = $stockdata['product_id'];
		$brand_id = $stockdata['brand_id'];
		$imei = $stockdata['imei'];
		$sno = $stockdata['sno'];
		$wperiod = $stockdata['wperiod'];

		



		if ($imei == "") {
			$imei = NULL;
		}

//---------------------------------------
		
			$data1['created_at'] = $created_at;
			$data1['updated_at'] = $updated_at;
			$data1['promo_id'] = 0;
			$data1['promodetail_id'] = 0;
			$data1['user_id'] = $retailer_id;
			$data1['product_id'] = $product_id;
			$data1['brand_id'] = $brand_id;
			$data1['imei'] = $imei;
			$data1['sno'] = $sno;
			$data1['mobile'] = NULL;
			$data1['wperiod'] = $wperiod;
			//$data1['iswar'] = 1;


//----------------------------------------
		$dwcount = Dwdetail::where(['sno'=>$sno, 'status' => 0])->count();  

		if ($dwcount > 0) {
			DB::table('dwdetails')->where('sno', $sno)->update(['status' => 1]);
			
			$dwdetail = Dwdetail::where(['sno'=>$sno])->first();    
			



			$sno = $dwdetail->sno;
	    $dwday = $dwdetail->dwday;
	    $dwcharge = $dwdetail->dwcharge;
	    
	    $mobileno = $dwdetail->mobile;

	    //=======================================
	    	$msg = "Thank you, your don't worry offer is approvd. Your Warranty is extended for " .$dwday.  " days";
	    	//self::send_msg($mobileno,$msg);
	    	self::jhorotek_sms_service($mobileno,$msg,
	    		$user='miranrulzz@gmail.com',
	    		$pass='@Syngpsil%$',$masking='GoPrep');	
	    //=======================================


	    $data1['iswar'] = 1;
			$data1['isdw'] = 1;
			$data1['dwday'] = $dwday;
			$data1['dwcharge'] = $dwcharge;
			$data1['twperiod'] = $wperiod + $dwday;

		}




			
			Smsdetail::create($data1);
//---------------------------------------

		}
// for product specification-------------------

}
//====smsdetails ==========


	//====================================================
    $userCount = 0;
    $snoCount = 0;
		$snodata = [];
		$userdata = [];

		foreach ($csv_data as $key => $value) {



	$retailer = $value[0];
	$sno = $value[1];
			
	//---------------------------------------
			$count1 = DB::table('stocks')->select('id')->where(['sno'=>$sno])->count();
			$count2 = DB::table('sales')->select('id')->where(['sno'=>$sno])->count();
			$count3 = DB::table('users')->select('id')->where(['officeid'=>$retailer,'level'=>200])->count();

			$count4 = DB::table('purchases')->select('id')->where(['sno'=>$sno])->count();
			
			if ($count1 < 1 || $count4 < 1) {
				//return redirect()->back()->withErrors("Duplicate serial no :  $sno can not be taken")->withInput();

				$snodata[] = $sno;
        $snoCount += 1;
			}	
		
			$count = DB::table('users')->select('id')->where(['officeid'=>$retailer,'level'=>200])->count();
				
			if ($count < 1) {
				//return redirect()->back()->withErrors("There is no retailer as ID $retailer")->withInput();

				$userdata[] = $retailer;
        $userCount += 1;	


			}



	//---------------------------------------

	}
// for product specification-------------------

//----------------
	
	if ($snoCount > 0 || $userCount > 0) {
	  $user_implode = implode(", ", $userdata);
	  $sno_implode = implode(", ", $snodata);
	  
	  return redirect()->back()->withErrors("UID : $user_implode </br> SNO : $sno_implode 
	  	</br> 
	  	can not be uploaded, please correction csv file first then upload")->withInput();
	}
//----------------



}elseif($type == 12){
	// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
	

//===============================================
	foreach ($csv_data as $key => $value) {



		$retailer = $value[0];
		$sno = $value[1];
			
		$created_at = date_format(date_create($value[2]),"Y-m-d H:i:s");
		$updated_at = date_format(date_create($value[2]),"Y-m-d H:i:s");

	//---------------------------------------
			$count1 = DB::table('stocks')->select('id')->where(['sno'=>$sno])->count();
			$count2 = DB::table('sales')->select('id')->where(['sno'=>$sno])->count();
			$count3 = DB::table('users')->select('id')->where(['officeid'=>$retailer,'level'=>200])->count();

			$count4 = DB::table('purchases')->select('id')->where(['sno'=>$sno])->count();
			
			if ($count1 > 0 && $count2 < 1 && $count3 > 0 && $count4 > 0) {
			
				$query = User::where(['officeid'=>$retailer,'level'=>200])->first();
				$users = $query->toArray();
				$user_id = $users['id'];


				$count5 = DB::table('retailers')->select('id')->where(['retailer_id'=>$user_id])->count();

				if ($count5 > 0) {
					$query = Purchase::where(['sno'=>$sno])->first();
					$purchases = $query->toArray();
					$distributor_id = $purchases['user_id'];


					$query = Retailer::where(['retailer_id'=>$user_id])->first();
					$retailers = $query->toArray();
					$retailer_id = $retailers['id'];
					$user_id = $retailers['retailer_id'];

					$stockresult = DB::table('stocks')->select('id','product_id','imei','sno','brand_id')->where(['sno'=>$sno])->take(1)->first();
					$stockdata = json_decode(json_encode($stockresult), True);
					
					$stock_id = $stockdata['id'];
					$product_id = $stockdata['product_id'];
					$brand_id = $stockdata['brand_id'];
					$imei = $stockdata['imei'];
					$sno = $stockdata['sno'];


					$data3['created_at'] = $created_at;
					$data3['updated_at'] = $updated_at;

					$data3['user_id'] = $distributor_id;
					$data3['ruser_id'] = $user_id;
					$data3['retailer_id'] = $retailer_id;

					$data3['stock_id'] = $stock_id;
					$data3['product_id'] = $product_id;
					$data3['brand_id'] = $brand_id;
					$data3['imei'] = $imei;
					$data3['sno'] = $sno;

					Sale::create($data3);

				}


			}	
	//---------------------------------------

	}

//===============================================
//===============================================


	//====================================================
    $userCount = 0;
    $snoCount = 0;
		$snodata = [];
		$userdata = [];

		foreach ($csv_data as $key => $value) {



	$retailer = $value[0];
	$sno = $value[1];
			
	//---------------------------------------
			$count1 = DB::table('stocks')->select('id')->where(['sno'=>$sno])->count();
			$count2 = DB::table('sales')->select('id')->where(['sno'=>$sno])->count();
			$count3 = DB::table('users')->select('id')->where(['officeid'=>$retailer,'level'=>200])->count();

			$count4 = DB::table('purchases')->select('id')->where(['sno'=>$sno])->count();
			
			if ($count1 < 1 || $count4 < 1) {
				//return redirect()->back()->withErrors("Duplicate serial no :  $sno can not be taken")->withInput();

				$snodata[] = $sno;
        $snoCount += 1;
			}	
		
			$count = DB::table('users')->select('id')->where(['officeid'=>$retailer,'level'=>200])->count();
				
			if ($count < 1) {
				//return redirect()->back()->withErrors("There is no retailer as ID $retailer")->withInput();

				$userdata[] = $retailer;
        $userCount += 1;	


			}



	//---------------------------------------

	}
// for product specification-------------------

//----------------
	
	if ($snoCount > 0 || $userCount > 0) {
	  $user_implode = implode(", ", $userdata);
	  $sno_implode = implode(", ", $snodata);
	  
	  return redirect()->back()->withErrors("UID : $user_implode </br> SNO : $sno_implode 
	  	</br> 
	  	can not be uploaded, please correction csv file first then upload")->withInput();
	}
//----------------



//===============================================


}elseif($type == 13){


// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
	
$snoCount = 0;
$snodata = [];
//===============================================
	foreach ($csv_data as $key => $value) {



		$retailer = $value[0];
		$sno = $value[1];

		$created_at = date_format(date_create($value[2]),"Y-m-d H:i:s");
		$updated_at = date_format(date_create($value[2]),"Y-m-d H:i:s");	

		//$created_at = date_format(date_create($value[2]),"Y-m-d H:i:s");
		//$updated_at = date_format(date_create($value[2]),"Y-m-d H:i:s");
			
	//---------------------------------------
			//$count1 = DB::table('stocks')->select('id')->where(['sno'=>$sno])->count();
			$count2 = DB::table('sales')->select('id')->where(['sno'=>$sno])->count();
			//$count3 = DB::table('users')->select('id')->where(['officeid'=>$retailer,'level'=>200])->count();

			//$count4 = DB::table('purchases')->select('id')->where(['sno'=>$sno])->count();
				


					if ($count2 > 0 ) {
						$snodata[] = $sno;
        		$snoCount += 1;
						DB::table('sales')->where(['sno'=>$sno])->delete();
					}


			}	
	//---------------------------------------

		if ($snoCount > 0 ) {
		  $sno_implode = implode(", ", $snodata);
		  
		  return redirect()->back()->withErrors("SNO : $sno_implode 
		  	</br> ")->withInput();
		}


	}else if($type == 14){


// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
		



// delete purchase area==============

		foreach ($csv_data as $key => $value) {


	$distributor = $value[0];
	$sno = $value[1];
			
// delete purchase area==============


//---------------------------------------
		$count = DB::table('purchases')->select('id')->where(['sno'=>$sno])->count();
		
		if ($count > 0) {
			DB::table('purchases')->where('sno', $sno)->delete();
		}
//---------------------------------------

	}




// delete purchase area==============


	foreach ($csv_data as $key => $value) {


	$distributor = $value[0];
	$sno = $value[1];
			




//---------------------------------------
		$count2 = DB::table('purchases')->select('id')->where(['sno'=>$sno])->count();
		if ($count2 > 0) {
			return redirect()->back()->withErrors("Duplicate serial no :  $sno can not be taken")->withInput();
		}	
	
		$count = DB::table('users')->select('id')->where(['officeid'=>$distributor])->count();
			
		if ($count < 1) {
			return redirect()->back()->withErrors("There is no user with this dstributor $distributor")->withInput();
		}		

		$count1 = DB::table('stocks')->select('id')->where(['sno'=>$sno])->count();
		if ($count1 < 1) {
			return redirect()->back()->withErrors("There is no more product in stock with this sno $sno")->withInput();
		}
//---------------------------------------

	}



// for product specification-------------------
		


		foreach ($csv_data as $key => $value) {


	$distributor = $value[0];
	$sno = $value[1];
			
//---------------------------------------




		$disresult = DB::table('users')->select('id')->where(['officeid'=>$distributor])->take(1)->first();
		$disdata = json_decode(json_encode($disresult), True);

		$disid = $disdata['id'];

		$stockresult = DB::table('stocks')->select('id','product_id','imei','sno','brand_id')->where(['sno'=>$sno])->take(1)->first();
		$stockdata = json_decode(json_encode($stockresult), True);
		
		$stock_id = $stockdata['id'];
		$product_id = $stockdata['product_id'];
		$brand_id = $stockdata['brand_id'];
		$imei = $stockdata['imei'];
		$sno = $stockdata['sno'];



		if ($imei == "") {
			$imei = NULL;
		}

//---------------------------------------
		

			$data1['stock_id'] = $stock_id;
			$data1['user_id'] = $disid;
			$data1['product_id'] = $product_id;
			$data1['brand_id'] = $brand_id;
			$data1['imei'] = $imei;
			$data1['sno'] = $sno;

			
			Purchase::create($data1);
//---------------------------------------

		}
// for product specification-------------------




}elseif ($type == 15) {
	// for product specification-------------------

  	$path = $request->file('csv_file')->getRealPath();

  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
  	
    $data = array_map('str_getcsv', file($path));
    $csv_data = array_slice($data, 1, count($row_index));
		
		$promortLossData = [];
		$retailerLossData = [];
    $promortCount = 0;


	foreach ($csv_data as $key => $value) {

		$promort = $value[0];
		$retailer = $value[1];
			
//---------------------------------------
		$prtcount = Promort::where(['name'=>$promort, 'status'=>1])->count();
		$rtcount = User::where(['officeid'=>$retailer])->count();
		
		if ($prtcount > 0 && $rtcount > 0) {
			$query = Promort::where(['name'=>$promort, 'status'=>1])->first();
			$promortResult = $query->toArray();

			$query = User::select('id')->where(['officeid'=>$retailer])->first();
			$userResult = $query->toArray();

			

      $data['promort_id'] = $promortResult['id'];
      $data['user_id'] = $userResult['id'];
      Promortretailer::create($data);

		}else{
			$promortLossData[] = $promort;
			$retailerLossData[] = $retailer;
      $promortCount += 1;
		}

	}


	//dd($promortLossData);

		if ($promortCount > 0 ) {
		  $promort_implode = implode(", ", $promortLossData);
		  $retailer_implode = implode(", ", $retailerLossData);
		  
		  return redirect()->back()->withErrors("Promotion : $promort_implode 
		  	</br> 
		  	RetailerID : $retailer_implode 
		  	</br> ")->withInput();
		}
// for product specification-------------------
}

//===============================================

    //return view('import_fields', compact('csv_data'));


		return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }





  private static function send_msg($mobileno,$msg){
    $phoneno = str_replace("+", "", $mobileno); 
    $getdata = http_build_query(
      array(
          'masking' => 'SMART TECH',
          'userName' => 'SmartTech_Sofel',
          'password'=>'46fb610d839ea46f08f7ab8810686e19',
          'MsgType'=>'TEXT',
          'receiver'=>$phoneno,
          'message'=>$msg,
        )
    );

    $opts = array('http' =>
      array(
        'method'  => 'GET',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $getdata
      )
    );

    $context  = stream_context_create($opts);
     
    file_get_contents ('http://api.boom-cast.com/boomcast/WebFramework/boomCastWebService/externalApiSendTextMessage.php?'.$getdata, false, $context);

  }




  private static function jhorotek_sms_service($mobile,$smsBody,$user='miranrulzz@gmail.com',$pass='@Syngpsil%$',$masking='GoPrep'){

      $sms_array = array(); 

      //create a json array of your sms 
      $row_array['trxID'] =     self::udate('YmdHisu');
      $row_array['trxTime'] = date('Y-m-d H:i:s'); 

      $mySMSArray [0]['smsID'] = self::udate('YmdHisu'); 
      $mySMSArray [0]['smsSendTime'] = date('Y-m-d H:i:s'); 
      $mySMSArray [0]['mask'] = $masking;
      //$mySMSArray [0]['mobileNo'] = '8801777001014'; 
      //$mySMSArray [0]['smsBody'] = 'Testing from infobuzzer to Ringku'; 

      $mySMSArray [0]['mobileNo'] = $mobile; 
      $mySMSArray [0]['smsBody'] = $smsBody;


      $row_array['smsDatumArray'] = $mySMSArray; 

      $myJSonDatum = json_encode($row_array); 

      //specifi the url 
      //$url="http://api.infobuzzer.net/v3.1/SendSMS/sendSmsInfoStore"; 
      $url="http://api.infobuzzer.net/v3.1/index.php/SendSMS/sendSmsInfoStore"; 

      if($ch = curl_init($url)) 
      { 
          //Your valid username & Password ----------Please update those field 
          //$username = 'info@synergyinterface1.com'; 
          //$password = 'info@Pass'; 


          $username = $user; 
          $password = $pass; 

          curl_setopt( $ch , CURLOPT_HTTPAUTH , CURLAUTH_BASIC ) ; 
          curl_setopt( $ch, CURLOPT_USERPWD , $username . ':' . $password ) ; 
          curl_setopt( $ch , CURLOPT_CUSTOMREQUEST , 'POST' ) ; 

          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 
              'Content-Length: ' . strlen($myJSonDatum))); 

          curl_setopt($ch, CURLOPT_POST, true); 
          curl_setopt($ch, CURLOPT_POSTFIELDS,$myJSonDatum); 
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

          curl_setopt( $ch, CURLOPT_TIMEOUT , 300 ) ; 
          $response=curl_exec($ch); 
          curl_close($ch); 
          //return $json = json_decode($response, true);
          //echo('Response is: '.$response);
          
          //$json['status'] ." ".$json['success']." ".$json['reason'];
          //return  "Response is" . $json;
      } 
      else 
      { 
        return "Sorry,the connection cannot be established"; 
      } 


    }


    private static function udate($format, $utimestamp = null) 
    { 
      $m = explode(' ',microtime()); 
      list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0]*1000,3));
      return date("YmdHis", $totalSeconds) . sprintf('%03d',$extraMilliseconds) ; 
    } 




// Upload1 =======================================



// Retailer =======================================
  
  public function InactiveRetailerView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		//$userCount = User::count();
	  
		$requestRetailerCount = User::where(['active'=> 0,'status'=> 0,'level'=>200])->orderBy('id','desc')->count();

		$_SESSION['requestRetailerCount'] = $requestRetailerCount;



	  $userResult = User::with('division','district','upazila')->select('id','firstname','lastname','contact','level','created_at','updated_at','status','active','photo','email','isdw',
	  	'division_id','district_id','upazila_id','officeid',
				DB::raw('(select CONCAT(t1.firstname, "-", t1.officeid, "-", t1.contact) from users as t1 where t1.id = users.tso_id) as tso'))->where(['active'=> 0,'status'=> 0,'level'=>200])->orderBy('id','desc')->paginate(300);
	  //$users = $userResult->toArray();

//dd($userResult);
//

		$divisionResult = Division::get();
	  $divisions = $divisionResult->toArray();

	  $districtResult = District::get();
	  $districts = $districtResult->toArray();

	  $upazilaResult = Upazila::get();
	  $upazilas = $upazilaResult->toArray();

  	return view('admin.inactiveRetailer',['retailers'=>$userResult, 'divisions'=>$divisions, 'districts'=>$districts, 'upazilas'=>$upazilas  ]);

  }

  public function RetailerView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		//$userCount = User::count();
	  
		$requestRetailerCount = User::where(['active'=> 0,'status'=> 0,'level'=>200])->orderBy('id','desc')->count();

		$_SESSION['requestRetailerCount'] = $requestRetailerCount;



	  //$userResult = User::with('territory')->get();
	  $userResult = User::with('division','district','upazila')->where('level',200)->orderBy('id','desc')->paginate(300);
	  //$users = $userResult->toArray();

//dd($userResult);
//

		$divisionResult = Division::get();
	  $divisions = $divisionResult->toArray();

	  $districtResult = District::get();
	  $districts = $districtResult->toArray();

	  $upazilaResult = Upazila::get();
	  $upazilas = $upazilaResult->toArray();

  	return view('admin.retailer',['retailers'=>$userResult, 'divisions'=>$divisions, 'districts'=>$districts, 'upazilas'=>$upazilas  ]);

  }

  public function RetailerViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$statement = DB::select("show table status like 'users'");
		$ainid = $statement[0]->Auto_increment;


		
//========================================================================================
  		$this->validate($request, [
        //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        'firstname' => 'required|min:2|max:50',
        //'lastname' => 'required|min:1|max:50',
        'email' => 'required|email|unique:users',
        'officeid' => 'required|unique:users',
        'password' => 'required|min:3|max:20',
        'confirm_password' => 'required|min:3|max:20|same:password',
        'contact' => 'required|numeric|min:1',
        //'level' => 'required'
      ]);	

      	$image = $request->file('image');
				
			  if (!is_null($image)) {
			  	$this->validate($request, [
		          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
		        ]);	


			  $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
				Storage::put($image_name, file_get_contents($image));
			  }else{
			  	$image_name = NULL;
			  }

			  $request['remember_token'] = $request['_token'];
				$request['password'] = bcrypt($request['password']);
			  $request['photo'] = $image_name;
			  //$request['region_id'] = NULL;
			  //$request['territory_id'] = NULL;
			  $request['level'] = 200;
			  
		  	User::create($request->all());  

			return redirect()->back()->with('success', 'Data has been inserted successfully');

//========================================================================================


 
  }

  public function RetailerUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		$id = $request->get('id');
  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request, [
        //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        'firstname' => 'required|min:2|max:50',
        //'lastname' => 'required|min:1|max:50',
        //'officeid' => 'required|unique:users',
        'contact' => 'required|numeric|min:1',
      ]);	


	  	$image = $request->file('image');
	  	$division_id = $request->get('division_id');
	  	$district_id = $request->get('district_id');
	  	$upazila_id = $request->get('upazila_id');
			//$attachment = $request->file('attachment');

		  if (!is_null($image)) {

				$this->validate($request, [
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        ]);
// for deleting file =======================
				File::delete('storage/app/' . $user['photo']);
// for deleting file =======================

			  $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
				Storage::put($image_name, file_get_contents($image));
			//=================================================================
				$user->firstname = $request->get('firstname');
				//$user->lastname = $request->get('lastname');
				//$user->email = $request->get('email');
				//$user->officeid = $request->get('officeid');
				$user->contact = $request->get('contact');
				$user->photo = $image_name;

				$user->division_id = $division_id;
				$user->district_id = $district_id;
				$user->upazila_id = $upazila_id;

	      $user->save();

			//=================================================================

			  }else{
			  	//$image_name = NULL;

			//=================================================================
				$user->firstname = $request->get('firstname');
				$user->lastname = $request->get('lastname');
				//$user->email = $request->get('email');
				//$user->officeid = $request->get('officeid');
				$user->contact = $request->get('contact');
				//$user->photo = $image_name;
				
				$user->division_id = $division_id;
				$user->district_id = $district_id;
				$user->upazila_id = $upazila_id;


	      $user->save();

			//=================================================================

			  }

		return redirect()->back()->with('success', 'Data has been updated successfully');	  
 
  }

 
  }

// Retailer =======================================


 



//================DailySalesReport=======================

  
  public function DailySalesReportViewPrint($user_id,$fdate,$todate){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		//-------------------------
  if (!$fdate || !$todate || !$user_id) {
    return redirect()->route('jouraccount.reports.daybook')->withErrors('Date not found, Please select date first');
  }else{
    Session::put(['user_id'=> $user_id,'fdate'=> $fdate,'todate'=>$todate]);
  }
//-------------------------
	  
	  $user_id = Session::get('user_id');
	  $fdate = Session::get('fdate');
	  $todate = Session::get('todate');

		$ssdata = [];
		$totalamount = [];
		$dailySalesReports = [];

		if ($user_id) {
			
		$ssdata['fdate'] = $fdate;
		$ssdata['todate'] = $todate;


		}




    $pdf = PDF::loadView('admin.dailySalesReports_print',['ssdata'=>$ssdata,'dailySalesReports'=>$dailySalesReports,'totalamount'=>$totalamount]);
  
    
    $pdf->setOptions(['isPhpEnabled' => true]); 
    $pdf->setPaper([0, 0, 780, 620], 'landscape'); // $y = 770; $x = 530; for normal 
    //$pdf->setPaper('L', 'landscape'); // $y = 770; $x = 530; for normal 

    return $pdf->stream('userdailySalesReports.pdf');

  }


  
  public function DailySalesReportView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		
		//Session::forget(['brand_id','user_id','sno','fdate','todate']);

		$brandResult = Brand::select('id','name')->orderBy('id','desc')->get();
	  $brands = $brandResult->toArray();

	  $userResult = User::select('id','firstname','officeid')->where('level',200)->orderBy('id','desc')->get();
	  $users = $userResult->toArray();



	  $brand_id = Session::get('brand_id');
	  $user_id = Session::get('user_id');
	  $sno = Session::get('sno');
	  $fdate = Session::get('fdate');
	  $todate = Session::get('todate');



		$ssdata = [];
		$totalamount = [];
		$dailySalesReports = [];

		if ($brand_id == 'all' && $fdate && $todate && !$user_id && !$sno) {
			$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;

				$dailySalesReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					//->where(['status'=>0])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id != 'all' && $fdate && $todate && !$user_id && !$sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailySalesReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					//->where(['status'=>0])
					->where(['brand_id'=>$brand_id])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id == 'all' && $fdate && $todate && $user_id && !$sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailySalesReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					//->where(['status'=>0])
					->where(['user_id'=>$user_id])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id == 'all' && $fdate && $todate && !$user_id && $sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno;
				$dailySalesReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					//->where(['status'=>0])
					->where(['sno'=>$sno])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id == 'all' && $fdate && $todate && $user_id && $sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailySalesReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					//->where(['status'=>0])
					->where(['user_id'=>$user_id,'sno'=>$sno])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id != 'all' && $fdate && $todate && $user_id && !$sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailySalesReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					//->where(['status'=>0])
					->where(['brand_id'=>$brand_id,'user_id'=>$user_id])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id != 'all' && $fdate && $todate && !$user_id && $sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailySalesReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					//->where(['status'=>0])
					->where(['brand_id'=>$brand_id,'sno'=>$sno])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id != 'all' && $fdate && $todate && $user_id && $sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailySalesReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					//->where(['status'=>0])
					->where(['brand_id'=>$brand_id,'user_id'=>$user_id,'sno'=>$sno])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}else{
			$dailySalesReports = [];
		}

//dd($dailySalesReports);

//Session::forget(['brand_id','user_id','sno','fdate','todate']);

  	return view('admin.dailySalesReport',['brands'=>$brands,'users'=>$users,'ssdata'=>$ssdata,'dailySalesReports'=>$dailySalesReports]);

  }


  public function DailySalesReportViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());


    Session::forget(['brand_id','user_id','sno','fdate','todate']);

    $this->validate($request, [
      'brand_id' => 'required',
      'fdate' => 'required',
      'todate' => 'required'
    ]);


    //dd($request->all());

    $brand_id = $request->get('brand_id');
    $user_id = $request->get('user_id');
    $sno = $request->get('sno');
    $fdate = $request->get('fdate');
    $todate = $request->get('todate');
    
    Session::put(['brand_id'=>$brand_id,'user_id'=>$user_id,'sno'=>$sno,'fdate'=>$fdate,'todate'=>$todate]);


    //dd(Session::all());


    return redirect(route('admin.dailySalesReport'));


  }

//================DailySalesReport======================

//================DailyCampaignReport=======================

  
  public function DailyCampaignReportViewPrint($user_id,$fdate,$todate){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		//-------------------------
  if (!$fdate || !$todate || !$user_id) {
    return redirect()->route('jouraccount.reports.daybook')->withErrors('Date not found, Please select date first');
  }else{
    Session::put(['user_id'=> $user_id,'fdate'=> $fdate,'todate'=>$todate]);
  }
//-------------------------
	  
	  $user_id = Session::get('user_id');
	  $fdate = Session::get('fdate');
	  $todate = Session::get('todate');

		$ssdata = [];
		$totalamount = [];
		$dailySalesReports = [];

		if ($user_id) {
			
		$ssdata['fdate'] = $fdate;
		$ssdata['todate'] = $todate;


		}




    $pdf = PDF::loadView('admin.dailyCampaignReports_print',['ssdata'=>$ssdata,'dailySalesReports'=>$dailySalesReports]);
  
    
    $pdf->setOptions(['isPhpEnabled' => true]); 
    $pdf->setPaper([0, 0, 780, 620], 'landscape'); // $y = 770; $x = 530; for normal 
    //$pdf->setPaper('L', 'landscape'); // $y = 770; $x = 530; for normal 

    return $pdf->stream('userdailySalesReports.pdf');

  }


  
  public function DailyCampaignReportView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		
		//Session::forget(['brand_id','user_id','sno','fdate','todate']);

		$brandResult = Brand::select('id','name')->orderBy('id','desc')->get();
	  $brands = $brandResult->toArray();

		$userResult = User::select('id','firstname','officeid')->where('level',200)->orderBy('id','desc')->get();
	  $users = $userResult->toArray();


	  $brand_id = Session::get('brand_id');
	  $user_id = Session::get('user_id');
	  $sno = Session::get('sno');
	  $fdate = Session::get('fdate');
	  $todate = Session::get('todate');



		$ssdata = [];
		$totalamount = [];
		$dailyCampaignReports = [];

		if ($brand_id == 'all' && $fdate && $todate && !$user_id && !$sno) {
			$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;

				$dailyCampaignReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod','remarks',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					->where(['status'=>1])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id != 'all' && $fdate && $todate && !$user_id && !$sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailyCampaignReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod','remarks',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					->where(['status'=>1])
					->where(['brand_id'=>$brand_id])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id == 'all' && $fdate && $todate && $user_id && !$sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailyCampaignReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod','remarks',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					->where(['status'=>1])
					->where(['user_id'=>$user_id])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id == 'all' && $fdate && $todate && !$user_id && $sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno;
				$dailyCampaignReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod','remarks',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					->where(['status'=>1])
					->where(['sno'=>$sno])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id == 'all' && $fdate && $todate && $user_id && $sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailyCampaignReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod','remarks',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					->where(['status'=>1])
					->where(['user_id'=>$user_id,'sno'=>$sno])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id != 'all' && $fdate && $todate && $user_id && !$sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailyCampaignReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod','remarks',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					->where(['status'=>1])
					->where(['brand_id'=>$brand_id,'user_id'=>$user_id])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id != 'all' && $fdate && $todate && !$user_id && $sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailyCampaignReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod','remarks',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					->where(['status'=>1])
					->where(['brand_id'=>$brand_id,'sno'=>$sno])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}elseif($brand_id != 'all' && $fdate && $todate && $user_id && $sno){
				$ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['sno'] = $sno; $ssdata['brand_id'] = $brand_id;
				$dailyCampaignReports = Smsdetail::with('user','brand','product','promodetail')
					->select('id','brand_id','product_id','promo_id','promodetail_id','user_id','mobile','imei','sno','wperiod','remarks',
						DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as saledate, DATE_FORMAT(created_at,"%D %b %y %r") as createdAt,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))
					->where(['status'=>1])
					->where(['brand_id'=>$brand_id,'user_id'=>$user_id,'sno'=>$sno])
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();

		}else{
			$dailyCampaignReports = [];
		}

//dd($dailyCampaignReports);

//Session::forget(['brand_id','user_id','sno','fdate','todate']);

  	return view('admin.dailyCampaignReport',['brands'=>$brands,'users'=>$users,'ssdata'=>$ssdata,'dailyCampaignReports'=>$dailyCampaignReports]);

  }


  public function DailyCampaignReportViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());


    Session::forget(['brand_id','user_id','sno','fdate','todate']);

    $this->validate($request, [
      'brand_id' => 'required',
      'fdate' => 'required',
      'todate' => 'required'
    ]);


    //dd($request->all());

    $brand_id = $request->get('brand_id');
    $user_id = $request->get('user_id');
    $sno = $request->get('sno');
    $fdate = $request->get('fdate');
    $todate = $request->get('todate');
    
    Session::put(['brand_id'=>$brand_id,'user_id'=>$user_id,'sno'=>$sno,'fdate'=>$fdate,'todate'=>$todate]);


    //dd(Session::all());


    return redirect(route('admin.dailyCampaignReport'));


  }

//================DailySalesReport======================



//================DailyReplaceReport=======================

  
  public function DailyReplaceReportViewPrint($user_id,$fdate,$todate){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    //-------------------------
  if (!$fdate || !$todate || !$user_id) {
    return redirect()->route('jouraccount.reports.daybook')->withErrors('Date not found, Please select date first');
  }else{
    Session::put(['user_id'=> $user_id,'fdate'=> $fdate,'todate'=>$todate]);
  }
//-------------------------
    
    $user_id = Session::get('user_id');
    $fdate = Session::get('fdate');
    $todate = Session::get('todate');

    $ssdata = [];
    $totalamount = [];
    $dailyReplaceReports = [];

    if ($user_id) {
      
    $ssdata['fdate'] = $fdate;
    $ssdata['todate'] = $todate;


    }




    $pdf = PDF::loadView('admin.dailyReplaceReports_print',['ssdata'=>$ssdata,'dailyReplaceReports'=>$dailyReplaceReports,'totalamount'=>$totalamount]);
  
    
    $pdf->setOptions(['isPhpEnabled' => true]); 
    $pdf->setPaper([0, 0, 780, 620], 'landscape'); // $y = 770; $x = 530; for normal 
    //$pdf->setPaper('L', 'landscape'); // $y = 770; $x = 530; for normal 

    return $pdf->stream('userdailyReplaceReports.pdf');

  }


  
  public function DailyReplaceReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    //Session::forget(['brand_id','user_id','sno','fdate','todate']);


    $fdate = Session::get('fdate');
    $todate = Session::get('todate');


    $dataCount = 0;
    $ssdata = [];
    $dailyReplaceReports = [];

if ($fdate && $todate) {
			$dataCount = 1;

			$ssdata['fdate'] = $fdate;
			$ssdata['todate'] = $todate;


			$dailyReplaceReports = Replace::with('smsdetail')
					->select('id','smsdetail_id','imei','sno',DB::raw('DATE_FORMAT(created_at,"%m/%d/%Y") as rplsdate'))
					->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
					->get();


			//dd($dailyReplaceReports);
}



    return view('admin.dailyReplaceReport',['ssdata'=>$ssdata,'dailyReplaceReports'=>$dailyReplaceReports,'dataCount'=>$dataCount]);

  }


  public function DailyReplaceReportViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());


    Session::forget(['fdate','todate']);

    $this->validate($request, [
      'fdate' => 'required',
      'todate' => 'required'
    ]);


    //dd($request->all());

    $fdate = $request->get('fdate');
    $todate = $request->get('todate');
    
    Session::put(['fdate'=>$fdate,'todate'=>$todate]);


    //dd(Session::all());


    return redirect(route('admin.dailyReplaceReport'));


  }

//================DailyReplaceReport======================












//================WcheckProduct=======================

  
  public function WcheckProductViewPrint($user_id,$fdate,$todate){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		//-------------------------
  if (!$fdate || !$todate || !$user_id) {
    return redirect()->route('jouraccount.reports.daybook')->withErrors('Date not found, Please select date first');
  }else{
    Session::put(['user_id'=> $user_id,'fdate'=> $fdate,'todate'=>$todate]);
  }
//-------------------------
	  
	  $user_id = Session::get('user_id');
	  $fdate = Session::get('fdate');
	  $todate = Session::get('todate');

		$ssdata = [];
		$totalamount = [];
		$wcheckProducts = [];

if ($user_id) {
	
$ssdata['fdate'] = $fdate;
$ssdata['todate'] = $todate;


}




    $pdf = PDF::loadView('admin.wcheckProducts_print',['ssdata'=>$ssdata,'wcheckProducts'=>$wcheckProducts,'totalamount'=>$totalamount]);
  
    
    $pdf->setOptions(['isPhpEnabled' => true]); 
    $pdf->setPaper([0, 0, 780, 620], 'landscape'); // $y = 770; $x = 530; for normal 
    //$pdf->setPaper('L', 'landscape'); // $y = 770; $x = 530; for normal 

    return $pdf->stream('userwcheckProducts.pdf');

  }


  
  public function WcheckProductView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}

	  
//Session::forget(['imei']);
		$ssdata = [];
		$data = [];
  	$dataCount = 0;
  	$imei = Session::get('imei');

  	if($imei){
  			$ssdata['imei'] = $imei;
  			$dataCount = 1;

  			$smsdetailCount = Smsdetail::where(['imei' => $imei])->orWhere(['sno'=>$imei])->count();
if ($smsdetailCount > 0) {
				
				$query = Smsdetail::with('product','replace')->select('id','product_id','promo_id','promodetail_id','sno','imei','wperiod','iswar',
					DB::raw('DATEDIFF(NOW(),created_at) as wdayCount, DATE_FORMAT(created_at,"%m/%d/%Y") as saledate,
						DATE_FORMAT(created_at,"%m/%d/%Y") as sdate, 
						DATE_FORMAT(DATE_ADD(created_at, INTERVAL wperiod DAY),"%m/%d/%Y") as edate'))

									->where(['imei' => $imei])
									->orWhere(['sno'=>$imei])
									//->take(1)
									->get();

				$data = json_decode(json_encode($query), True);				

				//dd($data);

}





  	}




//Session::forget(['user_id','fdate','todate']);

  	return view('admin.wcheckProduct',['ssdata'=>$ssdata,'wcheckProducts'=>$data,'dataCount'=>$dataCount]);

  }


  public function WcheckProductViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}

    Session::forget(['imei']);

    $this->validate($request, [
      'imei' => 'required'
    ]);


    //dd($request->all());

    $imei = $request->get('imei');
    
    Session::put(['imei'=>$imei]);

  return redirect(route('admin.wcheckProduct'));


  }


  public function WcheckProductReplace(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}


    $this->validate($request, [
      'id' => 'required',
      //'imei' => 'required',
      'sno' => 'required',
    ]);


    $id = $request->get('id');
    $smsdetail = Smsdetail::find($id);
    
    if ($smsdetail === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }


//-------------------
    $smsdetail->iswar = 0;
    $smsdetail->save(); 
//-------------------
  $request['smsdetail_id'] = $request->id;
  Replace::create($request->all());
//-------------------
    
    return redirect()->back()->with('success', 'Data has been inserted successfully');


  }


  public function WcheckProductReplaceUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}


    $this->validate($request, [
      'id' => 'required',
      //'imei' => 'required',
      'sno' => 'required',
    ]);


    $id = $request->get('id');
    $Replace = Replace::find($id);
    
    if ($Replace === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }


//-------------------
    $Replace->imei = $request->imei;
    $Replace->sno = $request->sno;
    $Replace->save(); 
//-------------------
    
    return redirect()->back()->with('success', 'Data has been update successfully');


  }




  public function WcheckProductReplaceDelete($id){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	
  	$Replace = Replace::find($id);
		
  	$productCount = 0;
  	//$productCount = Product::where('promo_id', $id)->count();
  	//$product = Product::where('promo_id', $id)->get();

		if ($Replace === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
  		if ($productCount > 0) {
				return redirect()->back()->withErrors('This Data can not be deleted becouse of related with product information');
			}else{

//--------------------------
				$smsdetail_id = $Replace->smsdetail_id;
				DB::table('smsdetails')->where('id', $smsdetail_id)->update(['iswar' => 1]);
//--------------------------

				$Replace->delete();
				return redirect()->back()->with('success', 'Data has been deleted successfully');
			}


		}
		

 
  }

//================WcheckProduct=======================








//================DailyStockReport=======================

  
  public function DailyStockReportViewPrint($user_id,$fdate,$todate){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    //-------------------------
  if (!$fdate || !$todate || !$user_id) {
    return redirect()->route('jouraccount.reports.daybook')->withErrors('Date not found, Please select date first');
  }else{
    Session::put(['user_id'=> $user_id,'fdate'=> $fdate,'todate'=>$todate]);
  }
//-------------------------
    
    $user_id = Session::get('user_id');
    $fdate = Session::get('fdate');
    $todate = Session::get('todate');

    $ssdata = [];
    $totalamount = [];
    $dailyStockReports = [];

if ($user_id) {
  
$ssdata['fdate'] = $fdate;
$ssdata['todate'] = $todate;


}




    $pdf = PDF::loadView('admin.dailyStockReports_print',['ssdata'=>$ssdata,'dailyStockReports'=>$dailyStockReports,'totalamount'=>$totalamount]);
  
    
    $pdf->setOptions(['isPhpEnabled' => true]); 
    $pdf->setPaper([0, 0, 780, 620], 'landscape'); // $y = 770; $x = 530; for normal 
    //$pdf->setPaper('L', 'landscape'); // $y = 770; $x = 530; for normal 

    return $pdf->stream('userdailyStockReports.pdf');

  }


  
  public function DailyStockReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    //$userCount = User::count();
    

		$distributorResult = User::where('level',100)->orderBy('id','desc')->get();
    $distributors = $distributorResult->toArray();



    $ssdata = [];
    $totalamount = [];
    $dailyStockReports = [];
    $ssdata['count'] = 0;


//dd(Session::all());

    $fdate = Session::get('fdate');
    $todate = Session::get('todate');
    $distributor_id = Session::get('distributor_id');
    $all_report = Session::get('all_report');

    if (!$fdate && !$todate && $all_report && $distributor_id) {
//--------------------------------------------------


//--------------------------------------------------
    $ssdata['count'] = 1;
    $ssdata['fdate'] = $fdate;
    $ssdata['todate'] = $todate;
//--------------------------------------------------
    $productResult = Product::select('id','name','model')->orderBy('id','desc')->get();
    $products = $productResult->toArray();


foreach ($products as $key => $product1) {
  $product_id = $product1['id'];
  $product = $product1['name'];
  $model = $product1['model'];



if ($distributor_id == "All") {

// with distributor_id========
$pcount = Purchase::where('product_id',$product_id)->count();

if ($pcount > 0 ) {
  $PurchaseResult = Purchase::with('user')->select('user_id',DB::raw('SUM(quantity) AS sin'))->where('product_id',$product_id)->groupBy('product_id')->first();
  $Purchases = $PurchaseResult->toArray();

  //$distributor = $Purchases['user']['firstname'] . " - ". $Purchases['user']['officeid'];
  $distributor = "All Distributoirs";
  $sin = $Purchases['sin'];
} else {
	$distributor = "All Distributoirs";
  $sin = 0;
}

$scount = Sale::where('product_id',$product_id)->count();

if ($scount > 0 ) {
  $SaleResult = Sale::with('user')->select('user_id',DB::raw('COUNT(product_id) as sout'))->where('product_id',$product_id)->groupBy('product_id')->first();
  $Sales = $SaleResult->toArray();

  //$distributor = $Sales['user']['firstname'] . " - ". $Sales['user']['officeid'];
  $distributor = "All Distributoirs";
  $sout = $Sales['sout'];
} else {
	$distributor = "All Distributoirs";
  $sout = 0;
}

// with distributor_id========
} else {

// with distributor_id========
$pcount = Purchase::where('user_id',$distributor_id)->where('product_id',$product_id)->count();

if ($pcount > 0 ) {
  $PurchaseResult = Purchase::with('user')->select('user_id',DB::raw('SUM(quantity) AS sin'))->where('user_id',$distributor_id)->where('product_id',$product_id)->groupBy('product_id')->first();
  $Purchases = $PurchaseResult->toArray();

  $distributor = $Purchases['user']['firstname'] . " - ". $Purchases['user']['officeid'];
  $sin = $Purchases['sin'];
} else {
	//$distributor = " - ";
  $sin = 0;
  $userData = User::where('id',$distributor_id)->first();
	$distributor = $userData->firstname . " " . $userData->officeid;
}

$scount = Sale::where('user_id',$distributor_id)->where('product_id',$product_id)->count();

if ($scount > 0 ) {
  $SaleResult = Sale::with('user')->select('user_id',DB::raw('COUNT(product_id) as sout'))->where('user_id',$distributor_id)->where('product_id',$product_id)->groupBy('product_id')->first();
  $Sales = $SaleResult->toArray();

  $distributor = $Sales['user']['firstname'] . " - ". $Sales['user']['officeid'];
  $sout = $Sales['sout'];
} else {
	//$distributor = " - ";
  $sout = 0;
  $userData = User::where('id',$distributor_id)->first();
	$distributor = $userData->firstname . " " . $userData->officeid;
}

// with distributor_id========
}





  $dailyStockReports[] = [
    'distributor' => $distributor,
    'product_id' => $product_id,
    'product' => $product,
    'model' => $model,
    'stockin' => $sin,
    'stockout' => $sout,
    'stock' => $sin - $sout
  ]; 



}
//--------------------------------------------------
    }elseif($fdate && $todate && !$all_report  && $distributor_id){
//--------------------------------------------------
    $ssdata['count'] = 1;
    $ssdata['fdate'] = $fdate;
    $ssdata['todate'] = $todate;
//--------------------------------------------------
    
//--------------------------------------------------

    $productResult = Product::select('id','name','model')->orderBy('id','desc')->get();
    $products = $productResult->toArray();


foreach ($products as $key => $product1) {
  $product_id = $product1['id'];
  $product = $product1['name'];
  $model = $product1['model'];


if ($distributor_id == "All") {

// with distributor_id all========

$pcount = Purchase::where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->count();

if ($pcount > 0 ) {
  $PurchaseResult = Purchase::with('user')->select('user_id',DB::raw('SUM(quantity) AS sin'))->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->groupBy('product_id')->first();
  $Purchases = $PurchaseResult->toArray();
	//$distributor = $Purchases['user']['firstname'] . " - ". $Purchases['user']['officeid'];
	$distributor = "All Distributoirs";
  $sin = $Purchases['sin'];
} else {
	$distributor = "All Distributoirs";
  $sin = 0;
}

$scount = Sale::where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->count();

if ($scount > 0 ) {
  $SaleResult = Sale::with('user')->select('user_id',DB::raw('COUNT(product_id) as sout'))->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->groupBy('product_id')->first();
  $Sales = $SaleResult->toArray();
	//$distributor = $Sales['user']['firstname'] . " - ". $Sales['user']['officeid'];
	$distributor = "All Distributoirs";
  $sout = $Sales['sout'];
} else {
	$distributor = "All Distributoirs";
  $sout = 0;
}

// with distributor_id all========

} else {

// with distributor_id========

$pcount = Purchase::where('user_id',$distributor_id)->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->count();

if ($pcount > 0 ) {
  $PurchaseResult = Purchase::with('user')->select('user_id',DB::raw('SUM(quantity) AS sin'))->where('user_id',$distributor_id)->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->groupBy('product_id')->first();
  $Purchases = $PurchaseResult->toArray();
	$distributor = $Purchases['user']['firstname'] . " - ". $Purchases['user']['officeid'];
  $sin = $Purchases['sin'];
} else {
	//$distributor = " - ";
  $sin = 0;

	$userData = User::where('id',$distributor_id)->first();
	$distributor = $userData->firstname . " " . $userData->officeid;
}

$scount = Sale::where('user_id',$distributor_id)->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->count();

if ($scount > 0 ) {
  $SaleResult = Sale::with('user')->select('user_id',DB::raw('COUNT(product_id) as sout'))->where('user_id',$distributor_id)->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->groupBy('product_id')->first();
  $Sales = $SaleResult->toArray();
	$distributor = $Sales['user']['firstname'] . " - ". $Sales['user']['officeid'];
  $sout = $Sales['sout'];
} else {
	//$distributor = " - ";
  $sout = 0;
  $userData = User::where('id',$distributor_id)->first();
	$distributor = $userData->firstname . " " . $userData->officeid;
}

// with distributor_id========

}


  $dailyStockReports[] = [
    'distributor' => $distributor,
    'product_id' => $product_id,
    'product' => $product,
    'model' => $model,
    'stockin' => $sin,
    'stockout' => $sout,
    'stock' => $sin - $sout
  ]; 


    }



}


//Session::forget(['user_id','fdate','todate']);

    return view('admin.dailyStockReport',['ssdata'=>$ssdata,'dailyStockReports'=>$dailyStockReports,'distributors' => $distributors]);

  }


  public function DailyStockReportViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());

    Session::forget(['fdate','todate','all_report']);


if ($request->get('all_report') == null) {
    
    $this->validate($request, [
      'fdate' => 'required',
      'todate' => 'required',
      'distributor_id' => 'required',
    ]);


    $distributor_id = $request->get('distributor_id');
    $fdate = $request->get('fdate');
    $todate = $request->get('todate');
    //$all_report = $request->get('all_report');

    Session::put(['fdate'=>$fdate,'todate'=>$todate,'distributor_id'=>$distributor_id]);
}else{
    $this->validate($request, [
      'all_report' => 'required','distributor_id' => 'required',
    ]);
    $distributor_id = $request->get('distributor_id');
    $all_report = $request->get('all_report');

    Session::put(['all_report'=>$all_report,'distributor_id'=>$distributor_id ]);
}

  return redirect(route('admin.dailyStockReport'));


  }

//================DailyStockReport=======================


//================RetailerCheckReportView=======================
  
  public function RetailerCheckReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    //$userCount = User::count();
    

		$distributorResult = User::where('level',100)->orderBy('id','desc')->get();
    $distributors = $distributorResult->toArray();



    $ssdata = [];
    $retailerCheckReports = [];
    $ssdata['count'] = 0;

    $distributor_id = Session::get('distributor_id');

//dd($distributor_id);
    if ($distributor_id == "All") {
	//--------------------------------------------------
    	$distributorResult = User::with('retailer')->select('id','firstname','email','officeid')->where('level',100)->orderBy('id','desc')->get();
    	$retailerCheckReports = $distributorResult->toArray();

		}else{
			$distributorResult = User::with('retailer')->select('id','firstname','email','officeid')->where('id',$distributor_id)->where('level',100)->orderBy('id','desc')->get();
    	$retailerCheckReports = $distributorResult->toArray();

		}

//dd($retailerCheckReports);
//Session::forget(['user_id','fdate','todate']);

    return view('admin.retailerCheckReport',['ssdata'=>$ssdata,'retailerCheckReports'=>$retailerCheckReports,'distributors' => $distributors]);

  }


  public function RetailerCheckReportViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());
		Session::forget(['distributor_id']);

		$this->validate($request, [
      'distributor_id' => 'required',
    ]);
		$distributor_id = $request->get('distributor_id');

    Session::put(['distributor_id'=>$distributor_id]);


  	return redirect(route('admin.retailerCheckReport'));


  }

//================RetailerCheckReportView=======================





// dailyPurchaseSaleReport1 area===============


  public function DailyPurchaseSaleReport1View(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    //$userCount = User::count();
    

    $distributorResult = User::where('level',100)->orderBy('id','desc')->get();
    $distributors = $distributorResult->toArray();

		$productResult = Product::orderBy('id','desc')->get();
    $products = $productResult->toArray();

    $retailerResult = Retailer::orderBy('id','desc')->get();
    $retailers = $retailerResult->toArray();

    $ssdata = [];
    $totalamount = [];
    $dailyPurchaseSaleReport1s = [];
    $ssdata['count'] = 0;

    $purchases = [];
    $sales = [];


//dd(Session::all());

    $fdate = Session::get('fdate');
    $todate = Session::get('todate');
    $type = Session::get('type');
    $distributor_id = Session::get('distributor_id');

   $sales = [];
	if($fdate && $todate && $type && $distributor_id){
//--------------------------------------------------
   	$ssdata['count'] = 1;
    $ssdata['type'] = $type;
    $ssdata['fdate'] = $fdate;
    $ssdata['todate'] = $todate;
//--------------------------------------------------
   
   if ($distributor_id == "All") {
		  //with distributor_id all===========
		    if ($type == "Purchase") {
		    	$purchases = Purchase::with('product','user')->select('id','user_id','product_id','quantity','sno','status','imei','created_at')->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->get();
		    } elseif($type == "Sale") {
		    	$sales = Sale::with('product','retailer','user')->select('id','user_id','product_id','retailer_id','sno','imei','created_at')->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->get();
		    }
		  //with distributor_id all===========
    } else {
		  //with distributor_id===========
		    if ($type == "Purchase") {
		    	$purchases = Purchase::with('product','user')->select('id','user_id','product_id','quantity','sno','status','imei','created_at')->where('user_id',$distributor_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->get();
		    } elseif($type == "Sale") {
		    	$sales = Sale::with('product','retailer','user')->select('id','user_id','product_id','retailer_id','sno','imei','created_at')->where('user_id',$distributor_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->get();
		    }
		  //with distributor_id===========
    }
     

}

//Session::forget(['user_id','fdate','todate']);

    return view('admin.dailyPurchaseSaleReport1',['ssdata'=>$ssdata,'dailyPurchaseSaleReport1s'=>$dailyPurchaseSaleReport1s,'distributors' => $distributors,'sales'=>$sales,'purchases'=>$purchases,'retailers'=>$retailers,'products'=>$products]);

  }


  public function DailyPurchaseSaleReport1ViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());

    Session::forget(['fdate','todate','all_report']);


	$this->validate($request, [
      'fdate' => 'required',
      'todate' => 'required',
      'distributor_id' => 'required',
      'type' => 'required',
    ]);


    $distributor_id = $request->get('distributor_id');
    $type = $request->get('type');
    $fdate = $request->get('fdate');
    $todate = $request->get('todate');

    Session::put(['fdate'=>$fdate,'todate'=>$todate,'type'=>$type,'distributor_id'=>$distributor_id]);

  return redirect(route('admin.dailyPurchaseSaleReport1'));


  }



// dailyPurchaseSaleReport1 area===============



//================DailyPurchaseSaleReport=======================
  public function DailyPurchaseSaleReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    //$userCount = User::count();
    

    $distributorResult = User::where('level',100)->orderBy('id','desc')->get();
    $distributors = $distributorResult->toArray();

$productResult = Product::orderBy('id','desc')->get();
    $products = $productResult->toArray();

    $retailerResult = Retailer::orderBy('id','desc')->get();
    $retailers = $retailerResult->toArray();

    $ssdata = [];
    $totalamount = [];
    $dailyPurchaseSaleReports = [];
    $ssdata['count'] = 0;

    $purchases = [];
    $sales = [];


//dd(Session::all());

    $fdate = Session::get('fdate');
    $todate = Session::get('todate');
    $type = Session::get('type');
    $distributor_id = Session::get('distributor_id');


	if($fdate && $todate && $type && $distributor_id){
//--------------------------------------------------
   	$ssdata['count'] = 1;
    $ssdata['type'] = $type;
    $ssdata['fdate'] = $fdate;
    $ssdata['todate'] = $todate;
//--------------------------------------------------
   
   if ($distributor_id == "All") {
		  //with distributor_id all===========
		    if ($type == "Purchase") {
		    	$purchases = Purchase::with('product','user')->select('id','user_id','product_id','quantity','sno','status','imei','created_at')->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->paginate(1000);
		    } elseif($type == "Sale") {
		    	$sales = Sale::with('product','retailer','user')->select('id','user_id','product_id','retailer_id','sno','imei','created_at')->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->paginate(1000);
		    }
		  //with distributor_id all===========
    } else {
		  //with distributor_id===========
		    if ($type == "Purchase") {
		    	$purchases = Purchase::with('product','user')->select('id','user_id','product_id','quantity','sno','status','imei','created_at')->where('user_id',$distributor_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->paginate(1000);
		    } elseif($type == "Sale") {
		    	$sales = Sale::with('product','retailer','user')->select('id','user_id','product_id','retailer_id','sno','imei','created_at')->where('user_id',$distributor_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->paginate(1000);
		    }
		  //with distributor_id===========
    }
     





}


//Session::forget(['user_id','fdate','todate']);

    return view('admin.dailyPurchaseSaleReport',['ssdata'=>$ssdata,'dailyPurchaseSaleReports'=>$dailyPurchaseSaleReports,'distributors' => $distributors,'sales'=>$sales,'purchases'=>$purchases,'retailers'=>$retailers,'products'=>$products]);

  }


  public function DailyPurchaseSaleReportViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());

    Session::forget(['fdate','todate','all_report']);


		$this->validate($request, [
      'fdate' => 'required',
      'todate' => 'required',
      'distributor_id' => 'required',
      'type' => 'required',
    ]);


    $distributor_id = $request->get('distributor_id');
    $type = $request->get('type');
    $fdate = $request->get('fdate');
    $todate = $request->get('todate');

    Session::put(['fdate'=>$fdate,'todate'=>$todate,'type'=>$type,'distributor_id'=>$distributor_id]);

  return redirect(route('admin.dailyPurchaseSaleReport'));


  }



  public function PurchaseUpdate(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $id = $request->get('id');
    $purchase = Purchase::find($id);
    
    if ($purchase === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      $this->validate($request,[
      	//'quantity'=>'required',
      	//'product_id'=>'required',
      	'distributor_id'=>'required'
      ]);
      //$purchase->quantity = $request->get('quantity');
      //$purchase->product_id = $request->get('product_id');
      $purchase->user_id = $request->get('distributor_id');
	  $purchase->save();

      return redirect()->back()->with('success', 'Data has been updated successfully');
    }

 
  }



  public function PurchaseDestroy($id){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $Purchase = Purchase::find($id);
    
    $productCount = 0;
    //$productCount = Product::where('promo_id', $id)->count();
    //$product = Product::where('promo_id', $id)->get();

    if ($Purchase === null) {
      return redirect()->back()->withErrors('There are no data with this id');

    }else{
      if ($productCount > 0) {
        return redirect()->back()->withErrors('This Data can not be deleted becouse of related with product information');
      }else{
        $Purchase->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully');
      }


    }
 
  }







  public function PurchaseInactive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];

  	$purchase = Purchase::find($id);
		
		if ($purchase === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
			$purchase->status = false;
  		$purchase->save();
  
			return redirect()->back()->with('success', 'Data has been inactivated successfully');
		}

  }

  public function PurchaseActive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];

  	$purchase = Purchase::find($id);
		
		if ($purchase === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
			$purchase->status = true;
  		$purchase->save();
			return redirect()->back()->with('success', 'Data has been activated successfully');
		}



	
  }







  public function SaleUpdate(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    $id = $request->get('id');
    $Sale = Sale::find($id);
    
    if ($Sale === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      $this->validate($request,['retailer_id'=>'required']);
      $Sale->retailer_id = $request->get('retailer_id');
      $Sale->save();
      return redirect()->back()->with('success', 'Data has been updated successfully');
    }

 
  }



  public function SaleDestroy($id){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $Sale = Sale::find($id);
    
    $productCount = 0;
    //$productCount = Product::where('promo_id', $id)->count();
    //$product = Product::where('promo_id', $id)->get();

    if ($Sale === null) {
      return redirect()->back()->withErrors('There are no data with this id');

    }else{
      if ($productCount > 0) {
        return redirect()->back()->withErrors('This Data can not be deleted becouse of related with product information');
      }else{
        $Sale->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully');
      }


    }
    

 
  }



//================DailyPurchaseSaleReport=======================




//================DailySalesReport=======================

  
  public function DailyDistributorSalesReportViewPrint($user_id,$fdate,$todate){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    //-------------------------
  if (!$fdate || !$todate || !$user_id) {
    return redirect()->route('jouraccount.reports.daybook')->withErrors('Date not found, Please select date first');
  }else{
    Session::put(['user_id'=> $user_id,'fdate'=> $fdate,'todate'=>$todate]);
  }
//-------------------------
    
    $user_id = Session::get('user_id');
    $fdate = Session::get('fdate');
    $todate = Session::get('todate');

    $ssdata = [];
    $totalamount = [];
    $dailyDistributorSalesReports = [];

    if ($user_id) {
      
    $ssdata['fdate'] = $fdate;
    $ssdata['todate'] = $todate;


    }




    $pdf = PDF::loadView('distributor.dailySalesReports_print',['ssdata'=>$ssdata,'dailyDistributorSalesReports'=>$dailyDistributorSalesReports,'totalamount'=>$totalamount]);
  
    
    $pdf->setOptions(['isPhpEnabled' => true]); 
    $pdf->setPaper([0, 0, 780, 620], 'landscape'); // $y = 770; $x = 530; for normal 
    //$pdf->setPaper('L', 'landscape'); // $y = 770; $x = 530; for normal 

    return $pdf->stream('userdailySalesReports.pdf');

  }


  
  public function DailyDistributorSalesReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    //Session::forget(['brand_id','user_id','sno','fdate','todate']);

    $brandResult = Brand::select('id','name')->orderBy('id','desc')->get();
    $brands = $brandResult->toArray();

    //$userResult = User::select('dist_return')->where('level',100)->where('id',Auth::id())->first();
    //$status = $userResult->toArray();



    $distributorResult = User::select('id','firstname','officeid')->where('level',100)->orderBy('id','desc')->get();
    $distributors = $distributorResult->toArray();


    //$retailerResult = Retailer::select('id as id','name as name','officeid','retailer_id')->where('user_id',Auth::id())->orderBy('id','desc')->get();
    //$retailers = $retailerResult->toArray();


    $distributor_id = Session::get('distributor_id');
    $sno = Session::get('sno');
    $fdate = Session::get('fdate');
    $todate = Session::get('todate');


    /*$sales = Sale::with('product','retailer')->select('id','product_id','retailer_id','sno','imei','created_at')->where('user_id',Auth::id())->paginate(500);
    //$sales = $saleResult->toArray();*/

    $ssdata = [];
    $totalamount = [];
    $dailyDistributorSalesReports = [];

    if ($distributor_id == 'all' && $fdate && $todate && !$sno) {
      $ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['distributor_id'] = $distributor_id; $ssdata['sno'] = $sno;


        $dailyDistributorSalesReports = Sale::with('user','product','retailer','sr','salereturn')->select('id','sr_id','user_id','product_id','retailer_id','sno','imei','created_at')->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->paginate(10000);

    }elseif($distributor_id != 'all' && $fdate && $todate && !$sno){
        $ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['distributor_id'] = $distributor_id; $ssdata['sno'] = $sno;
        

        $dailyDistributorSalesReports = Sale::with('user','product','retailer','sr','salereturn')->select('id','sr_id','user_id','product_id','retailer_id','sno','imei','created_at')->where(['user_id'=>$distributor_id])->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->paginate(10000);


    }elseif($distributor_id == 'all' && $fdate && $todate && $sno){
        $ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['distributor_id'] = $distributor_id; $ssdata['sno'] = $sno;

        $dailyDistributorSalesReports = Sale::with('user','product','retailer','sr','salereturn')->select('id','sr_id','user_id','product_id','retailer_id','sno','imei','created_at')->where(['sno'=>$sno])->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->paginate(10000);


    }elseif($distributor_id != 'all' && $fdate && $todate && $sno){
        $ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['distributor_id'] = $distributor_id; $ssdata['sno'] = $sno;


        $dailyDistributorSalesReports = Sale::with('user','product','retailer','sr','salereturn')->select('id','sr_id','user_id','product_id','retailer_id','sno','imei','created_at')->where(['user_id'=>$distributor_id,'sno'=>$sno])->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->paginate(10000);



    }else{
      $dailyDistributorSalesReports = [];
    }
//dd($dailyDistributorSalesReports);

//Session::forget(['retailer_id','user_id','sno','fdate','todate']);

//dd(Auth::id());


    return view('admin.dailydistributorSalesReport',['brands'=>$brands,'distributors'=>$distributors,'ssdata'=>$ssdata,'dailyDistributorSalesReports'=>$dailyDistributorSalesReports]);

  }


  public function DailyDistributorSalesReportViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    


    Session::forget(['distributor_id','sno','fdate','todate']);

    $this->validate($request, [
      'distributor_id' => 'required',
      'fdate' => 'required',
      'todate' => 'required'
    ]);


    //dd($request->all());

    $distributor_id = $request->get('distributor_id');
    $sno = $request->get('sno');
    $fdate = $request->get('fdate');
    $todate = $request->get('todate');
    
    Session::put(['distributor_id'=>$distributor_id,'sno'=>$sno,'fdate'=>$fdate,'todate'=>$todate]);


    //dd(Session::all());


    return redirect(route('admin.dailyDistributorSalesReport'));


  }

//================DailySalesReport======================



// Salesrepresentative =======================================
  
  public function SalesrepresentativeView(){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		//$userCount = User::count();
	  

	  //$userResult = User::with('territory')->get();
	  $userResult = User::where('level',50)->orderBy('id','desc')->paginate(300);
	  //$users = $userResult->toArray();

//dd($userResult);
//



  	return view('admin.salesrepresentative',['salesrepresentatives'=>$userResult]);

  }

  public function SalesrepresentativeViewStore(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$statement = DB::select("show table status like 'users'");
		$ainid = $statement[0]->Auto_increment;


		
//========================================================================================
  		$this->validate($request, [
        //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        'firstname' => 'required|min:2|max:50',
        //'lastname' => 'required|min:1|max:50',
        'email' => 'required|email|unique:users',
        'officeid' => 'required|unique:users',
        'password' => 'required|min:3|max:20',
        'confirm_password' => 'required|min:3|max:20|same:password',
        'contact' => 'required|numeric|min:1',
        //'level' => 'required'
      ]);	

      	$image = $request->file('image');
				
			  if (!is_null($image)) {
			  	$this->validate($request, [
		          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
		        ]);	


			  $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
				Storage::put($image_name, file_get_contents($image));
			  }else{
			  	$image_name = NULL;
			  }

			  $request['remember_token'] = $request['_token'];
				$request['password'] = bcrypt($request['password']);
			  $request['photo'] = $image_name;
			  //$request['region_id'] = NULL;
			  //$request['territory_id'] = NULL;
			  $request['level'] = 50;
			  
		  	User::create($request->all());  

			return redirect()->back()->with('success', 'Data has been inserted successfully');

//========================================================================================


 
  }

  public function SalesrepresentativeUpdate(Request $request){
		if (Auth::user()->level != 500) { return redirect()->route('logout');}
		$id = $request->get('id');
  	$user = User::find($id);
		
		if ($user === null) {
			return redirect()->back()->withErrors('There are no data with this id');
		}else{
	  	$this->validate($request, [
        //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        'firstname' => 'required|min:2|max:50',
        //'lastname' => 'required|min:1|max:50',
        //'officeid' => 'required|unique:users',
        'contact' => 'required|numeric|min:1',
      ]);	


	  	$image = $request->file('image');
			//$attachment = $request->file('attachment');

		  if (!is_null($image)) {

				$this->validate($request, [
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200000',
        ]);
// for deleting file =======================
				File::delete('storage/app/' . $user['photo']);
// for deleting file =======================

			  $image_name = time().mt_rand().substr($image->getClientOriginalName(),strripos($image->getClientOriginalName(),'.'));
				Storage::put($image_name, file_get_contents($image));
			//=================================================================
				$user->firstname = $request->get('firstname');
				//$user->lastname = $request->get('lastname');
				//$user->email = $request->get('email');
				//$user->officeid = $request->get('officeid');
				$user->contact = $request->get('contact');
				$user->photo = $image_name;
	      $user->save();

			//=================================================================

			  }else{
			  	//$image_name = NULL;

			//=================================================================
				$user->firstname = $request->get('firstname');
				//$user->lastname = $request->get('lastname');
				//$user->email = $request->get('email');
				//$user->officeid = $request->get('officeid');
				$user->contact = $request->get('contact');
				//$user->photo = $image_name;
	      $user->save();

			//=================================================================

			  }

		return redirect()->back()->with('success', 'Data has been updated successfully');	  
 
  }

 
  }





  public function AddSr(Request $request){
  	if (Auth::user()->level != 500) { return redirect()->route('logout');}
  	$this->validate($request, [
        'user_id' => 'required',
        'srs' => 'required',
      ]);	

			$user_id = $request->user_id;
			$srs = $request->srs;


			foreach ($srs as $key => $sr) {
						
				$count = Sr::where(['sr_id' => $sr])->count();

				if ($count > 0) {
					return redirect()->back()->withErrors("Same retailer can not be added")->withInput();
				}


			}




			foreach ($srs as $key => $sr) {
						
				$user = User::where('id',$sr)->take(1)->first();



				$data['user_id'] = $user_id;
				$data['sr_id'] = $user->id;
				$data['name'] = $user->firstname;
				$data['email'] = $user->email;
				$data['officeid'] = $user->officeid;
				
				Sr::create($data);


			}

		return redirect()->back()->with('success', 'Data has been inserted successfully');

	}


  public function deleteSr($id){
  	if (Auth::user()->level != 500) { return redirect()->route('logout');}

  	if ($id == null) {
			return redirect()->back()->withErrors("Retailer can not be deleted")->withInput();
		}
		$count = Sale::where(['sr_id'=>$id])->count();
		
		if($count > 0 ){
			return redirect()->back()->withErrors('This user can not be deleted due to related to other data');
		}
		
		DB::table('srs')->where('id', $id)->delete();

		return redirect()->back()->with('success', 'Data has been deleted successfully');

	}






// Salesrepresentative =======================================



//================DailyRetailerStockReport=======================
  
  public function DailyRetailerStockReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    //$userCount = User::count();
    

    $retailerResult = User::where('level',200)->orderBy('id','desc')->get();
    $retailers = $retailerResult->toArray();



    $ssdata = [];
    $totalamount = [];
    $dailyRetailerStockReports = [];
    $ssdata['count'] = 0;


//dd(Session::all());

    $fdate = Session::get('fdate');
    $todate = Session::get('todate');
    $retailer_id = Session::get('retailer_id');
    $all_report = Session::get('all_report');

    if (!$fdate && !$todate && $all_report && $retailer_id) {
//--------------------------------------------------


//--------------------------------------------------
    $ssdata['count'] = 1;
    $ssdata['fdate'] = $fdate;
    $ssdata['todate'] = $todate;
//--------------------------------------------------
    $productResult = Product::select('id','name','model')->orderBy('id','desc')->get();
    $products = $productResult->toArray();


foreach ($products as $key => $product1) {
  $product_id = $product1['id'];
  $product = $product1['name'];
  $model = $product1['model'];



if ($retailer_id == "All") {

// with retailer_id========
$pcount = Sale::where('product_id',$product_id)->count();

if ($pcount > 0 ) {
  $SaleResult = Sale::with('user')->select('user_id',DB::raw('SUM(quantity) AS sin'))->where('product_id',$product_id)->groupBy('product_id')->first();
  $Sales = $SaleResult->toArray();

  //$retailer = $Sales['user']['firstname'] . " - ". $Sales['user']['officeid'];
  $retailer = "All Retailers";
  $sin = $Sales['sin'];
} else {
  $retailer = "All Retailers";
  $sin = 0;
}

$scount = Smsdetail::where('product_id',$product_id)->count();

if ($scount > 0 ) {
  $SmsdetailResult = Smsdetail::with('user')->select('user_id',DB::raw('COUNT(product_id) as sout'))->where('product_id',$product_id)->groupBy('product_id')->first();
  $Smsdetails = $SmsdetailResult->toArray();

  //$retailer = $Smsdetails['user']['firstname'] . " - ". $Smsdetails['user']['officeid'];
  $retailer = "All Retailers";
  $sout = $Smsdetails['sout'];
} else {
  $retailer = "All Retailers";
  $sout = 0;
}

// with retailer_id========
} else {

// with retailer_id========
$pcount = Sale::where('ruser_id',$retailer_id)->where('product_id',$product_id)->count();

if ($pcount > 0 ) {
  $SaleResult = Sale::with('user')->select('user_id',DB::raw('SUM(quantity) AS sin'))->where('ruser_id',$retailer_id)->where('product_id',$product_id)->groupBy('product_id')->first();
  $Sales = $SaleResult->toArray();

  $retailer = $Sales['user']['firstname'] . " - ". $Sales['user']['officeid'];
  $sin = $Sales['sin'];
} else {
  //$retailer = " - ";
  $sin = 0;
  $userData = User::where('id',$retailer_id)->first();
  $retailer = $userData->firstname . " " . $userData->officeid;
}

$scount = Smsdetail::where('user_id',$retailer_id)->where('product_id',$product_id)->count();

if ($scount > 0 ) {
  $SmsdetailResult = Smsdetail::with('user')->select('user_id',DB::raw('COUNT(product_id) as sout'))->where('user_id',$retailer_id)->where('product_id',$product_id)->groupBy('product_id')->first();
  $Smsdetails = $SmsdetailResult->toArray();

  $retailer = $Smsdetails['user']['firstname'] . " - ". $Smsdetails['user']['officeid'];
  $sout = $Smsdetails['sout'];
} else {
  //$retailer = " - ";
  $sout = 0;
  $userData = User::where('id',$retailer_id)->first();
  $retailer = $userData->firstname . " " . $userData->officeid;
}

// with retailer_id========
}





  $dailyRetailerStockReports[] = [
    'retailer' => $retailer,
    'product_id' => $product_id,
    'product' => $product,
    'model' => $model,
    'stockin' => $sin,
    'stockout' => $sout,
    'stock' => $sin - $sout
  ]; 



}
//--------------------------------------------------
    }elseif($fdate && $todate && !$all_report  && $retailer_id){
//--------------------------------------------------
    $ssdata['count'] = 1;
    $ssdata['fdate'] = $fdate;
    $ssdata['todate'] = $todate;
//--------------------------------------------------
    
//--------------------------------------------------

    $productResult = Product::select('id','name','model')->orderBy('id','desc')->get();
    $products = $productResult->toArray();


foreach ($products as $key => $product1) {
  $product_id = $product1['id'];
  $product = $product1['name'];
  $model = $product1['model'];


if ($retailer_id == "All") {

// with retailer_id all========

$pcount = Sale::where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->count();

if ($pcount > 0 ) {
  $SaleResult = Sale::with('user')->select('user_id',DB::raw('SUM(quantity) AS sin'))->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->groupBy('product_id')->first();
  $Sales = $SaleResult->toArray();
  //$retailer = $Sales['user']['firstname'] . " - ". $Sales['user']['officeid'];
  $retailer = "All Retailers";
  $sin = $Sales['sin'];
} else {
  $retailer = "All Retailers";
  $sin = 0;
}

$scount = Smsdetail::where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->count();

if ($scount > 0 ) {
  $SmsdetailResult = Smsdetail::with('user')->select('user_id',DB::raw('COUNT(product_id) as sout'))->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->groupBy('product_id')->first();
  $Smsdetails = $SmsdetailResult->toArray();
  //$retailer = $Smsdetails['user']['firstname'] . " - ". $Smsdetails['user']['officeid'];
  $retailer = "All Retailers";
  $sout = $Smsdetails['sout'];
} else {
  $retailer = "All Retailers";
  $sout = 0;
}

// with retailer_id all========

} else {

// with retailer_id========

$pcount = Sale::where('ruser_id',$retailer_id)->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->count();

if ($pcount > 0 ) {
  $SaleResult = Sale::with('user')->select('user_id',DB::raw('SUM(quantity) AS sin'))->where('ruser_id',$retailer_id)->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->groupBy('product_id')->first();
  $Sales = $SaleResult->toArray();
  $retailer = $Sales['user']['firstname'] . " - ". $Sales['user']['officeid'];
  $sin = $Sales['sin'];
} else {
  //$retailer = " - ";
  $sin = 0;

  $userData = User::where('id',$retailer_id)->first();
  $retailer = $userData->firstname . " " . $userData->officeid;
}

$scount = Smsdetail::where('user_id',$retailer_id)->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->count();

if ($scount > 0 ) {
  $SmsdetailResult = Smsdetail::with('user')->select('user_id',DB::raw('COUNT(product_id) as sout'))->where('user_id',$retailer_id)->where('product_id',$product_id)->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])->groupBy('product_id')->first();
  $Smsdetails = $SmsdetailResult->toArray();
  $retailer = $Smsdetails['user']['firstname'] . " - ". $Smsdetails['user']['officeid'];
  $sout = $Smsdetails['sout'];
} else {
  //$retailer = " - ";
  $sout = 0;
  $userData = User::where('id',$retailer_id)->first();
  $retailer = $userData->firstname . " " . $userData->officeid;
}

// with retailer_id========

}


  $dailyRetailerStockReports[] = [
    'retailer' => $retailer,
    'product_id' => $product_id,
    'product' => $product,
    'model' => $model,
    'stockin' => $sin,
    'stockout' => $sout,
    'stock' => $sin - $sout
  ]; 


    }



}


//Session::forget(['user_id','fdate','todate']);

    return view('admin.dailyRetailerStockReport',['ssdata'=>$ssdata,'dailyRetailerStockReports'=>$dailyRetailerStockReports,'retailers' => $retailers]);

  }


  public function DailyRetailerStockReportViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());

    Session::forget(['fdate','todate','all_report']);


if ($request->get('all_report') == null) {
    
    $this->validate($request, [
      'fdate' => 'required',
      'todate' => 'required',
      'retailer_id' => 'required',
    ]);


    $retailer_id = $request->get('retailer_id');
    $fdate = $request->get('fdate');
    $todate = $request->get('todate');
    //$all_report = $request->get('all_report');

    Session::put(['fdate'=>$fdate,'todate'=>$todate,'retailer_id'=>$retailer_id]);
}else{
    $this->validate($request, [
      'all_report' => 'required','retailer_id' => 'required',
    ]);
    $retailer_id = $request->get('retailer_id');
    $all_report = $request->get('all_report');

    Session::put(['all_report'=>$all_report,'retailer_id'=>$retailer_id ]);
}

  return redirect(route('admin.dailyRetailerStockReport'));


  }

//================DailyRetailerStockReport=======================


//================DailyRTSMSReport======================

  public function DailyRTSMSReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    //Session::forget(['fdate','todate']);

    //=====================
      $returnCount = Preturn::where('status','<=', 2)->count();
      $_SESSION['returnCount'] = $returnCount;
    //=====================

    $fdate = Session::get('fdate');
    $todate = Session::get('todate');

    $ssdata = [];
    $preturns = [];

    if ($fdate && $todate) {

      $ssdata['fdate'] = $fdate;
      $ssdata['todate'] = $todate;


      $preturns = Promortsmsdetail::with('user','promort','promortdetail')

                ->select('id','user_id','promort_id','promortdetail_id','details','phoneno','created_at','updated_at','color')
                ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
                //->OrderBy('status','Desc')
                ->OrderBy('id','Desc')
                ->get();
    }

	//dd($preturns);

    return view('admin.dailyRTSMSReport',['ssdata'=>$ssdata,'preturns'=>$preturns]);

  }


  public function DailyRTSMSReportViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());


    Session::forget(['fdate','todate']);

    $this->validate($request, [
      'fdate' => 'required',
      'todate' => 'required'
    ]);


    //dd($request->all());

    $fdate = $request->get('fdate');
    $todate = $request->get('todate');
    
    Session::put(['fdate'=>$fdate,'todate'=>$todate]);


    //dd(Session::all());


    return redirect(route('admin.dailyRTSMSReport'));


  }

//================DailyRTSMSReport======================



//================DailyimeivReport======================

  public function DailyimeivReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    //Session::forget(['csvpath','rpath']);
    
    $ssdata = [];
    $preturns = [];
	
	$arr_data[] = Session::get('arr_data');
	if ($arr_data[0]) {

		foreach ($arr_data[0]["sno"] as $key => $value) {
			$sno = $value;

			$count1 = DB::table('stocks')->select('id')->where(['sno'=>$sno])->count();

			if ($count1 > 0) {
				

				//========stock===
				$StockResult = Stock::select(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as cdate"))->where(['sno'=>$sno])->first();
				$Stocks = $StockResult->toArray();
				$importdate = $Stocks['cdate'];
				//========stock===
				//dd($importdate);

				//========purchase===
				$count2 = DB::table('purchases')->select('id')->where(['sno'=>$sno])->count();
				if ($count2 > 0) {
					$PurchaseResult = Purchase::with('user')->select('user_id',DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as cdate"))->where(['sno'=>$sno])->first();
				  $Purchases = $PurchaseResult->toArray();
					$st1id = $Purchases['user']['firstname'] . " - ". $Purchases['user']['officeid'];
				  $st1date = $Purchases['cdate'];
				}else{
					$st1id = "-";
				  $st1date = "-";
				}
				//========purchase===

				//========sale===
				$count3 = DB::table('sales')->select('id')->where(['sno'=>$sno])->count();
				if ($count3 > 0) {
					$SaleResult = Sale::with('retailer')->select('retailer_id',DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as cdate"))->where(['sno'=>$sno])->first();
				  $Sales = $SaleResult->toArray();
					$st2id = $Sales['retailer']['name'] . " - ". $Sales['retailer']['officeid'];
				  $st2date = $Sales['cdate'];
				}else{
					$st2id = "-";
				  $st2date = "-";
				}
				//========sale===

				//========smsdetails===
				$count4 = DB::table('smsdetails')->select('id')->where(['sno'=>$sno])->count();
				
				if ($count4 > 0) {
					$SmsdetailResult = Smsdetail::with('user')->select('user_id',DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as cdate"))->where(['sno'=>$sno])->first();
				  $Smsdetails = $SmsdetailResult->toArray();
					$st3id = $Smsdetails['user']['firstname'] . " - ". $Smsdetails['user']['officeid'];
				  $st3date = $Smsdetails['cdate'];
				}else{
					$st3id = "-";
				  $st3date = "-";
				}
				//========smsdetails===

				$remarks = "IMEI/SNO IS Available";


				$preturns[] = [
					'sno' => $sno,
					'importdate' => $importdate,
					'st1date' => $st1date,
					'st1id' => $st1id,
					'st2date' => $st2date,
					'st2id' => $st2id,
					'st3date' => $st3date,
					'st3id' => $st3id,
					'remarks' => $remarks,
				];
				
			}else{
				$remarks = "IMEI/SNO Not Available";

				$preturns[] = [
					'sno' => $sno,
					'importdate' => "-",
					'st1date' => "-",
					'st1id' => "-",
					'st2date' => "-",
					'st2id' => "-",
					'st3date' => "-",
					'st3id' => "-",
					'remarks' => "IMEI/SNO Not Available",
				];
			}

		}
		//dd($preturns);
	}



    return view('admin.dailyimeivReport',['ssdata'=>$ssdata,'preturns'=>$preturns]);

  }


  public function DailyimeivReportViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    Session::forget(['csvpath','rpath']);

    /*$this->validate($request, [
      'fdate' => 'required',
      'todate' => 'required'
    ]);*/



	if (is_null($request->file('csv_file')) == true) {
		return redirect()->back()->withErrors("Please select csv fole");
	}

	$path = $request->file('csv_file')->getRealPath();

	$arr_data = [];
    if ($path) {
	  	$path = $request->file('csv_file')->getRealPath();

	  	$row_index = file($request->file('csv_file'), FILE_SKIP_EMPTY_LINES);
	  	
	    $data = array_map('str_getcsv', file($path));
	    $csv_data = array_slice($data, 1, count($row_index));

		foreach ($csv_data as $key => $value) {
			$arr_data['sno'][] = $value[0];
		}

    }

	Session::put(['arr_data'=>$arr_data]);

    return redirect(route('admin.dailyimeivReport'));


  }

//================DailyimeivReport======================





//================DailyReturnReport======================

  public function DailyReturnReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    //Session::forget(['fdate','todate']);

  	//=====================
			$returnCount = Preturn::where('status','<=', 2)->count();
			$_SESSION['returnCount'] = $returnCount;
		//=====================

    $fdate = Session::get('fdate');
    $todate = Session::get('todate');

    $ssdata = [];
    $preturns = [];

    if ($fdate && $todate) {

      $ssdata['fdate'] = $fdate;
      $ssdata['todate'] = $todate;


      $preturns = Preturn::with('product')

                ->select('id','product_id','retailer_id','sno','imei','created_at','updated_at','status',
                	DB::raw('(select CONCAT(users.firstname, "-", users.officeid, "-", users.contact) from users where users.id = user_id) as distributor'),

									DB::raw('(select CONCAT(users.firstname, "-", users.officeid, "-", users.contact) from users where users.id = ruser_id) as retailer'))
                
                ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
                ->OrderBy('status','Desc')
                ->OrderBy('id','Desc')
                ->get();


      //dd($preturns);
    }



    return view('admin.dailyReturnReport',['ssdata'=>$ssdata,'preturns'=>$preturns]);

  }


  public function DailyReturnReportViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    //dd($request->all());


    Session::forget(['fdate','todate']);

    $this->validate($request, [
      'fdate' => 'required',
      'todate' => 'required'
    ]);


    //dd($request->all());

    $fdate = $request->get('fdate');
    $todate = $request->get('todate');
    
    Session::put(['fdate'=>$fdate,'todate'=>$todate]);


    //dd(Session::all());


    return redirect(route('admin.dailyReturnReport'));


  }

//================DailyReturnReport======================


// ReturnProduct =======================================
  
  public function ReturnProductViewAll(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
  

  	
    //=====================
			$returnCount = Preturn::where('status','<=', 2)->count();
			$_SESSION['returnCount'] = $returnCount;
		//=====================

    $preturns = Preturn::with('product')->select('id','product_id','retailer_id','sno','imei','created_at','updated_at','status',DB::raw('(select CONCAT(users.firstname, "-", users.officeid, "-", users.contact) from users where users.id = user_id) as distributor'),DB::raw('(select CONCAT(users.firstname, "-", users.officeid, "-", users.contact) from users where users.id = ruser_id) as retailer'))->OrderBy('status','Desc')->OrderBy('id','Desc')->paginate(300);


    //dd($preturns);
    

    return view('admin.returnProductAll',['preturns'=>$preturns]);

  }

  public function ReturnProductView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
  
    //=====================
			$returnCount = Preturn::where('status','<=', 2)->count();
			$_SESSION['returnCount'] = $returnCount;
		//=====================

    $preturns = Preturn::with('product','retailer')->select('id','product_id','retailer_id','sno','imei','created_at','updated_at','status',

    	DB::raw('(select CONCAT(users.firstname, "-", users.officeid, "-", users.contact) from users where users.id = user_id) as distributor'),
    	DB::raw('(select CONCAT(users.firstname, "-", users.officeid, "-", users.contact) from users where users.id = ruser_id) as retailer')

    )->where('status','<=', 2)->OrderBy('status','Desc')->OrderBy('id','Desc')->paginate(200);
    //$sales = $saleResult->toArray();

    return view('admin.returnProduct',['preturns'=>$preturns]);

  }

  public function ReturnProductViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $this->validate($request,['snos'=>'required']);
    //dd($request->all());
    $snos =array_unique($request->snos);
    $data = [];
    $snoCount = 0;
    foreach ($snos as $key => $value) {
      $sno = $value;
    //=================================
      $count = Preturn::where(['sno'=>$sno,'status' => 2])->count();

      if ($count > 0 ) {
        DB::table('preturns')->where(['sno'=>$sno])->update(['status' => 3,'nd_id'=>Auth::id()]);

        DB::table('sales')->where(['sno'=>$sno])->delete();
        DB::table('purchases')->where(['sno'=>$sno])->delete();

      }else{
        $data[] = $sno;
        $snoCount += 1;
      }
    //=================================

    }

    if ($snoCount > 0) {
      $implode = implode(", ", $data);
      return redirect()->back()->withErrors("$implode s.no has not been update, please check status , others sno has been updated")->withInput();
    }
    return redirect()->back()->with('success', 'Data has been inserted successfully');

 
  }

  public function ReturnProductDelete($id = null){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
 
    $Preturn = Preturn::find($id);
    
    $status =$Preturn->status;



    if ($Preturn === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      if ($status > 2) {
        return redirect()->back()->withErrors('This item can not be deleted becouse of this item already approved');
      }else{
        $Preturn->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully');
      }


    }
    

 
  }


// ReturnProduct =======================================





//================DailyDistStockReportV1=======================

  public function DailyDistStockReportV1View(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    

    $userResult = User::select('id','firstname','officeid')->where('level',100)->orderBy('id','desc')->get();
    $users = $userResult->toArray();

    $query = Product::select('name','id','model')->where('brand_id',2)->get();
    $products = $query->toArray();
    



    $user_id = Session::get('user_id');
    $distributor_id = Session::get('user_id');
    $fdate = '2019-01-01';
    $todate = Session::get('todate');


    /*$sales = Sale::with('product','distributor')->select('id','product_id','distributor_id','sno','imei','created_at')->where('user_id',Auth::id())->paginate(500);
    //$sales = $saleResult->toArray();*/

    $ssdata = [];
    $totalamount = [];
    $dailyDistStockReportV1s = [];

    if ($distributor_id == 'all' && $fdate && $todate) {
      $ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['distributor_id'] = $distributor_id;
//----------------------
  $query = User::select('id as id','firstname','officeid')->where('level',100)->get();
  $distributors = $query->toArray(); 

  $array_qty = [];
  foreach ($distributors as $key => $distributor) {
    
    $distributor_id = $distributor['id'];

    $query = Product::select('name','id','model')->where('brand_id',2)->get();
    $products = $query->toArray();

    foreach ($products as $key => $product) {
      $product_id = $product['id'];

# Purchase =====
      $count = Purchase::select(DB::raw('(CASE WHEN SUM(quantity) IS NULL THEN 0 ELSE SUM(quantity) END) as quantity'))
            ->where(['user_id'=>$distributor_id,'product_id'=>$product_id])
            ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
            ->groupBy('product_id')
            ->count();

      if ($count > 0) {
        $query = Purchase::select(DB::raw('(CASE WHEN SUM(quantity) IS NULL THEN 0 ELSE SUM(quantity) END) as quantity'))
            ->where(['user_id'=>$distributor_id,'product_id'=>$product_id])
            ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
            ->groupBy('product_id')
            ->first();
        $purchases = $query->toArray();

        $data1[$key] = $purchases['quantity'];
      }else{
        $data1[$key] = 0;
      }
# Purchase =====
# Sale =====
      
      $count = Sale::select(DB::raw('(CASE WHEN SUM(quantity) IS NULL THEN 0 ELSE SUM(quantity) END) as quantity'))
            ->where(['user_id'=>$distributor_id,'product_id'=>$product_id])
            ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
            ->groupBy('product_id')
            ->count();

      if ($count > 0) {
        $query = Sale::select(DB::raw('(CASE WHEN SUM(quantity) IS NULL THEN 0 ELSE SUM(quantity) END) as quantity'))
            ->where(['user_id'=>$distributor_id,'product_id'=>$product_id])
            ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
            ->groupBy('product_id')
            ->first();
        $sales = $query->toArray();

        $data2[$key] = $sales['quantity'];
      }else{
        $data2[$key] = 0;
      }

# Sale =====

   


    }

    $dailyDistStockReportV1s[] = [
      'distname' => $distributor['firstname'],
      'distcode' => $distributor['officeid'],
      'data1' => $data1,
      'data2' => $data2,
      'total1' => array_sum($data1),
      'total2' => array_sum($data2),
    ];


  }


//dd($dailyDistStockReportV1s);

//----------------------

    }elseif($distributor_id != 'all' && $fdate && $todate){
        $ssdata['fdate'] = $fdate; $ssdata['todate'] = $todate; $ssdata['user_id'] = $user_id; $ssdata['distributor_id'] = $distributor_id;
//----------------------
  $query = User::select('id as id','firstname','officeid')->where('id',$distributor_id)->get();
  $distributors = $query->toArray(); 

  $array_qty = [];
  foreach ($distributors as $key => $distributor) {
    
    $distributor_id = $distributor['id'];

    $query = Product::select('name','id','model')->where('brand_id',2)->get();
    $products = $query->toArray();

    foreach ($products as $key => $product) {
      $product_id = $product['id'];


      # Purchase =====
      $count = Purchase::select(DB::raw('(CASE WHEN SUM(quantity) IS NULL THEN 0 ELSE SUM(quantity) END) as quantity'))
            ->where(['user_id'=>$distributor_id,'product_id'=>$product_id])
            ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
            ->groupBy('product_id')
            ->count();

      if ($count > 0) {
        $query = Purchase::select(DB::raw('(CASE WHEN SUM(quantity) IS NULL THEN 0 ELSE SUM(quantity) END) as quantity'))
            ->where(['user_id'=>$distributor_id,'product_id'=>$product_id])
            ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
            ->groupBy('product_id')
            ->first();
        $purchases = $query->toArray();

        $data1[$key] = $purchases['quantity'];
      }else{
        $data1[$key] = 0;
      }
# Purchase =====
# Sale =====
      $count = Sale::select(DB::raw('(CASE WHEN SUM(quantity) IS NULL THEN 0 ELSE SUM(quantity) END) as quantity'))
            ->where(['user_id'=>$distributor_id,'product_id'=>$product_id])
            ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
            ->groupBy('product_id')
            ->count();

      if ($count > 0) {
        $query = Sale::select(DB::raw('(CASE WHEN SUM(quantity) IS NULL THEN 0 ELSE SUM(quantity) END) as quantity'))
            ->where(['user_id'=>$distributor_id,'product_id'=>$product_id])
            ->whereBetween(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"), [$fdate, $todate])
            ->groupBy('product_id')
            ->first();
        $sales = $query->toArray();

        $data2[$key] = $sales['quantity'];
      }else{
        $data2[$key] = 0;
      }
# Sale =====
    }

    $dailyDistStockReportV1s[] = [
      'distname' => $distributor['firstname'],
      'distcode' => $distributor['officeid'],
      'data1' => $data1,
      'data2' => $data2,
      'total1' => array_sum($data1),
      'total2' => array_sum($data2),
    ];


  }


//dd($dailyDistStockReportV1s);

//----------------------

    }else{
      $dailyDistStockReportV1s = [];

    }

//dd($dailyDistStockReportV1s);

//Session::forget(['distributor_id','user_id','sno','fdate','todate']);

//dd(Auth::id());


    return view('admin.dailyDistStockReportV1',['users'=>$users,'products'=>$products,'ssdata'=>$ssdata,'dailyDistStockReportV1s'=>$dailyDistStockReportV1s]);

  }


  public function DailyDistStockReportV1ViewStore(Request $request){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}

    Session::forget(['user_id','todate']);

    $this->validate($request, [
      'user_id' => 'required',
      'todate' => 'required'
    ]);

    $todate = $request->get('todate');
    $user_id = $request->get('user_id');
    
    Session::put(['user_id'=>$user_id,'todate'=>$todate]);
    return redirect(route('admin.dailyDistStockReportV1'));
  }

//================DailyDistStockReportV1======================

   

//================DistributorImeiStockReportView=======================

  public function DistributorImeiStockReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
$query = DB::table('purchases as t1')
	  ->select('t1.sno as sno','t1.imei as imei',
	  	't2.firstname as distributor','t2.officeid as officeid',
	    't3.name as product','t3.model as model')
	  ->join('users as t2', 't1.user_id', '=', 't2.id')
	  ->join('products as t3', 't1.product_id', '=', 't3.id')
	  ->where(['t1.brand_id'=>2])
	  ->whereNotIn('t1.sno',function($query){
				$query->select('sno')->from('sales');
			})
	  ->orderBy('t1.id','desc')
	  //->take(10)
	  ->get();
  //->paginate(5)
$queryresults = json_decode(json_encode($query), True);

//dd($queryresults);


    return view('admin.distributorImeiStock',['queryresults'=>$queryresults]);

  }

//================DistributorImeiStockReportView======================


//================RetailerImeiStockReportView=======================

  public function RetailerImeiStockReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $query = DB::table('sales as t1')
        ->select('t1.sno as sno','t1.imei as imei',
          't2.firstname as retailer','t2.officeid as retofficeid',
          't4.firstname as distributor','t4.officeid as distofficeid',
          't3.name as product','t3.model as model')
        ->join('users as t2', 't1.ruser_id', '=', 't2.id')
        ->join('products as t3', 't1.product_id', '=', 't3.id')
        ->join('users as t4', 't1.user_id', '=', 't4.id')
        ->where(['t1.brand_id'=>2])
        ->whereNotIn('t1.sno',function($query){
            $query->select('sno')->from('smsdetails');
          })
        ->orderBy('t1.id','desc')
        //->take(10)
        ->get();
      //->paginate(5)
    $queryresults = json_decode(json_encode($query), True);

    //dd($queryresults);


    return view('admin.retailerImeiStock',['queryresults'=>$queryresults]);

  }

//================RetailerImeiStockReportView======================




# ReportV1====


// DontWorry =======================================
  
  public function DontWorryView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    

    $dwrecords = [];

    $dwrecords = Dwdetail::with('product','brand','user')->orderBy('id','desc')->paginate(500);
    //$dwrecords = $query->toArray();


    //dd($dwrecords);


    return view('admin.dontWorry',['dwrecords'=>$dwrecords]);

  }

  public function DontWorryDelete($id = null){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
 
    $dwdetail = Dwdetail::find($id);
    
    $status = $dwdetail->status;
    if ($dwdetail === null) {
      return redirect()->back()->withErrors('There are no data with this id');
    }else{
      if ($status > 0) {
        return redirect()->back()->withErrors('This item can not be deleted becouse of already approved this item');
      }else{
        $dwdetail->delete();
        return redirect()->back()->with('success', 'Data has been deleted successfully');
      }


    }
    
  }




  public function DontWorryInactive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];
  	$dwdetail = Dwdetail::find($id);
		
		if ($dwdetail === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{
			//Update sms details==========
        $imei = $dwdetail->sno;
        $dwday = $dwdetail->dwday;

        //$smsdetailResult = Smsdetail::where(['sno' => $imei])->first();
        //$smsdetails = $smsdetailResult->toArray();
        //$twperiod = $smsdetails["wperiod"] + $dwday;

        //DB::table('smsdetails')->where('sno', $imei)->update(['isdw'=>0,'dwday'=>0,'twperiod' =>0 ]);

        DB::table('smsdetails')->where('sno', $imei)->delete();
      //Update sms details==========

			$dwdetail->status = false;
  		$dwdetail->save();
  
			return redirect()->back()->with('success', 'Data has been inactivated successfully');
		}

  }

  public function DontWorryActive(Request $request){
	  if (Auth::user()->level != 500) { return redirect()->route('admin.dashboard');}
  	
  	$this->validate($request,['id'=>'required']);

  	$id = $request['id'];
		$dwdetail = Dwdetail::find($id);
		
		//dd($request->all());


		if ($dwdetail === null) {
			return redirect()->back()->withErrors('There are no data with this id');

		}else{

			//Update sms details==========
    $sno = $dwdetail->sno;
    $dwday = $dwdetail->dwday;
    $dwcharge = $dwdetail->dwcharge;
    $user_id = $dwdetail->user_id;
    $promort_id = $dwdetail->promort_id;
    $brand_id = $dwdetail->brand_id;
    $customer = $dwdetail->customer;
    $mobile = $dwdetail->mobile;
    $created_at = $dwdetail->created_at;
    $updated_at = $dwdetail->updated_at;




$smscount = DB::table('smsdetails')->where(['sno'=>$sno])->count();

if ($smscount < 1) {
	# code...


//---------------------------------------
		
		/*$queryresult = DB::table('users')->select('id','contact')->where(['officeid'=>$retaileid])->take(1)->first();
		$users = json_decode(json_encode($queryresult), True);

		$retailer_id = $users['id'];
		$mobile = $users['contact'];*/

		$stockresult = DB::table('stocks')->select('id','product_id','imei','sno','brand_id','wperiod')->where(['sno'=>$sno])->first();
		$stockdata = json_decode(json_encode($stockresult), True);
		
		$stock_id = $stockdata['id'];
		$product_id = $stockdata['product_id'];
		$brand_id = $stockdata['brand_id'];
		$imei = $stockdata['imei'];
		$sno = $stockdata['sno'];
		$wperiod = $stockdata['wperiod'];

		



		if ($imei == "") {
			$imei = NULL;
		}

//---------------------------------------
		
			$data1['created_at'] = $created_at;
			$data1['updated_at'] = $updated_at;
			$data1['promo_id'] = 0;
			$data1['promodetail_id'] = 0;
			$data1['user_id'] = $user_id;
			$data1['product_id'] = $product_id;
			$data1['brand_id'] = $brand_id;
			$data1['imei'] = $imei;
			$data1['sno'] = $sno;
			$data1['mobile'] = $mobile;
			$data1['wperiod'] = $wperiod;
			$data1['iswar'] = 1;
			$data1['isdw'] = 1;
			$data1['dwday'] = $dwday;
			$data1['dwcharge'] = $dwcharge;
			$data1['twperiod'] = $wperiod + $dwday;

			
	Smsdetail::create($data1);

}else{
	DB::table('smsdetails')->where('sno', $sno)->update(['isdw' => 1,'dwday' => $dwday,'dwcharge' => $dwcharge, 'twperiod' => $twperiod ]);
}
//---------------------------------------

        /*$smsdetailResult = Smsdetail::where(['sno' => $imei])->first();
        $smsdetails = $smsdetailResult->toArray();
        $twperiod = $smsdetails["wperiod"] + $dwday;
        DB::table('smsdetails')->where('sno', $imei)->update(['isdw' => 1,'dwday' => $dwday, 'twperiod' => $twperiod ]);*/
      //Update sms details==========

			$dwdetail->status = true;
  		$dwdetail->save();
			return redirect()->back()->with('success', 'Data has been activated successfully');
		}

	
  }




// DontWorry =======================================


}