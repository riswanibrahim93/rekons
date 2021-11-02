
        @forelse ($data as $idx=>$item)
        @php
        $number = (int)$idx+1;
        @endphp
        <tr>
          <td >{{$number}}</td>
          <td>{{$item->data->date??''}}</td>
          <td>{{$item->data->ld??''}}</td>
          <td>{{$item->data->full_name??''}}</td>
          <td>{{$item->data->product??''}}</td>
          <td>{{$item->data->plafond??''}}</td>
          <td>{{$item->data->atr??''}}</td>
          <td>{{$item->data->outstanding??''}}</td>
          <td>
            <span class="@if ($item->status==0)
            badge badge-danger
            @elseif($item->status==1)
            badge badge-warning
            @elseif($item->status==2)
            Beda Fasilitas
            @else
            Valid
            @endif">
              @if ($item->status==1)
              No Atribusi
              @elseif($item->status==2)
              Beda Fasilitas
              @else
              Valid
              @endif
            </span>
          </td>
        </tr>
        @empty

        @endforelse
     