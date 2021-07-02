  @extends('layouts.extra')

  @section('title')
      {{"R&R Property Reservation LLC.| Your Property, Our Priority :: Login"}}
  @endsection

  @section('content')

<style type="text/css">
  .has-error{
    color: red;
  }
</style>

<!-- ================================================================================================================= -->
<!-- box-login -->

            <div class="box-login">
                <form class="form-login"
                    method="post" action="{{ route('auth.login.store') }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}} ">
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


<fieldset>
    <legend>Sign in to your account</legend>
    <p>Please enter your name and password to log in.</p>
    <div class="form-group">
      <span class="input-icon">
        <input type="text" class="form-control {{$errors->has('email') ? 'has-error' : '' }}"
                name="email" id="email" placeholder="Email" value="{{ old('email') }}"> 
                <i class="fa fa-user"></i>
      </span>
      <span class="glyphicon glyphicon-envelope form-control-feedback" style="color:red">{{ $errors->first('email') }}</span>
    </div>


    <div class="form-group form-actions">
      <span class="input-icon">
        <input type="password"
                class="form-control password {{$errors->has('password') ? 'has-error' : '' }}" name="password" placeholder="Password"> 
                <i class="fa fa-lock"></i> 
{{-- <a class="forgot" href="login_forgot.html">I forgot my password</a> --}}
      </span>
      <span class="glyphicon glyphicon-envelope form-control-feedback" style="color:red">{{ $errors->first('password') }}</span>
      </div>
    <div class="form-actions">
        <button type="submit"
        class="btn btn-primary pull-right">Login <i
        class="fa fa-arrow-circle-right"></i>
        </button>
    </div>
</fieldset>
                </form>








              <!-- footer area -->
                <div class="copyright"> <span
                        class="text-bold text-uppercase"></span> <span>All Rights Reserved By R&R Property Reservation LLC.</span>

                      <span>
                       &copy; <span class="current-year"></span> R&R Powered by <a href="https://synergyinterface.com/" target="_blank">Synergy Interface Ltd</a>
                    </span>
                      </div>
              <!-- footer area -->


                    

            </div>

            <!-- box-login -->


<!-- ================================================================================================================= -->



  @endsection
