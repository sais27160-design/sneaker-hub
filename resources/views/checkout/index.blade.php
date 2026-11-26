<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SneakerHub - Checkout</title>

    @vite(['resources/css/app.css'])

    <style>
    .checkout-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(320px, 1fr);
        gap: 32px;
        align-items: start;
    }

    .checkout-summary-item {
        display: grid;
        grid-template-columns: 88px minmax(0, 1fr);
        gap: 16px;
        align-items: start;
        width: 100%;
    }

    .checkout-product-image {
        width: 88px;
        height: 88px;
        min-width: 88px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #191522;
        padding: 8px;
    }

    .checkout-product-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    .checkout-product-info {
        min-width: 0;
        overflow-wrap: anywhere;
    }

    @media (max-width: 900px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
    }
</style>

</head>

<body class="min-h-screen bg-[#08070d] text-white">

    <!-- Navigation -->
    <header class="border-b border-white/10 bg-[#0b0912]">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6">

            <a href="{{ route('home') }}" class="text-2xl font-extrabold">
                Sneaker<span class="text-purple-400">Hub</span>
            </a>

            <nav class="flex items-center gap-6 text-sm font-medium text-gray-300">
                <a href="{{ route('sneakers.index') }}" class="transition hover:text-purple-400">
                    Sneakers
                </a>

                <a href="{{ route('cart.index') }}" class="text-purple-400">
                    Shopping Cart
                </a>
            </nav>

        </div>
    </header>


    <main class="mx-auto max-w-7xl px-6 py-12">

        <!-- Heading -->
        <div class="mb-10">
            <p class="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-purple-400">
                Almost There
            </p>

            <h1 class="text-4xl font-extrabold md:text-5xl">
                Checkout<span class="text-purple-400">.</span>
            </h1>

            <p class="mt-4 text-gray-400">
                Enter your delivery details and review your order.
            </p>
        </div>


       <!-- Validation errors -->
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-400">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Checkout layout -->
            <div class="checkout-layout">

                <!-- LEFT: Delivery information -->
                <section>

                    <div class="rounded-2xl border border-white/10 bg-[#111019] p-6 md:p-8">

                        <h2 class="mb-2 text-2xl font-bold">
                            Delivery Information
                        </h2>

                        <p class="mb-8 text-sm text-gray-400">
                            Where should we deliver your sneakers?
                        </p>


                    <form method="POST" action="{{ route('checkout.store') }}">

                        @csrf

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                            <!-- Customer name -->
                            <div class="md:col-span-2">
                                <label for="customer_name"
                                    class="mb-2 block text-sm font-semibold">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    name="customer_name"
                                    id="customer_name"
                                    value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                                    placeholder="Enter your full name"
                                    required
                                    maxlength="255"
                                    class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-4 text-white outline-none transition placeholder:text-gray-500 focus:border-purple-500"
                                >
                            </div>


                            <!-- Email -->
                            <div>
                                <label for="customer_email"
                                    class="mb-2 block text-sm font-semibold">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    name="customer_email"
                                    id="customer_email"
                                    value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                                    placeholder="example@email.com"
                                    required
                                    maxlength="255"
                                    class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-4 text-white outline-none transition placeholder:text-gray-500 focus:border-purple-500"
                                >
                            </div>


                            <!-- Phone -->
                            <div>
                                <label for="phone"
                                    class="mb-2 block text-sm font-semibold">
                                    Phone Number
                                </label>

                                <input
                                    type="tel"
                                    name="phone"
                                    id="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="Enter your phone number"
                                    required
                                    maxlength="30"
                                    class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-4 text-white outline-none transition placeholder:text-gray-500 focus:border-purple-500"
                                >
                            </div>


                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="shipping_address"
                                    class="mb-2 block text-sm font-semibold">
                                    Street Address
                                </label>

                                <textarea
                                    name="shipping_address"
                                    id="shipping_address"
                                    rows="3"
                                    placeholder="Street, building number, apartment..."
                                    required
                                    maxlength="1000"
                                    class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-4 text-white outline-none transition placeholder:text-gray-500 focus:border-purple-500"
                                >{{ old('shipping_address') }}</textarea>
                            </div>


                            <!-- City -->
                            <div>
                                <label for="shipping_city"
                                    class="mb-2 block text-sm font-semibold">
                                    City
                                </label>

                                <input
                                    type="text"
                                    name="shipping_city"
                                    id="shipping_city"
                                    value="{{ old('shipping_city') }}"
                                    placeholder="Enter your city"
                                    required
                                    maxlength="100"
                                    class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-4 text-white outline-none transition placeholder:text-gray-500 focus:border-purple-500"
                                >
                            </div>


                            <!-- Postal code -->
                            <div>
                                <label for="shipping_postal_code"
                                    class="mb-2 block text-sm font-semibold">
                                    Postal Code
                                </label>

                                <input
                                    type="text"
                                    name="shipping_postal_code"
                                    id="shipping_postal_code"
                                    value="{{ old('shipping_postal_code') }}"
                                    placeholder="Enter postal code"
                                    required
                                    maxlength="20"
                                    class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-4 text-white outline-none transition placeholder:text-gray-500 focus:border-purple-500"
                                >
                            </div>


                            <!-- Country -->
                            <div class="md:col-span-2">
                                <label for="shipping_country"
                                    class="mb-2 block text-sm font-semibold">
                                    Country
                                </label>

                                <input
                                    type="text"
                                    name="shipping_country"
                                    id="shipping_country"
                                    value="{{ old('shipping_country') }}"
                                    placeholder="Enter your country"
                                    required
                                    maxlength="100"
                                    class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-4 text-white outline-none transition placeholder:text-gray-500 focus:border-purple-500"
                                >
                            </div>

                        </div>


                        <!-- Buttons -->
                        <div class="mt-8 flex flex-col gap-4 sm:flex-row">

                            <a href="{{ route('cart.index') }}"
                                class="flex-1 rounded-full border border-white/20 px-6 py-4 text-center font-semibold transition hover:border-purple-400 hover:text-purple-400">
                                &larr; Back to Cart
                            </a>

                            <button
                                type="submit"
                                class="flex-1 rounded-full bg-purple-600 px-6 py-4 font-bold transition hover:bg-purple-500"
                            >
                                Place Order
                            </button>

                        </div>

                    </form>

                </div>

            </section>


            <!-- RIGHT: Order summary -->
            <aside class="rounded-2xl border border-white/10 bg-[#111019] p-6 lg:sticky lg:top-8">

                <h2 class="mb-6 text-xl font-bold">
                    Order Summary
                </h2>


                <!-- Products -->
                <div class="space-y-5">

                    
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

                    <div style="
                        display: flex;
                        align-items: flex-start;
                        gap: 16px;
                        width: 100%;
                        min-width: 0;
                        box-sizing: border-box;
                    ">

                        <!-- Product thumbnail -->
                        <div style="
                            width: 88px;
                            height: 88px;
                            min-width: 88px;
                            flex: 0 0 88px;
                            padding: 8px;
                            box-sizing: border-box;
                            overflow: hidden;
                            border-radius: 12px;
                            background: #191522;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">

                            @if ($imageUrl)
                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $item['sneaker']->name }}"
                                    style="
                                        width: 100%;
                                        height: 100%;
                                        object-fit: contain;
                                        display: block;
                                    "
                                >
                            @else
                                <span style="font-size: 30px;">&#128095;</span>
                            @endif

                        </div>

                        <!-- Product information -->
                        <div style="
                            flex: 1;
                            min-width: 0;
                            overflow-wrap: anywhere; ">

                            <p class="text-xs font-semibold uppercase tracking-widest text-purple-400">
                                {{ $item['sneaker']->brand?->name ?? 'Sneaker' }}
                            </p>

                            <p class="mt-1 font-bold text-white">
                                {{ $item['sneaker']->name }}
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                EU {{ rtrim(rtrim(number_format((float) $item['size']->size, 1, '.', ''), '0'), '.') }}
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                Quantity: {{ $item['quantity'] }}
                            </p>

                            <p class="mt-2 font-semibold text-white">
                                &#8364;{{ number_format($item['line_total'], 2) }}
                            </p>

                        </div>

                    </div>

                @endforeach


                </div>


                <div class="my-6 border-t border-white/10"></div>


                <!-- Subtotal -->
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-400">
                        Subtotal
                    </span>

                    <span class="font-semibold">
                        &euro;{{ number_format($subtotal, 2) }}
                    </span>
                </div>


                <!-- Shipping -->
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-sm text-gray-400">
                        Shipping
                    </span>

                    <span class="text-sm text-gray-400">
                        €3.99
                    </span>
                </div>


                <!-- Total -->
                <div class="mt-6 flex items-center justify-between border-t border-white/10 pt-6">

                    <span class="text-lg font-bold">
                        Total
                    </span>

                    <span class="text-2xl font-extrabold">
                        &#8364;{{ number_format($subtotal + 3.99, 2) }}
                    </span>

                </div>


                <p class="mt-4 text-xs leading-6 text-gray-500">
                    A fixed shipping fee of €3.99 is included in this total. This project currently records orders without processing online payments.
                </p>


                <div class="mt-6 border-t border-white/10 pt-5 text-center text-xs text-gray-500">
                    &#128274; Secure order submission
                </div>

            </aside>

        </div>

    </main>


    <!-- Footer -->
    <footer class="mt-16 border-t border-white/10">
        <div class="mx-auto max-w-7xl px-6 py-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} SneakerHub. All rights reserved.
        </div>
    </footer>

</body>
</html>
