 @php
 $paths = Request::path();
 @endphp
 <div class="page-sidebar custom-scrollbar">
   <div class="sidebar-user text-center">
     <div>
       <img class="img-50 rounded-circle" src="{{asset('assets/images/user/1.jpg')}}" alt="#">
     </div>
     <h6 class="mt-3 f-12">{{Auth::user()->name}}</h6>
   </div>
   <ul class="sidebar-menu">
     <li>
       <a href="{{route('data.index')}}" class="sidebar-header @if($paths=='data'||$paths=='admin') active @endif">
         <i class="icon-book"></i><span>Data Rekon</span>
       </a>
     </li>
     <li>
       <a href="{{route('proses')}}" class="sidebar-header @if($paths=='process-recons'||$paths=='admin') active @endif">
         <i class="icon-settings"></i><span>Proses Rekon</span>
       </a>
     </li>
   </ul>
   {{-- <div class="sidebar-widget text-center">
     <div class="sidebar-widget-top">
       <h6 class="mb-2 fs-14">Need Help</h6>
       <i class="icon-bell"></i>
     </div>
     <div class="sidebar-widget-bottom p-20 m-20">
       <p>+1 234 567 899
         <br>help@pixelstrap.com
         <br><a href="#">Visit FAQ</a>
       </p>
     </div>
   </div> --}}
 </div>