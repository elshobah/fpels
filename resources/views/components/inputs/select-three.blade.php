<div class="@error($note_id) has-error @enderror">
    @if ($label)
        <label for="{{ $note_id }}" class="text-capitalize">{{ $label }}
            @if ($required)
                <small class="required text-danger">*</small>
            @endif
        </label>
    @endif
    <div class="custom-select-icon">
        <select id="{{ $note_id }}" {{ $attributes->wire('model') }} class="custom-select"
            name="{{ $note_id }}">
            <option></option>
            @if (!empty($items))
                @foreach ($items as $item)
                    <option value="{{ $item[$key] }}">
                        {{ $item[$text] }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>
@error($note_id)
    <small style="color: #dc3545">{{ $message }}</small>
@enderror
