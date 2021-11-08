<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="universal admin is super flexible, powerful, clean & modern responsive bootstrap 4 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, universal admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="pixelstrap">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />
  <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon" />
  <title>@yield('title') | Sistem Rekonsiliasi</title>

  <!--Google font-->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/fontawesome.css')}}">

  <!-- ico-font -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/icofont.css')}}">

  <!-- Themify icon -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themify.css')}}">

  <!-- Flag icon -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/flag-icon.css')}}">

  <!-- prism css -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">

  <!-- Owl css -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/owlcarousel.css')}}">

  <!-- Bootstrap css -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}}">

  <!-- App css -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">

  <!-- Responsive css -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datatables.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datatable-extension.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}">

</head>

<body>

  <!-- Loader starts -->
  <div class="loader-wrapper">
    <div class="loader bg-white">
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
      {{-- <h4>Have a great day at work today <span>&#x263A;</span></h4> --}}
    </div>
  </div>
  <!-- Loader ends -->

  <!--page-wrapper Start-->
  <div class="page-wrapper">

    <!--Page Header Start-->
    @include('partials.navbar')
    <!--Page Header Ends-->

    <!--Page Body Start-->
    <div class="page-body-wrapper">
      <!--Page Sidebar Start-->
      @include('partials.sidebar')
      <!--Page Sidebar Ends-->

      <div class="page-body">
        <!-- Container-fluid header starts -->
        @include('partials.header')
        <!-- Container-fluid header Ends -->

        <!-- Container-fluid starts -->
        <div class="container-fluid">
          @yield('content')
        </div>
        <!-- Container-fluid Ends -->
      </div>
      <!--Page Body Ends-->
    </div>
    <!--Page Body Ends-->

  </div>
  <!--page-wrapper Ends-->

  <!-- latest jquery-->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
  <!-- Timeline js-->
  <script src="{{asset('assets/js/timeline-v-2/jquery.timeliny.min.js')}}"></script>
  <script src="{{asset('assets/js/timeline-v-2/timeline-v-2-custom.js')}}"></script>
  <!-- Bootstrap js-->
  <script src="{{asset('assets/js/bootstrap/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap/bootstrap.js')}}"></script>

  <!-- Chart JS-->
  <script src="{{asset('assets/js/chart/Chart.min.js')}}"></script>

  <!-- Morris Chart JS-->
  <script src="{{asset('assets/js/morris-chart/raphael.js')}}"></script>
  <script src="{{asset('assets/js/morris-chart/morris.js')}}"></script>

  <!-- owlcarousel js-->
  <script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>

  <!-- Sidebar jquery-->
  <script src="{{asset('assets/js/sidebar-menu.js')}}"></script>

  <!--Sparkline  Chart JS-->
  <script src="{{asset('assets/js/sparkline/sparkline.js')}}"></script>

  <!--Height Equal Js-->
  <script src="{{asset('assets/js/height-equal.js')}}"></script>

  <!-- prism js -->
  <script src="{{asset('assets/js/prism/prism.min.js')}}"></script>

  <!-- clipboard js -->
  <script src="{{asset('assets/js/clipboard/clipboard.min.js')}}"></script>

  <!-- custom card js  -->
  <script src="{{asset('assets/js/custom-card/custom-card.js')}}"></script>

  <!-- Theme js-->
  <script src="{{asset('assets/js/script.js')}}"></script>
  {{-- <script src="{{asset('assets/js/theme-customizer/customizer.js')}}"></script> --}}
  {{-- <script src="{{asset('assets/js/chat-sidebar/chat.js')}}"></script> --}}
  <script src="{{asset('assets/js/dashboard-default.js')}}"></script>

  <!-- Counter js-->
  <script src="{{asset('assets/js/counter/jquery.waypoints.min.js')}}"></script>
  <script src="{{asset('assets/js/counter/jquery.counterup.min.js')}}"></script>
  <script src="{{asset('assets/js/counter/counter-custom.js')}}"></script>

  <script src="{{asset('assets/js/notify/bootstrap-notify.min.js')}}"></script>
  <script src="{{asset('assets/js/notify/index.js')}}"></script>
  <script>
    const BASE_URL = `{{ url('/') }}`
    const URL_NOW = `{{ request()->url() }}`
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content")
  </script>
  <script>
    const refresh_table = url => {
      new Promise((resolve, reject) => {
        $("#table_data").LoadingOverlay('show')
        $axios.get(url)
          .then(({
            data
          }) => {
            $("#table_data").LoadingOverlay('hide')
            $('#table_data').html(data)
          })
          .catch(err => {
            console.log(err)
            $("#table_data").LoadingOverlay('hide')
            $swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
            })
          })
      })
    }


    const $toastr = $swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', $swal.stopTimer)
        toast.addEventListener('mouseleave', $swal.resumeTimer)
      }
    });
  </script>
  @if (Session::has('success'))
  <script>
    $(document).ready(function() {
      $toastr.fire({
        icon: 'success',
        title: "{{session('success')}}"
      });
    })
  </script>
  @endif
  @if (Session::has('error'))
  <script>
    $(document).ready(function() {
      $toastr.fire({
        icon: 'error',
        title: "{{session('error')}}"
      });
    })
  </script>
  @endif
  <script>
    function copyToClipboard(id) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(`#notif${id}`).text()).select();
      document.execCommand("copy");
      $temp.remove();
      $toastr.fire({
        icon: 'success',
        title: 'Ld berhasil dicopi!, silahkan paste di kolom search'
      });
      // setTimeout(() => {
       var urlHere = "{{route('pemberkasan.edit', ":id ")}}";
        urlHere = urlHere.replace(':id', id);
        // url.replace(':id', parseInt(id));
        $axios.get(urlHere).then(()=>{
          setTimeout(() => {
            window.location.replace("{{route('proses')}}");
          }, 2000);
        })
      // }, 500);
    }
  </script>
  @yield('script')
</body>

</html>