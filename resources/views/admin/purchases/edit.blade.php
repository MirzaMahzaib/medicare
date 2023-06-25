@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.purchaseinvoice.update",$invoices[0]->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="required" for="supplier">Supplier Name</label>
                <input class="form-control {{ $errors->has('supplier') ? 'is-invalid' : '' }}" type="text" name="supplier" id="supplier" value="{{ old('supplier', $invoices[0]->supplier) }}" required>
                @if($errors->has('supplier'))
                    <div class="invalid-feedback">
                        {{ $errors->first('supplier') }}
                    </div>
                @endif
            </div>
            <div id="med_data">
                @foreach ($invoices as $invoice)
                    <div class="row align-items-end" id="med_row">
                        <div class="col-md-3">
                            <div class="form-group mb-4 mb-md-0">
                                <label class="required" for="med_name">Medicine Name</label>
                                <select class="form-control productId {{ $errors->has('product_id') ? 'is-invalid' : '' }}" name="product_id[]" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ $invoice->product_id == $product->id ? 'selected' : '' }}>{{ $product->med_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-4 mb-md-0">
                                <label class="required" for="med_pack">Medicine Pack</label>
                                <input class="form-control {{ $errors->has('med_pack') ? 'is-invalid' : '' }}" type="number" name="med_pack[]" value="{{ old('med_name', $invoice->pack) }}" required>
                                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-4 mb-md-0">
                                <label class="required" for="med_qty">Medicine Quantity</label>
                                <input class="form-control {{ $errors->has('med_qty') ? 'is-invalid' : '' }}" type="number" name="med_qty[]" value="{{ old('med_name', $invoice->qty) }}" required>
                                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-4 mb-md-0">
                                <label class="required" for="med_price">Medicine Price (Per Pack)</label>
                                <input class="form-control {{ $errors->has('med_price') ? 'is-invalid' : '' }}" type="number" name="med_price[]" value="{{ old('med_name',$invoice->price) }}" step="0.01" required>
                                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="form-group mt-4">
                        <button class="btn btn-primary align-self-end" id="addMore">Add More</button>
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-success" type="submit">
                            {{ trans('global.save') }} Records
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



@endsection
@section('scripts')
    <script>
        $("#addMore").on('click',function(e){
            e.preventDefault();
            const html = `<div class="row align-items-end mt-4 med_row">
                    <div class="col-md-3">
                        <div class="form-group mb-4 mb-md-0">
                            <label class="required" for="med_name">Medicine Name</label>
                            <select class="form-control productId {{ $errors->has('product_id') ? 'is-invalid' : '' }}" name="product_id[]" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->med_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4 mb-md-0">
                            <label class="required" for="med_pack">Medicine Pack</label>
                            <input class="form-control {{ $errors->has('med_pack') ? 'is-invalid' : '' }}" type="number" name="med_pack[]" value="{{ old('med_name') }}" required>
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4 mb-md-0">
                            <label class="required" for="med_qty">Medicine Quantity</label>
                            <input class="form-control {{ $errors->has('med_qty') ? 'is-invalid' : '' }}" type="number" name="med_qty[]" value="{{ old('med_name') }}" required>
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4 mb-md-0">
                            <label class="required" for="med_price">Medicine Price (Per Pack)</label>
                            <input class="form-control {{ $errors->has('med_price') ? 'is-invalid' : '' }}" type="number" name="med_price[]" value="{{ old('med_name') }}" step="0.01" required>
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                    </div>
                </div>`;
            $("#med_data").append(html);
            $("#remove").on('click',function(e){
                e.preventDefault();
                $(this).parents('div.med_row').remove();
            })
        })
    </script>
@endsection
