@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Purchase Details
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Supplier</label>
                        <input type="text" disabled value="{{ $products[0]->supplier }}" class="form-control bg-white">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Total</label>
                        <input type="text" disabled value="Rs {{ $products[0]->total }}" class="form-control bg-white">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Purchased At</label>
                        <input type="text" disabled value="{{ $products[0]->created_at->format('D, d M Y') }}" class="form-control bg-white">
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="bg-dark">
                    <tr>
                        <th>
                            Medicines
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Quantity
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->med_name }}</td>
                            <td>Rs. {{ $product->price }}</td>
                            <td>{{ $product->qty }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
