@extends('layouts.main')
@section('title', 'Data Rekons')
@section('content')
<div class="card">
  <div class="card-header">
    <div class="row justify-content-between">
      <div class="col-6-lg">
        <button class="btn btn-outline-primary ml-2" onclick="refresh_table(URL_NOW)"><i class="fas fa-sync"></i>Refresh</button>
      </div>
      <div class="col-6-lg">
        <button class="btn btn-outline-primary ml-2" onclick="refresh_table(URL_NOW)"><i class="fas fa-sync"></i>Refresh</button>
      </div>
    </div>
  </div>
  <div class="table-responsive" id="table_data">
    @include('pages.data.eka-pagination')
  </div>
</div>
@endsection