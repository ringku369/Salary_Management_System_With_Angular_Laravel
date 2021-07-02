<?php  

//================RetailerImeiStockReportView=======================

  public function RetailerImeiStockReportView(){
    if (Auth::user()->level != 500) { return redirect()->route('logout');}
    
    $query = DB::table('sales as t1')
        ->select('t1.sno as sno','t1.imei as imei',
          't2.firstname as retailer','t2.officeid as retofficeid',
          't4.firstname as distributor','t4.officeid as disofficeid',
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
?>