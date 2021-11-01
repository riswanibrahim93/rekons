@extends('layouts.main')
@section('title', 'Proses Rekon')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="col-xl-6 col-sm-12">
          <h5 class="pull-left mb-4">Form upload data rekon @if (Auth::user()->role==1)
            PT BSI
            @else
            PT EKA AKAR JATI
            @endif </h5>
          {{-- <div class="col"> --}}

          <button class="action btn btn-light" type="button" id="proses">proses</button>
          {{-- </div> --}}
        </div>
        <!-- <div class="col-xl-6 ml-auto col-sm-12"> -->
        {{-- <input type="search" class="form-control-plaintext col-xl-3 d-block ml-auto col-sm-12 mt-2" name="keyword" placeholder="Search"
            value="{{ request()->keyword ?? '' }}"> --}}
        <form class="form-inline search-form col-xl-3 d-block ml-auto col-sm-12">
          <div class="form-group">
            <label class="sr-only">Email</label>
            <input type="search" class="form-control-plaintext" placeholder="Search..">
            <span class="d-sm-none mobile-search">
            </span>
          </div>
        </form>
        <!-- </div> -->
      </div>
      <div class="card-body">
       @include('pages.rekons.pagination')
      </div>

    </div>
  </div>
</div>
@endsection
@section('script')
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
  $(document).ready(function() {
    $("#proses").on('click', function() {
      // $("#table_data").LoadingOverlay('hide')
      myLoader('#table_data', 'show');
      $axios.get("{{route('data.create')}}").then((data) => {
        $('#table_data').html(data.html)
        myLoader('#table_data', 'hide');
      }).catch(() => {
        myLoader('#table_data', 'hide');
        $swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
        })
      })
    })
  })
  // $("#table_data").LoadingOverlay('hide')
</script>
@endsection