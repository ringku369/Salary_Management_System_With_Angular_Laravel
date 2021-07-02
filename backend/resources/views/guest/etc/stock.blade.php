@extends('layouts.master_admin')

@section('title')
  {{"E-Warranty Ststem :: Stock"}}
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
              <h3 class="box-title">Product Add</h3>
            </div>
    

    <!-- ================================== form area==================================== -->
{{-- for for displaying success and errror message --}}
  <form class="form-horizontal" method="POST" action="{{ route('admin.stock.store') }}" autocomplete="off" enctype="multipart/form-data">
<div class="box-body">
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
</div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
{{-- for for displaying success and errror message --}}

      <div class="box-body">
        
        
                
          <div class="form-group {{ $errors->has('product_id') ? 'has-error' : '' }}">
      
              <label class="col-sm-2 control-label">Product :</label>
<div class="col-sm-5">
              <select name="product_id" id="product" class="form-control select2" required="required">
                <option value="">Select Product</option>
                @foreach($products as $key=>$product )
                  <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                @endforeach
              </select>          

            <span class="text-danger">{{ $errors->first('product_id') }}</span>
</div>
               
        </div>


        <!-- <div class="col-md-12">
          <div class="form-group {{ $errors->has('imei') ? 'has-error' : '' }}">
            <label for="imei">IMEI:</label>
            <input type="text" id="imei" name="imei" class="form-control" placeholder="Enter IMEI No" value="{{ old('imei') }}">
            <span class="text-danger">{{ $errors->first('imei') }}</span>
          </div>
        </div>
        
        
        <div class="col-md-12">
          <div class="form-group {{ $errors->has('sno') ? 'has-error' : '' }}">
            <label for="sno">Serial No:</label>
            <input type="text" id="sno" name="sno" class="form-control" placeholder="Enter Serial No No" value="{{ old('sno') }}">
            <span class="text-danger">{{ $errors->first('sno') }}</span>
          </div>
        </div>
        
        <div class="col-md-12">
          <div class="form-group {{ $errors->has('wperiod') ? 'has-error' : '' }}">
            <label for="wperiod">Warranty Period:</label>
            <input type="number" id="wperiod" name="wperiod" class="form-control" placeholder="Warranty Period" value="{{ old('wperiod') }}">
            <span class="text-danger">{{ $errors->first('wperiod') }}</span>
          </div>
        </div> -->



        <div class="form-group">
          <div class="container1">
            
            <label class="col-sm-2 control-label">Product Details</label>

            <div class="col-sm-10">
              <button  class="add_form_field btn btn-warning btn-md" style="width:49%">Add Field</button><br><br>
            </div>

          </div>
        </div>



<!-- ************************************************* -->
<script>
$(document).ready(function() {

    var max_fields      = 20;
    var wrapper         = $(".container1"); 
    var add_button      = $(".add_form_field"); 
    
    var total = 0;

    var x = 1; 
    $(add_button).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
            x++; 
            $(wrapper).append('<div class="row "style="padding:0px 30px 8px 212px">'+
              '<div class="col-xs-4">'+
               '<input type="text" name="imeis[]" id="imei'+ x +'" class="form-control" style="" required placeholder="IMEI" min="0">'+
              '</div>'+
              '<div class="col-xs-3">'+
               '<input type="text" name="snos[]" id="sno'+ x +'" class="form-control" style="" required placeholder="Serial No" min="0">'+
              '</div>'+
              '<div class="col-xs-3">'+
                '<input type="number" name="wperiods[]" id="wperiod'+ x +'" class="form-control" style="" required  placeholder="Warranty Period" step=any min="0">'+
              '</div>'+
                '<button id="delete'+ x +'"  class="delete btn btn-danger btn-round col-sm-2">Delete Field &nbsp;<span style="font-size:16px; font-weight:bold;"> - </span></button>'+
            '</div>');

        }
      else{
        alert('You Reached the limits')
      }

//========================================


});


//=========================================================
    $(wrapper).on("click",".delete", function(e){ 
       e.preventDefault(); $(this).parent('div').remove(); x--;
    });

//=========================================================







});




</script>




<!-- ************************************************* -->






      </div>




      <div class="box-footer">
        <button type="submit" class="btn btn-success pull-right">Submit</button>
      </div>

  </form>

