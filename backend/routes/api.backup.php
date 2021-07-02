<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




/*Route::group([
  'middleware' => ['auth:api','RoleAuth:Retailer'],
  //'prefix' => 'auth',
  'namespace' => 'Api'
], function () {

  Route::post('logout',['as'=>'api.logout','uses'=>'ApiAuthController@logout']);
  Route::post('refresh',['as'=>'api.refresh','uses'=>'ApiAuthController@refresh']);
  Route::post('me',['as'=>'api.me','uses'=>'ApiAuthController@me']);
  Route::post('payload',['as'=>'api.payload','uses'=>'ApiAuthController@payload']);

});*/

/*INSERT INTO `users` (`id`, `username`, `name`, `email`, `contact`, `balance`, `email_verified_at`, `password`, `remember_token`, `level`, `role`, `status`, `active`, `_lft`, `_rgt`, `parent_id`, `refer_id`, `position`, `isposition`, `ismatch`, `gencount`, `created_at`, `updated_at`) VALUES
(1, '2022', 'Ringku', 'ringku369@gmail.com', '01712616057', 0, NULL, '$2y$10$vm/Gilvvl5RhENm.azh4AuLbF1kGyoX8nOnxLmbjBBPnzug2/AXXW', '$2y$10$RNXT6oJ74YOnD3u47gQ/jOsZHCO7QXuhd969g1AfP.sYHxfx167HW', 1000, 'Superadmin', 1, 1, 1, 136, NULL, NULL, 0, 'N', 1, 0, '2021-01-20 10:26:06', '2021-01-20 10:33:05')*/

/*sruqnbgxdyxygipu*/





Route::group([
  'middleware' => ['auth:api','RoleAuth:Superadmin','CORS'],
  //'prefix' => 'auth',
  'namespace' => 'Api'
], function () {

  
  Route::get('superadmin/getBalanceForSuperadmin', ['as'=>'api.getBalanceForSuperadmin','uses'=>'ApiSuperAdminController@getBalanceForSuperadmin']);


  Route::get('superadmin/sendMailToUser', ['as'=>'api.sendMailToUser','uses'=>'ApiSuperAdminController@sendMailToUser']);

  
  Route::get('superadmin/getTree', ['as'=>'api.getTree','uses'=>'ApiSuperAdminController@getTree']);

  Route::get('superadmin/getSelfTree', ['as'=>'api.getSelfTree','uses'=>'ApiSuperAdminController@getSelfTree']);
  
  Route::post('superadmin/getTreeByID', ['as'=>'api.getTreeByID','uses'=>'ApiSuperAdminController@getTreeByID']);

  Route::get('superadmin/getDownlinkUser', ['as'=>'api.getDownlinkUser','uses'=>'ApiSuperAdminController@getDownlinkUser']);
  
  Route::get('superadmin/getDownlinkallUser', ['as'=>'api.getDownlinkallUser','uses'=>'ApiSuperAdminController@getDownlinkallUser']);

  Route::get('superadmin/getAllLinkUser', ['as'=>'api.getAllLinkUser','uses'=>'ApiSuperAdminController@getAllLinkUser']);

  Route::get('superadmin/getAdminLinkUser', ['as'=>'api.getAdminLinkUser','uses'=>'ApiSuperAdminController@getAdminLinkUser']);


  Route::get('superadmin/getSelfProfile', ['as'=>'api.getSelfProfile','uses'=>'ApiSuperAdminController@getSelfProfile']);

  Route::post('superadmin/putSelfProfile', ['as'=>'api.putSelfProfile','uses'=>'ApiSuperAdminController@putSelfProfile']);
  
  Route::post('superadmin/putSelfPassword', ['as'=>'api.putSelfPassword','uses'=>'ApiSuperAdminController@putSelfPassword']);
  
  Route::post('superadmin/putSelfPasswordConfirmation', ['as'=>'api.putSelfPasswordConfirmation','uses'=>'ApiSuperAdminController@putSelfPasswordConfirmation']);

  
  Route::get('superadmin/getSingleUser', ['as'=>'api.getSingleUser','uses'=>'ApiSuperAdminController@getSingleUser']);
  
  Route::post('superadmin/createUser', ['as'=>'api.createUser','uses'=>'ApiSuperAdminController@createUser']);


  Route::post('superadmin/postDirectSponsor', ['as'=>'api.postDirectSponsor','uses'=>'ApiSuperAdminController@postDirectSponsor']);

  Route::post('superadmin/postIndirectSponsor', ['as'=>'api.postIndirectSponsor','uses'=>'ApiSuperAdminController@postIndirectSponsor']);

// user to user fund trasfer
  Route::post('superadmin/postFundTrToUser', ['as'=>'api.postFundTrToUser','uses'=>'ApiSuperAdminController@postFundTrToUser']);

  Route::post('superadmin/postFundTrToUserConfirm', ['as'=>'api.postFundTrToUserConfirm','uses'=>'ApiSuperAdminController@postFundTrToUserConfirm']);
// user to user fund trasfer
// 
// user to admin fund trasfer
  Route::post('superadmin/postFundTrToAdmin', ['as'=>'api.postFundTrToAdmin','uses'=>'ApiSuperAdminController@postFundTrToAdmin']);

  Route::post('superadmin/postFundTrToAdminConfirm', ['as'=>'api.postFundTrToAdminConfirm','uses'=>'ApiSuperAdminController@postFundTrToAdminConfirm']);
// user to admin fund trasfer


// report report section
Route::post('superadmin/dateWiseSelfDLUser', ['as'=>'api.dateWiseSelfDLUser','uses'=>'ApiSuperAdminController@dateWiseSelfDLUser']);

Route::post('superadmin/dateWiseSelfProfit', ['as'=>'api.dateWiseSelfProfit','uses'=>'ApiSuperAdminController@dateWiseSelfProfit']);

Route::post('superadmin/dateWiseSelfTransaction', ['as'=>'api.dateWiseSelfTransaction','uses'=>'ApiSuperAdminController@dateWiseSelfTransaction']);
// report report section



});


