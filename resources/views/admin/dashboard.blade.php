<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SneakerHub Admin</title>
    @vite(['resources/css/app.css'])
    <style>
    .delete-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        background: rgba(0, 0, 0, 0.75);
    }

    .delete-modal:target {
        display: flex;
    }

    .delete-modal-backdrop {
        position: absolute;
        inset: 0;
    }

    .delete-modal-content {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 28rem;
        padding: 1.75rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 1rem;
        background: #111019;
    }
</style>
</head>
<body class="min-h-screen bg-[#08070d] text-white">

    <!-- Header -->
    <header class="border-b border-white/10 bg-[#0b0912]">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-8 py-5">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-extrabold">
                    Sneaker<span class="text-purple-400">Hub</span>
                </a>
                <span class="rounded-full bg-purple-500/15 px-3 py-1 text-xs font-bold text-purple-300">Admin</span>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('sneakers.index') }}" class="rounded-full border border-white/20 px-5 py-2 text-sm font-semibold transition hover:border-purple-400 hover:text-purple-300">
                    View Store &rarr;
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full border border-red-500/40 px-5 py-2 text-sm font-semibold text-red-400 transition hover:bg-red-500 hover:text-white">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-8 py-12">

        <!-- Page heading -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold">Store <span class="text-purple-400">Overview</span></h1>
            <p class="mt-2 text-gray-400">Manage your sneakers, stock, and prices in one place.</p>
        </div>

        <!-- Success and error messages -->
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-400">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-400">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Store statistics -->
        <section class="mb-8 grid grid-cols-4 gap-5">
            <div class="rounded-2xl border border-white/10 bg-[#111019] p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Sneakers</p>
                <p class="mt-3 text-3xl font-extrabold">{{ $totalSneakers }}</p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-[#111019] p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Pairs in Stock</p>
                <p class="mt-3 text-3xl font-extrabold text-purple-400">{{ $totalStock }}</p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-[#111019] p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Orders</p>
                <p class="mt-3 text-3xl font-extrabold">{{ $totalOrders }}</p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-[#111019] p-6">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Revenue</p>
                <p class="mt-3 text-3xl font-extrabold text-green-400">&euro;{{ number_format((float) $totalRevenue, 2) }}</p>
            </div>
        </section>

        
        <!-- Add or edit sneaker -->
        <section class="mb-8 rounded-2xl border border-white/10 bg-[#111019] p-7">

            <!-- Form heading -->
            <div class="mb-5 border-b border-white/10 pb-4">
                <h2 class="text-xl font-bold">
                    <span class="text-purple-400">+</span>
                    {{ $editingSneaker ? 'Edit Sneaker' : 'Add New Sneaker' }}
                </h2>
            </div>

            <form
                method="POST"
                enctype="multipart/form-data"
                action="{{ $editingSneaker ? route('admin.sneakers.update', $editingSneaker) : route('admin.sneakers.store') }}"
            >
                @csrf

                @if ($editingSneaker)
                    @method('PUT')
                @endif

                <!-- Two-column form -->
                <div class="grid grid-cols-2 gap-x-6 gap-y-4">

                    <!-- Sneaker Name -->
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-300">
                            Sneaker Name
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            value="{{ old('name', $editingSneaker?->name) }}"
                            placeholder="e.g. Air Jordan 4 Retro"
                            class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-3 text-white outline-none focus:border-purple-500"
                        >
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand_id" class="mb-2 block text-sm font-medium text-gray-300">
                            Brand
                        </label>

                        <select
                            id="brand_id"
                            name="brand_id"
                            required
                            class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-3 text-white outline-none focus:border-purple-500"
                        >
                            <option value="">Choose brand</option>

                            @foreach ($brands as $brand)
                                <option
                                    value="{{ $brand->id }}"
                                    @selected(old('brand_id', $editingSneaker?->brand_id) == $brand->id)
                                >
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="mb-2 block text-sm font-medium text-gray-300">
                            Price (EUR)
                        </label>

                        <input
                            id="price"
                            name="price"
                            type="number"
                            step="0.01"
                            min="0"
                            required
                            value="{{ old('price', $editingSneaker?->price) }}"
                            placeholder="159.99"
                            class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-3 text-white outline-none focus:border-purple-500"
                        >
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock_quantity" class="mb-2 block text-sm font-medium text-gray-300">
                            Stock Pairs
                        </label>

                        <input
                            id="stock_quantity"
                            name="stock_quantity"
                            type="number"
                            min="0"
                            step="1"
                            required
                            value="{{ old('stock_quantity', $editingSneaker ? $editingSneaker->sizes->sum('stock_quantity') : 21) }}"
                            class="w-full rounded-xl border border-white/10 bg-[#191522] px-4 py-3 text-white outline-none focus:border-purple-500"
                        >
                    </div>

                    <!-- Image URL and upload -->
                    <div class="col-span-2">

                        <label for="image" class="mb-2 block text-sm font-medium text-gray-300">
                            Image URL (Optional)
                        </label>

                        <div class="flex items-center gap-3">

                            <input
                                id="image"
                                name="image"
                                type="text"
                                value="{{ old('image', $editingSneaker?->image) }}"
                                placeholder="https://example.com/sneaker.png"
                                class="min-w-0 flex-1 rounded-xl border border-white/10 bg-[#191522] px-4 py-3 text-white outline-none focus:border-purple-500"
                            >

                            <!-- Upload image button -->
                            <label
                                for="image_file"
                                title="Upload sneaker image"
                                class="flex h-14 w-14 flex-shrink-0 cursor-pointer items-center justify-center rounded-xl border border-white/10 bg-[#191522] text-gray-400 transition hover:border-purple-500 hover:text-purple-400"
                            >
                                <svg
                                    width="22"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <rect x="3" y="3" width="18" height="18" rx="3"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <path d="m21 15-5-5L5 21"/>
                                </svg>
                            </label>

                            <input
                                id="image_file"
                                name="image_file"
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                class="sr-only"
                            >

                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="col-span-2 flex items-center justify-end gap-4 pt-2">

                        @if ($editingSneaker)
                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="text-sm font-semibold text-gray-400 transition hover:text-white"
                            >
                                Cancel Editing
                            </a>
                        @endif

                        <button
                            type="submit"
                            class="w-48 rounded-xl bg-purple-600 px-5 py-3 font-bold text-white transition hover:bg-purple-500"
                        >
                            {{ $editingSneaker ? 'Update Sneaker' : 'Save Sneaker' }}
                        </button>

                    </div>

                </div>
            </form>

        </section>

        <!-- Manage Sneakers -->
        <section class="mt-8 overflow-hidden rounded-2xl border border-white/10 bg-[#111019]">

            <!-- Heading -->
            <div class="flex items-center justify-between border-b border-white/10 px-7 py-5">
                <h2 class="text-xl font-bold">Manage Sneakers</h2>
                <span class="text-sm text-gray-400">{{ $sneakers->count() }} items</span>
            </div>

            <!-- Sneakers Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">

                    <thead class="border-b border-white/10 bg-[#191522] text-xs font-semibold uppercase tracking-wider text-gray-400">
                        <tr>
                            <th class="px-6 py-4">Sneaker</th>
                            <th class="px-6 py-4">Brand</th>
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4">Total Stock</th>
                            <th class="px-6 py-4 text-right"</th>
                    </thead>

                    <tbody class="divide-y divide-white/10">

                        @forelse ($sneakers as $sneaker)

                            @php
                                $rowStock = $sneaker->sizes->sum('stock_quantity');

                                $rowImage = $sneaker->image
                                    ? (
                                        str_starts_with($sneaker->image, 'http')
                                            ? $sneaker->image
                                            : asset('storage/' . $sneaker->image)
                                    )
                                    : null;
                            @endphp

                            <tr class="hover:bg-white/[0.03]">

                                <!-- Sneaker -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-12 w-14 flex-shrink-0 items-center justify-center overflow-hidden rounded-xl bg-[#191522] p-2">
                                            @if ($rowImage)
                                                <img
                                                    src="{{ $rowImage }}"
                                                    alt="{{ $sneaker->name }}"
                                                    class="h-full w-full object-contain"
                                                >
                                            @else
                                                <span class="text-2xl">&#128095;</span>
                                            @endif
                                        </div>

                                        <span class="font-semibold">
                                            {{ $sneaker->name }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Brand -->
                                <td class="px-6 py-4 font-medium text-purple-400">
                                    {{ $sneaker->brand?->name ?? '—' }}
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4 font-semibold">
                                    &euro;{{ number_format((float) $sneaker->price, 2) }}
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4">
                                    @if ($rowStock > 0)
                                        <span class="rounded-full bg-green-500/10 px-3 py-1 text-xs font-semibold text-green-400">
                                            {{ $rowStock }} pairs
                                        </span>
                                    @else
                                        <span class="rounded-full bg-red-500/10 px-3 py-1 text-xs font-semibold text-red-400">
                                            Sold Out
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-3">

                                        <a
                                            href="{{ route('admin.dashboard', ['edit' => $sneaker->id]) }}"
                                            class="rounded-lg bg-purple-500/15 px-4 py-2 text-sm font-semibold text-purple-300 transition hover:bg-purple-600 hover:text-white"
                                        >
                                            Edit
                                        </a>

                                        <a
                                            href="#delete-modal-{{ $sneaker->id }}"
                                            class="px-2 py-2 text-sm text-gray-500 transition hover:text-red-400"
                                        >
                                            Delete
                                        </a>

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    No sneakers found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </section>
                  <!-- Delete Confirmation Modals -->
        @foreach ($sneakers as $sneaker)

            <div id="delete-modal-{{ $sneaker->id }}" class="delete-modal">

                <a href="#" class="delete-modal-backdrop"></a>

                <div class="delete-modal-content">

                    <h2 class="text-xl font-bold text-white">
                        Delete Sneaker?
                    </h2>

                    <p class="mt-3 text-sm text-gray-400">
                        Are you sure you want to delete
                        <strong class="text-white">{{ $sneaker->name }}</strong>?
                        This action cannot be undone.
                    </p>

                    <div class="mt-7 flex justify-end gap-3">

                        <a
                            href="#"
                            class="rounded-xl border border-white/10 px-5 py-3 text-sm font-semibold text-gray-300 hover:bg-white/5"
                        >
                            Cancel
                        </a>

                        <form
                            method="POST"
                            action="{{ route('admin.sneakers.destroy', $sneaker) }}"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white hover:bg-red-500"
                            >
                                Yes, Delete
                            </button>
                        </form>

                    </div>
                </div>
            </div>

@endforeach

    </main>

    <footer class="mt-16 border-t border-white/10 py-8 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} SneakerHub Admin. All rights reserved.
    </footer>

</body>
</html>
