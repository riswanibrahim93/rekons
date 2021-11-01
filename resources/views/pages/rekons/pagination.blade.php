<div class="dt-ext table-responsive" id="table_data">
  <div id="export-button_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
    <div class="dt-buttons"> <button class="dt-button buttons-copy buttons-html5" tabindex="0"
        aria-controls="export-button"><span>Copy</span></button> <button class="dt-button buttons-excel buttons-html5"
        tabindex="0" aria-controls="export-button"><span>Excel</span></button> <button
        class="dt-button buttons-csv buttons-html5" tabindex="0" aria-controls="export-button"><span>CSV</span></button>
      <button class="dt-button buttons-pdf buttons-html5" tabindex="0"
        aria-controls="export-button"><span>PDF</span></button>
    </div>
    <div id="export-button_filter" class="dataTables_filter"><label>Search:<input type="search"
          class="form-control form-control-sm" placeholder="" aria-controls="export-button"></label></div>
    <table id="export-button" class="display dataTable" role="grid" aria-describedby="export-button_info">
      <thead>
        <tr role="row">
          <th class="sorting_asc" tabindex="0" aria-controls="export-button" rowspan="1" colspan="1"
            style="width: 130.117px;" aria-label="No: activate to sort column descending" aria-sort="ascending">No
          </th>
          <th class="sorting" tabindex="0" aria-controls="export-button" rowspan="1" colspan="1"
            style="width: 215.917px;" aria-label="TGL Cair: activate to sort column ascending">TGL Cair</th>
          <th class="sorting" tabindex="0" aria-controls="export-button" rowspan="1" colspan="1"
            style="width: 91.0333px;" aria-label="LD: activate to sort column ascending">LD</th>
          <th class="sorting" tabindex="0" aria-controls="export-button" rowspan="1" colspan="1"
            style="width: 37.8667px;" aria-label="Nama: activate to sort column ascending">Nama</th>
          <th class="sorting" tabindex="0" aria-controls="export-button" rowspan="1" colspan="1" style="width: 89.8px;"
            aria-label="Produk: activate to sort column ascending">Produk</th>
          <th class="sorting" tabindex="0" aria-controls="export-button" rowspan="1" colspan="1"
            style="width: 70.2667px;" aria-label="Plafond: activate to sort column ascending">Plafond</th>
          <th class="sorting" tabindex="0" aria-controls="export-button" rowspan="1" colspan="1"
            style="width: 70.2667px;" aria-label="Atribusi: activate to sort column ascending">Atribusi</th>
          <th class="sorting" tabindex="0" aria-controls="export-button" rowspan="1" colspan="1"
            style="width: 70.2667px;" aria-label="Pembiayaan: activate to sort column ascending">Pembiayaan</th>
          <th class="sorting" tabindex="0" aria-controls="export-button" rowspan="1" colspan="1"
            style="width: 70.2667px;" aria-label="Status: activate to sort column ascending">Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($data as $idx=>$item)
        @php
        $number = (int)$idx+1;
        @endphp
        <tr>
          <td class="sorting_1">{{$number}}</td>
          <td>{{$item->data->date??''}}</td>
          <td>{{$item->data->ld??''}}</td>
          <td>{{$item->data->full_name??''}}</td>
          <td>{{$item->data->product??''}}</td>
          <td>{{$item->data->plafond??''}}</td>
          <td>{{$item->data->atr??''}}</td>
          <td>{{$item->data->outstanding??''}}</td>
          <td class="font-secondary">
            @if ($item->status==1)
            No Atribusi
            @elseif($item->status==2)
            Beda Fasilitas
            @else
            Valid
            @endif
          </td>
        </tr>
        @empty

        @endforelse
      </tbody>
      <!-- <tfoot>
        <tr>
          <th rowspan="1" colspan="1">Name</th>
          <th rowspan="1" colspan="1">Position</th>
          <th rowspan="1" colspan="1">Office</th>
          <th rowspan="1" colspan="1">Age</th>
          <th rowspan="1" colspan="1">Start date</th>
          <th rowspan="1" colspan="1">Salary</th>
        </tr>
      </tfoot> -->
    </table>
    <div class="dataTables_info" id="export-button_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries
    </div>
    <div class="dataTables_paginate paging_simple_numbers" id="export-button_paginate">
      <ul class="pagination">
        <li class="paginate_button page-item previous disabled" id="export-button_previous"><a href="#"
            aria-controls="export-button" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
        <li class="paginate_button page-item active"><a href="#" aria-controls="export-button" data-dt-idx="1"
            tabindex="0" class="page-link">1</a></li>
        <li class="paginate_button page-item "><a href="#" aria-controls="export-button" data-dt-idx="2" tabindex="0"
            class="page-link">2</a></li>
        <li class="paginate_button page-item "><a href="#" aria-controls="export-button" data-dt-idx="3" tabindex="0"
            class="page-link">3</a></li>
        <li class="paginate_button page-item "><a href="#" aria-controls="export-button" data-dt-idx="4" tabindex="0"
            class="page-link">4</a></li>
        <li class="paginate_button page-item "><a href="#" aria-controls="export-button" data-dt-idx="5" tabindex="0"
            class="page-link">5</a></li>
        <li class="paginate_button page-item "><a href="#" aria-controls="export-button" data-dt-idx="6" tabindex="0"
            class="page-link">6</a></li>
        <li class="paginate_button page-item next" id="export-button_next"><a href="#" aria-controls="export-button"
            data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
      </ul>
    </div>
  </div>
</div>