@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-silver']) }}>
    {{ $value ?? $slot }}
</label>
