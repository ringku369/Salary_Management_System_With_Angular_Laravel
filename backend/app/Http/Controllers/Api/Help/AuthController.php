<?php



  private function IncCheckStep2($yearMonth){

    $dta[] = 0;

    $query = Generation::select('id','ta')->where('my',$yearMonth)->first();
    $gid = $query->id;
    $ta = $query->ta;


    //step-1
    $query = Userrank::select('id','incentive')->where(['count'=>10])->first();
    $ic = $query->incentive;
    $ica = ($ta*$ic)/100;
    $count = Incentive::select('id','user_id')->whereBetween('bmcount', [10, 49])->count();

    if ($count > 0) {
      $dta[] =+ $ica;
      $amount = $ica/$count;
      $incentives = Incentive::select('id','user_id')->whereBetween('bmcount', [10, 49])->get();
      


      $affected = DB::table('users')->where(['email' => $request->email,'username' => $request->username])->update(
      ['verifycode' => NULL, 'password'=> bcrypt($request['password'])]);

      foreach ($incentives as $user) {

        $incid = $user->id;
        $affected = DB::table('users')->where(['id'=>$incid])->update(['amount' => $amount,'iscount'=>1]);
        $data2['user_id'] = $user->user_id;
        $data2['amount'] = $amount;
        $data2['status'] = 5;
        Profit::create($data2);
      }
      



    }
    //step-1
    //
    //step-2
    $query = Userrank::select('id','incentive')->where(['count'=>50])->first();
    $ic = $query->incentive;
    $ica = ($ta*$ic)/100;
    $count = Incentive::select('id','user_id')->whereBetween('bmcount', [50, 99])->count();

    if ($count > 0) {
      $dta[] =+ $ica;
      $amount = $ica/$count;
      $incentives = Incentive::select('id','user_id')->whereBetween('bmcount', [50, 99])->get();
      
      foreach ($incentives as $user) {
        $incid = $user->id;
        $affected = DB::table('users')->where(['id'=>$incid])->update(['amount' => $amount,'iscount'=>1]);
        $data2['user_id'] = $user->user_id;
        $data2['amount'] = $amount;
        $data2['status'] = 5;
        Profit::create($data2);
      }
      
    }
    //step-2
    //
    //step-3
    $query = Userrank::select('id','incentive')->where(['count'=>100])->first();
    $ic = $query->incentive;
    $ica = ($ta*$ic)/100;
    $count = Incentive::select('id','user_id')->whereBetween('bmcount', [100, 499])->count();

    if ($count > 0) {
      $dta[] =+ $ica;
      $amount = $ica/$count;
      $incentives = Incentive::select('id','user_id')->whereBetween('bmcount', [100, 499])->get();
      
      foreach ($incentives as $user) {
        $incid = $user->id;
        $affected = DB::table('users')->where(['id'=>$incid])->update(['amount' => $amount,'iscount'=>1]);
        $data2['user_id'] = $user->user_id;
        $data2['amount'] = $amount;
        $data2['status'] = 5;
        Profit::create($data2);
      }
      
    }
    //step-3
    //
    //step-4
    $query = Userrank::select('id','incentive')->where(['count'=>500])->first();
    $ic = $query->incentive;
    $ica = ($ta*$ic)/100;
    $count = Incentive::select('id','user_id')->whereBetween('bmcount', [500, 999])->count();

    if ($count > 0) {
      $dta[] =+ $ica;
      $amount = $ica/$count;
      $incentives = Incentive::select('id','user_id')->whereBetween('bmcount', [500, 999])->get();
      
      foreach ($incentives as $user) {
        $incid = $user->id;
        $affected = DB::table('users')->where(['id'=>$incid])->update(['amount' => $amount,'iscount'=>1]);
        $data2['user_id'] = $user->user_id;
        $data2['amount'] = $amount;
        $data2['status'] = 5;
        Profit::create($data2);
      }
      
    }
    //step-4
    //
    //step-5
    $query = Userrank::select('id','incentive')->where(['count'=>1000])->first();
    $ic = $query->incentive;
    $ica = ($ta*$ic)/100;
    $count = Incentive::select('id','user_id')->whereBetween('bmcount', [1000, 1999])->count();

    if ($count > 0) {
      $dta[] =+ $ica;
      $amount = $ica/$count;
      $incentives = Incentive::select('id','user_id')->whereBetween('bmcount', [1000, 1999])->get();
      
      foreach ($incentives as $user) {
        $incid = $user->id;
        $affected = DB::table('users')->where(['id'=>$incid])->update(['amount' => $amount,'iscount'=>1]);
        $data2['user_id'] = $user->user_id;
        $data2['amount'] = $amount;
        $data2['status'] = 5;
        Profit::create($data2);
      }
      
    }
    //step-5
    //
    //step-6
    $query = Userrank::select('id','incentive')->where(['count'=>2000])->first();
    $ic = $query->incentive;
    $ica = ($ta*$ic)/100;
    $count = Incentive::select('id','user_id')->whereBetween('bmcount', [2000, 4999])->count();

    if ($count > 0) {
      $dta[] =+ $ica;
      $amount = $ica/$count;
      $incentives = Incentive::select('id','user_id')->whereBetween('bmcount', [2000, 4999])->get();
      
      foreach ($incentives as $user) {
        $incid = $user->id;
        $affected = DB::table('users')->where(['id'=>$incid])->update(['amount' => $amount,'iscount'=>1]);
        $data2['user_id'] = $user->user_id;
        $data2['amount'] = $amount;
        $data2['status'] = 5;
        Profit::create($data2);
      }
      
    }
    //step-6
    //
    //step-7
    $query = Userrank::select('id','incentive')->where(['count'=>5000])->first();
    $ic = $query->incentive;
    $ica = ($ta*$ic)/100;
    $count = Incentive::select('id','user_id')->whereBetween('bmcount', [5000, 9999])->count();

    if ($count > 0) {
      $dta[] =+ $ica;
      $amount = $ica/$count;
      $incentives = Incentive::select('id','user_id')->whereBetween('bmcount', [5000, 9999])->get();
      
      foreach ($incentives as $user) {
        $incid = $user->id;
        $affected = DB::table('users')->where(['id'=>$incid])->update(['amount' => $amount,'iscount'=>1]);
        $data2['user_id'] = $user->user_id;
        $data2['amount'] = $amount;
        $data2['status'] = 5;
        Profit::create($data2);
      }
      
    }
    //step-7
    //
    //step-8
    $query = Userrank::select('id','incentive')->where(['count'=>10000])->first();
    $ic = $query->incentive;
    $ica = ($ta*$ic)/100;
    $count = Incentive::select('id','user_id')->whereBetween('bmcount', [10000, 100000])->count();

    if ($count > 0) {
      $dta[] =+ $ica;
      $amount = $ica/$count;
      $incentives = Incentive::select('id','user_id')->whereBetween('bmcount', [10000, 100000])->get();
      
      foreach ($incentives as $user) {
        $incid = $user->id;
        $affected = DB::table('users')->where(['id'=>$incid])->update(['amount' => $amount,'iscount'=>1]);
        $data2['user_id'] = $user->user_id;
        $data2['amount'] = $amount;
        $data2['status'] = 5;
        Profit::create($data2);
      }
      
    }
    //step-8


    $generation = Generation::find($gid);
    $generation->ta = $ta;
    $generation->dta = array_sum($dta);
    $generation->status = 1;
    return $generation->save();



  }



  