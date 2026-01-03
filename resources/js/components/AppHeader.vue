<script setup lang="ts">
    import AppLogo from '@/components/AppLogo.vue';
    import Container from '@/components/Container.vue';
    import { home } from '@/routes';
    import { Link } from '@inertiajs/vue3';
</script>

<template>
    <!-- App Header -->
    <header class="bg-white py-4 border-b border-stone-200">
        <Container class="flex items-center gap-2">
            <Link :href="home.url()">
                <AppLogo />
            </Link>
        </Container>
    </header>
</template>
