@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-primary focus:border-accent focus:ring-accent rounded-md shadow-sm']) }}>
