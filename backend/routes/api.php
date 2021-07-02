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
//1=FOP,VCIN(From Ipening Amount),2=FRA(From Rank Fund) 



Route::group([
  'middleware' => ['auth:api','RoleAuth:Admin','CORS'],
  //'prefix' => 'auth',
  'namespace' => 'Api'
], function () {

  Route::get('admin/getBalanceForAdmin', ['as'=>'api.getBalanceForAdmin','uses'=>'ApiAdminController@getBalanceForAdmin']);

  Route::get('admin/sendMailToUser', ['as'=>'api.sendMailToUser','uses'=>'ApiAdminController@sendMailToUser']);

 
  Route::get('admin/getUser', ['as'=>'api.getUser','uses'=>'ApiAdminController@getUser']);
  Route::post('admin/createUser', ['as'=>'api.createUser','uses'=>'ApiAdminController@createUser']);
  Route::put('admin/updateUser', ['as'=>'api.updateUser','uses'=>'ApiAdminController@updateUser']);
  Route::delete('admin/deleteUser/{id}', ['as'=>'api.deleteUser','uses'=>'ApiAdminController@deleteUser'])->where(['id' => '[0-9]+']);


  Route::get('admin/getBank', ['as'=>'api.getBank','uses'=>'ApiAdminController@getBank']);
  Route::post('admin/createBank', ['as'=>'api.createBank','uses'=>'ApiAdminController@createBank']);
  Route::put('admin/updateBank', ['as'=>'api.updateBank','uses'=>'ApiAdminController@updateBank']);
  Route::delete('admin/deleteBank/{id}', ['as'=>'api.deleteBank','uses'=>'ApiAdminController@deleteBank'])->where(['id' => '[0-9]+']);


  
  
  Route::get('admin/getRank', ['as'=>'api.getRank','uses'=>'ApiAdminController@getRank']);
  Route::post('admin/createRank', ['as'=>'api.createRank','uses'=>'ApiAdminController@createRank']);
  Route::put('admin/updateRank', ['as'=>'api.updateRank','uses'=>'ApiAdminController@updateRank']);
  //Route::delete('admin/deleteRank/{id}', ['as'=>'api.deleteRank','uses'=>'ApiAdminController@deleteRank'])->where(['id' => '[0-9]+']);


  
  Route::get('admin/getBranch', ['as'=>'api.getBranch','uses'=>'ApiAdminController@getBranch']);
  Route::post('admin/createBranch', ['as'=>'api.createBranch','uses'=>'ApiAdminController@createBranch']);
  Route::put('admin/updateBranch', ['as'=>'api.updateBranch','uses'=>'ApiAdminController@updateBranch']);
  Route::delete('admin/deleteBranch/{id}', ['as'=>'api.deleteBranch','uses'=>'ApiAdminController@deleteBranch'])->where(['id' => '[0-9]+']);

  Route::get('admin/getDeposit', ['as'=>'api.getDeposit','uses'=>'ApiAdminController@getDeposit']);
  Route::post('admin/createDeposit', ['as'=>'api.createDeposit','uses'=>'ApiAdminController@createDeposit']);
  //Route::put('admin/updateDeposit', ['as'=>'api.updateDeposit','uses'=>'ApiAdminController@updateDeposit']);
  //Route::delete('admin/deleteDeposit/{id}', ['as'=>'api.deleteDeposit','uses'=>'ApiAdminController@deleteDeposit'])->where(['id' => '[0-9]+']);



  Route::get('admin/getBranchForDD', ['as'=>'api.getBranchForDD','uses'=>'ApiAdminController@getBranchForDD']);
  Route::get('admin/getBankForDD', ['as'=>'api.getBankForDD','uses'=>'ApiAdminController@getBankForDD']);
  Route::get('admin/getRankForDD', ['as'=>'api.getRankForDD','uses'=>'ApiAdminController@getRankForDD']);
  Route::get('admin/getUserForDD', ['as'=>'api.getRankForDD','uses'=>'ApiAdminController@getUserForDD']);
  
  Route::get('admin/getSelfProfile', ['as'=>'api.getSelfProfile','uses'=>'ApiAdminController@getSelfProfile']);
  Route::put('admin/putSelfProfile', ['as'=>'api.putSelfProfile','uses'=>'ApiAdminController@putSelfProfile']);
  Route::put('admin/putSelfEmail', ['as'=>'api.putSelfEmail','uses'=>'ApiAdminController@putSelfEmail']);
  


  Route::post('admin/getUserProfile', ['as'=>'api.getUserProfile','uses'=>'ApiAdminController@getUserProfile']);
  Route::post('admin/putSelfPassword', ['as'=>'api.putSelfPassword','uses'=>'ApiAdminController@putSelfPassword']);
  Route::post('admin/putSelfPasswordConfirmation', ['as'=>'api.putSelfPasswordConfirmation','uses'=>'ApiAdminController@putSelfPasswordConfirmation']);

  
  Route::post('admin/postFundTrToUser', ['as'=>'api.postFundTrToUser','uses'=>'ApiAdminController@postFundTrToUser']);
  Route::post('admin/postFundTrToUserConfirm', ['as'=>'api.postFundTrToUserConfirm','uses'=>'ApiAdminController@postFundTrToUserConfirm']);
// user to user fund trasfer


  Route::get('admin/getDashboardData', ['as'=>'api.getDashboardData','uses'=>'ApiAdminController@getDashboardData']);

  Route::post('admin/dateWiseEmployeeHistory', ['as'=>'api.dateWiseEmployeeHistory','uses'=>'ApiAdminController@dateWiseEmployeeHistory']);

  Route::post('admin/dateWiseFundTrnHistory', ['as'=>'api.dateWiseFundTrnHistory','uses'=>'ApiAdminController@dateWiseFundTrnHistory']);

  Route::post('admin/dateWiseUserFundTrnHistory', ['as'=>'api.dateWiseUserFundTrnHistory','uses'=>'ApiAdminController@dateWiseUserFundTrnHistory']);


});

