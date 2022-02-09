 <table class="table table-bordernone">
   <thead>
     <tr>
       <th class="text-center">
         No
       </th>
       <!-- <th>Periode</th> -->
       <th class="text-center">Cabang</th>
       <th class="text-center">Jumlah NOA</th>
       <th class="text-center">Plafond</th>
       <th class="text-center">Aksi</th>
     </tr>
   </thead>
   <tbody>

     @forelse ($data as $idx=>$item)
     @php
     $number = (int)$idx+1;
     @endphp
     <tr>
       <td class="text-center">{{$number}}</td>
       <td class="text-center">{{$item->branch_name}}</td>
       <td class="text-center">{{$item->noa}}</td>
       <td class="text-center">{{$item->biaya}}</td>
       <td class="text-center">
        @if (Auth::user()->role==1)
        <!-- <a href="{{route('process.dataDetail', ['branch' => $item->branch_name])}}" class="btn btn-primary btn-sm px-2" style="font-size: 10px;"><strong>Detail</strong></a> -->
        <button onclick="tabelDetail(`{{$item->branch_name}}`);" class="btn btn-primary btn-sm px-2" style="font-size: 10px;"><strong>Detail</strong></button>
        <a href="{{route('bavaPDF', ['branch' => $item->branch_name])}}" target="_blank" class="btn btn-primary btn-sm px-2" style="font-size: 10px;" onclick="filterData()"><strong>View Bava</strong></a>
        @else
        <a href="{{route('process.dataDetail', ['branch' => $item->branch_name])}}" class="btn btn-primary btn-sm px-2" style="font-size: 10px;"><strong>Detail</strong></a>
        <a href="{{route('bava', ['branch' => $item->branch_name])}}" target="_blank" class="btn btn-primary btn-sm px-2" style="font-size: 10px;" onclick="filterData()"><strong>View Bava</strong></a>
        <button type="button" class="btn btn-primary btn-sm px-2" style="font-size: 10px;" data-toggle="modal" data-target="#upload-bava"><strong>Upload Bava</strong></button>
        <a href="{{route('bavaPDF', ['branch' => $item->branch_name])}}" target="_blank" class="btn btn-primary btn-sm px-2" style="font-size: 10px;" onclick="filterData()"><strong>Download Bava</strong></a>

        <!-- Button trigger modal -->
<!--         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Launch demo modal
        </button> -->

        <!-- Modal -->
        <div class="modal fade" id="upload-bava" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload File Bava</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="/uploadBava/{{$item->branch_name}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="input-group">
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
            </div>
          </div>
        </div>
            @endif
       </td>
     </tr>
     @empty

     @endforelse
   </tbody>
 </table>
 {{ $data->links() }}