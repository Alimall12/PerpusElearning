@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#081C15]']) }}>
    {{ $value ?? $slot }}
</label>
