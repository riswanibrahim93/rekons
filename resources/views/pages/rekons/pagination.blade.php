 <table class="table table-bordernone">
   <thead>
     <tr>
       <th class="text-center">
         No
       </th>
       <th class="text-center">Periode</th>
       <th class="text-center">Cabang</th>
       <th class="text-center">Jumlah NOA</th>
       <th class="text-center">Pembiayaan</th>
       <th class="text-center">Aksi</th>
     </tr>
   </thead>
   <tbody>

     @forelse ($data as $idx=>$item)
     <tr>
       <td class="text-center">{{$item->data->branch_name}}</td>
        <button type="button" class="btn btn-primary btn-sm px-2" style="font-size: 10px;" data-toggle="modal" data-target="#upload-bava"><strong>Upload Bava</strong></button>

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
                <form action="{{ route('upload.bava') }}" method="post" enctype="multipart/form-data">
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
       </td>
     </tr>
     @empty

     @endforelse
   </tbody>
 </table>
 {{ $data->links() }}