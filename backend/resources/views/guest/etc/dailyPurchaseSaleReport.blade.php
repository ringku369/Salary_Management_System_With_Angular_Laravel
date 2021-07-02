@extends('layouts.master_admin')

@section('title')
  {{"E-Warranty System :: Daily Stock Report"}}
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
              <h3 class="box-title text-danger">Daily Purchase Or Sales Report</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
  
            <!-- form start -->
             <form class="form-horizontal" method="POST" action="{{ route('admin.dailyPurchaseSaleReport.store') }} " autocomplete="off" enctype="multipart/form-data">

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

                <div class="col-md-8">
                  <label class="control-label" for="distributor">Distributor :</label>
                  <select name="distributor_id" id="distributor" class="form-control select2" required="required">
                    <option value="All">All</option>
                    @foreach($distributors as $key=>$distributor )
                      <option value="{{ $distributor['id'] }}" {{ Session::get('distributor_id') == $distributor['id'] ? ' selected="selected"' : '' }}>{{ $distributor['firstname'] }} - {{ $distributor['officeid'] }}</option>
                    @endforeach
                  </select> 
                  <span class="text-danger">{{ $errors->first('distributor_id') }}</span>
                </div>

                  <div class="col-md-8">
                    <label for="Level" class="control-label">From Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="fdate" placeholder="YYYY-MM-DD" value="{{@$retVal = (Session::get('fdate')) ? $ssdata['fdate'] : ""  }}" type="text" class="form-control pull-right" id="datepicker3" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-8">
                    <label for="Level" class="control-label">To Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="todate" placeholder="YYYY-MM-DD" value="{{@$retVal = (Session::get('todate')) ? $ssdata['todate'] : ""  }}" type="text" class="form-control pull-right" id="datepicker4" autocomplete="off">
                    </div>
                  </div>
                


<div class="col-md-8">
                 
<br>
                 
                  <div class="col-sm-123">
                    <label class="radio-inline">
                      <input type="radio" name="type" value="Purchase" @if (Session::get('type') == "Purchase" ) checked @endif>Purchase
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="type" value="Sale" @if (Session::get('type') == "Sale" ) checked @endif>Sale
                    </label>
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


  <section class="col-lg-12 connectedSortable">
          <!-- Recent Invoice -->
          <div class="box box-warning">
            <div class="box-header">

            </div>
            <!-- /.box-header -->
            <div class="box-body">
@if ($ssdata['count'] == 1)
@if ($ssdata['type'] == "Purchase")
  <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Status</th>
                  <th>Distributor</th>
                   <th>Distributor ID</th>
                  <th>Product Name </th>
                  <th>Product Model </th>
                  <th>Serial No </th>
                  <th>IMEI </th>
                  <!-- <th>Quantity </th> -->
                  <th>Created Date </th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
@foreach ($purchases as $key => $element)
  
  <tr>
    <td>{{$key + 1}} </td>


<td>
  @if ($element->status == true)
       <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'purchaseStatusModal'. $element->id}}">Received</button>
    @else
      <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'purchaseStatusModal'. $element->id}}">Not Received</button>
    @endif
</td>





    <td>{{$element->user['firstname']}} </td>
    <td>{{$element->user['officeid']}} </td>
    <td>{{$element->product['name']}} </td>
    <td>{{$element->product['model']}} </td>
  <td>{{$element->sno}} </td>
    <td> 
      @if ($element->imei == NULL)
        -
      @else
        {{$element->imei}}
      @endif
    </td>
    <!-- <td>{{--$element->quantity--}} </td> -->
    <td>{{date_format(date_create($element->created_at),"d-M-Y")}}</td>
<td>
  
  <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'purchaseUpdateModal'. $element->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

  <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'purchaseDeleteModal'. $element->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

</td>


  </tr>

  <!-- Modal -->
  <div class="modal fade" id="{{'purchaseDeleteModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->product['name']}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<!-- body part -->




  <form action="{{route('admin.purchase.delete',$element->id)}}" method="post">
   <p class="text-info">Do You Want To Delete This Data ?</p>
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

<!--custom delete modal part================================ -->


<!--custom update modal part================================ -->

  <div class="modal fade" id="{{'purchaseUpdateModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->product['name']}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<!-- body part -->

<form action="{{route('admin.purchase.update')}}" method="post">
  <p class="text-info">Do You Want To Update This Data ?</p>
   <br>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input name="_method" type="hidden" value="put">
  <input type="hidden" name="id" value="{{ $element->id }}">


 


  <div class="form-group {{ $errors->has('distributor_id') ? 'has-error' : '' }}">
    <label for="distributor">Distributor:</label>
  
      <select name="distributor_id" id="distributor" class="form-control" required="true">
        <option value="">Select Distributor</option>
        @foreach($distributors as $distributor )
          <option value="{{ $distributor['id'] }}" {{ $element['user']['id'] == $distributor['id'] ? ' selected="selected"' : '' }}>{{ $distributor['firstname'] }} - {{ $distributor['officeid'] }}</option>
        @endforeach
      </select>          
  
    <span class="text-danger">{{ $errors->first('distributor_id') }}</span>
  </div> 



