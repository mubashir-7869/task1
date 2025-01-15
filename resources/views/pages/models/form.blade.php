{{ Form::open(['url' => $action, 'method' => $method]) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <!-- Model Name -->
            <div class="form-group">
                {{ Form::label('name', 'Model Name', ['class' => 'col-form-label']) }}
                {{ Form::text('name', old('name', $row->name ?? ''), ['class' => 'form-control', 'required' => 'required']) }}
            </div>

            <!-- Brand Name -->
            <div class="form-group mt-3">
                {{ Form::label('brand_name', 'Brand Name', ['class' => 'col-form-label']) }}
                {{ Form::select('brand_id', $brands->pluck('name', 'id')->toArray(), old('brand_id', $row->brand_id ?? null), ['class' => 'form-control', 'placeholder' => 'Select Brand', 'required' => 'required']) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <!-- Cancel Button -->
    {{ Form::button('Cancel', ['class' => 'btn btn-light', 'data-bs-dismiss' => 'modal']) }}
<<<<<<< HEAD

    <!-- Submit Button (either "Create" or "Update" based on the context) -->
=======
<<<<<<< HEAD

    <!-- Submit Button (either "Create" or "Update" based on the context) -->
=======
>>>>>>> e4491ad02c969cb118a302ba4fe54e8255d2e498
>>>>>>> 013a8dde3db08e069247b22a6fa0da7d4396f557
    {{ Form::submit(isset($row) ? __('Update') : __('Create'), ['class' => 'btn btn-primary']) }}
</div>
{{ Form::close() }}
