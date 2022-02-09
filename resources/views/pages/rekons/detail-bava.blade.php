@extends('layouts.main')
@section('title', 'Proses Rekon')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="row justify-content-between">
          <div class="col-lg-6 col-sm-12">
          <h5 class="pull-left mb-4">File Bava @if (Auth::user()->role==1)
            PT BSI
            @else
            PT EKA AKAR JATI
            @endif </h5>
          </div>
        </div>
      </div>
      <!-- <div class="card-body">
          <div class="col-sm-4 text-right mt-3">
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
        </div> -->
        
        

        <div class="table-responsive tabelcabang" id="table_data">
          <table class="table table-bordernone">
             <thead>
               <tr>
                <!-- <th>
                  <input type="checkbox" id="selectAll">
                </th> -->
                 <th>No</th>
                 <th>Branch Name</th>
                 <th>Name File</th>
                 <th>Created At</th>
                 <th>View</th>
                 <!-- <th>Aksi</th> -->
               </tr>
             </thead>
             <tbody>

               @forelse ($bava as $idx=>$item)
               @php
               $number = (int)$idx+1;
               @endphp
               <tr>
                <!-- <td>
                  <input type="checkbox" value="{{$item->id}}" id="ids" name="ids" class="selectData">
                </td> -->
                 <td>{{$number}}</td>
                 <td>{{$branch_name}}</td>
                 <td>{{$item->file}}</td>
                 <td>{{$item->created_at}}</td>
                 <td>
                   <a href="/pdf-bava/{{$item->file}}" target="_blank" class="btn btn-primary btn-sm px-2" style="font-size: 10px;" onclick="filterData()"><strong>View Bava</strong></a>
                 </td>
               </tr>
               @empty

               @endforelse
             </tbody>
           </table>
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
<script type="text/javascript" charset="utf8"
  src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript" charset="utf8"
  src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript">
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

 