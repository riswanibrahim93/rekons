@extends('layouts.main')
@section('title', 'Proses Rekon')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header row">
        {{-- <div class="col-xl-6 col-sm-12"> --}}
        <h5 class="pull-left mb-4 col-md-6 col-sm-12">Proses rekonsiliasi @if (Auth::user()->role==1)
          PT BSI
          @else
          PT EKA AKAR JATI
          @endif </h5>
        <div class="d-flex col-md-6 col-sm-12">
          <div>
            <p>Minimum date:</p>
            <span><input type="date" id="min" name="min"></span>
          </div>
          <div>
            <p>Maximum date:</p>
            <span><input type="date" id="max" name="max"></span>
          </div>
        </div>
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
              <div id="export-button_filter" class="dataTables_filter"><label>Search:<input type="search"
                    class="form-control form-control-sm" placeholder="" aria-controls="export-button"></label></div>
              --}}
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
                <th>Cabang</th>
                <th>Atribusi</th>
                <th>Pembiayaan</th>
                <th>Detail</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="table_data">
              @include('pages.rekons.pagination')
            </tbody>
          </table>
          {{--
            </div> --}}
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_tambah">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-12">
          <h5 class="modal-title">Pemberkasan Data Pembanding</h5>
          <p class="small" id="modalTitle"></p>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
<script>
  function rekonsss() {
    myLoader('#export-button', 'show');
    $axios.get("{{route('data.create')}}").then((data) => {
      let timerInterval

      $swal.fire({
        title: 'Sukses',
        icon: 'success',
        showConfirmButton: false,
        showCancelButton: false,
        html: 'Rekonsiliasi berhasil dilakukan!<br /></br>' +
          'Halaman akan direload dalam <strong></strong> detik.',
        timer: 3000,
        didOpen: () => {

          timerInterval = setInterval(() => {
            $swal.getHtmlContainer().querySelector('strong')
              .textContent = ($swal.getTimerLeft() / 1000)
              .toFixed(0)
          }, 100)
        },
        willClose: () => {
          clearInterval(timerInterval)
        }
      }).then(() => {
        document.location.reload();
      })
      // myLoader('#table_data', 'hide');
    }).catch(() => {
      myLoader('#table_data', 'hide');
      $swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!',
      })
    })
  }
  let timerInterval;

  function processData() {
    console.log({
      start_date: minDate.val(),
      end_date: maxDate.val()
    })
    $axios.post("{{route('check.data')}}", {
      start_date: minDate.val(),
      end_date: maxDate.val()
    }).then((data) => {
      if (data.data.length > 0) {
        $swal.fire({
          title: "Yakin?",
          text: "Anda akan melakukan rekonsiliasi ulang!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya!'
        }).then(async (res) => {
          if (res.isConfirmed) {
            console.log(data.data);
            await Promise.all(data.data).then((values) => {
              var urlHere = "{{route('data.destroy', ": id ")}}";
              values.forEach(element => {
                urlHere = urlHere.replace(':id', element.id);
                $axios.delete(`${urlHere}`)
              });
            })
            rekonsss();
          }
        })

      } else {
        rekonsss();
      }
    })
  }

  function showModal(id1, id2, name, ld) {
    $("#modalTitle").html(`Atas nama ${name}, nomor ld : ${ld}`)
    // $("#formTambah")[0].reset()
    $('#modal_tambah').modal('show')
  }

  // $("#table_data").LoadingOverlay('hide')
</script>
<script src="{{asset('assets/js/datatable-extension/custom.js')}}"></script>
@endsection