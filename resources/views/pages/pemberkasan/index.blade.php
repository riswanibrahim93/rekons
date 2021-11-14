@extends('layouts.main')
@section('title', 'Proses Rekon')
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <h5 class="pull-left mb-4">Proses rekonsiliasi @if (Auth::user()->role==1)
            PT BSI
            @else
            PT EKA AKAR JATI
            @endif </h5>
        </div>
        <div class="row">
          <div class="col-xl-8 col-sm-12 my-2">
            <div class="row">
              <div>
                <p>Tanggal awal:</p>
                <span><input type="date" id="min" name="min"></span>
              </div>
              <div>
                <p>Tanggal akhir:</p>
                <span><input type="date" id="max" name="max"></span>
              </div>
            </div>
            <button type="button" class="btn btn-primary btn-sm mt-2" onclick="filterData()"><strong>Filter</strong></button>
          </div>
          <div class="col-xl-4 col-sm-12 my-2 form-group">
          </div>
        </div>
      </div>
      <div class="card-body">
        <button class="btn-success btn-sm mb-2" onclick="processData()">Proses Reskonsiliasi</button>
        <div class="table-responsive">
          @include('pages.pemberkasan.pagination')
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
          <a href="#" class="btn btn-success">Update Data Valid</a>
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
          </tbody>
        </table>
      </div>
      <div class="row mx-2">
        <ul class="list-group col-12">
         <li class="list-group-item active">Cara Mengupdate Data</li>
         <li class="list-group-item">1. Silahkan upload ulang data di halanan Data Rekon</li>
         <li class="list-group-item">2. Jika "Ld" sama maka sistem akan otomatis mengupdate data</li>
         <li class="list-group-item">3. Lakukan proses rekonsiliasi ulang di halaman Proses Rekons</li>
       </ul>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
    <script>
       function showModal(branch_name, ld) {
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
    </script>
@endsection