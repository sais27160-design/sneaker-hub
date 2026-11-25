<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';
import { logout } from '@/routes';

defineOptions({
    layout: {
        title: 'Email verification',
        description: 'Email verification is disabled for this project.',
    },
});
</script>

<template>
    <Head title="Email verification" />

    <div class="space-y-6 text-center">
        <p class="text-sm text-muted-foreground">
            Email verification is currently disabled.
        </p>

        <TextLink :href="logout()" as="button" class="mx-auto block text-sm">
            Log out
        </TextLink>
    </div>
</template>