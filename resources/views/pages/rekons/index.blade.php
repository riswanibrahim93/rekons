@extends('layouts.main')
@section('title', 'Proses Rekon')
@section('content')
@if (session('status'))
  <div class="alert alert-success">
      {{ session('status') }}
  </div>
@endif
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="row justify-content-between">
          <div class="col-lg-6 col-sm-12">
          <h5 class="pull-left mb-4">Proses rekonsiliasi @if (Auth::user()->role==1)
            PT BSI
            @else
            PT EKA AKAR JATI
            @endif </h5>
          </div>
        </div>
        <div class="row justify-content-between px-3">
          <div class="col-6-lg col-12-sm">
            <div class="input-group input-group-sm mb-2">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Tanggal Mulai</label>
              </div>
              <input type="date" class="form-control" aria-label="Sizing example input" id="min"
                aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group input-group-sm mb-2">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Tanggal Akhir</label>
              </div>
              <input type="date" class="form-control" aria-label="Sizing example input" id="max"
                aria-describedby="inputGroup-sizing-sm">
            </div>
            <button type="button" class="btn btn-primary btn-sm" onclick="filterData()"><strong>Filter</strong></button>
            <button class="btn btn-primary btn-sm ml-2 pull-right" type="button" onclick="processData()"><strong>Proses
                Reskonsiliasi</strong></button>
          </div>
          <div class="col-6-lg col-12-sm mb-2">
            {{-- <form action="" method="get">
              <div class="input-group">
                <input type="text" class="form-control" name="keyword" placeholder="keyword" aria-label="keyword"
                  value="{{ request()->keyword ?? '' }}" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit" id="button-addon2"><i class="icon-search"></i></button>
                </div>
              </div>
            </form> --}}
            <!-- <div class="input-group mt-2">
              <select class="custom-select" id="selectCabang" aria-label="Example select with button addon"
                name="parent_id">
                <option value="" disabled selected>== Pilih Cabang==</option>
                @forelse ($branches as $branch)
                <option value="{{$branch->code}},{{$branch->name}}" @if ($notif==$branch->name)
                  selected
                  @endif>{{$branch->name}}</option>
                @empty
                <option value="" disabled>Belum ada cabang</option>
                @endforelse
              </select>
              </select>
              <div class="input-group-append">
                <button class="btn btn-primary" type="button"
                  onclick="showModal()"><strong>Pemberkasan</strong></button>
              </div>
            </div> -->
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-6 mt-2">
          </div>
          <div class="col-sm-2"></div>
          <div class="col-sm-4 text-right">
              <form action="" method="get">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="keyword" placeholder="keyword" aria-label="keyword"
                    value="{{ request()->keyword ?? '' }}" aria-describedby="button-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" id="button-addon2"><i class="icon-search"></i></button>
                  </div>
                </div>
              </form>
          </div>
        </div>
        <div class="table-responsive" id="table_data">
          @include('pages.rekons.pagination')
        </div>
        <div class="data-detail" hidden="true">
          <div class="col-sm-6 mb-4 mt-5">
            <h5>List data pada cabang</h5>
            <p class="text-justify">Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur aliquet quam id dui posuere blandit. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem.</p>
          </div>
          <div class="col-sm-6 mb-3">
              <a class="badge badge-success px-5 py-2" id="validationAllSelect" style="font-size: 12px;"><i class="fas fa-check-circle pr-1"></i> Validasi</a>
              <a class="badge badge-danger px-5 py-2" id="tolakAllSelect" style="font-size: 12px;"><i class="fas fa-times-circle pr-1"></i> Tolak</a>
          </div> 
          <div class="table-responsive" id="table_data_detail">
            <table class="table table-bordernone">
               <thead>
                 <tr>
                  <th>
                    <input type="checkbox" id="selectAll">
                  </th>
                   <th>No</th>
                   <th>Periode</th>
                   <th>LD</th>
                   <th>Nama</th>
                   <th>Produk</th>
                   <th>Atribusi</th>
                   <th>Plafond</th>
                   <th>Detail</th>
                   <th>Status</th>
                   <!-- <th>Aksi</th> -->
                 </tr>
               </thead>
               <tbody class="tambahTabel">
                 
               </tbody>
             </table>
          </div>       
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
          <a href="#" class="btn btn-primary">Update Data Valid</a>
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
              <td><a href="" target="_blank" id="bsiLink" class="btn btn-primary">Lihat</a></td>
              <td><a href="" target="_blank" id="ekaLink" class="btn btn-warning">Lihat</a></td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td><button class="btn btn-primary" onclick="uploadButton(1)"><span
                    id="spinner_field1"></span>upload</button>
                <form action="" method="post" enctype="multipart/form-data" id="form1">
                  @csrf
                  <input type="hidden" name="ld" id="ld" class="ld">
                  <input type="file" style="overflow:hidden;width:0px;height:0px;" accept="application/pdf" name="file"
                    id="bsi_file">
                </form>
              </td>
              <td><button class="btn btn-warning" onclick="uploadButton(2)"><span
                    id="spinner_field2"></span>upload</button>
                <form id="form2" action="" method="post" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="ld" id="ld" class="ld">
                  <input type="file" style="overflow:hidden;width:0px;height:0px;" accept="application/pdf" name="file"
                    id="eka_file">
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
<script type="text/javascript" charset="utf8"
  src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript" charset="utf8"
  src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  var minDate = $('#min'),
    maxDate = $('#max');

  function tabelDetail(branch_name){
    $('.data-detail').removeAttr('hidden');
    // var branch_name = $('#branch_name').html();
    console.log(branch_name);

    $axios.post("{{route('detail.cabang')}}", {
      branch_name: branch_name
    })
    .then((data) => {
      var detail = data.data[0];
      var html = "";
      var status = "";
      var number = 1;
      console.log(data);
      detail.forEach(function(element) { 
        if(element.status == 0)
        {
          status = `<span class="badge badge-danger">Valid</span>`
        }
        else
        {
          status = `<span class="badge badge-success">Invalid</span>`
        }
        html += `<tr>
                  <td>
                  <input type="checkbox" value="`+element.id+`" id="ids" name="ids" class="selectData">
                  </td>
                  <td>`+number+`</td>
                  <td class="dateData">`+element.periode+`</td>
                  <td>`+element.data.ld+`</td>
                  <td>`+element.data.full_name+`</td>
                  <td>`+element.data.product+`</td>
                  <td>`+element.atr+`</td>
                  <td>`+element.data.outstanding+`</td>
                  <td>`+element.description+`</td>
                  <td>`+status+`</td>
                </tr>`;
        console.log(element.periode);
        number++;
      });
      $('.tambahTabel').html(html);
    })
    .catch((err) => {
      console.log(err);
    })
  }

  function rekonsss() {
    myLoader('#table_data', 'show');
    $axios.post("{{route('process.data')}}", {
      start_date: minDate.val(),
      end_date: maxDate.val()
    }).then((data) => {
      console.log('masuk rekons')
      // let timerInterval
      // console.log(data.data);
      // $swal.fire({
      //   title: 'Sukses',
      //   icon: 'success',
      //   showConfirmButton: false,
      //   showCancelButton: false,
      //   html: 'Rekonsiliasi berhasil dilakukan!<br /></br>' +
      //     'Halaman akan direload dalam <strong></strong> detik.',
      //   timer: 3000,
      //   didOpen: () => {

      //     timerInterval = setInterval(() => {
      //       $swal.getHtmlContainer().querySelector('strong')
      //         .textContent = ($swal.getTimerLeft() / 1000)
      //         .toFixed(0)
      //     }, 100)
      //   },
      //   willClose: () => {
      //     clearInterval(timerInterval)
      //   }
      // }).then(() => {
      refresh_table(URL_NOW);
      // })
      // myLoader('#table_data', 'hide');
    })
    .catch((err) => {

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
    if (minDate.val() == "" && maxDate.val() == "") {
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
    // console.log('cek dulu')
    // $axios.defaults.baseURL = 'https://reqres.in/api/';
    // $axios.post('users',{
    //  'first_name':'Junny',
    //  'last_name':'Joni'
    // })
    // .then((data)=>console.log(data))
    // .catch((error)=>console.log('Error: '+error))


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
            let dataToDelete = data.data;
            if (dataToDelete.length>0) {
              dataToDelete.forEach((item)=>{
                var urlHere = "{{route('data.destroy', ":id ")}}";
                urlHere = urlHere.replace(':id', item.reconciled_data_id);
                $axios.delete(`${urlHere}`)
              })
            }
            rekonsss();
          }
        })

      } else {
        console.log('rekons')
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

  function openFile(url) {
    window.open(url)
  }
  let ld = "";
  let branch_name = "{{$notif}}";

  $(window).ready(()=>{
    let valueH = $("#selectCabang").val().split(",");
    ld = valueH[0];
    branch_name = valueH[1];
  });

  $("#selectCabang").on("change", function() {
    let valueH = $(this).val().split(",");
    ld = valueH[0];
    branch_name = valueH[1];
    console.log(valueH);
  })

  function showModal() {
    // console.log(minDate.val() == "");
    if (ld === "") {
      $swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "Silahkan pilih cabang terlebih dahulu",
      });
      return;
    }

    $("#modalTitle").html(`Data cabang ${branch_name}`)
    $(".ld").val(ld);

    var urlHere = "{{route('pemberkasan.show', ":id ")}}";
    urlHere = urlHere.replace(':id', ld);
    $("#ekaLink").attr('href', "#");
    $("#ekaLink").attr('target', null);
    $("#ekaLink").attr('onClick', 'noFileErr()');
    $("#bsiLink").attr('href', "#");
    $("#bsiLink").attr('target', null);
    $("#bsiLink").attr('onClick', 'noFileErr()');
    $axios.get(`${urlHere}`).then((data) => {
      let results = data.data.data;
      let isReconciled = data.data.isReconciled;
      if(!isReconciled)return $swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: `Belum ada data di cabang ${branch_name} yang sudah direkonsiliasi!`,
      });
      console.log(results);
      if (results.length > 0) {
        results.forEach((item) => {
          if (item.from == 1) {
            $("#bsiLink").attr('href', item.file);
            // $("#bsiLink").attr('target', "_blank");
            $("#bsiLink").attr('onClick', null);
            // download=
            console.log('bsi get')
          }
          if (item.from == 2) {
            $("#ekaLink").attr('href', item.file);
            // $("#ekaLink").attr('target', "_blank");
            $("#ekaLink").attr('onClick', null);
            console.log('eka get');
          }
        })
      } else {
        $("#ekaLink").attr('href', "#");
        $("#ekaLink").attr('target', null);
        $("#ekaLink").attr('onClick', 'noFileErr()');
        $("#bsiLink").attr('href', "#");
        $("#bsiLink").attr('target', null);
        $("#bsiLink").attr('onClick', 'noFileErr()');

      }

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
          $("#bsiLink").attr('onClick', null);

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
          $("#ekaLink").attr('onClick', null);
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

  function filterData() {
        var iFini = moment(replaceTheShit(minDate.val()), "YYYY/MM/DD").format("X");
        var iFfin = moment(replaceTheShit(maxDate.val()), "YYYY/MM/DD").format("X");
        let data = $(".dateData").toArray()
        for (let index = 0; index < data.length; index++) {
          var evalDate = moment(replaceTheShit(data[index].textContent), "YYYY/MM/DD").format("X");
          const element = data[index];
          if (
              (iFini === 'Invalid date' && iFfin === 'Invalid date') ||
              (iFini === 'Invalid date' && evalDate <= iFfin) ||
              (iFini <= evalDate && iFfin === 'Invalid date') ||
              (iFini <= evalDate && evalDate <= iFfin)
          ) {
             if(element.parentElement.classList.contains('d-none')){
               element.parentElement.classList.remove('d-none');
             }
          } else {
              element.parentElement.classList.add('d-none');
          }
        }

  }
