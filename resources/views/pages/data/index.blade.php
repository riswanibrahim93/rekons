@extends('layouts.main')
@section('title', 'Data Rekons')
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
            <form action="{{route('import_datas')}}" method="post" enctype="multipart/form-data">
              @csrf
              <!-- <button type="button" class="btn btn-outline-light txt-dark" data-original-title="btn btn-outline-light txt-dark" title="">Light Button</button> -->
              <input type="file" name="file" id="">
              <button class="action btn btn-light" type="submit">Upload</button>
            </form>
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
        <div class="tabbed-card">
          <ul class="pull-right nav nav-pills nav-primary" id="pills-clrtabinfo" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-clrhome-tabinfo" data-toggle="pill" href="#pills-clrhomeinfo" role="tab" aria-controls="pills-clrhome" aria-selected="true">PT EKA AKAR JATI</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-clrprofile-tabinfo" data-toggle="pill" href="#pills-clrprofileinfo" role="tab" aria-controls="pills-clrprofile" aria-selected="false">
                BSI</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-clrtabContentinfo">
            <div class="tab-pane fade show active" id="pills-clrhomeinfo" role="tabpanel" aria-labelledby="pills-clrhome-tabinfo">
             @include('pages.data.eka-pagination')
            </div>
            <div class="tab-pane fade" id="pills-clrprofileinfo" role="tabpanel" aria-labelledby="pills-clrprofile-tabinfo">
             @include('pages.data.bsi-pagination')
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
@section('script')

@endsection