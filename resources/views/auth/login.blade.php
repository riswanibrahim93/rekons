@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<!--login page start-->
<div class="authentication-main">
  <div class="row">
    <div class="col-md-4 p-0">
      <div class="auth-innerleft">
        <div class="text-center">
          <img src="{{asset('assets/images/logo-light.png')}}" class="logo-login" alt="">
          <p class="text-primary">Sistem Rekonsiliasi</p>
          <hr>
          <div class="social-media">
            <ul class="list-inline">
              <li class="list-inline-item"><i class="fa fa-facebook txt-fb" aria-hidden="true"></i></li>
              <li class="list-inline-item"><i class="fa fa-google-plus txt-google-plus" aria-hidden="true"></i></li>
              <li class="list-inline-item"><i class="fa fa-twitter txt-twitter" aria-hidden="true"></i></li>
              <li class="list-inline-item"><i class="fa fa-linkedin txt-linkedin" aria-hidden="true"></i></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8 p-0">
      <div class="auth-innerright">
        <div class="authentication-box">
          <h4>LOGIN</h4>
          @forelse ($errors->all() as $message)
          <p class="text-danger">{{$message}}</p>
          @empty
          <h6>Enter your Email and Password For Login</h6>
          @endforelse
          <div class="card mt-4 p-4 mb-0">
            <form class="theme-form" method="POST" action="{{route('login')}}">
              @csrf
              <div class="form-group">
                <label class="col-form-label pt-0">Email</label>
                <input type="text" class="form-control form-control-lg" required name="email" value="{{old('email')}}">
              </div>
              <div class="form-group">
                <label class="col-form-label">Password</label>
                <input type="password" class="form-control form-control-lg" required name="password">
              </div>
              <div class="checkbox p-0">
                <input id="checkbox1" type="checkbox">
                <label for="checkbox1">Remember me</label>
              </div>
              <div class="form-group form-row mt-3 mb-0">
                <div class="col-md-3">
                  <button type="submit" class="btn btn-primary">LOGIN</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--login page end-->
@endsection
@section('script')

@endsection