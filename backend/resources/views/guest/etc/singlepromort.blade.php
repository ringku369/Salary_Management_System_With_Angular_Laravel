@extends('layouts.master_admin')

@section('title')
  {{"E-Warranty Ststem :: Retailer Promotion"}}
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
                  <th>Action</th>
                  <th>Retailer </th>

                  <th>Status</th>
                  <th>Details</th>

                  <th>Promo </th>
                  <th>Start Date </th>
                  <th>End Date </th>
                  <th>Created Date </th>
                  
                  
                </tr>
                </thead>
                <tbody>
@foreach ($promorts as $key=>$element)
     
     
                <tr>

                  <td>{{$key + 1}}</td>

<td>

  

  <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'promortUpdateModal'. $element->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

  <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'promortDeleteModal'. $element->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                  </td>





<td>

  @if (count($element->promortretailer) > 0)
    <button class="btn btn-xs btn-info" title="Retailer" data-toggle="modal" data-target="#{{'promortInfoRetailerModal'. $element->id}}"><i style="width: 20px;" class="fa fa-info" aria-hidden="true"></i></button>
  @else
    <button class="btn btn-xs btn-warning" title="Retailer" data-toggle="modal" data-target="#{{'promortAddRetailerModal'. $element->id}}"><i style="width: 20px;" class="fa fa-plus" aria-hidden="true"></i></button>
  @endif

</td>


<td>
  
  @if ($element->status == true)
     <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'promortStatusModal'. $element->id}}">Active</button>
  @else
    <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'promortStatusModal'. $element->id}}">Inactive</button>
  @endif

</td>

<td>
  <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#{{'promortDetailsModal'. $element->id}}">Show Details</button>
</td>


                  <td>{{$element->name}}</td>
                  <td>{{$element->sdate}}</td>
                  <td>{{$element->edate}}</td>
                  <td>{{date_format(date_create($element->created_at),"d-M-Y")}}</td>
                  






                  

                </tr>
@endforeach 
                </tbody>
               
              </table>

<table>
  
  <tbody>
      <tr>
        <td colspan="9">
          {{ $promorts->links() }}
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


@forelse ($promorts as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'promortUpdateModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<form action="{{route('admin.promort.update')}}" method="post">
  <p class="text-info">Do You Want To Update This Data ?</p>
   <br>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input name="_method" type="hidden" value="put">
  <input type="hidden" name="id" value="{{ $element->id }}">

<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
  <label for="name">Promo:</label>
  <input type="text" id="name" name="name" class="form-control" placeholder="Enter Retailer Name" value="{{ $element->name }}">
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


@forelse ($promorts as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'promortDeleteModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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




  <form action="{{route('admin.promort.delete',$element->id)}}" method="post">
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




<!--custom promortStatusModal modal part================================ -->


@forelse ($promorts as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'promortStatusModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  <form action="{{ route('admin.promort.changeActiveStatus') }}" method="post">
   <p class="text-info">Do You Want To Inactive This Retailer ?</p>
   <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $element->id }}">
    <input type="hidden" name="status" value="{{ $element->status }}">
    
    <div class="form-group">
      <button class="form-control btn btn-danger">Inactive</button>
    </div>

  </form>
@else
   <form action="{{ route('admin.promort.changeActiveStatus') }}" method="post">
   <p class="text-info">Do You Want To Active This Retailer ?</p>
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
<!--custom promortStatusModal modal part================================ -->

<!--custom promortDetailsModal modal part================================ -->


@forelse ($promorts as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'promortDetailsModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<div class="pull-right"> 
  <button style="padding: 1px 50px" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#{{'promortDetailsAddModal'}}"> Add ...</button>
  <br><br>
</div>
<table id="example" class="table">
  <tr>
    <th>Action</th>
    <th>Quantity</th>
    <th>Limit</th>
    <th>Details</th>
    <th>Status</th>
  </tr>
    @foreach ($element->promortdetail as $key=>$promortdetail)
      <tr>
        

<td>

  <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'promortDetailsUpdateModal'. $promortdetail['id']}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

  <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'promortDetailsDeleteModal'. $promortdetail['id']}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                  </td>


        
        <td>{{$promortdetail['quantity']}}</td>
        <td>{{$promortdetail['limitperday']}}</td>
        <td>{{$promortdetail['details']}}</td>
        <td>

  @if ($promortdetail['status'] == true)
     <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'promortDetailsStatusModal'. $promortdetail['id']}}">Active</button>
  @else
    <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'promortDetailsStatusModal'. $promortdetail['id']}}">Inactive</button>
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
<!--custom promortDetailsModal modal part================================ -->


