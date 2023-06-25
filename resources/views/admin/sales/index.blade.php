@extends('layouts.admin')
@section('content')
@can('purchase_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12 d-flex">
            <a class="btn btn-success mr-4" href="{{ route('admin.sales.create') }}">
                {{ trans('global.add') }} Sales
            </a>
            @include('partials.messages')
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Purchases {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Purchase">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Medicine Name
                        </th>
                        <th>
                            Quantity
                        </th>
                        <th>
                            Sold At
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $key => $sale)
                        <tr data-entry-id="{{ $sale->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $sale->products->med_name ?? '' }}
                            </td>
                            <td>
                                {{ $sale->qty ?? '' }}
                            </td>
                            <td>
                                {{ $sale->created_at->format('D, d M Y') ?? '' }}
                            </td>
                            <td>
                                @can('purchase_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.purchases.edit', $sale->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('purchase_delete')
                                    <form action="{{ route('admin.purchases.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('purchase_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.purchases.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Purchase:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
