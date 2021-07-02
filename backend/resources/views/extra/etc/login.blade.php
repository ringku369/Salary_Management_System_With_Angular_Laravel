  @extends('layouts.extra')

  @section('title')
      {{"E-Warranty Ststem :: Login"}}
  @endsection

  @section('content')


<!-- ================================================================================================================= -->

<div class="login-box">
  <div class="login-logo">
    <!-- <img src="{{ asset( 'storage/app/' . $settings['logo']) }}" alt="Care Nutrition Limited"> -->

@if (@$_SESSION["logo"] )
 
  <img src="{{ asset( 'storage/app/' . $_SESSION['logo']) }}" class="responsive no-repeat" alt="logo" style="width: 230px; height: 35px">
@else
  <img src="{{ asset('resources/assets/dms/dist/img/logo.png') }}" class="responsive no-repeat" alt="logo" style="width: 230px; height: 35px">
@endif

  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>



    <form method="post" action="{{ route('auth.login.store') }}">
        
        @if ($errors->all())
          <div class="alert alert-danger">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if(Session::has('message'))
          <div class="alert alert-info">
            {{Session::get('message')}}
          </div>
        @endif




        <div class="form-group has-feedback {{$errors->has('email') ? 'has-error' : '' }} ">
          <label for="exampleInputEmail1">Email address</label>
          <input class="form-control" name="email" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('email') }}">
          <span class="glyphicon glyphicon-envelope form-control-feedback">{{ $errors->first('email') }}</span>
        </div>
        
        <div class="form-group has-feedback {{$errors->has('password') ? 'has-error' : '' }}">
          <label for="exampleInputPassword1">Password</label>
          <input class="form-control" name="password" id="exampleInputPassword1" type="password" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback">{{ $errors->first('password') }}</span>
        </div>
        
        <input type="hidden" name="_token" value="{{csrf_token()}} ">
        <input type="submit" value="Login" class="btn btn-primary btn-block btn-flat">

      </form>

  </div>
  <!-- /.login-box-body -->
</div>


<!-- ================================================================================================================= -->



  @endsection
