@forelse ($data as $idx=>$item)
@php
$number = (int)$idx+1;
@endphp
<tr>
  <td>{{$number}}</td>
  <td>{{$item->data->date}}</td>
  <td>{{$item->data->ld}}</td>
  <td>{{$item->data->full_name}}</td>
  <td>{{$item->data->product}}</td>
  <td>{{$item->data->branch_name}}</td>
  <td>{{$item->atr??''}}</td>
  <td>{{$item->data->outstanding??''}}</td>
  <td>{{$item->description}}</td>
  <td>
    <span class="@if ($item->status==0)
            badge badge-danger
            @else
           badge badge-success
            @endif">
      @if ($item->status==1)
      Valid
      @else
      Invalid
      @endif
    </span>
  </td>
  <td>
    @if ($item->status==0)
    <span class="badge badge-success pointer" style="cursor: pointer;" onclick="showModal(`{{$item->data_id}}`,`{{$item->bsi_id}}`, `{{$item->data->full_name}}`, `{{$item->data->ld}}`)">
      Pemberkasan
    </span>
    @endif
  </td>
</tr>
@empty

@endforelse