<!-- <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
  <label for="sno">Quantity:</label>
  <input type="text" id="quantity" name="quantity" class="form-control" placeholder="Enter Product Serial Number" value="{{ $element->quantity }}" required="required">
  <span class="text-danger">{{ $errors->first('quantity') }}</span>
</div> -->


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



<!--custom update modal part================================ -->
@endforeach
                </tbody>
               
              </table>
<table>
  
  <tbody>
      <tr>
        <td colspan="6">
          {{ $purchases->links() }}
        </td>
      </tr>
  </tbody>

</table>
@else
  <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Distributor </th>
                  <th>Distributor ID </th>
                  <th>Retailer </th>
                   <th>Retailer ID </th>
                  <th>Product Name </th>
                  <th>Product Model </th>
                  <th>IMEI </th>
                  <th>S.No </th>
                  <th>Created Date </th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
@foreach ($sales as $key => $element)
  
  <tr>
    <td>{{$key + 1}} </td>
    <td>{{$element->user['firstname']}}</td>
    <td>{{$element->user['officeid']}} </td>
    <td>{{$element->retailer['name']}} </td>
    <td>{{$element->retailer['officeid']}} </td>
    <td>{{$element->product['name']}} </td>
    <td>{{$element->product['model']}} </td>
    <td>{{$element->imei}} </td>
    <td>{{$element->sno}} </td>
    <td>{{date_format(date_create($element->created_at),"d-M-Y")}}</td>
<td>
  
  <!-- <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'saleUpdateModal'. $element->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> -->

  <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'saleDeleteModal'. $element->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

</td>


  </tr>

<!-- Modal -->
  <div class="modal fade" id="{{'saleDeleteModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->sno}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<!-- body part -->




  <form action="{{route('admin.sale.delete',$element->id)}}" method="post">
   <p class="text-info">Do You Want To Delete This Data ?</p>
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

<!--custom delete modal part================================ -->


<!--custom update modal part================================ -->

  <div class="modal fade" id="{{'saleUpdateModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->id}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<!-- body part -->

<form action="{{route('admin.sale.update')}}" method="post">
  <p class="text-info">Do You Want To Update This Data ?</p>
   <br>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input name="_method" type="hidden" value="put">
  <input type="hidden" name="id" value="{{ $element->id }}">


  <div class="form-group {{ $errors->has('product_id') ? 'has-error' : '' }}">
    <label for="product">Retailer:</label>

      <select name="purchase_id" id="purchase" class="form-control" required="true">
        <option value="">Select Retailer</option>
        
      </select>          

    <span class="text-danger">{{ $errors->first('purchase_id') }}</span>
  </div>


<!-- <div class="form-group {{ $errors->has('sno') ? 'has-error' : '' }}">
  <label for="sno">Serial No :</label>
  <input type="text" id="sno" name="sno" class="form-control" placeholder="Enter S.No" value="{{ $element->sno }}">
  <span class="text-danger">{{ $errors->first('sno') }}</span>
</div> -->







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



<!--custom update modal part================================ -->

@endforeach
                </tbody>
               
              </table>
<table>
  
  <tbody>
      <tr>
        <td colspan="6">
          {{ $sales->links() }}
        </td>
      </tr>
  </tbody>

</table>
@endif
@endif




<!--custom hospitaldetailStatusModal modal part================================ -->


@forelse ($purchases as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'purchaseStatusModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->user['officeid']}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<!-- body part -->


@if ($element->status == true)
  <form action="{{ route('admin.purchase.inactive') }}" method="post">
   <h3 class="text-info">Do You Want To Not Receive This Product ?</h3>
   <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $element->id }}">
    <!-- <input name="_method" type="hidden" value="delete"> -->
    
    <div class="form-group">
      <button class="form-control btn btn-danger">Not Receive</button>
    </div>

  </form>
@else
   <form action="{{ route('admin.purchase.active') }}" method="post">
   <h3 class="text-info">Do You Want To Receive This Product ?</h3>
   <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $element->id }}">
    <!-- <input name="_method" type="hidden" value="delete"> -->
    
    <div class="form-group">
      <button class="form-control btn btn-primary">Receive</button>
    </div>

  </form>
@endif



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
<!--custom hospitaldetailStatusModal modal part================================ -->











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
  //Session::forget(['type','fdate','todate']);
@endphp
<!-- content part================================ -->
@endsection