Route::group([
  'middleware' => ['auth:api','RoleAuth:Admin','CORS'],
  //'prefix' => 'auth',
  'namespace' => 'Api'
], function () {

    Route::get('admin/getBalanceForAdmin', ['as'=>'api.getBalanceForAdmin','uses'=>'ApiAdminController@getBalanceForAdmin']);


  Route::get('admin/sendMailToUser', ['as'=>'api.sendMailToUser','uses'=>'ApiAdminController@sendMailToUser']);

  
  Route::get('admin/getTree', ['as'=>'api.getTree','uses'=>'ApiAdminController@getTree']);

  Route::get('admin/getSelfTree', ['as'=>'api.getSelfTree','uses'=>'ApiAdminController@getSelfTree']);
  
  Route::post('admin/getTreeByID', ['as'=>'api.getTreeByID','uses'=>'ApiAdminController@getTreeByID']);

  Route::get('admin/getDownlinkUser', ['as'=>'api.getDownlinkUser','uses'=>'ApiAdminController@getDownlinkUser']);
  
  Route::get('admin/getDownlinkallUser', ['as'=>'api.getDownlinkallUser','uses'=>'ApiAdminController@getDownlinkallUser']);

  Route::get('admin/getAllLinkUser', ['as'=>'api.getAllLinkUser','uses'=>'ApiAdminController@getAllLinkUser']);

  Route::get('admin/getAdminLinkUser', ['as'=>'api.getAdminLinkUser','uses'=>'ApiAdminController@getAdminLinkUser']);


  Route::get('admin/getSelfProfile', ['as'=>'api.getSelfProfile','uses'=>'ApiAdminController@getSelfProfile']);
  
  Route::post('admin/putSelfProfile', ['as'=>'api.putSelfProfile','uses'=>'ApiAdminController@putSelfProfile']);
  
  Route::post('admin/putSelfPassword', ['as'=>'api.putSelfPassword','uses'=>'ApiAdminController@putSelfPassword']);
  
  Route::post('admin/putSelfPasswordConfirmation', ['as'=>'api.putSelfPasswordConfirmation','uses'=>'ApiAdminController@putSelfPasswordConfirmation']);

  
  Route::get('admin/getSingleUser', ['as'=>'api.getSingleUser','uses'=>'ApiAdminController@getSingleUser']);
  
  Route::post('admin/createUser', ['as'=>'api.createUser','uses'=>'ApiAdminController@createUser']);


  Route::post('admin/postDirectSponsor', ['as'=>'api.postDirectSponsor','uses'=>'ApiAdminController@postDirectSponsor']);

  Route::post('admin/postIndirectSponsor', ['as'=>'api.postIndirectSponsor','uses'=>'ApiAdminController@postIndirectSponsor']);

// user to user fund trasfer
  Route::post('admin/postFundTrToUser', ['as'=>'api.postFundTrToUser','uses'=>'ApiAdminController@postFundTrToUser']);

  Route::post('admin/postFundTrToUserConfirm', ['as'=>'api.postFundTrToUserConfirm','uses'=>'ApiAdminController@postFundTrToUserConfirm']);
// user to user fund trasfer
// 
// user to admin fund trasfer
  Route::post('admin/postFundTrToAdmin', ['as'=>'api.postFundTrToAdmin','uses'=>'ApiAdminController@postFundTrToAdmin']);

  Route::post('admin/postFundTrToAdminConfirm', ['as'=>'api.postFundTrToAdminConfirm','uses'=>'ApiAdminController@postFundTrToAdminConfirm']);
// user to admin fund trasfer


// report report section
Route::post('admin/dateWiseSelfDLUser', ['as'=>'api.dateWiseSelfDLUser','uses'=>'ApiAdminController@dateWiseSelfDLUser']);

Route::post('admin/dateWiseSelfProfit', ['as'=>'api.dateWiseSelfProfit','uses'=>'ApiAdminController@dateWiseSelfProfit']);

Route::post('admin/dateWiseSelfTransaction', ['as'=>'api.dateWiseSelfTransaction','uses'=>'ApiAdminController@dateWiseSelfTransaction']);
// report report section

});