<!-- ================================== form area==================================== -->



          </div>


        </div>
      </div>



      <div class="row">
            <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title">Stock List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>#</th>
                  <th> Product </th>
                  <th> Model </th>
                  <th> Brand </th>
                  <th> IMEI </th>
                  <th> S-No </th>
                  <th> W-Period </th>
                  <th> Created Date </th>
                  <th> Action </th>
                </tr>
                </thead>
                <tbody>
@foreach ($stocks as $key=>$element)
     
     
                <tr>
                  
                  <td>{{$key + 1}}</td>
                  <td>{{$element->product['name']}}</td>
                  <td>{{$element->product['model']}}</td>
                  <td>{{$element->brand['name']}}</td>
                  <td>{{$element->imei}}</td>
                  <td>{{$element->sno}}</td>
                  <td>{{$element->wperiod}}</td>
                  <td>{{date_format(date_create($element->created_at),"d-M-Y")}}</td>
                  
                  <td>

  <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'stockUpdateModal'. $element->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

  <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'stockDeleteModal'. $element->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                  </td>

                </tr>
@endforeach 
                </tbody>
               
              </table>


<table>
  
  <tbody>
      <tr>
        <td colspan="8">
          {{ $stocks->links() }}
        </td>
      </tr>
  </tbody>

</table>


            </div>
            <div class="clear"></div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </section>
    




 
  </div>
<!-- content part================================ -->


<!--custom update modal part================================ -->


@forelse ($stocks as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'stockUpdateModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->imei}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<!-- body part -->

<form action="{{route('admin.stock.update')}}" method="post">
  <h3 class="text-info">Do You Want To Update This Data ?</h3>
   <br>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input name="_method" type="hidden" value="put">
  <input type="hidden" name="id" value="{{ $element->id }}">


  <div class="form-group {{ $errors->has('product_id') ? 'has-error' : '' }}">
    <label for="product">Product:</label>

      <select name="product_id" id="product" class="form-control">
        <option value="">Select Product</option>
        @foreach($products as $product )
          <option value="{{ $product['id'] }}" {{ $element['product_id'] == $product['id'] ? ' selected="selected"' : '' }}>{{ $product['name'] }}</option>
        @endforeach
      </select>          

    <span class="text-danger">{{ $errors->first('product_id') }}</span>
  </div>


<div class="form-group {{ $errors->has('imei') ? 'has-error' : '' }}">
  <label for="imei">IMEI:</label>
  <input type="text" id="imei" name="imei" class="form-control" placeholder="Enter Product Name" value="{{ $element->imei }}">
  <span class="text-danger">{{ $errors->first('imei') }}</span>
</div>


<div class="form-group {{ $errors->has('sno') ? 'has-error' : '' }}">
  <label for="sno">Serial No:</label>
  <input type="text" id="sno" name="sno" class="form-control" placeholder="Enter Serial No No" value="{{ $element->sno }}">
  <span class="text-danger">{{ $errors->first('sno') }}</span>
</div>



<div class="form-group {{ $errors->has('wperiod') ? 'has-error' : '' }}">
  <label for="wperiod">Warranty Period:</label>
  <input type="number" id="wperiod" name="wperiod" class="form-control" placeholder="Warranty Period" value="{{ $element->wperiod }}">
  <span class="text-danger">{{ $errors->first('wperiod') }}</span>
</div>

  <div class="form-group">
    <button class="form-control btn btn-success">Update</button>
  </div>
</form>

<!-- body part -->
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
@empty
  {{'Data not found'}}
@endforelse
<!--custom update modal part================================ -->

<!--custom delete modal part================================ -->


@forelse ($stocks as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'stockDeleteModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->imei}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<!-- body part -->




  <form action="{{route('admin.stock.delete',$element->id)}}" method="post">
   <h3 class="text-info">Do You Want To Delete This Data ?</h3>
   <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input name="_method" type="hidden" value="delete">
    
    <div class="form-group">
      <button class="form-control btn btn-danger">Delete</button>
    </div>

  </form>

<!-- body part -->
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
@empty
  {{'Data not found'}}
@endforelse
<!--custom delete modal part================================ -->




@endsection