</script>
<script type="text/javascript">
  $(function(e){
    $('#selectAll').click(function(){
      $(".selectData").prop('checked',$(this).prop('checked'));
    });
    $('#validationAllSelect').click(function(e){
      e.preventDefault();
      var all_ids = [];
      $('input:checkbox[name=ids]:checked').each(function(){
        all_ids.push($(this).val());
      });

      $axios.post("{{route('validasi.selected')}}", {
        ids: all_ids
      })
      .then((data) => {
        console.log(data.status);
        if(data.status == 200)
        {
          $swal.fire({
            icon: 'success',
            title: 'Validasi Data Berhasil',
            showConfirmButton: false,
            timer: 1500
          })
        }
        window.location.reload();
      })
      .catch((err) => {

        console.log(err);
        myLoader('#table_data', 'hide');
        $swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: err.message.text,
        })
      })
    });
    $('#tolakAllSelect').click(function(e){
      e.preventDefault();
      var all_ids = [];
      $('input:checkbox[name=ids]:checked').each(function(){
        all_ids.push($(this).val());
      });

      // action tolak
      $swal.fire({
        title: "Yakin?",
        text: "Anda akan menolak data yang terpilih!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Ya!'
      }).then((result) => {
        if (result.isConfirmed) {
          $axios.post("{{route('tolak.selected')}}", {
            ids: all_ids
          })
          .then((data) => {
            console.log(data.status);
            if(data.status == 200)
            {
              $swal.fire({
                icon: 'success',
                title: 'Tolak Data Berhasil',
                showConfirmButton: false,
                timer: 1500
              })
            }
            window.location.reload();
          })
          .catch((err) => {

            console.log(err);
            myLoader('#table_data', 'hide');
            $swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: err.message.text,
            })
          })
        }
      })
    });
  });
</script>
<script src="{{asset('assets/js/datatable-extension/custom.js')}}"></script>
@endsection