<!--custom promortDetailsAddModal modal part================================ -->

@forelse ($promorts as $key => $element)


    <!-- Modal -->
    <div class="modal fade" id="{{'promortDetailsAddModal'}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> Add Promo Details</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body">
  <!-- body part -->
<div class="table-responsive" style="overflow-x: scroll;overflow-y: scroll; height: 300px;white-space:nowrap; width:100%">

<form action="{{route('admin.promort.promortdetails.add')}}" method="post">
  

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <!-- <input name="_method" type="hidden" value="put"> -->
  <input type="hidden" name="promort_id" value="{{ $element->id}} ">


<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
  <label for="details">Details:</label>
  <input type="text" id="details" name="details" class="form-control" placeholder="Details" value="" required="true">
  <span class="text-danger">{{ $errors->first('details') }}</span>
</div>


<div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
  <label for="quantity">Quantity:</label>
  <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Enter quantity" value="" required="true">
  <span class="text-danger">{{ $errors->first('quantity') }}</span>
</div>


<div class="form-group {{ $errors->has('limitperday') ? 'has-error' : '' }}">
  <label for="limitperday">Limit Per Day:</label>
  <input type="number" id="limitperday" name="limitperday" class="form-control" placeholder="Enter limit per day" value="" required="true">
  <span class="text-danger">{{ $errors->first('limitperday') }}</span>
</div>



  <div class="form-group">
    <button class="form-control btn btn-success"> Add ...</button>
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


<!--custom promortDetailsAddModal modal part================================ -->









<!--custom promortdetails update modal part================================ -->

@forelse ($promorts as $key => $element)

<!--custom promortdetails delete modal part================================ -->
    @foreach ($element->promortdetail as $key=>$promortdetail)
    <!-- Modal -->
    <div class="modal fade" id="{{'promortDetailsDeleteModal'. $promortdetail['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{$promortdetail['details']}}</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body">
  <!-- body part -->




    <form action="{{route('admin.promort.promortdetails.delete',$promortdetail['id'])}}" method="post">
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
<!--custom promortdetails delete modal part================================ -->

@endforeach



@forelse ($promorts as $key => $element)



<!--custom promortdetails update modal part================================ -->
    @foreach ($element->promortdetail as $key=>$promortdetail)
    <!-- Modal -->
    <div class="modal fade" id="{{'promortDetailsUpdateModal'. $promortdetail['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{$promortdetail['details']}}</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body">
  <!-- body part -->
<div class="table-responsive" style="overflow-x: scroll;overflow-y: scroll; height: 300px;white-space:nowrap; width:100%">

<form action="{{route('admin.promort.promortdetails.update')}}" method="post">
  <p class="text-info">Do You Want To Update This Data ?</p>
   <br>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input name="_method" type="hidden" value="put">
  <input type="hidden" name="id" value="{{ $promortdetail['id'] }}">



<div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
  <label for="quantity">Quantity:</label>
  <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Enter quantity" value="{{ $promortdetail['quantity'] }}" required="true">
  <span class="text-danger">{{ $errors->first('quantity') }}</span>
</div>


<div class="form-group {{ $errors->has('limitperday') ? 'has-error' : '' }}">
  <label for="limitperday">Limit Per Day:</label>
  <input type="number" id="limitperday" name="limitperday" class="form-control" placeholder="Enter limit per day" value="{{ $promortdetail['limitperday'] }}" required="true">
  <span class="text-danger">{{ $errors->first('limitperday') }}</span>
</div>

<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
  <label for="details">Details:</label>
  <input type="text" id="details" name="details" class="form-control" placeholder="Details" value="{{ $promortdetail['details'] }}" required="true">
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
<!--custom promortdetails update modal part================================ -->



@endforeach











@forelse ($promorts as $key => $element)

