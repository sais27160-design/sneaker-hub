
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SneakerHub - Sneakers</title>

    @vite(['resources/css/app.css'])

    <style>
    .size-select-wrapper .size-arrow-box {
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: border-color 0.2s ease;
    }

    .size-select-wrapper:hover .size-arrow-box,
    .size-select-wrapper:focus-within .size-arrow-box {
        border-color: #A855F7;
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

            <nav class="hidden items-center gap-8 text-sm font-medium text-gray-300 md:flex">
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

             <a href="{{ route('cart.index') }}"
                class="rounded-full border border-purple-500/50 px-5 py-2 text-sm font-semibold text-purple-400 transition hover:bg-purple-600 hover:text-white">

            
                    🛒 Cart

                <span class="ml-1 rounded-full bg-purple-600 px-2 py-1 text-xs text-white">
                    {{ collect(session('cart', []))->sum('quantity') }}
                </span>
            </a>

            <a href="{{ route('home') }}"
                class="rounded-full border border-white/20 px-5 py-2 text-sm transition hover:border-purple-400 hover:text-purple-400">
                Back Home
            </a>

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
            <form method="POST" action="{{ route('sneakers.action') }}" class="mb-8">
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


                    <!-- Wishlist -->
                    <form method="POST" action="{{ route('sneakers.action') }}" class="mt-3">

                        @csrf

                        <input type="hidden" name="action" value="add_to_wishlist">
                        <input type="hidden" name="sneaker_id" value="{{ $selectedSneaker->id }}">

                        <button
                            type="submit"
                            class="w-full rounded-full border border-white/20 px-8 py-4 font-bold transition hover:border-purple-400 hover:text-purple-400"
                        >
                            ♡ Add to Wishlist
                        </button>

                    </form>


                    <!-- Product description -->
                    <details class="mt-8 border-t border-white/10 py-5">

                        <summary class="cursor-pointer font-semibold">
                            Product Details
                        </summary>

                        <p class="mt-4 leading-7 text-gray-400">
                            {{ $selectedSneaker->description ?: 'No product description available.' }}
                        </p>

                    </details>

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


    <!-- Footer -->
    <footer class="mt-16 border-t border-white/10">

        <div class="mx-auto max-w-7xl px-6 py-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} SneakerHub. All rights reserved.
        </div>

    </footer>

</body>
</html>
