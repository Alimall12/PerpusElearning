@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#FBB02D] text-sm font-medium leading-5 text-[#FBB02D] focus:outline-none focus:border-[#FBB02D] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[#EBF2FA] hover:text-[#038666] hover:border-[#038666] focus:outline-none focus:text-[#038666] focus:border-[#038666] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
