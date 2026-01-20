@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gold/30 focus:border-gold focus:ring-gold rounded-md shadow-sm']) }}>
