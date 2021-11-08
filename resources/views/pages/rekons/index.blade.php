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
            <p>Tanggal awal:</p>
            <span><input type="date" id="min" name="min"></span>
          </div>
          <div>
            <p>Tanggal akhir:</p>
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
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">BSI</th>
              <th scope="col">Eka</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td><a href="" target="_blank" id="bsiLink" class="btn btn-success">Lihat</a></td>
              <td><a href="" target="_blank" id="ekaLink" class="btn btn-warning">Lihat</a></td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td><button class="btn btn-success" onclick="uploadButton(1)"><span id="spinner_field1"></span>upload</button>
                <form action="" method="post" enctype="multipart/form-data" id="form1">
                  @csrf
                  <input type="hidden" name="ld" id="ld" class="ld">
                  <input type="file" style="overflow:hidden;width:0px;height:0px;" accept="application/pdf" name="file" id="bsi_file">
                </form>
              </td>
              <td><button class="btn btn-warning" onclick="uploadButton(2)"><span id="spinner_field2"></span>upload</button>
                <form id="form2" action="" method="post" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="ld" id="ld" class="ld">
                  <input type="file" style="overflow:hidden;width:0px;height:0px;" accept="application/pdf" name="file" id="eka_file">
                </form>
              </td>
            </tr>
          </tbody>
        </table>
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
  var minDate = $('#min'),
    maxDate = $('#max');

  function rekonsss() {
    myLoader('#export-button', 'show');
    $axios.post("{{route('process.data')}}", {
      start_date: minDate.val(),
      end_date: maxDate.val()
    }).then((data) => {
      let timerInterval
      console.log(data.data);
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
        // document.location.reload();
      })
      // myLoader('#table_data', 'hide');
    }).catch((err) => {

      console.log(err);
      myLoader('#table_data', 'hide');
      $swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: err.message.text,
      })
    })
  }
  let timerInterval;

  function processData() {
    if (minDate.val() == "") {
      $swal.fire({
        title: "Perhatian!",
        text: "Minimal tentukan tanggal awal dahulu!",
        icon: 'warning',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ya!'
      }).then((res) => {
        if (res.isConfirmed) {
          return;
        }
      });
      return;
    }
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
              var urlHere = "{{route('data.destroy', ":id ")}}";
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

  function noFileErr() {
    $swal.fire({
      title: "Opps",
      icon: "warning",
      text: "Belum ada file"
    })
  }

  function showModal(id1, id2, name, ld) {
    console.log(minDate.val() == "");

    $("#modalTitle").html(`Atas nama ${name}, nomor ld : ${ld}`)
    // $(`#form${Gtype}`)[0].reset()
    $(".ld").val(ld);

    var urlHere = "{{route('pemberkasan.show', ":id ")}}";
    urlHere = urlHere.replace(':id', ld);
    $axios.get(`${urlHere}`).then((data) => {
      let results = data.data;
      results.forEach((item) => {
        if (item.from == 1) {
          $("#bsiLink").attr('href', item.file);
          $("#bsiLink").attr('target', "_blank");
          $("#ekaLink").attr('onClick', null);
        } else {
          $("#bsiLink").attr('href', "#");
          $("#bsiLink").attr('target', null);
          $("#bsiLink").attr('onClick', 'noFileErr()');
        }
        if (item.from == 2) {
          $("#ekaLink").attr('href', item.file);
          $("#ekaLink").attr('target', "_blank");
          $("#ekaLink").attr('onClick', null);
        } else {
          $("#bsiLink").attr('href', "#");
          $("#bsiLink").attr('target', null);
          $("#ekaLink").attr('onClick', 'noFileErr()');
        }
      })

      $('#modal_tambah').modal('show')
    });
  }
  let Gtype = 0;

  function uploadButton(type) {
    // $(`#spinner_field${type}`).html('<i class="fa fa-spin fa-spinner mr-2"></i>');
    Gtype = type;
    if (type === 1) {
      $("#bsi_file").click();
    } else {
      $("#eka_file").click();
    }
  }
  $("#bsi_file").on('change', function() {
    $("#form1").submit();
  });
  $("#eka_file").on('change', function() {
    $("#form2").submit();
  });
  $("#form1").on('submit', async (e) => {
    e.preventDefault();
    let FormDataVar = new FormData($(`#form${Gtype}`)[0]);
    $(`#spinner_field${Gtype}`).html('<i class="fa fa-spin fa-spinner mr-2"></i>');
    console.log(FormDataVar)
    for (var pair of FormDataVar.entries()) {
      console.log(pair[0] + ', ' + pair[1]);
    }
    await new Promise((resolve, reject) => {
      $axios.post(`{{ route('pemberkasan.store') }}`, FormDataVar, {
          headers: {
            'Content-type': 'multipart/form-data'
          }
        })
        .then(({
          data
        }) => {
          $(`#spinner_field${Gtype}`).html(null);

          $("#bsiLink").attr('href', data.message.link);
          $toastr.fire({
            icon: 'success',
            title: data.message.body
          });
        })
        .catch(err => {
          $(`#spinner_field${Gtype}`).html(null);
          $toastr.fire({
            icon: 'error',
            title: err.message.body
          });
        });
    });
  });
  $("#form2").on('submit', async (e) => {
    e.preventDefault();
    let FormDataVar = new FormData($(`#form${Gtype}`)[0]);
    $(`#spinner_field${Gtype}`).html('<i class="fa fa-spin fa-spinner mr-2"></i>');
    console.log(FormDataVar)
    for (var pair of FormDataVar.entries()) {
      console.log(pair[0] + ', ' + pair[1]);
    };
    await new Promise((resolve, reject) => {
      $axios.post(`{{ route('pemberkasan.store') }}`, FormDataVar, {
          headers: {
            'Content-type': 'multipart/form-data'
          }
        })
        .then(({
          data
        }) => {
          $("#ekaLink").attr('href', data.message.link);
          $(`#spinner_field${Gtype}`).html(null);
          $toastr.fire({
            icon: 'success',
            title: data.message.body
          });
        })
        .catch(err => {
          $(`#spinner_field${Gtype}`).html(null);
          $toastr.fire({
            icon: 'error',
            title: err.message.body
          });
        });
    });
  });
</script>
<script src="{{asset('assets/js/datatable-extension/custom.js')}}"></script>
@endsection