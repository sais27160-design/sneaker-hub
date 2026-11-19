
<script setup lang="ts">
</script>

<template>
    <div class="min-h-screen bg-black text-white p-10">
        <nav class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">
                SneakerHub
            </h1>

            <div class="space-x-4">
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            </div>
        </nav>

        <main class="mt-32 text-center">
            <h2 class="text-6xl font-bold">
                Welcome to SneakerHub
            </h2>

            <p class="mt-6 text-gray-400 text-xl">
                Discover. Collect. Share your sneakers.
            </p>

            <button class="mt-8 bg-white text-black px-8 py-3 rounded-lg">
                Explore Sneakers
            </button>
        </main>
    </div>
</template>
