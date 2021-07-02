<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiAuthController;
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
//use App\Product;
//use App\ProductCategory;

// use App\Carmodel;
// use App\Car;
// use App\Year;
// use App\Engine;
// use App\Type;
// use App\Part;
// use App\Product;
// use App\ProductPhoto;
// use App\ProductAttribute;

// use App\Currency;
// use App\Timezone;

// use App\Division;
// use App\District;

// use App\Chassis;
// use App\Brand;

// use App\Order;
// use App\BellingAddress;
// use App\PaymentMethod;
// use App\DeliveryMethod;
// use App\Center;
// use App\Area;
// use App\Invoice;
// use App\Setting;
// use App\Page;
// use App\Newsletter;
// use App\Coupon;
// use App\Service;
// use App\Slider;


// use App\Project;
// use App\ProjectPhoto;

// use App\Wishlist;


class ApiGuestController extends Controller
{
	private $ApiAuthController;

	public function __construct()
  {
      $this->ApiAuthController = new ApiAuthController;
  }


	protected function Test(){
    //return "This is test";

    $query = User::select('id','firstname','lastname')->where('active',1)->first();
	  $queryResult = $query->toArray();

	  //$queryResult = array_merge(['demo'=>1],$queryResult);

		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);


  	//return "Tseting Methode .....";

  	//return self::$currency;

  	//return Auth::user()->level;

  	//$statement = DB::select("show table status like 'products'");
		//$aiid = $statement[0]->Auto_increment;
 		////return response()->json(['user_id' => $statement[0]->Auto_increment]);



	  $timezoneCount = Timezone::count();
	  $timezoneResult = Timezone::where(['status'=>1])->first();
	  $timezones = $timezoneResult->toArray();

	  //return self::$timezone = $timezones['timezone'];
	  self::$timezone;
	  

	  $currencyCount = Currency::count();
	  $currencyResult = Currency::where(['status'=>1])->first();
	  $currencys = $currencyResult->toArray();

	  //self::$code = $currencys['code'];
	  //self::$currency = $currencys['currency'];
	  self::$currency;
	  self::$code;

	  $carCount = Car::count();
	  $carResult = Car::with('carmodel')->orderBy('id','desc')->get();
	  $cars = $carResult->toArray();

	  $carmodelCount = Carmodel::count();
	  $carmodelResult = Carmodel::with('car')->orderBy('id','desc')->get();
	  $carmodels = $carmodelResult->toArray();

	  $engineCount = Engine::count();
	  $engineResult = Engine::orderBy('id','desc')->get();
	  $engines = $engineResult->toArray();

	  $brandCount = Brand::count();
	  $brandResult = Brand::orderBy('id','asc')->get();
	  $brands = $brandResult->toArray();

	  $yearCount = Year::count();
	  $yearResult = Year::orderBy('id','desc')->get();
	  $years = $yearResult->toArray();



	  $typeCount = Type::count();
	  $typeResult = Type::with('part')->orderBy('id','desc')->get();
	  $types = $typeResult->toArray();


	  $partCount = Part::count();
	  $query = Part::with('type')->orderBy('id','desc')->get();
	  $parts = $query->toArray();

	  $divisionCount = Division::count();
	  $divisionResult = Division::with('district')->orderBy('id','desc')->get();
	  $divisions = $divisionResult->toArray();


	  $districtCount = District::count();
	  $districtResult = District::with('division')->orderBy('id','desc')->get();
	  $districts = $districtResult->toArray();


	  $productCount = product::count();
	  $query = product::with(['productPhoto','car','carmodel','year','engine','type','part'])->orderBy('id','desc')->get();
	  $products = $query->toArray();


	  $wishListCount = Wishlist::count();
	  $wishListResult = Wishlist::with(['user','product'])->orderBy('id','desc')->get();
	  $wishLists = $wishListResult->toArray();


//================================ Wishlist Code========================

	  $userCount = User::count();
	  $userResult = User::with(['wishlist'])->where('id',Auth::id())->first();
	  $user = $userResult->toArray();

//dd($user['wishlist']);

