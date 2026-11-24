<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SneakerHub - Shopping Cart</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-[#08070d] text-white">

    <!-- Navigation -->
    <header class="border-b border-white/10 bg-[#0b0912]">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6">

            <a href="{{ route('home') }}" class="text-2xl font-extrabold">
                Sneaker<span class="text-purple-400">Hub</span>
            </a>

            <nav class="flex items-center gap-6 text-sm font-medium text-gray-300">
                <a href="{{ route('home') }}" class="transition hover:text-purple-400">
                    Home
                </a>

                <a href="{{ route('sneakers.index') }}" class="transition hover:text-purple-400">
                    Continue Shopping
                </a>

                <a href="{{ route('cart.index') }}" class="text-purple-400">
                    Cart
                </a>
            </nav>

        </div>
    </header>


    <main class="mx-auto max-w-7xl px-6 py-12">

        <!-- Page heading -->
        <div class="mb-10">
            <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-purple-400">
                Your Shopping Bag
            </p>

            <h1 class="text-4xl font-extrabold md:text-5xl">
                Shopping Cart<span class="text-purple-400">.</span>
            </h1>

            <p class="mt-4 text-gray-400">
                Review your sneakers before checkout.
            </p>
        </div>


        <!-- Success message -->
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-green-400">
                {{ session('success') }}
            </div>
        @endif


        <!-- Error messages -->
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-400">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif


        @if ($cartItems->isNotEmpty())

            <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-3">

                <!-- LEFT: Cart items -->
                <section class="space-y-5 lg:col-span-2">

                    <div class="flex items-center justify-between border-b border-white/10 pb-5">
                        <h2 class="text-xl font-bold">
                            Your Items
                        </h2>

                        <p class="text-sm text-gray-400">
                            {{ $cartItems->sum('quantity') }} items
                        </p>
                    </div>


                    @foreach ($cartItems as $item)

                        @php
                            $imageUrl = $item['sneaker']->image
                                ? (
                                    str_starts_with($item['sneaker']->image, 'http')
                                        ? $item['sneaker']->image
                                        : asset('storage/' . $item['sneaker']->image)
                                )
                                : null;
                        @endphp


                        <div class="rounded-2xl border border-white/10 bg-[#111019] p-5">

                            <div class="flex flex-col gap-6 sm:flex-row">

                                <!-- Product image -->
                                <div class="flex h-36 w-full flex-shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#191522] p-3 sm:w-40">

                                    @if ($imageUrl)

                                        <img
                                            src="{{ $imageUrl }}"
                                            alt="{{ $item['sneaker']->name }}"
                                            class="h-full w-full object-contain"
                                        >

                                    @else

                                        <span class="text-5xl">&#128095;</span>

                                    @endif

                                </div>


                                <!-- Product information -->
                                <div class="flex flex-1 flex-col justify-between">

                                    <div>

                                        <p class="text-xs font-semibold uppercase tracking-widest text-purple-400">
                                            {{ $item['sneaker']->brand?->name ?? 'Sneaker' }}
                                        </p>

                                        <h3 class="mt-2 text-xl font-bold">
                                            {{ $item['sneaker']->name }}
                                        </h3>

                                        <p class="mt-2 text-sm text-gray-400">
                                            EU Size:
                                            {{ rtrim(rtrim(number_format((float) $item['size']->size, 1, '.', ''), '0'), '.') }}
                                        </p>

                                        <p class="mt-2 text-lg font-bold">
                                            &#8364;{{ number_format($item['unit_price'], 2) }}
                                        </p>

                                    </div>


                                    <!-- Quantity and remove -->
                                    <div class="mt-5 flex flex-wrap items-center justify-between gap-4">

                                        
                                    <!-- Quantity controls -->
                                    <div class="flex items-center gap-2">

                                        <span class="mr-2 text-sm text-gray-400">
                                            Quantity
                                        </span>

                                        <!-- Decrease or Remove -->
                                        @if ($item['quantity'] <= 1)

                                            <form method="POST" action="{{ route('cart.remove') }}">
                                                @csrf
                                                <input type="hidden" name="key" value="{{ $item['key'] }}">

                                                <button
                                                    type="submit"
                                                    title="Remove item"
                                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-red-500/40 text-red-400 hover:bg-red-500 hover:text-white"
                                                >
                                                    &minus;
                                                </button>
                                            </form>

                                        @else

                                            <form method="POST" action="{{ route('cart.update') }}">
                                                @csrf
                                                <input type="hidden" name="key" value="{{ $item['key'] }}">
                                                <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">

                                                <button
                                                    type="submit"
                                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/20 hover:border-purple-400"
                                                >
                                                    &minus;
                                                </button>
                                            </form>

                                        @endif

                                        <!-- Quantity number -->
                                        <span class="min-w-8 text-center text-base font-bold text-white">
                                            {{ $item['quantity'] }}
                                        </span>

                                        <!-- Increase -->
                                        <form method="POST" action="{{ route('cart.update') }}">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $item['key'] }}">
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">

                                            <button
                                                type="submit"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/20 hover:border-purple-400"
                                            >
                                                +
                                            </button>
                                        </form>

                                    </div>



                                        <!-- Remove -->
                                        <form method="POST" action="{{ route('cart.remove') }}">
                                            @csrf

                                            <input type="hidden" name="key" value="{{ $item['key'] }}">

                                            <button
                                                type="submit"
                                                class="text-sm font-semibold text-red-400 transition hover:text-red-300"
                                            >
                                                Remove
                                            </button>
                                        </form>

                                    </div>

                                </div>


                                <!-- Item total -->
                                <div class="flex items-start justify-end sm:w-28">
                                    <p class="text-lg font-extrabold">
                                        &#8364;{{ number_format($item['line_total'], 2) }}
                                    </p>
                                </div>

                            </div>

                        </div>

                    @endforeach


                    <!-- Continue shopping -->
                    <a href="{{ route('sneakers.index') }}"
                        class="inline-flex items-center gap-2 pt-3 text-sm font-semibold text-purple-400 transition hover:text-purple-300">
                        &larr; Continue Shopping
                    </a>

                </section>


                <!-- RIGHT: Order summary -->
                <aside class="rounded-2xl border border-white/10 bg-[#111019] p-6 lg:sticky lg:top-8">

                    <h2 class="mb-6 text-xl font-bold">
                        Order Summary
                    </h2>


                    <!-- Subtotal -->
                    <div class="flex items-center justify-between border-b border-white/10 pb-5">
                        <span class="text-sm text-gray-400">
                            Subtotal
                        </span>

                        <span class="font-semibold">
                            &#8364;{{ number_format($subtotal, 2) }}
                        </span>
                    </div>


                    <!-- Shipping -->
                    <div class="flex items-center justify-between border-b border-white/10 py-5">
                        <span class="text-sm text-gray-400">
                            Shipping
                        </span>

                        <span class="text-sm text-gray-400">
                            Calculated at checkout
                        </span>
                    </div>


                    <!-- Total -->
                    <div class="flex items-center justify-between py-6">
                        <span class="text-lg font-bold">
                            Total before shipping
                        </span>

                        <span class="text-2xl font-extrabold">
                            &#8364;{{ number_format($subtotal, 2) }}
                        </span>
                    </div>


                    <!-- Checkout -->
                    <button
                        type="button"
                        disabled
                        class="w-full cursor-not-allowed rounded-full bg-purple-600 px-6 py-4 font-bold text-white opacity-60"
                    >
                        Checkout Coming Next
                    </button>

                    <p class="mt-4 text-center text-xs leading-6 text-gray-500">
                        Shipping and applicable taxes will be calculated during checkout.
                    </p>


                    <!-- Secure shopping -->
                    <div class="mt-6 border-t border-white/10 pt-5 text-center text-xs text-gray-500">
                        <span>&#128274;</span>
                        Secure shopping with SneakerHub
                    </div>

                </aside>

            </div>


        @else

            <!-- Empty cart -->
            <div class="rounded-3xl border border-white/10 bg-[#111019] px-6 py-20 text-center">

                <div class="mb-6 text-7xl">&#128722;</div>

                <h2 class="text-2xl font-bold">
                    Your cart is empty
                </h2>

                <p class="mt-3 text-gray-400">
                    You haven't added any sneakers to your cart yet.
                </p>

                <a href="{{ route('sneakers.index') }}"
                    class="mt-8 inline-block rounded-full bg-purple-600 px-8 py-4 font-bold transition hover:bg-purple-500">
                    Explore Sneakers
                </a>

            </div>

        @endif

    </main>


    <!-- Footer -->
    <footer class="mt-16 border-t border-white/10">
        <div class="mx-auto max-w-7xl px-6 py-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} SneakerHub. All rights reserved.
        </div>
    </footer>

</body>
</html>
