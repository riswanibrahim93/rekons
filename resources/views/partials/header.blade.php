   <div class="container-fluid">
     @php
     $paths = explode('/', Request::path());
     $len = count($paths)-1;
     if (Request::path() != '/') {
     $path = ucfirst($paths[$len]);
     }else {
     $path = 'Dashboard';
     }
     @endphp
     <div class="page-header">
       <div class="row">
         <div class="col-lg-6">
           <h3>Sistem
             <small>Rekonsiliasi</small>
           </h3>
         </div>
         <div class="col-lg-6">
           <ol class="breadcrumb pull-right">
             <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
             {{-- <div class="breadcrumb-item active"><a href="#">Dashboard</a></div> --}}
            @if (Request::path() != "/")
            @foreach ($paths as $key => $path )
            <?php 
                $br = "";
                $breadcrumb = ucfirst($path);
                $arr_breadcrumb = explode("%20",$breadcrumb);
                for ($i=0; $i < count($arr_breadcrumb); $i++) { 
                  $br = $br.' '.$arr_breadcrumb[$i];
                }
             ?>
            <li class="breadcrumb-item">{{$br}}</li>
            @endforeach
            @endif
           </ol>
         </div>
       </div>
     </div>
   </div>