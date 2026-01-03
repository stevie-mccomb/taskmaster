<script setup lang="ts">
    import Container from '@/components/Container.vue';
    import { home, login, logout, register } from '@/routes';
    import { Link, usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';

    const isLoggedIn = computed<boolean>(() => !!usePage().props.auth.user?.id);

    const linkClass = `cursor-pointer block px-4 py-2 hover:bg-stone-200 hover:text-cyan-500`;
</script>

<template>
    <!-- Sticky Bar -->
    <header class="sticky top-0 bg-linear-to-br from-cyan-900 to-cyan-950 text-stone-200 border-b border-cyan-700">
        <Container class="flex justify-end items-center">
            <nav class="flex">
                <Link v-if="isLoggedIn" :href="home.url()" :class="linkClass">
                    Home
                </Link>

                <Link v-if="isLoggedIn" :href="logout.url()" method="post" :class="linkClass">
                    Log Out
                </Link>

                <Link v-if="!isLoggedIn" :href="login.url()" :class="linkClass">
                    Log In
                </Link>

                <Link v-if="!isLoggedIn" :href="register.url()" :class="linkClass">
                    Register
                </Link>
            </nav>
        </Container>
    </header>
</template>