Route::group([
  'middleware' => ['auth:api','RoleAuth:User','CORS'],
  //'prefix' => 'auth',
  'namespace' => 'Api'
], function () {

  Route::get('user/getBalanceForUser', ['as'=>'api.getBalanceForUser','uses'=>'ApiUserController@getBalanceForUser']);


  Route::get('user/sendMailToUser', ['as'=>'api.sendMailToUser','uses'=>'ApiUserController@sendMailToUser']);

  
  Route::get('user/getTree', ['as'=>'api.getTree','uses'=>'ApiUserController@getTree']);

  Route::get('user/getSelfTree', ['as'=>'api.getSelfTree','uses'=>'ApiUserController@getSelfTree']);
  
  Route::post('user/getTreeByID', ['as'=>'api.getTreeByID','uses'=>'ApiUserController@getTreeByID']);

  Route::get('user/getDownlinkUser', ['as'=>'api.getDownlinkUser','uses'=>'ApiUserController@getDownlinkUser']);
  
  Route::get('user/getDownlinkallUser', ['as'=>'api.getDownlinkallUser','uses'=>'ApiUserController@getDownlinkallUser']);

  Route::get('user/getAllLinkUser', ['as'=>'api.getAllLinkUser','uses'=>'ApiUserController@getAllLinkUser']);

  Route::get('user/getAdminLinkUser', ['as'=>'api.getAdminLinkUser','uses'=>'ApiUserController@getAdminLinkUser']);


  Route::get('user/getSelfProfile', ['as'=>'api.getSelfProfile','uses'=>'ApiUserController@getSelfProfile']);
  
  Route::post('user/putSelfProfile', ['as'=>'api.putSelfProfile','uses'=>'ApiUserController@putSelfProfile']);
  
  Route::post('user/putSelfPassword', ['as'=>'api.putSelfPassword','uses'=>'ApiUserController@putSelfPassword']);
  
  Route::post('user/putSelfPasswordConfirmation', ['as'=>'api.putSelfPasswordConfirmation','uses'=>'ApiUserController@putSelfPasswordConfirmation']);

  
  Route::get('user/getSingleUser', ['as'=>'api.getSingleUser','uses'=>'ApiUserController@getSingleUser']);
  
  Route::post('user/createUser', ['as'=>'api.createUser','uses'=>'ApiUserController@createUser']);


  Route::post('user/postDirectSponsor', ['as'=>'api.postDirectSponsor','uses'=>'ApiUserController@postDirectSponsor']);

  Route::post('user/postIndirectSponsor', ['as'=>'api.postIndirectSponsor','uses'=>'ApiUserController@postIndirectSponsor']);

// user to user fund trasfer
  Route::post('user/postFundTrToUser', ['as'=>'api.postFundTrToUser','uses'=>'ApiUserController@postFundTrToUser']);

  Route::post('user/postFundTrToUserConfirm', ['as'=>'api.postFundTrToUserConfirm','uses'=>'ApiUserController@postFundTrToUserConfirm']);
// user to user fund trasfer
// 
// user to admin fund trasfer
  Route::post('user/postFundTrToAdmin', ['as'=>'api.postFundTrToAdmin','uses'=>'ApiUserController@postFundTrToAdmin']);

  Route::post('user/postFundTrToAdminConfirm', ['as'=>'api.postFundTrToAdminConfirm','uses'=>'ApiUserController@postFundTrToAdminConfirm']);
// user to admin fund trasfer


// report report section
Route::post('user/dateWiseSelfDLUser', ['as'=>'api.dateWiseSelfDLUser','uses'=>'ApiUserController@dateWiseSelfDLUser']);

Route::post('user/dateWiseSelfProfit', ['as'=>'api.dateWiseSelfProfit','uses'=>'ApiUserController@dateWiseSelfProfit']);

Route::post('user/dateWiseSelfTransaction', ['as'=>'api.dateWiseSelfTransaction','uses'=>'ApiUserController@dateWiseSelfTransaction']);
// report report section

});




