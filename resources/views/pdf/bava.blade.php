<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style type="text/css">
      .title{
        font-weight: bold;
        font-size: 16px;
      }
      .title-berita-acara{
        font-weight: bold;
        font-size: 14px;
      }
      p{
        font-size: 11px;
      }
      .input{
        font-size: 11px;
      }
      span{
        font-size: 12px;
      }
      .table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        font-size: 10px;
        margin-left: 20px;
        margin-right: 20px;
      }

      .table td, .table th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
      }

      .table tr{background-color: #f2f2f2; border:  1px solid #ddd;}

      .table tr:hover {background-color: #ddd;}

      .table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #00A39D;
        color: white;
      }
      .stample {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        font-size: 10px;
        width: 60%; 
        float:right;
      }
      .stample td, .stample th {
        padding-left: 8px;
        padding-right: 8px;
        padding-top: 2px;
        padding-bottom: 2px;
        text-align: center;
        background-color: #f2f2f2;
        border: 1px solid #ddd;
      }
      .stample tr{
        border: 1px solid #ddd;
      }
      .kosong {
        height: 100px;
      }
    </style>

    <title>Bava</title>
  </head>
  <body>
    <div class="container">
      <div class="kop-surat">
        <div class="logo" style="width: 20%; float:left;">
          <!-- <img src="{{asset('img/logo-eka-black.jpg')}}"> -->
        </div>
        <div class="kop text-center" style="width: 60%; float:right; padding-right: 20%;">
            <h2 class="title"><b>PT. EKA AKAR JATI</b></h2>
            <span><i>Consultan Management & Businiss</i></span>
            <span>Jl. Dawuhan Tegalgondo Rt. 24/06 Karangploso Malang</span>
        </div>
      </div>
      <hr>
      <div class="berita-acara ps-4">
        <div class="title text-center mb-2">
          <h3 class="title-berita-acara">BERITA ACARA<br>VALIDASI DATA PRODUK</h3>
        </div>
        <p>
          Pada Hari ______________ , Tgl___________________ , Kami yang bertanda tangan dibawah ini:
        </p>
          <div class="mt-3 input">
            <i>Nama Korea</i>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:
          </div>
          <div class="mt-1 input">
            <i>Nama CBRM</i>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:
          </div>
          <div class="mt-1 mb-2 input">
            <i>Branch</i>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:
          </div>
          <p>Menyatakan bahwa benar adanya telah terjadi Pencairan olah <i>Karyawan PT. Eka Akar Jati</i> sesuai dengan data produksi <br>sebagai berikut:</p>
      </div>
      <table class="table table-striped">
         <thead class="text-center">
           <tr>
             <th>
               No
             </th>
             <!-- <th>Periode</th> -->
             <th>Produk</th>
             <th>Nama Nasabah</th>
             <th>Tanggal Cair</th>
             <th>NO LD</th>
             <th>Plafond Rekonsiliasi</th>
             <th>Ket Rekonsiliasi</th>
             <th style="background-color: #04AA6D;">Plafond Valid</th>
             <th style="background-color: #04AA6D;">Keterangan Korea / CBRM</th>
             <!-- <th>Detail</th>
             <th>Status</th> -->
           </tr>
         </thead>
         <tbody class="text-center">

           @forelse ($data as $idx=>$item)
           @php
           $number = (int)$idx+1;
           @endphp
           <tr>
             <td>{{$number}}</td>
             <!-- <td class="dateData">{{$item->periode}}</td> -->
             <td>{{$item->data->product}}</td>
             <td>{{$item->data->full_name}}</td>
             <td></td>
             <td>{{$item->data->ld}}</td>
             <!-- <td>{{$item->atr??''}}</td> -->
             <td></td>
             <td></td>
             <td>{{$item->data->outstanding??''}}</td>
             <!-- <td>{{$item->description}}</td> -->
             <!-- <td>
                 @if ($item->status==1)
                 Valid
                 @else
                 Invalid
                 @endif
             </td> -->
             <td rowspan="2"></td>
           </tr>
           <tr>
            <td colspan="2" style="background-color: white; border: none;"></td>
            <td colspan="2" style="background-color: white; border: none; text-align: left;">
              <input type="checkbox" id="vehicle1" name="vehicle1">
              <label for="vehicle1">Take Over / SK FRESH</label>
              <hr>
              <br>
              <input type="checkbox" id="vehicle1" name="vehicle1">
              <label for="vehicle1"> TOP UP</label>
            </td>
            <td colspan="4" style="background-color: white; border: none; text-align: left;">
              <input type="checkbox" id="vehicle1" name="vehicle1">
              <label for="vehicle1"> BANK ASAL &ensp;&ensp;&nbsp;:</label>
              <hr>
              <br>
              <input type="checkbox" id="vehicle1" name="vehicle1">
              <label for="vehicle1"> 1 LD</label>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
              <label>OS PELUNASAN :</label>

              <br>
              <input type="checkbox" id="vehicle1" name="vehicle1">
              <label for="vehicle1"> 2 LD</label>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
              <label>NOMOR LD 1 &ensp;&ensp;&nbsp;:</label>

            </td>
           </tr>
           @empty

           @endforelse
         </tbody>
       </table>
      <div class="penutup ps-4 mt-2">
        <p>Demikian berita acara ini dibuat dengan sebenar-benarnya dan tanpa ada paksaan dari pihak manapun.</p>
      </div>
    </div>
      <div class="text-right" style="width: 50%; float:right;">
        <table class="stample">
          <tr>
            <th>Dibuat Oleh :</th>
            <th>Verify Oleh :</th>
          </tr>
          <tr>
            <td class="kosong" style="background-color: white;"></td>
            <td class="kosong" style="background-color: white;"></td>
          </tr>
          <tr>
            <td style="height: 20px;"></td>
            <td style="height: 20px;"></td>
          </tr>
          <tr>
            <td><i>Koordinator Area</i></td>
            <td><i>CRBM/BM</i></td>
          </tr>
        </table>
      </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>
  
