@extends('layouts.master_admin')

@section('title')
  {{"E-Warranty Ststem :: Upload File"}}
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
    <section class="content-header">
      <div class="row">
        <div class="">
      
      <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Add Upload</h3>
            </div>
    

    <!-- ================================== form area==================================== -->
{{-- for for displaying success and errror message --}}
  <form class="form-horizontal" method="POST" action="{{ route('admin.upload1.store') }}" autocomplete="on" enctype="multipart/form-data">
<div class="box-body">
    @if(count($errors))
      <div class="alert alert-danger alert-dismissible">
        <strong>Whoops!</strong> There were some problems with your input.
        <br/>
        <ul>
          @foreach($errors->all() as $error)
          <li>{!! $error !!}</li>
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
</div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
{{-- for for displaying success and errror message --}}

      <div class="box-body">
        
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

        <div class="form-group">
            <div class="col-md-8 col-md-offset-2">
                <div class="form-group1">
                  <label for="type">Select Upload Type :</label>
                  <select name="type" class="form-control" id="type" required="required">
                    <option>Select Type</option>
                    <option value="1">Brand - 01</option>
                    <option value="2">Category - 02</option>
                    <option value="3">Product/Model - 03</option>
                    <option value="4">Specification - 04</option>
                    <option value="5">Stock/Product Add - 05</option>
                    <option value="6">Retailer Upload - 06</option>
                    <option value="7">SMS Details - 07</option>
                    <option value="8">Campaign Data - 08</option>
                     <option value="9">Distributor Retail Mapping - 09</option>
                     <option value="10">Distributor Purchase - 10</option>
                     <option value="11">I-Retailer Upload - 11</option>
                     <option value="12">Sales Upload - 12</option>
                     <option value="13">Delete I-retailer Upload - 13</option>
                     <option value="14">Distributor IME Transfer - 14</option>
                     <option value="15">Retailer Promotion - 15</option>
                  </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-2">
                <button type="submit" class="btn btn-primary">
                    Submit CSV
                </button>
            </div>
        </div>



      </div>

      <!-- <div class="box-footer">
        <button type="submit" class="btn btn-success pull-right">Submit</button>
      </div> -->

  </form>

<!-- ================================== form area==================================== -->



          </div>


        </div>
      </div>



<!-- <div class="row">
    <div class="box box-warning">
    <div class="box-header">
      <h3 class="box-title">Brand List</h3>
    </div>
    <div class="box-body">
      <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
          <th>#</th>
          <th>Brand </th>
          <th>Created Date </th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
       
      </table>
    </div>
    <div class="clear"></div>
  </div>
</div> -->




    </section>
    




 
  </div>
<!-- content part================================ -->


@endsection