<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</button>
