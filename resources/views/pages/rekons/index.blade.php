@extends('layouts.main')
@section('title', 'Proses Rekon')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        {{-- <div class="col-xl-6 col-sm-12"> --}}
          <h5 class="pull-left mb-4">Proses rekonsiliasi @if (Auth::user()->role==1)
            PT BSI
            @else
            PT EKA AKAR JATI
            @endif </h5>
          {{-- <div class="col"> --}}

            {{-- <button class="action btn btn-light" type="button" id="proses">proses</button> --}}
            {{-- </div> --}}
          {{--
        </div> --}}
        <!-- <div class="col-xl-6 ml-auto col-sm-12"> -->
        {{-- <input type="search" class="form-control-plaintext col-xl-3 d-block ml-auto col-sm-12 mt-2" name="keyword"
          placeholder="Search" value="{{ request()->keyword ?? '' }}"> --}}

        <!-- </div> -->
      </div>
      <div class="card-body">
        <div class="dt-ext table-responsive">
          {{-- <div id="export-button_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">

            <div class="dt-buttons"> <button class="dt-button buttons-copy buttons-html5 btn-success" tabindex="0"
                aria-controls="export-button" id="proses"><span>Proces</span></button> <button
                class="dt-button buttons-excel buttons-html5" tabindex="0"
                aria-controls="export-button"><span>Excel</span></button> <button
                class="dt-button buttons-csv buttons-html5" tabindex="0"
                aria-controls="export-button"><span>CSV</span></button>
              <button class="dt-button buttons-pdf buttons-html5" tabindex="0"
                aria-controls="export-button"><span>PDF</span></button>
            </div>
            <div id="export-button_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="export-button"></label></div> --}}
            <table id="export-button" class="display">
              <thead>
                <tr>
                  <th>
                    No
                  </th>
                  <th>TGL Cair</th>
                  <th>LD</th>
                  <th>Nama</th>
                  <th>Produk</th>
                  <th>Plafond</th>
                  <th>Atribusi</th>
                  <th>Pembiayaan</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody id="table_data">
                @include('pages.rekons.pagination')
              </tbody>
            </table>
          {{-- </div> --}}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/buttons.colVis.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/jszip.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/pdfmake.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/vfs_fonts.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/dataTables.autoFill.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/dataTables.select.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/buttons.print.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/buttons.html5.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/js/datatable-extension/custom.js')}}"></script>
<script>
  $(document).ready(function() {
    $("#proses").on('click', function() {
      // $("#table_data").LoadingOverlay('hide')
      myLoader('#export-button', 'show');
      $axios.get("{{route('data.create')}}").then((data) => {
        // conso
        $('#table_data').html(data.data.html)
        // myLoader('#table_data', 'hide');
      }).catch(() => {
        // myLoader('#table_data', 'hide');
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