Route::group([
  'middleware' => ['auth:api','CORS'],
  //'prefix' => 'auth',
  'namespace' => 'Api'
], function () {

//common
  Route::post('logout',['as'=>'api.logout','uses'=>'ApiAuthController@logout']);
  Route::post('refresh',['as'=>'api.refresh','uses'=>'ApiAuthController@refresh']);
  Route::post('me',['as'=>'api.me','uses'=>'ApiAuthController@me']);
  Route::post('payload',['as'=>'api.payload','uses'=>'ApiAuthController@payload']);
//common


});




Route::group([
  //'middleware' => 'auth:api',
  'namespace' => 'Api'
], function () {
  Route::get('test',['as'=>'api.test','uses'=>'ApiGuestController@test']);

  Route::post('login',['as'=>'api.login','uses'=>'ApiAuthController@login']);

  /*Route::post('morningtimeschedules',['as'=>'api.morningtimeschedules','uses'=>'ApiGuestController@morningtimeschedules']);

  Route::post('noontimeschedules',['as'=>'api.noontimeschedules','uses'=>'ApiGuestController@noontimeschedules']);

  Route::post('eveningtimeschedules',['as'=>'api.eveningtimeschedules','uses'=>'ApiGuestController@eveningtimeschedules']);

  Route::post('bookedschedules',['as'=>'api.bookedschedules','uses'=>'ApiGuestController@bookedschedules']);

  Route::get('sendmailtesting',['as'=>'api.sendmailtesting','uses'=>'ApiGuestController@sendmailtesting']);*/

  //Route::get('coupon',['as'=>'api.coupon','uses'=>'ApiGuestController@coupon']);
  //
  // Route::get('setting',['as'=>'api.setting','uses'=>'ApiGuestController@setting']);

  // Route::get('categories',['as'=>'api.categories','uses'=>'ApiGuestController@categories']);

  // Route::get('subcategories',['as'=>'api.subcategories','uses'=>'ApiGuestController@subcategories']);

  // Route::get('cats',['as'=>'api.cats','uses'=>'ApiGuestController@cats']);
  // Route::get('subcats/{cid}',['as'=>'api.subcats','uses'=>'ApiGuestController@subcats'])->where(['cid' => '[0-9]+']);
  // Route::get('popularseachcount/{pid}',['as'=>'api.popularseachcount','uses'=>'ApiGuestController@popularseachcount'])->where(['cid' => '[0-9]+']);

  // Route::get('slider',['as'=>'api.slider','uses'=>'ApiGuestController@slider']);

  // Route::get('allproducts',['as'=>'api.allproducts','uses'=>'ApiGuestController@allproducts']);

  // Route::get('productswithlimit/{limit?}/{page?}',['as'=>'api.productswithlimit','uses'=>'ApiGuestController@productswithlimit'])->where(['limit' => '[0-9]+'])->where(['page' => '[0-9]+']);


  // Route::get('catwiseproductswithlimit/{cat_id}/{limit?}/{page?}',['as'=>'api.catwiseproductswithlimit','uses'=>'ApiGuestController@catwiseproductswithlimit'])->where(['limit' => '[0-9]+'])->where(['page' => '[0-9]+'])->where(['cat_id' => '[0-9]+']);


  // Route::get('discountproductswithlimit/{limit?}/{page?}',['as'=>'api.discountproductswithlimit','uses'=>'ApiGuestController@discountproductswithlimit'])->where(['limit' => '[0-9]+'])->where(['page' => '[0-9]+']);


  // Route::get('popularproductswithlimit/{limit?}/{page?}',['as'=>'api.popularproductswithlimit','uses'=>'ApiGuestController@popularproductswithlimit'])->where(['limit' => '[0-9]+'])->where(['page' => '[0-9]+']);

  // Route::get('specialproductswithlimit/{limit?}/{page?}',['as'=>'api.specialproductswithlimit','uses'=>'ApiGuestController@specialproductswithlimit'])->where(['limit' => '[0-9]+'])->where(['page' => '[0-9]+']);

  // Route::get('bestsaleproductswithlimit/{limit?}/{page?}',['as'=>'api.bestsaleproductswithlimit','uses'=>'ApiGuestController@bestsaleproductswithlimit'])->where(['limit' => '[0-9]+'])->where(['page' => '[0-9]+']);

  // Route::post('searchproductswithlimit/{limit?}/{page?}', ['as'=>'api.searchproductswithlimit','uses'=>'ApiGuestController@searchproductswithlimit'])->where(['limit' => '[0-9]+'])->where(['page' => '[0-9]+']);

  // Route::get('productdetails/{pid}',['as'=>'api.productdetails','uses'=>'ApiGuestController@productdetails'])->where(['pid' => '[0-9]+']);

  // Route::post('checkcoupon',['as'=>'api.checkcoupon','uses'=>'ApiGuestController@checkcoupon']);

  // //Route::get('districts',['as'=>'api.districts','uses'=>'ApiGuestController@districts']);

  // Route::post('userregistration',['as'=>'api.userregistration','uses'=>'ApiGuestController@userregistration']);

  // Route::post('userpasswordrecoverymode',['as'=>'api.userpasswordrecoverymode','uses'=>'ApiGuestController@userpasswordrecoverymode']);

});