<!--custom promortdetails status modal part================================ -->
    @foreach ($element->promortdetail as $key=>$promortdetail)
    <!-- Modal -->
    <div class="modal fade" id="{{'promortDetailsStatusModal'. $promortdetail['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{$promortdetail['details']}}</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body">
  <!-- body part -->




@if ($promortdetail['status'] == true)
  <form action="{{ route('admin.promort.changeActiveStatusPromortDetails') }}" method="post">
   <p class="text-info">Do You Want To Inactive This record ?</p>
   <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $promortdetail['id'] }}">
    <input type="hidden" name="status" value="{{ $promortdetail['status'] }}">
    
    <div class="form-group">
      <button class="form-control btn btn-danger">Inactive</button>
    </div>

  </form>
@else
   <form action="{{ route('admin.promort.changeActiveStatusPromortDetails') }}" method="post">
   <p class="text-info">Do You Want To Active This record ?</p>
   <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $promortdetail['id'] }}">
    <input type="hidden" name="status" value="{{ $promortdetail['status'] }}">
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
<!--custom promortdetails status modal part================================ -->

@endforeach









<!--custom promortInfoRetailerModal modal part================================ -->


@forelse ($promorts as $key => $element)
  <!-- Modal -->
  <div class="modal fade" id="{{'promortInfoRetailerModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<div class="pull-right"> 
  <button style="padding: 1px 50px" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#{{'promortAddRetailerModal'. $element->id}}"> Add ...</button>


  <br><br>
</div>
<table id="example" class="table">
  <tr>
    <th>#</th>
    <th>Action</th>
    <th>Name</th>
    <th>Office Id</th>
  </tr>
    @foreach ($element->promortretailer as $key=>$promortretailer)
      <tr>
        
        <td> {{$key + 1}} </td>

<td>

  <!-- <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#{{'promortRetailerUpdateModal'. $promortretailer['id']}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> -->

  <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{'promortRetailerDeleteModal'. $promortretailer['id']}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                  </td>


        
        <td>{{$promortretailer->user['firstname']}}</td>
        <td>{{$promortretailer->user['officeid']}}</td>
      



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
<!--custom promortInfoRetailerModal modal part================================ -->



<!--custom promortAddRetailerModal modal part================================ -->

@forelse ($promorts as $key => $element)


    <!-- Modal -->
    <div class="modal fade" id="{{'promortAddRetailerModal'. $element->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> Add Retailer</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body">
  <!-- body part -->
<div class="table-responsive" style="overflow-x: scroll;overflow-y: scroll; height: 200px;white-space:nowrap; width:100%">

<form action="{{route('admin.promort.add.retailer')}}" method="post">
  

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <!-- <input name="_method" type="hidden" value="put"> -->
  <input type="hidden" name="promort_id" value="{{ $element->id}} ">

    
    <div  class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
      <label for="user" class="control-label">Retailer</label>
      <div class="">
        <select name="users[]" id="user_id" class="form-control select2" multiple="multiple" style="width: 100%;">
          
          @foreach ($users as $key => $element)
            <option value="{{$element['id']}}">{{$element['officeid']}} - {{$element['firstname']}}</option>
          @endforeach
        </select>
        <span class="text-danger">{{ $errors->first('user_id') }}</span>
      </div>
    </div>



  <div class="form-group">
    <button class="form-control btn btn-success"> Add ...</button>
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


<!--custom promortAddRetailerModal modal part================================ -->


<!--custom promortAddRetailerModal modal part================================ -->




<!--custom promortRetailerDeleteModal update modal part================================ -->

@forelse ($promorts as $key => $element)

<!--custom promortdetails delete modal part================================ -->
    @foreach ($element->promortretailer as $key=>$promortretailer)
    <!-- Modal -->
    <div class="modal fade" id="{{'promortRetailerDeleteModal'. $promortretailer['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{$promortretailer['details']}}</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div class="modal-body">
  <!-- body part -->




    <form action="{{route('admin.promort.promortretailer.delete',$promortretailer['id'])}}" method="post">
     <p class="text-info">Do You Want To Delete This Data ?</p>
     <br>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input name="_method" type="hidden" value="delete">
      <input name="promort_id" type="hidden" value="{{$element->id}}">
      
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
<!--custom promortdetails delete modal part================================ -->

@endforeach



<!--custom promortRetailerDeleteModal modal part================================ -->






@endsection