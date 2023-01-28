<select class="form-input rounded-md shadow-sm block w-full" wire:model="value">
    <option value="">{{ $placeholder }}</option>
    @foreach($options as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
