@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 focus:border-ocean-500 focus:ring-ocean-500 rounded-xl shadow-sm text-sm transition-colors duration-200']) }}>
