@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'text-gray-300 shadow appearance-none dark:bg-base border rounded w-full py-2 px-3 mb-2 leading-tight focus:outline-none focus:shadow-outline']) !!}>
