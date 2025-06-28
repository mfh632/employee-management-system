@php
    $attributes = $attributes->merge([
        'class' => 'bg-emerald-500 text-white px-3 py-1 ml-2 rounded-md hover:bg-emerald-600 focus:ring focus:ring-emerald-300 cursor-pointer',
        'type' => 'button'
    ]);
@endphp

<button {{ $attributes }} type="button">
    {{ $slot }}
</button>