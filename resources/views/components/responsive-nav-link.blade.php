@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#FBB02D] text-start text-base font-medium text-[#FBB02D] bg-[#1B4322] focus:outline-none focus:text-[#FBB02D] focus:bg-[#1B4322] focus:border-[#FBB02D] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[#EBF2FA] hover:text-[#038666] hover:bg-[#1B4322] hover:border-[#038666] focus:outline-none focus:text-[#038666] focus:bg-[#1B4322] focus:border-[#038666] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
