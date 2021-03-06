<table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">TGL Cair</th>
      <th scope="col">LD</th>
      <th scope="col">Nama</th>
      <th scope="col">Nama Cabang</th>
      <th scope="col">Produk</th>
      <th scope="col">Atribusi</th>
      {{-- <th scope="col">Pembiayaan</th> --}}
    </tr>
  </thead>
  <tbody>
    @forelse ($bsi_data as $idx=>$item)
    <tr>
      <td scope="row">{{ ($bsi_data->currentpage()-1) * $bsi_data->perpage() + $loop->index + 1 }}</td>
      <td>{{$item->date}}</td>
      <td>{{$item->ld}}</td>
      <td>{{$item->full_name}}</td>
      <td>{{$item->branch_name}}</td>
      <td>{{$item->product}}</td>
      <td>{{$item->outstanding}}</td>
      {{-- <td class="font-secondary">Pending</td> --}}
    </tr>
    @empty

    @endforelse
  </tbody>
</table>
{{ $bsi_data->links() }}