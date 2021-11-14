<div class="page-main-header">
  <div class="main-header-left">
    <div class="logo-wrapper">
      <a href="index.html">
        <img src="{{asset('assets/images/logo-light.png')}}" class="image-dark" alt="" />
        <img src="{{asset('assets/images/logo-light-dark-layout.png')}}" class="image-light" alt="" />
      </a>
    </div>
  </div>
  <div class="main-header-right row">
    <div class="mobile-sidebar">
      <div class="media-body text-right switch-sm">
        <label class="switch">
          <input type="checkbox" id="sidebar-toggle" checked>
          <span class="switch-state"></span>
        </label>
      </div>
    </div>
    <div class="nav-right col">
      <ul class="nav-menus">
        <li>
          <form class="form-inline search-form">
            <div class="form-group">
              <label class="sr-only">Email</label>
              <input type="search" class="form-control-plaintext" placeholder="Search..">
              <span class="d-sm-none mobile-search">
              </span>
            </div>
          </form>
        </li>
        <li>
          <a href="#!" onclick="javascript:toggleFullScreen()" class="text-dark">
            <img class="align-self-center pull-right mr-2" src="{{asset('assets/images/dashboard/browser.png')}}" alt="header-browser">
          </a>
        </li>
        <li class="onhover-dropdown">
          <a href="#!" class="txt-dark">
            <img class="align-self-center pull-right mr-2" src="{{asset('assets/images/dashboard/notification.png')}}" alt="header-notification">
            @if (count($notifications)>0)
            <span class="badge badge-pill badge-primary notification">{{count($notifications)}}</span>
            @endif
          </a>
          <ul class="notification-dropdown onhover-show-div">
            <li>Notification <span class="badge badge-pill badge-secondary text-white text-uppercase pull-right">{{count($notifications)}}
                New</span></li>
            @forelse ($notifications as $notification)
            <p style="overflow: hidden; height:0px;width:0px;">{{$notification->filing->ld}}</p>
            <li onclick="copyToClipboard('{{$notification->id}}')">
              <div class="media">
                <i class="align-self-center notification-icon icofont icofont-history bg-primary"></i>
                <div class="media-body">
                  <h6 class="mt-0">Pemberkasan baru!</h6>
                  <p class="mb-0" id="notif{{$notification->id}}">{{$notification->description}}</p>
                  <span><i class=" icofont icofont-clock-time p-r-5"></i>{{\Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</span>
                </div>
              </div>
            </li>
            @empty
            <li class="text-center">You have Check <a href="#">all</a> notification </li>
            @endforelse
          </ul>
        </li>
        <li class="onhover-dropdown">
          <div class="media  align-items-center">
            <img class="align-self-center pull-right mr-2" src="{{asset('assets/images/dashboard/user.png')}}" alt="header-user" />
            <div class="media-body">
              <h6 class="m-0 txt-dark f-16">
                {{Auth::user()->name}}
                <i class="fa fa-angle-down pull-right ml-2"></i>
              </h6>
            </div>
          </div>
          <ul class="profile-dropdown onhover-show-div p-20">
            <!-- <li>
                  <a href="#">
                    <i class="icon-user"></i>
                    Edit Profile
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="icon-email"></i>
                    Inbox
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="icon-check-box"></i>
                    Task
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="icon-comments"></i>
                    Chat
                  </a>
                </li> -->
            <li>
              <a href="#" onclick="$(document).ready(()=>{$('#logoutForm').submit()})">
                <i class="icon-power-off"></i>
                Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <form action="{{route('logout')}}" method="post" class="d-none" id="logoutForm">
        @csrf
      </form>
      <div class="d-lg-none mobile-toggle">
        <i class="icon-more"></i>
      </div>
    </div>
  </div>
</div>