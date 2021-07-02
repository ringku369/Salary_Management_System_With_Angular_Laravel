@extends('layouts.master_admin')

@section('title')
	{{"R&R Property Reservation LLC.| Your Property, Our Priority :: Dashboard"}}
@endsection


@section('content')

<!-- content part================================ -->
<!-- Main Body -->
<div class="main-content">
<div class="wrap-content container" id="container">
    <section id="page-title" class="padding-top-15 padding-bottom-15">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="mainTitle">Page Content</h1><span class="mainDescription">overview &amp;
                    stats</span>
            </div>
            {{-- <div class="col-sm-5">
                <ul class="mini-stats pull-right">
                    <li>
                        <div class="sparkline-1"><span></span></div>
                        <div class="values"><strong class="text-dark">18304</strong>
                            <p class="text-small no-margin">Sales</p>
                        </div>
                    </li>
                    <li>
                        <div class="sparkline-2"><span></span></div>
                        <div class="values"><strong class="text-dark">&#36;3,833</strong>
                            <p class="text-small no-margin">Earnings</p>
                        </div>
                    </li>
                    <li>
                        <div class="sparkline-3"><span></span></div>
                        <div class="values"><strong class="text-dark">&#36;848</strong>
                            <p class="text-small no-margin">Referrals</p>
                        </div>
                    </li>
                </ul>
            </div> --}}
        </div>
    </section>

<div class="container-fluid container-fullw">
  <div class="row">
      <div class="col-md-12">
          {{-- <h5 class="over-title"><span class="text-bold">Search...</span></h5> --}}
          
          <div class="panel panel-white no-radius">
              <div class="panel-body">
<form class="form-horizontal" method="POST" action="{{ route('admin.contentSearch.store') }} " autocomplete="off" enctype="multipart/form-data">

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
                  <div class="row">
                      
                      <div class="col-md-9">
                          {{-- <p class="text-bold margin-top-0 margin-bottom-0">Date Range</p> --}}
                          <div class="input-group input-daterange datepicker">
                            <input name="fdate" type="text" class="form-control" placeholder="MM/DD/YYYY" required="required">
                              <div class="input-group-prepend"><span
                                      class="input-group-text"><small>to</small></span></div>
                              <input name="todate" type="text" class="form-control" placeholder="MM/DD/YYYY" required="required">
                          </div>
                      </div>

                      <div class="col-md-3">
                        <input type="submit" class="form-control btn btn-primary" value="Search...">
                      </div>
                  </div>

</form>

              </div>
          </div>
      </div>
  </div>




    
    <div class="container-fluid container-fullw bg-white">
        <div class="row">
            

            <div class="col-md-12">
              
<div class="panel panel-white no-radius">
                                    <div class="panel-body">
                                        <div class="partition-light-grey padding-15 text-center margin-bottom-20">
                                            <h4 class="no-margin">Registration List</h4>
                                            {{-- <span class="text-light">based
                                                on the major browsers</span> --}}
                                        </div>
                                        <div id="accordion" class="accordion accordion-white no-margin">
                                            <div class="card no-radius">
                                                <div class="card-header">
@if (@$ssdata['fdate'])
<p class="text-center text-danger margin-bottom-10 margin-top-10">Data From {{@$ssdata['fdate']}} to {{@$ssdata['todate']}}</p>
@endif
                                                </div>
                                                <div class="mainTableArea">

{{-- Table Area --}}

<table class="table" cellspacing="0" width="100%" id="example5">
    <thead>
      <tr>
        <th>#</th>
        <th>Action</th>
        <th>Name</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Company</th>
        
        <th>Address</th>
        <th>Area</th>
        <th>Experience</th>
        <th>Created Date</th>
      </tr>
    </thead>
    <tbody>

@foreach ($results as $key =>$element)

      <tr>

        <td>{{$key + 1}}</td>
<td>

{{-- <span style="cursor: pointer;"
data-toggle="modal" 
data-target="#updateModal">
  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
</span> | --}}

<span style="cursor: pointer;" 
class="text-danger BtnDelete" 
value="{{$element['id']}}"
action="{{route('admin.content.delete',$element['id'])}}" 
method="delete"
token ="{{ csrf_token() }}"
>
  <i class="fa fa-trash-o" aria-hidden="true"></i>
</span>


</td>
        <td>{{$element['name']}}</td>
        <td>
          <a href="mailto:{{$element['email']}}">{{$element['email']}}</a>
        </td>
        <td>{{$element['contact']}}</td>
        <td>{{$element['company']}}</td>
        <td>{{$element['address']}}</td>
        <td>{{$element['area']}}</td>
        <td>{{$element['experience']}}</td>
        <td>{{date_format(date_create($element['created_at']),"d-M-Y")}}</td>
       
      </tr>

@endforeach

    </tbody>
  </table>

{{-- Table Area --}}


                                                </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>





            </div>



        </div>


</div>
</div>

            <!-- Main Body -->




<!-- content part================================ -->

<script type="text/javascript">
// delete code
  $('.BtnDelete').on('click',function(event){
    event.preventDefault();
    let _id = $(this).attr('value');
    let url = $(this).attr('action');
    let method = $(this).attr('method');
    let token = $(this).attr('token');

    let formdata = {
      _token : token,
      _method : method
    }

    Swal.fire({
      title: 'Are you sure want to delete this data?',
      //text: "You won't be able to revert this!",
      icon: 'error',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Delete!'
    }).then((result) => {
      if (result.isConfirmed) {
        DelAjaxCode(url,method,formdata);
      }
    });
    
  });

  function DelAjaxCode(url,method,formdata){
    $.ajax({
      url: url,
      type: method,
      data:formdata,
      success:function(response){
        Swal.fire('Deleted!',response.success[0],'success');
        setInterval(function(){location.reload();}, 1000);
      },
      error: function(xhr,status,error ) {
        Swal.fire('Error!',xhr.responseJSON[0],'error');
      }
    });
  }
// delete code


  </script>

@php
  Session::forget(['user_id','fdate','todate']);
@endphp
@endsection