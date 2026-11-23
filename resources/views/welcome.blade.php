
@vite(['resources/css/app.css'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SneakerHub | Discover Your Next Sneakers</title>

    @vite(['resources/css/app.css'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
          rel="stylesheet">
</head>

<body class="bg-[#09090f] text-white"
      style="font-family: 'Inter', sans-serif;">

    <!-- NAVIGATION -->
    <header class="sticky top-0 z-50 border-b border-white/10 bg-[#09090f]/90 backdrop-blur-xl">

        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">

            <!-- Logo -->
            <a href="/" class="text-2xl font-black tracking-tight">
                Sneaker<span class="text-purple-400">Hub</span>
            </a>

            <!-- Navigation links -->
            <div class="hidden items-center gap-8 text-sm font-medium text-gray-300 md:flex">
                <a href="/" class="transition hover:text-purple-400">Home</a>
                <a href="{{ route('sneakers.index') }}" class="transition hover:text-purple-400">Sneakers</a>
                <a href="#brands" class="transition hover:text-purple-400">Brands</a>
                <a href="#about" class="transition hover:text-purple-400">About</a>
            </div>

            <!-- Authentication buttons -->
            <div class="flex items-center gap-3">

                <a href="/login"
                   class="hidden rounded-full px-5 py-2.5 text-sm font-semibold transition hover:bg-white/10 sm:block">
                    Login
                </a>

                <a href="/register"
                   class="rounded-full bg-purple-600 px-5 py-2.5 text-sm font-bold transition hover:bg-purple-500">
                    Sign Up
                </a>

            </div>

        </nav>
    </header>


    <!-- HERO SECTION -->
    <main>

        <section class="relative overflow-hidden">

            <!-- Background effects -->
            <div class="absolute -left-40 top-20 h-96 w-96 rounded-full bg-purple-700/20 blur-[120px]"></div>

            <div class="absolute -right-40 bottom-0 h-96 w-96 rounded-full bg-blue-600/10 blur-[120px]"></div>

            <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 py-20 md:grid-cols-2 md:py-32">

                <!-- Hero text -->
                <div>

                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-purple-400/30 bg-purple-500/10 px-4 py-2 text-sm text-purple-300">
                        <span class="h-2 w-2 rounded-full bg-purple-400"></span>
                        Your sneaker destination
                    </div>

                    <h1 class="text-5xl font-black leading-tight tracking-tight sm:text-6xl lg:text-7xl">
                        Find Your
                        <span class="block text-purple-400">Next Pair.</span>
                    </h1>

                    <p class="mt-6 max-w-lg text-lg leading-8 text-gray-400">
                        Discover iconic sneakers, explore your favorite brands,
                        and find the perfect pair to match your style.
                    </p>

                    <div class="mt-10 flex flex-wrap gap-4">

                       <a href="/sneakers"
                            class="rounded-full bg-purple-600 px-8 py-4 font-bold transition hover:-translate-y-1 hover:bg-purple-500">
                            Explore Sneakers →
                        </a>

                        <a href="#featured"
                           class="rounded-full border border-white/20 px-8 py-4 font-semibold transition hover:border-purple-400 hover:bg-white/5">
                            Discover More
                        </a>

                    </div>

                    <!-- Store highlights -->
                    <div class="mt-14 flex flex-wrap gap-10 border-t border-white/10 pt-8">

                        <div>
                            <h3 class="text-2xl font-bold">Top Brands</h3>
                            <p class="mt-1 text-sm text-gray-500">Explore your favorites</p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold">Your Wishlist</h3>
                            <p class="mt-1 text-sm text-gray-500">Save your next pair</p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold">Easy Shopping</h3>
                            <p class="mt-1 text-sm text-gray-500">Simple and convenient</p>
                        </div>

                    </div>

                </div>


                <!-- Hero image -->
                <div class="relative">

                    <div class="absolute inset-0 rounded-3xl bg-purple-600/20 blur-3xl"></div>

                    <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-[#242033] to-[#111116] p-4 shadow-2xl">

                        <img
                            src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1200&q=85"
                            alt="Red sneaker"
                            class="h-[350px] w-full rounded-2xl object-cover sm:h-[450px]"
                        >

                        <div class="absolute bottom-8 left-8 right-8 rounded-2xl border border-white/10 bg-black/70 p-5 backdrop-blur-xl">

                            <p class="text-sm font-medium text-purple-300">
                                SNEAKER CULTURE
                            </p>

                            <h2 class="mt-2 text-2xl font-bold">
                                Step Into Your Style
                            </h2>

                            <p class="mt-2 text-sm text-gray-400">
                                Every pair tells a story.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- FEATURED SNEAKERS -->
        <section id="featured" class="border-t border-white/10 bg-[#0e0e16] py-24">

            <div class="mx-auto max-w-7xl px-6">

                <div class="mb-12 flex flex-wrap items-end justify-between gap-6">

                    <div>
                        <p class="mb-3 font-semibold uppercase tracking-[0.2em] text-purple-400">
                            The Collection
                        </p>

                        <h2 class="text-4xl font-black sm:text-5xl">
                            Featured Sneakers
                        </h2>

                        <p class="mt-4 text-gray-400">
                            Discover sneakers that stand out.
                        </p>
                    </div>

                    <a href="{{ route('sneakers.index') }}"
                        class="font-semibold text-purple-400 transition hover:text-purple-300">
                        View All Sneakers →
                    </a>

                </div>


                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                    <!-- Sneaker 1 -->
                    <div class="group overflow-hidden rounded-3xl border border-white/10 bg-[#171720] transition hover:-translate-y-2 hover:border-purple-400/40">

                        <div class="overflow-hidden bg-[#22222c]">

                            <img
                                src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80"
                                alt="Red sneaker"
                                class="h-64 w-full object-cover transition duration-500 group-hover:scale-110"
                            >

                        </div>

                        <div class="p-6">

                            <p class="text-sm text-purple-400">Nike</p>

                            <h3 class="mt-2 text-xl font-bold">
                                Air Collection
                            </h3>

                            <div class="mt-5 flex items-center justify-between">

                                <span class="text-lg font-bold">Explore</span>

                                <a href="{{ route('sneakers.index') }}"
                                    class="rounded-full bg-white/10 px-5 py-2 text-sm font-semibold transition hover:bg-purple-600">
                                        View →
                                </a>

                            </div>

                        </div>

                    </div>


                    <!-- Sneaker 2 -->
                    <div class="group overflow-hidden rounded-3xl border border-white/10 bg-[#171720] transition hover:-translate-y-2 hover:border-purple-400/40">

                        <div class="overflow-hidden bg-[#22222c]">

                            <img
                                src="https://images.unsplash.com/photo-1552346154-21d32810aba3?auto=format&fit=crop&w=800&q=80"
                                alt="Stylish white sneaker"
                                class="h-64 w-full object-cover transition duration-500 group-hover:scale-110"
                            >

                        </div>

                        <div class="p-6">

                            <p class="text-sm text-purple-400">Streetwear</p>

                            <h3 class="mt-2 text-xl font-bold">
                                Everyday Sneakers
                            </h3>

                            <div class="mt-5 flex items-center justify-between">

                                <span class="text-lg font-bold">Explore</span>

                                <a href="/login"
                                   class="rounded-full bg-white/10 px-5 py-2 text-sm font-semibold transition hover:bg-purple-600">
                                    View →
                                </a>

                            </div>

                        </div>

                    </div>


                    <!-- Sneaker 3 -->
                    <div class="group overflow-hidden rounded-3xl border border-white/10 bg-[#171720] transition hover:-translate-y-2 hover:border-purple-400/40">

                        <div class="overflow-hidden bg-[#22222c]">

                            <img
                                src="https://images.unsplash.com/photo-1495555961986-6d4c1ecb7be3?auto=format&fit=crop&w=800&q=80"
                                alt="Classic sneaker"
                                class="h-64 w-full object-cover transition duration-500 group-hover:scale-110"
                            >

                        </div>

                        <div class="p-6">

                            <p class="text-sm text-purple-400">Classic Style</p>

                            <h3 class="mt-2 text-xl font-bold">
                                Timeless Collection
                            </h3>

                            <div class="mt-5 flex items-center justify-between">

                                <span class="text-lg font-bold">Explore</span>

                                <a href="/login"
                                   class="rounded-full bg-white/10 px-5 py-2 text-sm font-semibold transition hover:bg-purple-600">
                                    View →
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- BRANDS -->
        <section id="brands" class="py-20">

            <div class="mx-auto max-w-7xl px-6 text-center">

                <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-purple-400">
                    Our Brands
                </p>

                <h2 class="text-3xl font-black sm:text-4xl">
                    Explore Your Favorite Brands
                </h2>

                <div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-4">

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-8 text-xl font-black transition hover:border-purple-400/40 hover:bg-purple-500/10">
                        NIKE
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-8 text-xl font-black transition hover:border-purple-400/40 hover:bg-purple-500/10">
                        ADIDAS
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-8 text-xl font-black transition hover:border-purple-400/40 hover:bg-purple-500/10">
                        PUMA
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-8 text-xl font-black transition hover:border-purple-400/40 hover:bg-purple-500/10">
                        NEW BALANCE
                    </div>

                </div>

            </div>

        </section>


        <!-- ABOUT / CTA -->
        <section id="about" class="px-6 py-20">

            <div class="mx-auto max-w-7xl overflow-hidden rounded-3xl bg-gradient-to-r from-purple-700 to-indigo-700 px-8 py-16 text-center sm:px-16">

                <h2 class="text-4xl font-black sm:text-5xl">
                    Your Next Favorite Pair Awaits.
                </h2>

                <p class="mx-auto mt-6 max-w-2xl text-lg text-purple-100">
                    Join SneakerHub and discover a world of sneakers,
                    brands, and styles.
                </p>

                <a href="/register"
                   class="mt-8 inline-block rounded-full bg-white px-8 py-4 font-bold text-purple-700 transition hover:-translate-y-1 hover:bg-gray-100">
                    Create Your Account →
                </a>

            </div>

        </section>

    </main>


    <!-- FOOTER -->
    <footer class="border-t border-white/10 bg-[#07070b]">

        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-6 px-6 py-10 sm:flex-row sm:items-center">

            <div>
                <a href="/" class="text-xl font-black">
                    Sneaker<span class="text-purple-400">Hub</span>
                </a>

                <p class="mt-2 text-sm text-gray-500">
                    Discover. Collect. Share your sneakers.
                </p>
            </div>

            <div class="flex gap-6 text-sm text-gray-400">

                <a href="/login" class="transition hover:text-white">
                    Login
                </a>

                <a href="/register" class="transition hover:text-white">
                    Register
                </a>

            </div>

        </div>

        <div class="border-t border-white/5 py-5 text-center text-sm text-gray-600">
            © {{ date('Y') }} SneakerHub. All rights reserved.
        </div>

    </footer>

</body>
</html>
