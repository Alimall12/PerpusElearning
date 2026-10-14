@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#038666] focus:border-[#038666] focus:ring-[#038666] rounded-md shadow-sm']) }}>
