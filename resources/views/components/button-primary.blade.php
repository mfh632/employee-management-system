@php
    $attributes = $attributes->merge([
        'class' => 'bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 focus:ring focus:ring-blue-300 cursor-pointer',
        'type' => 'button'
    ]);
@endphp

<button {{ $attributes }}>
    {{ $slot }}
</button>