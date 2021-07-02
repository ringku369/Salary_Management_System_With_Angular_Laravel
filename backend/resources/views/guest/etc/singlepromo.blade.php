@extends('layouts.master_admin')

@section('title')
  {{"E-Warranty Ststem :: Promotion"}}
@endsection


@section('content')

<!-- content part================================ -->

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- bc part================================ -->
      @include('admin.bc.bc')
    <!-- bc part================================ -->

    </section>


  
    <!-- Main content -->
    <section class="content-header">
      <div class="row">
        
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


      </div>



      <div class="row">
            <div class="box box-warning">
            <div class="box-header">
              <h3 class="box-title">Promo List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>#</th>
                  
                  <th>Promo </th>
                  <th>Start Date </th>
                  <th>End Date </th>
                  <th>Created Date </th>
                  <th>Status</th>
                  <th>Details</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
@foreach ($promos as $key=>$element)
     
     
                <tr>

                  <td>{{$key + 1}}</td>




                  <td>{{$element->name}}</td>
                  <td>{{$element->sdate}}</td>
                  <td>{{$element->edate}}</td>
                  <td>{{date_format(date_create($element->created_at),"d-M-Y")}}</td>
                  


<td>
  
  @if ($element->status == true)
     <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'promoStatusModal'. $element->id}}">Active</button>
  @else
    <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'promoStatusModal'. $element->id}}">Inactive</button>
  @endif

</td>

<td>
  <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#{{'promoDetailsModal'. $element->id}}">Show Details</button>
</td>

                  <td>

  <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'promoUpdateModal'. $element->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

  <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'promoDeleteModal'. $element->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                  </td>

                </tr>
@endforeach 
                </tbody>
               
              </table>

<table>
  
  <tbody>
      <tr>
        <td colspan="9">
          {{ $promos->links() }}
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


@forelse ($promos as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'promoUpdateModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->name}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<!-- body part -->

<form action="{{route('admin.promo.update')}}" method="post">
  <p class="text-info">Do You Want To Update This Data ?</p>
   <br>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input name="_method" type="hidden" value="put">
  <input type="hidden" name="id" value="{{ $element->id }}">

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
  <label for="name">Promo:</label>
  <input type="text" id="name" name="name" class="form-control" placeholder="Enter Product Name" value="{{ $element->name }}">
  <span class="text-danger">{{ $errors->first('name') }}</span>
</div>



  <div class="form-group {{ $errors->has('sdate') ? 'has-error' : '' }}">
    <label for="level2">Start Date:</label>
    <div class="input-group date">
      <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </div>
      <input name="sdate" placeholder="YYYY-MM-DD" type="text" class="form-control" id="datepickerfdf{{$element->id}}"  required="required" autocomplete="off" value="{{ $element['sdate1'] }}">
    </div>
    <span class="text-danger">{{ $errors->first('sdate') }}</span>
  </div>

  <div class="form-group {{ $errors->has('edate') ? 'has-error' : '' }}">
    <label for="level2">End Date:</label>
    <div class="input-group date">
      <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </div>
      <input name="edate" placeholder="YYYY-MM-DD" type="text" class="form-control" id="datepickerfde{{$element->id}}"  required="required" autocomplete="off" value="{{ $element['edate1'] }}">
    </div>
    <span class="text-danger">{{ $errors->first('edate') }}</span>
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


<script>
  $(function () {


    $('#datepickerfdf{{$element->id}}').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });
    $('#datepickerfde{{$element->id}}').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });


  
  })
</script>



@empty
  {{'Data not found'}}
@endforelse
<!--custom update modal part================================ -->

<!--custom delete modal part================================ -->


@forelse ($promos as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'promoDeleteModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->name}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<!-- body part -->




  <form action="{{route('admin.promo.delete',$element->id)}}" method="post">
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
@empty
  {{'Data not found'}}
@endforelse
<!--custom delete modal part================================ -->




<!--custom promoStatusModal modal part================================ -->


@forelse ($promos as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'promoStatusModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->name}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<!-- body part -->


@if ($element->status == true)
  <form action="{{ route('admin.promo.changeActiveStatus') }}" method="post">
   <p class="text-info">Do You Want To Inactive This Product ?</p>
   <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $element->id }}">
    <input type="hidden" name="status" value="{{ $element->status }}">
    
    <div class="form-group">
      <button class="form-control btn btn-danger">Inactive</button>
    </div>

  </form>
@else
   <form action="{{ route('admin.promo.changeActiveStatus') }}" method="post">
   <p class="text-info">Do You Want To Active This Product ?</p>
   <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $element->id }}">
    <input type="hidden" name="status" value="{{ $element->status }}">
    <!-- <input name="_method" type="hidden" value="delete"> -->
    
    <div class="form-group">
      <button class="form-control btn btn-primary">Active</button>
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
<!--custom promoStatusModal modal part================================ -->

<!--custom promoDetailsModal modal part================================ -->


