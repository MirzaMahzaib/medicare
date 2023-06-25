@extends('layouts.admin')
@section('content')
@include('partials.messages')
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.products.store") }}" enctype="multipart/form-data">
            @csrf
            <div id="med_data">
                <div class="row align-items-end" id="med_row">
                    <div class="col-md-6">
                        <div class="form-group mb-4 mb-md-0">
                            <label class="required" for="med_name">Medicine Name</label>
                            <input class="form-control {{ $errors->has('med_name') ? 'is-invalid' : '' }}" type="text" name="med_name[]" value="{{ old('med_name') }}" required>
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4 mb-md-0">
                            <label class="required" for="med_pack_qty">Tabs In Pack</label>
                            <input class="form-control {{ $errors->has('med_pack_qty') ? 'is-invalid' : '' }}" type="number" name="med_pack_qty[]" value="{{ old('med_pack_qty') }}" required>
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                    </div>
                </div>
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
            const html = `<div class="row align-items-end" id="med_row">
                    <div class="col-md-6 mt-3">
                        <div class="form-group mb-4 mb-md-0">
                            <label class="required" for="med_name">Medicine Name</label>
                            <input class="form-control {{ $errors->has('med_name') ? 'is-invalid' : '' }}" type="text" name="med_name[]" value="{{ old('med_name') }}" required>
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group mb-4 mb-md-0">
                            <label class="required" for="med_pack_qty">Tabs In Pack</label>
                            <input class="form-control {{ $errors->has('med_pack_qty') ? 'is-invalid' : '' }}" type="number" name="med_pack_qty[]" value="{{ old('med_pack_qty') }}" required>
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
