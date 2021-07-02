<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*INSERT INTO `users` (`id`, `username`, `name`, `email`, `contact`, `balance`, `email_verified_at`, `password`, `remember_token`, `level`, `role`, `status`, `active`, `_lft`, `_rgt`, `parent_id`, `refer_id`, `position`, `isposition`, `ismatch`, `gencount`, `created_at`, `updated_at`) VALUES
(1, '1000', 'Vizz BD', 'ringku369@gmail.com', '01712616057', 20020.5, NULL, '$2y$10$vm/Gilvvl5RhENm.azh4AuLbF1kGyoX8nOnxLmbjBBPnzug2/AXXW', '$2y$10$RNXT6oJ74YOnD3u47gQ/jOsZHCO7QXuhd969g1AfP.sYHxfx167HW', 1000, 'Superadmin', 1, 1, 1, 136, NULL, NULL, 0, 'N', 1, 0, '2021-02-21 10:26:06', '2021-02-21 10:33:05');

INSERT INTO `profits` (`id`, `user_id`, `ds_id`, `ids_id`, `child_id`, `mt_id`, `to_id`, `amount`, `status`, `iscount`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 1, NULL, NULL, 0.5, 1, 1, '2021-02-21 08:50:03', '2021-02-21 08:50:03'),
(2, 1, NULL, NULL, 1, NULL, 1, 20020, 6, 1, '2021-02-21 04:57:47', '2021-02-21 04:57:47');

INSERT INTO `vcfunds` (`id`, `user_id`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2021-02-21 08:50:03', '2021-02-21 08:50:03'),
(2, 1, 1, 2, '2021-02-21 08:50:03', '2021-02-21 08:50:03');*/




#userfunds
// 1=FCA(From Create Acc), 2=FFT(From Fund Transfer)

#profits
//1=OB(Opening Balance),2=DS(Direct Sponsor),3=IDS(Indirect Sponsor),4=MT(Binary Matching),
//5=GEN(Renak Income),6=FFT(From Fund Transfer), 7 = VCIN (VixxClub Incentive)

#vcfunds
//1=FOP(From Ipening Amount),2=FRA(From Rank Fund) 



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



  Route::post('superadmin/binaryMatchingReport', ['as'=>'api.binaryMatchingReport','uses'=>'ApiSuperAdminController@binaryMatchingReport']);


  Route::post('superadmin/dateWiseUserBlnUpdate', ['as'=>'api.dateWiseUserBlnUpdate','uses'=>'ApiSuperAdminController@dateWiseUserBlnUpdate']);

  Route::post('superadmin/monthWiseGenerationUpdate', ['as'=>'api.monthWiseGenerationUpdate','uses'=>'ApiSuperAdminController@monthWiseGenerationUpdate']);




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

Route::post('admin/binaryMatchingReport', ['as'=>'api.binaryMatchingReport','uses'=>'ApiAdminController@binaryMatchingReport']);

Route::post('admin/dateWiseUserBlnUpdate', ['as'=>'api.dateWiseUserBlnUpdate','uses'=>'ApiAdminController@dateWiseUserBlnUpdate']);

Route::post('admin/monthWiseGenerationUpdate', ['as'=>'api.monthWiseGenerationUpdate','uses'=>'ApiAdminController@monthWiseGenerationUpdate']);


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

  //Route::get('user/getAllLinkUser', ['as'=>'api.getAllLinkUser','uses'=>'ApiUserController@getAllLinkUser']);

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

Route::post('user/binaryMatchingReport', ['as'=>'api.binaryMatchingReport','uses'=>'ApiUserController@binaryMatchingReport']);

// report report section

});


// Auth Route

Route::group([
  'middleware' => ['auth:api','CORS'],
  'namespace' => 'Api'
], function () {

//common
  Route::get('getRank', ['as'=>'api.getRank','uses'=>'ApiAuthController@getRank']);
  Route::post('logout',['as'=>'api.logout','uses'=>'ApiAuthController@logout']);
  //Route::post('refresh',['as'=>'api.refresh','uses'=>'ApiAuthController@refresh']);
  //Route::post('me',['as'=>'api.me','uses'=>'ApiAuthController@me']);
  //Route::post('payload',['as'=>'api.payload','uses'=>'ApiAuthController@payload']);
//common


});


Route::group([
  'middleware' => ['CORS'],
  'namespace' => 'Api'
], function () {
  Route::get('test1',['as'=>'api.test1','uses'=>'ApiGuestController@test1']);
  Route::get('test',['as'=>'api.test','uses'=>'ApiAuthController@test']);
  Route::post('login',['as'=>'api.login','uses'=>'ApiAuthController@login']);
  Route::post('postResetInfo',['as'=>'api.postResetInfo','uses'=>'ApiAuthController@postResetInfo']);
  Route::post('verifycodeCheck',['as'=>'api.verifycodeCheck','uses'=>'ApiAuthController@verifycodeCheck']);
  Route::post('putResetPasswordConfirmation',['as'=>'api.putResetPasswordConfirmation','uses'=>'ApiAuthController@putResetPasswordConfirmation']);


});