Route::group([
  'middleware' => ['auth:api','RoleAuth:User','CORS'],
  //'prefix' => 'auth',
  'namespace' => 'Api'
], function () {

  Route::get('user/getBalanceForUser', ['as'=>'api.getBalanceForUser','uses'=>'ApiUserController@getBalanceForUser']);

  Route::get('user/getSelfProfile', ['as'=>'api.getSelfProfile','uses'=>'ApiUserController@getSelfProfile']);
  
  Route::put('user/putSelfProfile', ['as'=>'api.putSelfProfile','uses'=>'ApiUserController@putSelfProfile']);
  
  Route::post('user/putSelfPassword', ['as'=>'api.putSelfPassword','uses'=>'ApiUserController@putSelfPassword']);
  
  Route::post('user/putSelfPasswordConfirmation', ['as'=>'api.putSelfPasswordConfirmation','uses'=>'ApiUserController@putSelfPasswordConfirmation']);


  Route::post('user/dateWiseUserFundTrnHistory', ['as'=>'api.dateWiseUserFundTrnHistory','uses'=>'ApiUserController@dateWiseUserFundTrnHistory']);

  Route::get('user/getDashboardData', ['as'=>'api.getDashboardData','uses'=>'ApiUserController@getDashboardData']);



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



Route::group([
  'middleware' => ['auth:api','RoleAuth:Superadmin','CORS'],
  //'prefix' => 'auth',
  'namespace' => 'Api'
], function () {

  
  Route::get('superadmin/getBalanceForSuperadmin', ['as'=>'api.getBalanceForSuperadmin','uses'=>'ApiSuperAdminController@getBalanceForSuperadmin']);

  Route::get('superadmin/getSelfProfile', ['as'=>'api.getSelfProfile','uses'=>'ApiSuperAdminController@getSelfProfile']);

  Route::post('superadmin/putSelfProfile', ['as'=>'api.putSelfProfile','uses'=>'ApiSuperAdminController@putSelfProfile']);
  
  Route::post('superadmin/putSelfPassword', ['as'=>'api.putSelfPassword','uses'=>'ApiSuperAdminController@putSelfPassword']);
  
  Route::post('superadmin/putSelfPasswordConfirmation', ['as'=>'api.putSelfPasswordConfirmation','uses'=>'ApiSuperAdminController@putSelfPasswordConfirmation']);

});
