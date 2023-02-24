@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:ring-0 focus:ring-pink-500 focus:border-pink-500 rounded bg-gray-200 text-gray-600 p-2']) !!}>
    {{ $slot }}
</select>
