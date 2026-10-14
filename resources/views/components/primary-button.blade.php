<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-[#FBB02D] border border-transparent rounded-md font-semibold text-sm text-[#081C15] hover:bg-[#d89a26] focus:bg-[#d89a26] active:bg-[#c08820] focus:outline-none focus:ring-2 focus:ring-[#038666] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
