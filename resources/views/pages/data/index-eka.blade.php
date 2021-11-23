@extends('layouts.main')
@section('title', 'Data Rekons')
@section('content')
<div class="card">
  <div class="card-header">
    <div class="card-header">
      <div class="row justify-content-between">
        <div class="col-lg-6 col-sm-12">
          <h5 class="pull-left mb-4">Form upload data rekon
            <!-- PT BSI -->
            PT EKA AKAR JATI
          </h5>
          <form action="{{route('import_datas')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group w-75">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" name="file">
                <label class="custom-file-label" for="inputGroupFile04">Pilih file</label>
              </div>
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit" id="inputGroupFileAddon04">Upload</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-4 col-sm-12">
          <form action="" method="get" class="mb-3">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="keyword" placeholder="keyword" aria-label="keyword" value="{{ request()->keyword ?? '' }}" aria-describedby="button-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit" id="button-addon2"><i class="icon-search"></i></button>
              </div>
            </div>
          </form>
          <a href="@if(Auth::user()->role==1){{asset('templates/Field%20Rekon.xlsx')}}@else {{asset('templates/Field%20Rekon%20Eka.xlsx')}}@endif" download="Template Rekonsiliasi.xlsx" class="btn btn-primary btn-small pull-right">Download Template</a>
        </div>
      </div>
    </div>
    <div class="table-responsive" id="table_data">
      @include('pages.data.eka-pagination')
    </div>
  </div>
  @endsection