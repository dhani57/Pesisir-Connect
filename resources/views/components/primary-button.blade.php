<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-ocean-500 to-ocean-600 border border-transparent rounded-xl font-semibold text-sm text-white shadow-sm shadow-ocean-500/30 hover:from-ocean-600 hover:to-ocean-700 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:ring-offset-2 active:scale-95 transition-all duration-200']) }}>
    {{ $slot }}
</button>
