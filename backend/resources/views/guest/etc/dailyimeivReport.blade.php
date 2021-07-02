@extends('layouts.master_admin')

@section('title')
  {{"E-Warranty Ststem :: IMEI Verification Report"}}
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
              <h3 class="box-title text-danger">IMEI Verification Report</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
  
            <!-- form start -->
             <form class="form-horizontal1" method="POST" action="{{ route('admin.dailyimeivReport.store') }} " autocomplete="off" enctype="multipart/form-data">

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
               <br>
                
          <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
            <label for="csv_file" class="col-md-2 control-label">CSV file to import</label>

            <div class="col-md-8">
                <input id="csv_file" type="file" class="form-control" name="csv_file" required>

                @if ($errors->has('csv_file'))
                    <span class="help-block">
                    <strong>{{ $errors->first('csv_file') }}</strong>
                </span>
                @endif
            </div>
          </div>

        <!-- <div class="form-group">
            <div class="col-md-8 col-md-offset-2">
                <div class="form-group1">
                  <label for="type">Select Upload Type :</label>
                  <select name="type" class="form-control" id="type" required="required">
                    <option>Select Type</option>
                    <option value="1">IMEI or SNO</option>
                  </select>
                </div>
            </div>
        </div> -->
<br/>
<br/>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-2">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>



                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <!-- <button type="submit" class="btn btn-success pull-right">Submit</button> -->
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



  <section class="col-lg-12 connectedSortable">
          <!-- Recent Invoice -->
          <div class="box box-warning">
            <div class="box-header">
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
<!-- <p style="text-align: center;font-size: 12px;font-weight: bold;color: black;">
  Replace Daily Report By 
</p> -->

              <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>#</th>
                  <th>SNO </th>
                  <th>Import Data</th>
                  <th>ST1 Data </th>
                  <th>ST1 Distributor ID  </th>
                  <th>ST2 Data </th>
                  <th>ST2 Retailer ID  </th>
                  <th>SO Data </th>
                  <th>SO Retailer ID  </th>
                  <th>Remarks </th>
                </tr>
                </thead>
                <tbody>

@foreach ($preturns as $key => $element)
  <!-- <td>{{--date_format(date_create($element->created_at),"d-M-Y")--}}</td> -->
  <tr>
    <td>{{$key + 1}} </td>

    <td>{{$element['sno']}} </td>
    
    <td>{{$element["importdate"]}}</td>
   
    <td>{{$element["st1date"]}}</td>
    <td>{{$element['st1id']}} </td>
    <td>{{$element["st2date"]}} </td>
    <td>{{$element['st2id']}} </td>
    <td>{{$element["st3date"]}} </td>
    <td>{{$element['st3id']}} </td>
    <td>{{$element['remarks']}} </td>

  </tr>


@endforeach
                </tbody>
               
              </table>
  







            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


<!-- ************************************************* -->



  </section>

<!-- ==============one section area ================= -->








</div>
<!-- /.row (main row) -->



    </section>
    <!-- /.content -->
 
  </div>
<!-- /.content-wrapper -->



@php
  Session::forget(['arr_data']);
@endphp
<!-- content part================================ -->
@endsection