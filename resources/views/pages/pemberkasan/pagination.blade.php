 <table id="table_data" class="table table-bordernone">
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
       <!-- <th>Aksi</th> -->
     </tr>
   </thead>
   <tbody>

     @forelse ($data as $idx=>$item)
     @php
     $number = (int)$idx+1;
     @endphp
     <tr>
       <td>{{$number}}</td>
       <td class="dateData">{{$item->data->date}}</td>
       <td>{{$item->data->ld}}</td>
       <td>{{$item->data->full_name}}</td>
       <td>{{$item->data->product}}</td>
       <td>{{$item->data->branch_name}}</td>
       <td>{{$item->atr??''}}</td>
       <td>{{$item->data->outstanding??''}}</td>
       <td>{{$item->description}}</td>
       <td>
         <span class="@if ($item->data->filing)
         badge badge-success
         @else
         badge badge-danger
            @endif" style="cursor: pointer;" onclick="showModal(`{{$item->data->branch_name}}`, `{{$item->data->branch_code}}`)">
           @if ($item->data->filing)
           Pemberkasan
           @else
           Belum
           @endif
         </span>
       </td>
       <!-- <td>
    @if ($item->status==0)
    <span class="badge badge-success pointer" >
      Pemberkasan
    </span>
    @endif
  </td> -->
     </tr>
     @empty

     @endforelse
   </tbody>
 </table>
 {{ $data->links() }}