/* 

//Get Method

  // Image path link in setting api column name imagepath

  New API 

  https://synergyinterface.com/mxnapi/api/cats
  https://synergyinterface.com/mxnapi/api/subcats/cid
  https://synergyinterface.com/mxnapi/api/subcats/1       // example cid = 1

  https://synergyinterface.com/mxnapi/api/popularseachcount/pid
  https://synergyinterface.com/mxnapi/api/popularseachcount/1       // example pid = 1



  https://synergyinterface.com/mxnapi/api/districts
  https://synergyinterface.com/mxnapi/api/settings
  https://synergyinterface.com/mxnapi/api/slider
  https://synergyinterface.com/mxnapi/api/categories
  https://synergyinterface.com/mxnapi/api/subcategories



  https://synergyinterface.com/mxnapi/api/productswithlimit/limit/page          // example limit = *, page no will start from 1 not 0

  https://synergyinterface.com/mxnapi/api/productswithlimit                   // default limit = 10 , page = 1
      
  https://synergyinterface.com/mxnapi/api/catwiseproductswithlimit/cat_id/limit/page
  https://synergyinterface.com/mxnapi/api/catwiseproductswithlimit/2/5/1

  


  https://synergyinterface.com/mxnapi/api/discountproductswithlimit/5/1
  https://synergyinterface.com/mxnapi/api/popularproductswithlimit/5/1
  https://synergyinterface.com/mxnapi/api/specialproductswithlimit/5/1
  https://synergyinterface.com/mxnapi/api/bestsaleproductswithlimit/5/1


  https://synergyinterface.com/mxnapi/api/productdetails/pid              // pid means product id

  https://synergyinterface.com/mxnapi/api/productdetails/10              // if error return 400 status

//Get Method



Note: Token Authentication error status = 401 , Post method error status = 400 , success status = 200

//Post Method without auth

  https://synergyinterface.com/mxnapi/api/login                              // Field Name [username, password] . if error return 401 status

  https://synergyinterface.com/mxnapi/api/searchproductswithlimit/5/1      // Field Name [search] 
  https://synergyinterface.com/mxnapi/api/checkcoupon                     // Field Name [coupon]  . if error return 400 status

  https://synergyinterface.com/mxnapi/api/userpasswordrecoverymode      // Field name [email]

//Post Method without auth



//Post Method with auth With Bearer Token

  https://synergyinterface.com/mxnapi/api/userregistration        // Field name [firstname, lastname, email, password,confirm_password,contact,address,district_id]


  https://synergyinterface.com/mxnapi/api/userpasswordchange   // Field name [password, confirm_password]

  https://synergyinterface.com/mxnapi/api/userdetails    
  https://synergyinterface.com/mxnapi/api/userdetailsupdate  // Field Name [firstname,lastname,contact,address,district_id]

  https://synergyinterface.com/mxnapi/api/wishlist          // Field name [product_id]

  https://synergyinterface.com/mxnapi/api/wishlistdestroy  // Field name [product_id]

  https://synergyinterface.com/mxnapi/api/ordercancel    // Field name [invoice_id]


  https://synergyinterface.com/mxnapi/api/logout    
  https://synergyinterface.com/mxnapi/api/me     


  https://synergyinterface.com/mxnapi/api/checkout    // Field Name [paymentmethod =10,product_id[],quantity[],firstname,lastname,contact,address,district_id] Note: if coupon null then use N/A

  Example :
  =========
  
  "firstname": "Md",
  "lastname": "Sanaullah",
  "email": "ringku369@yahoo.com",
  "address": "Vatapara, Rajshahi",
  "district_id": "5",
  "contact": "01712616057",
  "paymentmethod": "10",
  "product_id": [
      "1",
      "2"
  ],
  "quantity": [
      "2",
      "2"
  ],
  "coupon": "1jq4C2neEx" // if coupon null so coupun value : N/A  // Default value : N/A



//Post Method with auth With Bearer Token



*/