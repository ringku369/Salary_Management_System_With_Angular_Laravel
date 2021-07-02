<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


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




class ApiAuthController extends Controller
{
    
  public function __construct()
  {
    //$this->middleware('auth:api', ['except' => ['login','test']]);
  }



  public function test()
  {

    


    return "This is test";
    //return route('api.login');
  }

  public function login(Request $request)
  {
    
    $rules  =  array(
      'username' => 'required|email',
      'password' => 'required|min:1|max:50'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }



    $credentials1 = ['email'=> $request['username'],'password'=> $request['password'],'level' => 100,'active' => 1];
    $credentials2 = ['email'=> $request['username'],'password'=> $request['password'],'level' => 500,'active' => 1];
    $credentials3 = ['officeid'=> $request['username'],'password'=> $request['password'],'level' => 100,'active' => 1];

    if ($token = auth()->attempt($credentials1)) {
      return $this->respondWithToken($token);
    }elseif($token = auth()->attempt($credentials1)){
      return $this->respondWithToken($token);
    }elseif($token = auth()->attempt($credentials1)){
      return $this->respondWithToken($token);
    }else {
      
      $returndata = ["email or password does not match, pls try again"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }
  }


  public function loginwithparameter($credentials)
  {
    if (! $token = auth()->attempt($credentials)) {
      $returndata = ["email or password does not match, pls try again"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
      //return response()->json(['error' => 'Wrong email or password, pls try again'], 400);
    }

    return $this->respondWithToken($token);
  }


  public function me()
  {
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

    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'name' => auth()->user()->firstname . " " . auth()->user()->lastname,
      'email' => auth()->user()->email,
      'role' => (auth()->user()->level == 500) ? 'Admin' : 'User',
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



  public function wishlist(Request $request){
    $rules  =  array(
      'product_id' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $count = Product::where('id', $request['product_id'])->count();

    if ($count == 0)
    {
      $returndata = ["There is no product with this id"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = Wishlist::where(['product_id'=>$request['product_id'],'user_id'=>Auth::id()])->count();

    if ($count > 0)
    {
      $returndata = ["This product has already been added in your wishlist"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $request['user_id'] = Auth::id();
    $queryResult = Wishlist::create($request->all());

    $returndata = ["This product has been added in your wishlist successfully"];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  }



  public function wishlistdestroy(Request $request){
    $rules  =  array(
      'product_id' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    $count = Product::where('id', $request['product_id'])->count();

    if ($count == 0)
    {
      $returndata = ["There is no product with this id"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = Wishlist::where(['product_id'=>$request['product_id'],'user_id'=>Auth::id()])->count();

    if ($count == 0)
    {
      $returndata = ["There is no product with this request in your wishlist"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $queryResult = DB::table('wishlists')->where(['product_id'=>$request['product_id'],'user_id'=>Auth::id()])->delete();

    if ($queryResult > 0) {
      $returndata = ["This product has been deleted in your wishlist successfully"];
      return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

    } else {
      $returndata = ["Something went wrong"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }


  }

  public function ordercancel(Request $request){
    $rules  =  array(
      'invoice_id' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }


    $count = Invoice::where(['id'=>$request['invoice_id'],'user_id'=>Auth::id()])->count();

    if ($count == 0)
    {
      $returndata = ["There is no order with this request"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $count = Invoice::where(['id'=>$request['invoice_id'],'user_id'=>Auth::id(),'status'=>1])->count();

    if ($count > 0)
    {
      $returndata = ["This order can not be canceled due to already been delivered it"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }

    $queryResult = DB::table('invoices')->where(['id'=>$request['invoice_id'],'user_id'=>Auth::id()])->update(
      ['cancel' => 1]
    );

    if ($queryResult > 0) {
      $returndata = ["This product has been sent to the admin successfully, inform you very soon"];
      return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

    } else {
      $returndata = ["Something went wrong"];
      return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);
    }


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
    
    //return Auth::id(); 

    $query = User::with(['district','wishlist','invoice'])->where('id',Auth::id())->first();
    //$query = User::where('id',Auth::id())->first();
    $queryResult = $query->toArray();
    return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }

  public function districts()
  {
  	//$returndata = ["Please check your mail and will get password","Stay with us.. Thanks ..."];
    //return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);

  	//$returndata = ["Something went wrong"];
    //return response()->json($returndata, 400,[],JSON_PRETTY_PRINT);


	  $query = District::orderBy('id','asc')->select('id','name')->get();
	  $queryResult = $query->toArray();
		return response()->json($queryResult,200,[],JSON_PRETTY_PRINT);
  }





    public function checkout(DemandController $demandController, Request $request){
    $rules  =  array(
        'firstname' => 'required|min:2|max:35',
        'lastname' => 'required|min:2|max:35',
        'email' => 'required|email',
        'contact' => 'required|min:11',
        'address' => 'required',
        'district_id' => 'required',
        'paymentmethod' => 'required',
        'product_id' => 'required',
        'quantity' => 'required',
        //'iscoupon' => 'required'
    );
    
    $validator = Validator::make( $request->all(),$rules);

    if ($validator->fails())
    {
      $messages = $validator->errors();
      return response()->json($messages->all(),400,[],JSON_PRETTY_PRINT);
    }

    //return $request->all();


    //===================================================  




    $firstname = $request['firstname'];
    $lastname = $request['lastname'];
    $email = $request['email'];
    $contact = $request['contact'];
    $address = $request['address'];
    $district_id = $request['district_id'];
    $paymentMethod = $request['paymentmethod'];

    $iscoupon = $request['iscoupon'];
    $coupon = $request['coupon'];


    if ($paymentMethod == 10) {
      $status = 0;
      $payment_type = "Cash On Delivery";
    }elseif ($paymentMethod == 20) {
      $status = 0;
      $payment_type = "Direct Bank Transfer";
    }

//===================
    $settingdata = Setting::select('currency','code','timezone','hotline','contact','vat','semail','indhaka','outdhaka','favicon','logo')->first();

    $vat = $settingdata->vat;


  
  //==========
    if ($district_id == 1) {
      $shipping_cost = $settingdata->indhaka;
    } else {
      $shipping_cost = $settingdata->outdhaka;
    }

  //==========



//====================
  


  //======================================
  //
    
    
    $statement = DB::select("show table status like 'invoices'");
    $invoice_id = $statement[0]->Auto_increment;
    $iuid =  $invoice_id + date('m') + date('Y');

    $statement = DB::select("show table status like 'orders'");
    $ainid = $statement[0]->Auto_increment;
    $ouid =  $ainid + date('m') + date('Y');

    $statement = DB::select("show table status like 'belling_addresses'");
    $belling_address_id = $statement[0]->Auto_increment;

    $statement = DB::select("show table status like 'delivery_methods'");
    $delivery_method_id = $statement[0]->Auto_increment;

    $statement = DB::select("show table status like 'payment_methods'");
    $payment_method_id = $statement[0]->Auto_increment;

  //======================================

    $product_arr = $request->product_id;
    $quantity_arr = $request->quantity;



    foreach ($product_arr as $key => $value) {
      
      $id = $value; 
      $qty = $quantity_arr[$key];


      $productCount = Product::where('id',$id)->count();

      $productResult = Product::where('id',$id)->first();
      $product = $productResult->toArray();

  //==============================================
      $productCode = $product['code'];

      $quantity = $product['quantity'];
      $resofqty = $quantity - $qty;

      $productupdate = Product::find($id);
      $productupdate->quantity = $resofqty;
      $productupdate->best_sale = $productupdate->best_sale + 1;
      $productupdate->save();


  //=========================
    if ($resofqty <= 10) {
      
      //$demandController->SendSmsToAdminForLowQtyByGateway($productCode,$quantity);
      //$demandController->SendEmailToAdminForLowQtyByGateway($productCode,$quantity);

    }
  //=========================
  //==============================================

  //============= for vat ==========================
      $prductPrice  = $product['total'] * $qty;
      $totalVat = ($prductPrice * $vat)/100;
  //============= for vat ==========================


      $productData['invoice_id'] = $invoice_id;
      $productData['iuid'] = $iuid;

      $productData['user_id'] = Auth::id();
      $productData['product_id']  = $product['id'];
      $productData['product_qty']  = $qty;
      $productData['product_price']  = $product['total'];
      $productData['subtotal']  = $product['total'] * $qty;
      $productData['date']  = date('m/d/Y');
      $productData['monthYear']  = date('m/Y');
      $productData['method_status']  = 1;
      $productData['ordermethod']  = "Delivery To Home";
      $productData['ouid']  = $ouid;
      $productData['shipping_cost']  = $shipping_cost;
      $productData['product_vat']  = $totalVat;


      $productData['belling_address_id']  = $belling_address_id;
      $productData['delivery_method_id']  = $delivery_method_id;
      $productData['payment_method_id']  = $payment_method_id;
      $order = Order::create($productData);


  //===================================================  
  //===================================================  

    $product_qty = $qty;
    $product_price = $product['total'];
    $shipping_cost = $shipping_cost;
    $product_vat = $vat;
    $subtotal = $product['total'] * $qty;

    $totalvat = ($subtotal * $product_vat)/100;

    $arr_totalvat[] = ($subtotal * $product_vat)/100;


    $total = $shipping_cost + $totalvat + $subtotal ;
    
    $excludingVat = $shipping_cost + $subtotal ;

    $arr_excludingVat[] = $shipping_cost + $subtotal ;
    
    $arr_total[] =  $subtotal ;


  //===================================================  

  //$grandGrandTotal = array_sum($arr_total) + array_sum($arr_totalvat) + $shipping_cost;

    } 


    $grandGrandTotal = array_sum($arr_total) + array_sum($arr_totalvat) + $shipping_cost;

//=====================================================================

    $bellingData['invoice_id'] = $invoice_id;
    $bellingData['iuid'] = $iuid;
    $bellingData['user_id'] = Auth::id();
    //$bellingData['order_id'] = $order->id;
    $bellingData['district_id']  = $district_id;
    $bellingData['firstname']  = $firstname;
    $bellingData['lastname']  = $lastname;
    $bellingData['zip']  = NULL;
    $bellingData['address']  = $address;
    $bellingData['contact']  = $contact;
    $bellingData['center_id']  = NULL;

    $bellingData['date']  = date('m/d/Y');

    $paymentsData['invoice_id'] = $invoice_id;
    $paymentsData['iuid'] = $iuid;
    //$paymentsData['order_id'] = $order->id;
    $paymentsData['payment_type']  = $payment_type;
    $paymentsData['payment_method']  = $paymentMethod;
    $paymentsData['status']  = $status;
    
    $deliveryData['invoice_id'] = $invoice_id;
    $deliveryData['iuid'] = $iuid;
    //$deliveryData['order_id'] = $order->id;
    $deliveryData['delivery_charge']  = $shipping_cost;
    $deliveryData['delivery_name']  = "Collect From Workshop";
    $deliveryData['status']  = 0;
    
    BellingAddress::create($bellingData);
    PaymentMethod::create($paymentsData);
    DeliveryMethod::create($deliveryData);


//=====================================================================

//====================for coupon code===================================


  /*if (isset($_SESSION["couponCodeAmount"])) {
    
    $coupon = $_SESSION["couponCodeAmount"];
    
    $couponCodeAmount = $_SESSION["couponCodeAmount"];

    $grandGrandTotal = $grandGrandTotal - $couponCodeAmount;

  }elseif (isset($_SESSION["couponCodeDisc"])) {
    
    $couponCodeDisc = $_SESSION["couponCodeDisc"];
    $coupon = ($grandGrandTotal * $couponCodeDisc)/100;
    $discountamount = ($grandGrandTotal * $couponCodeDisc)/100;
    $grandGrandTotal = $grandGrandTotal - $discountamount;
  }else{
    $coupon = NULL;
  }*/



    //==========  
    $count = Coupon::where(['active'=>1,'coupon'=>$coupon])->count();
    if ($count > 0 ) {
      $query = Coupon::select('id','discount','amount')->where('active',1)->first();
      $queryResult = $query->toArray();

      $coupon = $queryResult['amount'];
      $grandGrandTotal = $grandGrandTotal - $coupon;

    } else {
      $coupon = NULL;
    }
  //==========

//====================for coupon code===================================

  Invoice::create(['coupon'=>$coupon,'iuid'=>$iuid,'user_id'=>Auth::id(),'method_status'=>1,'date'=>date('m/d/Y'),'monthYear'=>date('m/Y')]);



//===============================================
  
  $name = $firstname." ". $lastname ;
// For Sms============

  //$demandController->SendSmsToAdminByGateway($contact,$iuid,$grandGrandTotal,$name);
  //$demandController->SendSmsToCustomerByGateway($contact,$iuid,$grandGrandTotal);

// For Email===================
  
  //$demandController->SendEmailToAdminByGateway($contact,$email,$iuid,$grandGrandTotal,$name);
  //$demandController->SendEmailToCustomerByGateway($name,$email,$iuid,$grandGrandTotal);

//===============================================



    $returndata = ["Order placed successfully, we will contact within 4 hours, Stay with us..."];
    return response()->json($returndata, 200,[],JSON_PRETTY_PRINT);





  }



}
