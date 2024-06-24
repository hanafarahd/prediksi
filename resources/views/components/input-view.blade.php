@props(['label', 'id', 'value' => ''])

<div class="col-sm-6">
    <div class="mb-3">
        <label class="form-label">{{ $label }}</label>
        <input type="text" class="form-control" id={{ $id }} value={{ $value }} disabled>
    </div>
</div>
