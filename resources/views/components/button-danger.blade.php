@php
    $attributes = $attributes->merge([
        'class' => 'bg-red-500 text-white px-3 py-1 ml-2 rounded-md hover:bg-red-600 focus:ring focus:ring-red-300 cursor-pointer',
        'type' => 'button'
    ]);
@endphp

<button {{ $attributes }} type="button">
    {{ $slot }}
</button>