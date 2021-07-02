@extends('layouts.master_admin')

@section('title')
  {{"E-Warranty Ststem :: Daily Sales Report"}}
@endsection


@section('content')


<!-- content part================================ -->

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- bc part================================ -->
      @include('admin.bc.bc')
    <!-- bc part================================ -->

    <!-- Main content -->
    <section class="content">


<!-- Main row -->
<div class="row">
  <!-- Left col -->
  


<!-- ==============one section area ================= -->


  <section class="col-lg-12 connectedSortable">
          <!-- Recent Invoice -->
          <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title text-danger">Distributor Stock Report</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
  
            <!-- form start -->
             <form class="form-horizontal1" method="POST" action="{{ route('admin.dailyDistStockReportV1.store') }} " autocomplete="off" enctype="multipart/form-data">

    @if(count($errors))
      <div class="alert alert-danger alert-dismissible">
        <strong>Whoops!</strong> There were some problems with your input.
        <br/>
        <ul>
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if(Session::has('success'))
      

      <div class="alert alert-success alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{Session::get('success')}}
      </div>

    @endif

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
{{-- for for displaying success and errror message --}}
                <div class="box-body">
               <br><br>

           

                  <div class="col-md-6 {{ $errors->has('user_id') ? 'has-error' : '' }}">
                    <label for="user" class="control-label">Distributor</label>
                    <select name="user_id" id="user_id" class="form-control select2" style="width: 100%;">
                      <option value="all">All</option>
                      @foreach ($users as $key => $element)
                        <option value="{{$element['id']}}" {{ $element['id'] == @$ssdata['user_id'] ? ' selected="selected"' : '' }}>{{$element['firstname']}} - {{$element['officeid']}}</option>
                      @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('user_id') }}</span>
                  </div>
          


                  <div class="col-md-6">
                    <label for="Level" class="control-label">Till Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="todate" placeholder="YYYY-MM-DD" value="{{@$retVal = ($ssdata['todate']) ? $ssdata['todate'] : ""  }}" type="text" class="form-control pull-right" id="datepicker4"  required="required" autocomplete="off">
                    </div>
                  </div>
                
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right">Submit</button>
              </div>
              <!-- /.box-footer -->
            
            </form>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


  </section>

<!-- ==============one section area ================= -->

<!-- ==============one section area ================= -->

@php
  @$fdate = date_format(date_create($ssdata['fdate']),"Y-m-d");
  @$todate = date_format(date_create($ssdata['todate']),"Y-m-d");
@endphp


  <section class="col-lg-12 connectedSortable">
          <!-- Recent Invoice -->
          <div class="box box-warning">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
<p style="text-align: center;font-size: 12px;font-weight: bold;color: black;">Daily Sales Report From {{@$ssdata['fdate']}} to {{@$ssdata['todate']}}</p>
 <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Distributor </th>
                  <th>Dist Code</th>
                  <th style="color: tomato">Total</th>
            @foreach ($products as $key=>$product)
              <th>{{$product['name']}} - {{$product['model']}}</th>
            @endforeach
              
                </tr>
                </thead>
                <tbody>
@foreach ($dailyDistStockReportV1s as $key1 => $element)
  
  <tr>
    <td>{{$key1 + 1}} </td>
    <td>{{$element['distname']}} </td>
    <td>{{$element['distcode']}} </td>
    
    <td>
      {{$element['total1'] - $element['total2']}} 
    </td>

    @foreach ($element['data1'] as $key => $data1)
      <td>{{$data1 - $element['data2'][$key] }}</td>
    @endforeach
    
    
  </tr>


@endforeach
                </tbody>
               
              </table>
<table>
  

</table>







            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


  </section>
<!-- ==============one section area ================= -->









</div>
<!-- /.row (main row) -->



    </section>
    <!-- /.content -->
 
  </div>
<!-- /.content-wrapper -->


<!-- <script type="text/javascript">
  

$(document).ready(function() {
  
  $('#level').on('change', function(e){
    var level = e.target.value;


    var route = "{{--route('ajax.GetUsersOnLevelChange')--}}/"+level;
    $.get(route, function(data) {
      //console.log(data);
      $('#user_id').empty();
      $('#user_id').append('<option value="">Select User</option>');
      $.each(data, function(index,data){
        $('#user_id').append('<option value="' + data.id + '">' + data.firstname + " "+ data.lastname + " ( " +data.email +" ) " +  '</option>');
      });
    });


  });


});

</script> -->

@php
  Session::forget(['user_id','fdate','todate']);
@endphp
<!-- content part================================ -->
@endsection