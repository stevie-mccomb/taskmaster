<script setup lang="ts">
    import AppLogo from '@/components/AppLogo.vue';
</script>

<template>
    <main class="absolute top-0 left-0 w-full h-full flex flex-col justify-center items-center bg-zinc-200">
        <AppLogo class="mb-8" />

        <div class="bg-white shadow-xl min-w-96 rounded-lg overflow-hidden">
            <header class="px-4 py-2 border-b border-zinc-300">
                <slot name="header" />
            </header>

            <section class="p-4">
                <slot />
            </section>

            <footer class="px-4 py-2 border-t border-zinc-300">
                <slot name="footer" />
            </footer>
        </div>
    </main>
</template>
