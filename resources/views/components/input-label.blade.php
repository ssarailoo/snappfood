@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-pink-600']) }}>
    {{ $value ?? $slot }}
</label>
