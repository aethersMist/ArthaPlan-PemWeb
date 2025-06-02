<button {{ $attributes->merge(['type' => 'button', 'class' => 'flex items-center justify-center px-4 py-2 text-light bg-primary rounded hover:bg-accent transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
