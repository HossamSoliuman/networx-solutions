@props(['field'])

@error($field)
    <p id="{{ $field }}-error" class="mt-1.5 text-xs font-medium text-red-600" role="alert">{{ $message }}</p>
@else
    <span id="{{ $field }}-error" class="sr-only"></span>
@enderror
