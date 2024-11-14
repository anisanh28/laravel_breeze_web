<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#ee5006] dark:bg-[#ee5006] border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-[#d84e05] dark:hover:bg-[#d84e05] focus:bg-[#d84e05] dark:focus:bg-[#d84e05] active:bg-[#d84e05] dark:active:bg-[#d84e05] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