	foreach ($user['wishlist'] as $key => $wishlist) {
		$product_id = $wishlist['product_id'];
		$query = Product::with(['image','photo','productPhoto','productAttribute','car','carmodel','brand','year','engine','chassis','type','part'])->where(['id'=>$product_id])->orderBy('id','desc')->take(5)->first();
	  $products = $query->toArray();
		$data[] = array(
        'product_id'=>$products['id'],
        'product'=>$products['product'],
        'code'=>$products['code'],
        'price'=>$products['price'],
        'total'=>$products['total'],
        'discount'=>$products['discount'],
        'product_photo'=>$products['product_photo'][0]['filename'],
      );
	}

	    
//================================ Wishlist Code========================


	  dd($data);
  }


  public function setting()
  {
	  $query = Setting::select('currency','code','timezone','hotline','contact','vat','semail','indhaka','outdhaka','favicon','logo','imagepath','viewstatus')->first();
	  $queryResult = $query->toArray();

		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }

  public function coupon()
  {

  	

  	return $this->ApiAuthController->test();
  	//return $ApiAuthController->test();
  	//return ApiAuthController::test();

	  $query = Coupon::select('id','discount','amount')->where('active',1)->first();
	  $queryResult = $query->toArray();

	  //$queryResult = array_merge(['demo'=>1],$queryResult);

		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }


  public function districts()
  {
	  $query = District::orderBy('id','asc')->select('id','name')->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }


  public function categories()
  {
	  $query = Type::with('subcat')->orderBy('id','asc')->select('id','type as name','icon')->get();
	  $queryResult = $query->toArray();

		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }



  public function subcategories()
  {
	  $query = Part::orderBy('id','asc')->select('id','part as name','icon')->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
	}
	
	public function cats()
  {
	  $query = Type::orderBy('id','asc')->select('id','type as name','icon')->get();
	  $queryResult = $query->toArray();

		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
	}
	
  public function subcats($cid)
  {
	  $query = Part::orderBy('id','asc')->select('id','part as name','icon')->where('type_id',$cid)->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
	}
	
  public function slider()
  {
	  $query = Slider::orderBy('id','desc')->select('id','slider as title','details','photo','curl')->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }


  public function allproducts()
  {

	  $query = product::with(['image','images'])->orderBy('id','desc')
	  									//->select('id','product as name','code as productcode','price','quantity','discount','total','short_details','details')
	  									->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }


  public function productswithlimit($limit=10,$page=1)
  {
	  $query = product::with(['image','images'])->orderBy('id','desc')
	  									->select('id','product as name','code as productcode','price','quantity','discount','total','short_details','details')->where('active',1)->take($page*$limit)->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }


  public function discountproductswithlimit($limit=10,$page=1)
  {
	  $query = product::with(['image','images'])->orderBy('discount','desc')
	  									->select('id','product as name','code as productcode','price','quantity','discount','total','short_details','details')->where('active',1)->take($page*$limit)->where('discount','>',0)
	  									->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }

  public function popularproductswithlimit($limit=10,$page=1)
  {
	  $query = product::with(['image','images'])->orderBy('popular_search','desc')
	  									->select('id','product as name','code as productcode','price','quantity','discount','total','short_details','details')->where('active',1)->take($page*$limit)->where('popular_search','>',0)
	  									->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }

  public function bestsaleproductswithlimit($limit=10,$page=1)
  {
	  $query = product::with(['image','images'])->orderBy('best_sale','desc')
	  									->select('id','product as name','code as productcode','price','quantity','discount','total','short_details','details')->where('active',1)->take($page*$limit)->where('best_sale','>',0)
	  									->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }


  public function specialproductswithlimit($limit=10,$page=1)
  {
	  $query = product::with(['image','images'])->orderBy('id','desc')
	  									->select('id','product as name','code as productcode','price','quantity','discount','total','short_details','details')->where('active',1)->take($page*$limit)->where('featured','>',0)
	  									->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }


  public function catwiseproductswithlimit($cat_id,$limit=10,$page=1)
  {
	  $query = product::with(['image','images'])->orderBy('id','desc')
	  									->select('id','product as name','code as productcode','price','quantity','discount','total','short_details','details')->where(['active'=>1,'part_id'=>$cat_id])->take($page*$limit)
	  									->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }


  public function searchproductswithlimit($limit=10,$page=1,Request $request)
  {

  	$searchTerm = $request->search;

		$query = product::with(['image','images'])->orderBy('id','desc')
	  									->select('id','product as name','code as productcode','price','quantity','discount','total','short_details','details')
											
											->where('active',1)
											->where('product', 'like', '%' . $searchTerm . '%')
											->orWhere('code', 'like', '%' . $searchTerm . '%')
											->take($page*$limit)
											->get();
	  $queryResult = $query->toArray();

		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }





  public function productdetails($pid=134)
  {
  	$count = product::select('id')->where('id',$pid)->count();

  	if ($count > 0 ) {
  		$query = product::with(['image','images'])->orderBy('id','desc')
	  									->select('id','product as name','code as productcode','price','quantity','discount','total','short_details','details')->where('id',$pid)->first();

		  $queryResult = $query->toArray();
			return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);

  	} else {
  		$returndata = ["Something went wrong"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
  	}

	  
  }





  public function checkcoupon(Request $request)
  {

  	//return date('Y-m-d');

  	$coupon = $request->coupon;

  	$count = Coupon::select('id')->where('active',1)->where('coupon',$coupon)->count();

		if ($count > 0) {
			
			$query = Coupon::select('id','discount','amount')->where('active',1)->where('coupon',$coupon)->first();
			$queryResult = $query->toArray();
			
			return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
		} else {
			$returndata = ["Something went wrong"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
		}	

		
  }

  public function userregistration(Request $request)
  {
		$rules  =  array(
        'firstname' => 'required|min:2|max:35',
        'lastname' => 'required|min:2|max:35',
        'email' => 'required|email|unique:users',
        'contact' => 'required|min:11',
        'password' => 'required|min:3|max:50',
        'confirm_password' => 'required|min:3|max:50|same:password'
    );


		$validator = Validator::make($request->all(),$rules);

		if ($validator->fails())
		{
		  $messages = $validator->errors();
			return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
		}else{

			$credentials = ['email'=> $request['email'],'password'=> $request['password']];

			$request['level'] = 100;
			$request['officeid'] = $request['contact'];
			$request['password'] = bcrypt($request['password']);
			$user = User::create($request->all());
			
			//$returndata['success'] = "User Created Successfully";
			//return response()->json($returndata,200);
			
			return $this->ApiAuthController->loginwithparameter($credentials);

		}
	}





	public function userpasswordrecoverymode(DemandController $demandController, Request $request)
  {
  	$rules  =  array(
      'email' => 'required|email'
    );


		$validator = Validator::make(
		  $request->all(),$rules
		);

		if ($validator->fails())
		{
		  $messages = $validator->errors();
			return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
		}


		$count = User::where(['active'=>1, 'email' => $request['email']])->count();

		if ($count == 0)
		{
			$returndata = ["There is no account with this email"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
		}


		$userdata = User::where(['active'=>1, 'email' => $request['email']])->first();

		$name = $userdata->firstname ." ". $userdata->lastname;
		$email = $userdata->email;
		$contact = $userdata->contact;
		$rawpassword = $userdata->rawpassword;

		$returnmsg = $demandController->SendEmailToCustomerByGateway($name,$email,$rawpassword);

		if ($returnmsg > 0) {
			$returndata = ["Please check your mail and will get password"];
      return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);
		} else {
			$returndata = ["Something went wrong"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
		}

  }


	public function popularseachcount($pid){
		$productupdate = Product::find($pid);

		if ($productupdate == null) {
			$returndata = ["Something went wrong"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
		}

		$productupdate->popular_search = $productupdate->popular_search + 1;
		$productupdate->save();

		//$returndata = ["Please check your mail and will get password"];
    //return response()->json(null, 200,[],JSON_PRETTY_PRINT);
	}




}