@forelse ($promos as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'promoDetailsModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$element->name}}</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>

          <div class="modal-body">
<div class="table-responsive" 
  style="overflow-x: scroll; overflow-y: scroll; height: 200px; white-space:nowrap; width:100%">
<!-- body part -->
<table id="example" class="table">
  <tr>
    <th>Action</th>
    <th>Product</th>
    <th>Amount</th>
    <th>Quantity</th>
    <th>Limit</th>
    <th>Details</th>
    <th>Status</th>
  </tr>
    @foreach ($element->promodetail as $key=>$promodetail)
      <tr>
        

<td>

  <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'promoDetailsUpdateModal'. $promodetail['id']}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

  <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'promoDetailsDeleteModal'. $promodetail['id']}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                  </td>



        <td>{{$promodetail['product']['name']}} - {{$promodetail['product']['model']}}</td>
        <td>{{$promodetail['amount']}}</td>
        <td>{{$promodetail['quantity']}}</td>
        <td>{{$promodetail['limitperday']}}</td>
        <td>{{$promodetail['details']}}</td>
        <td>

  @if ($promodetail['status'] == true)
     <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'promoDetailsStatusModal'. $promodetail['id']}}">Active</button>
  @else
    <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'promoDetailsStatusModal'. $promodetail['id']}}">Inactive</button>
  @endif

        </td>



      </tr>
  
    @endforeach
    
</table>

</div>

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
<!--custom promoDetailsModal modal part================================ -->






@forelse ($promos as $key => $element)

<!--custom promodetails delete modal part================================ -->
    @foreach ($element->promodetail as $key=>$promodetail)
    <!-- Modal -->
    <div class="modal fade" id="{{'promoDetailsDeleteModal'. $promodetail['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{$promodetail['amount']}}</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body">
  <!-- body part -->




    <form action="{{route('admin.promo.promodetails.delete',$promodetail['id'])}}" method="post">
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
  @empty
    {{'Data not found'}}
  @endforelse
<!--custom promodetails delete modal part================================ -->





@endforeach



@forelse ($promos as $key => $element)



<!--custom promodetails update modal part================================ -->
    @foreach ($element->promodetail as $key=>$promodetail)
    <!-- Modal -->
    <div class="modal fade" id="{{'promoDetailsUpdateModal'. $promodetail['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{$promodetail['amount']}}</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body">
  <!-- body part -->
<div class="table-responsive" style="overflow-x: scroll;overflow-y: scroll; height: 300px;white-space:nowrap; width:100%">

<form action="{{route('admin.promo.promodetails.update')}}" method="post">
  <p class="text-info">Do You Want To Update This Data ?</p>
   <br>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input name="_method" type="hidden" value="put">
  <input type="hidden" name="id" value="{{ $promodetail['id'] }}">




  <div class="form-group {{ $errors->has('product_id') ? 'has-error' : '' }}">
    <label for="product">Product:</label>

      <select name="product_id" id="product" class="form-control" required="true">
        <option value="">Select Product</option>
        @foreach($products as $product )
          <option value="{{ $product['id'] }}" {{ $promodetail['product']['id'] == $product['id'] ? ' selected="selected"' : '' }}>{{ $product['name'] }} - {{ $product['model'] }}</option>
        @endforeach
      </select>          

    <span class="text-danger">{{ $errors->first('product_id') }}</span>
  </div>




<div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}">
  <label for="amount">Amount:</label>
  <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount" value="{{ $promodetail['amount'] }}" step="any" required="true">
  <span class="text-danger">{{ $errors->first('amount') }}</span>
</div>


<div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
  <label for="quantity">Quantity:</label>
  <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Enter quantity" value="{{ $promodetail['quantity'] }}" required="true">
  <span class="text-danger">{{ $errors->first('quantity') }}</span>
</div>


<div class="form-group {{ $errors->has('limitperday') ? 'has-error' : '' }}">
  <label for="limitperday">Limit Per Day:</label>
  <input type="number" id="limitperday" name="limitperday" class="form-control" placeholder="Enter limit per day" value="{{ $promodetail['limitperday'] }}" required="true">
  <span class="text-danger">{{ $errors->first('limitperday') }}</span>
</div>

<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
  <label for="details">Details:</label>
  <input type="text" id="details" name="details" class="form-control" placeholder="Details" value="{{ $promodetail['details'] }}" required="true">
  <span class="text-danger">{{ $errors->first('details') }}</span>
</div>

  <div class="form-group">
    <button class="form-control btn btn-success">Update</button>
  </div>
</form>


</div>

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
<!--custom promodetails update modal part================================ -->



@endforeach











@forelse ($promos as $key => $element)

<!--custom promodetails status modal part================================ -->
    @foreach ($element->promodetail as $key=>$promodetail)
    <!-- Modal -->
    <div class="modal fade" id="{{'promoDetailsStatusModal'. $promodetail['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{$promodetail['amount']}}</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body">
  <!-- body part -->




@if ($promodetail['status'] == true)
  <form action="{{ route('admin.promo.changeActiveStatusPromoDetails') }}" method="post">
   <p class="text-info">Do You Want To Inactive This record ?</p>
   <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $promodetail['id'] }}">
    <input type="hidden" name="status" value="{{ $promodetail['status'] }}">
    
    <div class="form-group">
      <button class="form-control btn btn-danger">Inactive</button>
    </div>

  </form>
@else
   <form action="{{ route('admin.promo.changeActiveStatusPromoDetails') }}" method="post">
   <p class="text-info">Do You Want To Active This record ?</p>
   <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $promodetail['id'] }}">
    <input type="hidden" name="status" value="{{ $promodetail['status'] }}">
    <!-- <input name="_method" type="hidden" value="delete"> -->
    
    <div class="form-group">
      <button class="form-control btn btn-primary">Active</button>
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
<!--custom promodetails status modal part================================ -->





@endforeach









@endsection