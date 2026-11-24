<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SneakerHub - Sneakers</title>

    @vite(['resources/css/app.css'])

        <style>
                    /* WISHLIST OVERLAY */
        #wishlist-drawer {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 99999;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        #wishlist-drawer:target {
            display: flex;
            justify-content: flex-end;
            align-items: stretch;
        }

        /* RIGHT-SIDE PANEL */
        #wishlist-drawer .wishlist-panel {
            position: relative;
            z-index: 2;
            width: 480px;
            height: 100%;
            box-sizing: border-box;
            overflow-y: auto;
            padding: 28px;
            background: #0b0912;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: -15px 0 50px rgba(0, 0, 0, 0.4);
            animation: wishlist-slide-in 0.25s ease-out;
        }

        /* BACKDROP */
        #wishlist-drawer .wishlist-backdrop {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        /* HEADER */
        #wishlist-drawer .wishlist-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        #wishlist-drawer .wishlist-title {
            margin: 0;
            color: white;
            font-size: 20px;
            font-weight: 800;
        }

        #wishlist-drawer .wishlist-close {
            padding: 7px 14px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 999px;
            color: #d1d5db;
            font-size: 13px;
            text-decoration: none;
        }

        #wishlist-drawer .wishlist-close:hover {
            border-color: #a855f7;
            color: white;
        }

        /* PRODUCT LIST */
        #wishlist-drawer .wishlist-items {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        /* PRODUCT CARD */
        #wishlist-drawer .wishlist-item {
            display: grid;
            grid-template-columns: 76px minmax(0, 1fr) 68px;
            align-items: center;
            gap: 14px;
            width: 100%;
            padding: 14px;
            box-sizing: border-box;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 18px;
            background: #111019;
        }

        /* PRODUCT IMAGE */
        #wishlist-drawer .wishlist-thumb {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 76px;
            height: 60px;
            padding: 6px;
            box-sizing: border-box;
            overflow: hidden;
            border-radius: 12px;
            background: #191522;
        }

        #wishlist-drawer .wishlist-thumb img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* PRODUCT INFORMATION */
        #wishlist-drawer .wishlist-info {
            min-width: 0;
        }

        #wishlist-drawer .wishlist-brand {
            margin: 0 0 3px;
            color: #c084fc;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        #wishlist-drawer .wishlist-name {
            margin: 0 0 6px;
            overflow: hidden;
            color: white;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        #wishlist-drawer .wishlist-price {
            margin: 0;
            color: white;
            font-size: 14px;
            font-weight: 800;
        }

        /* VIEW AND REMOVE */
        #wishlist-drawer .wishlist-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        #wishlist-drawer .wishlist-actions form {
            margin: 0;
        }

        #wishlist-drawer .wishlist-actions button:not(.wishlist-remove) {
            padding: 5px 14px;
            border: none;
            border-radius: 8px;
            background: rgba(168, 85, 247, 0.22);
            color: #d8b4fe;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        #wishlist-drawer .wishlist-actions button:not(.wishlist-remove):hover {
            background: #9333ea;
            color: white;
        }

        #wishlist-drawer .wishlist-actions .wishlist-remove {
            padding: 2px 4px;
            border: none;
            background: transparent;
            color: #71717a;
            font-size: 12px;
            cursor: pointer;
        }

        #wishlist-drawer .wishlist-actions .wishlist-remove:hover {
            color: #f87171;
        }

        /* ANIMATION */
        @keyframes wishlist-slide-in {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
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

        <nav class="hidden items-center gap-8 text-sm font-medium text-gray-300 lg:flex">

            <a href="{{ route('home') }}" class="transition hover:text-purple-400">

                Home

            </a>

            <a href="{{ route('sneakers.index') }}" class="text-purple-400">

                Sneakers

            </a>

            <a href="{{ route('home') }}#brands" class="transition hover:text-purple-400">

                Brands

            </a>

            <a href="{{ route('home') }}#about" class="transition hover:text-purple-400">

                About

            </a>

        </nav>

        <!-- Right-side buttons -->

        <div class="flex items-center gap-3">

            <!-- Cart -->

            <a href="{{ route('cart.index') }}"

                class="rounded-full border border-purple-500/50 px-5 py-2 text-sm font-semibold text-purple-400 transition hover:bg-purple-600 hover:text-white">

                🛒 Cart

                <span class="ml-1 rounded-full bg-purple-600 px-2 py-1 text-xs text-white">

                    {{ collect(session('cart', []))->sum('quantity') }}

                </span>

            </a>

            @auth

                <!-- Wishlist -->

                <a href="{{ route('sneakers.index') }}#wishlist-drawer"

                    class="rounded-full border border-purple-500/50 px-5 py-2 text-sm font-semibold text-purple-400 transition hover:bg-purple-600 hover:text-white">

                    ♡ Wishlist

                    <span class="ml-1 rounded-full bg-purple-600 px-2 py-1 text-xs text-white">

                        {{ $wishlistItems->count() }}

                    </span>

                </a>

                <!-- User profile -->

                <a href="{{ route('dashboard') }}"

                    class="flex items-center gap-2 rounded-full border border-white/20 px-3 py-2 transition hover:border-purple-400">

                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-600 text-sm font-bold text-white">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </span>

                    <span class="max-w-24 truncate text-sm font-semibold text-white">

                        {{ auth()->user()->name }}

                    </span>

                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="rounded-full border border-red-500/40 px-5 py-2 text-sm font-semibold text-red-400 transition hover:bg-red-500 hover:text-white"
                    >
                        Log Out
                    </button>
                </form>

            @else

                <!-- Guest buttons -->

                <a href="{{ route('login') }}"

                    class="rounded-full border border-white/20 px-5 py-2 text-sm font-semibold transition hover:border-purple-400 hover:text-purple-400">

                    Log In

                </a>

                <a href="{{ route('register') }}"

                    class="rounded-full bg-purple-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-purple-500">

                    Sign Up

                </a>

            @endauth

        </div>

    </div>

</header>

    <main class="mx-auto max-w-7xl px-6 py-12">

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

        <!-- =================================== -->

        <!-- PRODUCT DETAILS VIEW -->

        <!-- =================================== -->

        @if ($selectedSneaker)

            @php

                $totalStock = $selectedSneaker->sizes->sum('stock_quantity');

                $imageUrl = $selectedSneaker->image

                    ? (

                        str_starts_with($selectedSneaker->image, 'http')

                            ? $selectedSneaker->image

                            : asset('storage/' . $selectedSneaker->image)

                    )

                    : null;

            @endphp

            <!-- Back button -->

            <form method="POST" action="{{ route('sneakers.action') }}" style="margin-top: 35px; margin-bottom: 32px;">

                @csrf

                <input type="hidden" name="action" value="back">

                <button type="submit"

                    class="rounded-full border border-white/20 px-6 py-3 text-sm font-semibold transition hover:border-purple-400 hover:text-purple-400">

                    &larr; Back to Sneakers

                </button>

            </form>

            <!-- Product information layout -->

            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">

                <!-- Product image -->

                <div class="flex min-h-[420px] items-center justify-center rounded-3xl border border-white/10 bg-[#191522] p-8">

                    @if ($imageUrl)

                        <img

                            src="{{ $imageUrl }}"

                            alt="{{ $selectedSneaker->brand?->name }} {{ $selectedSneaker->name }}"

                            class="max-h-[500px] w-full object-contain"

                        >

                    @else

                        <div class="text-center text-gray-500">

                            <div class="mb-4 text-8xl">&#128095;</div>

                            <p>No image available</p>

                        </div>

                    @endif

                </div>

                <!-- Product details -->

                <div class="flex flex-col justify-center">

                    <!-- Brand -->

                    <p class="mb-3 text-sm font-bold uppercase tracking-[0.2em] text-purple-400">

                        {{ $selectedSneaker->brand?->name ?? 'Sneaker' }}

                    </p>

                    <!-- Sneaker name -->

                    <h1 class="text-4xl font-extrabold">

                        {{ $selectedSneaker->name }}

                    </h1>

                    <!-- Price -->

                    <p class="mt-8 text-4xl font-extrabold">

                        &#8364;{{ number_format((float) $selectedSneaker->price, 2) }}

                    </p>

                    <!-- Stock status -->

                    <div class="mt-5">

                        @if ($totalStock > 0)

                            <span class="rounded-full bg-green-500/10 px-4 py-2 text-sm font-semibold text-green-400">

                                In Stock

                            </span>

                        @else

                            <span class="rounded-full bg-red-500/10 px-4 py-2 text-sm font-semibold text-red-400">

                                Sold Out

                            </span>

                        @endif

                    </div>

                    <!-- Add to Cart form -->

                    <form method="POST" action="{{ route('sneakers.action') }}" class="mt-8">

                        @csrf

                        <input type="hidden" name="action" value="add_to_cart">

                        <input type="hidden" name="sneaker_id" value="{{ $selectedSneaker->id }}">

                    <!-- Shoe size -->

                    <label for="size_id" class="mb-3 block text-sm font-semibold">

                        Choose your EU shoe size

                    </label>

                    <div class="size-select-wrapper" style="position: relative; width: 100%;">

                    <select

                        name="size_id"

                        id="size_id"

                        required

                        style="appearance: none; -webkit-appearance: none; background-image: none;"

                        class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-4 pr-16 text-white outline-none focus:border-purple-500"

                    >

                        <option value="" selected disabled>Choose your size</option>

                        @foreach ($selectedSneaker->sizes->sortBy('size') as $size)

                            <option

                                value="{{ $size->id }}"

                                @disabled($size->stock_quantity <= 0)

                            >

                                EU {{ rtrim(rtrim(number_format((float) $size->size, 1, '.', ''), '0'), '.') }}

                            </option>

                        @endforeach

                    </select>

                    <!-- Arrow square -->

                    <span

                        class="size-arrow-box"

                        style="

                            position: absolute;

                            right: 10px;

                            top: 50%;

                            transform: translateY(-50%);

                            width: 40px;

                            height: 40px;

                            min-width: 40px;

                            display: flex;

                            align-items: center;

                            justify-content: center;

                            box-sizing: border-box;

                            border-radius: 12px;

                            background: #211b2b;

                            pointer-events: none;

                        "

                    >

                        <svg

                            width="20"

                            height="20"

                            viewBox="0 0 24 24"

                            fill="none"

                            stroke="#FFFFFF"

                            stroke-width="2"

                            stroke-linecap="round"

                            stroke-linejoin="round"

                        >

                            <path d="m6 9 6 6 6-6"/>

                        </svg>

                    </span>

                </div>

                        <!-- Add to Cart -->

                        <button

                            type="submit"

                            @disabled($totalStock <= 0)

                            class="mt-6 w-full rounded-full bg-purple-600 px-8 py-4 font-bold transition hover:bg-purple-500 disabled:cursor-not-allowed disabled:opacity-50"

                        >

                            Add to Cart

                        </button>

                    </form>

                @php

                    $isWishlisted = auth()->check() &&

                        $wishlistItems->contains(

                            'sneaker_id',

                            $selectedSneaker->id

                        );

                @endphp

                <!-- Wishlist -->

                <form method="POST" action="{{ route('sneakers.action') }}" class="mt-3">

                    @csrf

                    <input type="hidden" name="action" value="add_to_wishlist">

                    <input type="hidden" name="sneaker_id" value="{{ $selectedSneaker->id }}">

                    <button

                        type="submit"

                        class="w-full rounded-full border border-white/20 px-8 py-4 font-bold transition hover:border-purple-400 hover:text-purple-400 {{ $isWishlisted ? 'border-purple-500 bg-purple-500/10 text-purple-300' : '' }}"

                    >

                        {{ $isWishlisted ? '♥ Saved in Wishlist' : '♡ Add to Wishlist' }}

                    </button>

                </form>

                </div>

            </div>

        <!-- =================================== -->

        <!-- SNEAKER CATALOGUE VIEW -->

        <!-- =================================== -->

        @else

            <!-- Page heading -->

            <div class="mb-12">

                <p class="mb-4 font-semibold uppercase tracking-[0.2em] text-purple-400">

                    SneakerHub Collection

                </p>

                <h1 class="text-4xl font-extrabold tracking-tight md:text-6xl">

                    Explore <span class="text-purple-400">Sneakers.</span>

                </h1>

                <p class="mt-5 max-w-2xl text-lg leading-8 text-gray-400">

                    Discover your next pair from your favourite brands.

                </p>

            </div>

            <!-- Sneaker count -->

            <div class="mb-8 flex items-center justify-between border-b border-white/10 pb-5">

                <h2 class="text-xl font-bold">

                    All Sneakers

                </h2>

                <p class="text-sm text-gray-400">

                    {{ $sneakers->count() }} sneakers

                </p>

            </div>

            <!-- Sneaker cards -->

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                @forelse ($sneakers as $sneaker)

                    @php

                        $totalStock = $sneaker->sizes->sum('stock_quantity');

                        $cardImageUrl = $sneaker->image

                            ? (

                                str_starts_with($sneaker->image, 'http')

                                    ? $sneaker->image

                                    : asset('storage/' . $sneaker->image)

                            )

                            : null;

                    @endphp

                    <!-- Sneaker card -->

                    <form method="POST" action="{{ route('sneakers.action') }}">

                        @csrf

                        <input type="hidden" name="action" value="view">

                        <input type="hidden" name="sneaker_id" value="{{ $sneaker->id }}">

                        <button

                            type="submit"

                            class="group w-full overflow-hidden rounded-2xl border border-white/10 bg-[#111019] text-left transition duration-300 hover:-translate-y-2 hover:border-purple-500/60"

                        >

                            <!-- Product image -->

                            <div class="flex h-64 items-center justify-center overflow-hidden bg-[#191522] p-5">

                                @if ($cardImageUrl)

                                    <img

                                        src="{{ $cardImageUrl }}"

                                        alt="{{ $sneaker->brand?->name }} {{ $sneaker->name }}"

                                        class="h-full w-full object-contain transition duration-500 group-hover:scale-110"

                                    >

                                @else

                                    <div class="text-center text-gray-500">

                                        <div class="mb-3 text-5xl">&#128095;</div>

                                        <p class="text-sm">No image available</p>

                                    </div>

                                @endif

                            </div>

                            <!-- Product information -->

                            <div class="p-6">

                                <!-- Brand -->

                                <p class="mb-2 text-xs font-semibold uppercase tracking-widest text-purple-400">

                                    {{ $sneaker->brand?->name ?? 'Sneaker' }}

                                </p>

                                <!-- Sneaker name -->

                                <h3 class="text-xl font-bold transition group-hover:text-purple-300">

                                    {{ $sneaker->name }}

                                </h3>

                                <!-- Price and stock -->

                                <div class="mt-6 flex items-center justify-between">

                                    <p class="text-2xl font-extrabold">

                                        &#8364;{{ number_format((float) $sneaker->price, 2) }}

                                    </p>

                                    @if ($totalStock > 0)

                                        <span class="rounded-full bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-400">

                                            In Stock

                                        </span>

                                    @else

                                        <span class="rounded-full bg-red-500/10 px-3 py-1 text-xs font-semibold text-red-400">

                                            Sold Out

                                        </span>

                                    @endif

                                </div>

                                <!-- Available stock -->

                                <p class="mt-3 text-xs text-gray-500">

                                    {{ $totalStock }} pairs available

                                </p>

                                <!-- View details -->

                                <p class="mt-6 text-sm font-semibold text-purple-400">

                                    View Details &rarr;

                                </p>

                            </div>

                        </button>

                    </form>

                @empty

                    <div class="col-span-full rounded-3xl border border-white/10 bg-[#111019] px-6 py-20 text-center">

                        <div class="mb-5 text-6xl">&#128095;</div>

                        <h3 class="text-2xl font-bold">

                            No sneakers available yet

                        </h3>

                        <p class="mt-3 text-gray-400">

                            Sneakers will appear here once they are added to the database.

                        </p>

                        <a href="{{ route('home') }}"

                            class="mt-8 inline-block rounded-full bg-purple-600 px-7 py-3 font-bold transition hover:bg-purple-500">

                            Back to Home

                        </a>

                    </div>

                @endforelse

            </div>

        @endif

    </main>

    @auth
            <div id="wishlist-drawer">

                <!-- Background -->
                <a
                    href="{{ route('sneakers.index') }}"
                    class="wishlist-backdrop"
                    aria-label="Close wishlist"
                ></a>

                <!-- Right-side panel -->
                <aside class="wishlist-panel">

                    <!-- Header -->
                    <div class="wishlist-header">

                        <h2 class="wishlist-title">
                            Saved Wishlist ({{ $wishlistItems->count() }})
                        </h2>

                        <a
                            href="{{ route('sneakers.index') }}"
                            class="wishlist-close"
                        >
                            Close &times;
                        </a>

                    </div>

                    <!-- Wishlist products -->
                    <div class="wishlist-items">

                        @forelse ($wishlistItems as $item)

                            @php
                                $wishlistImageUrl = $item->image
                                    ? (
                                        str_starts_with($item->image, 'http')
                                            ? $item->image
                                            : asset('storage/' . $item->image)
                                    )
                                    : null;
                            @endphp

                            <article class="wishlist-item">

                                <!-- Image -->
                                <div class="wishlist-thumb">

                                    @if ($wishlistImageUrl)
                                        <img
                                            src="{{ $wishlistImageUrl }}"
                                            alt="{{ $item->name }}"
                                        >
                                    @else
                                        <span class="text-xl text-gray-500">
                                            &#128095;
                                        </span>
                                    @endif

                                </div>

                                <!-- Product details -->
                                <div class="wishlist-info">

                                    <p class="wishlist-brand">
                                        {{ $item->brand_name ?? 'Sneaker' }}
                                    </p>

                                    <p class="wishlist-name">
                                        {{ $item->name }}
                                    </p>

                                    <p class="wishlist-price">
                                        €{{ number_format((float) $item->price, 2) }}
                                    </p>

                                </div>

                                <!-- Actions -->
                                <div class="wishlist-actions">

                                    <!-- View -->
                                    <form method="POST" action="{{ route('sneakers.action') }}">
                                        @csrf

                                        <input type="hidden" name="action" value="view">
                                        <input type="hidden" name="sneaker_id" value="{{ $item->sneaker_id }}">

                                        <button type="submit">
                                            View
                                        </button>
                                    </form>

                                    <!-- Remove -->
                                    <form method="POST" action="{{ route('sneakers.action') }}">
                                        @csrf

                                        <input type="hidden" name="action" value="remove_from_wishlist">
                                        <input type="hidden" name="sneaker_id" value="{{ $item->sneaker_id }}">

                                        <button type="submit" class="wishlist-remove">
                                            Remove
                                        </button>
                                    </form>

                                </div>

                            </article>

                        @empty

                            <div class="py-16 text-center text-gray-400">
                                <div class="mb-3 text-4xl text-purple-400">♡</div>

                                <p class="font-semibold text-white">
                                    No saved sneakers yet
                                </p>

                                <p class="mt-1 text-sm">
                                    Add a sneaker to your wishlist to see it here.
                                </p>
                            </div>

                        @endforelse

                    </div>

                </aside>

            </div>
            @endauth


    <!-- Footer -->

    <footer class="mt-16 border-t border-white/10">

        <div class="mx-auto max-w-7xl px-6 py-4 text-center text-sm text-gray-500">

            &copy; {{ date('Y') }} SneakerHub. All rights reserved.

        </div>

    </footer>

</body>

</html>
