<script setup lang="ts">
    import AppHeader from '@/components/AppHeader.vue';
    import StickyBar from '@/components/StickyBar.vue';
</script>

<template>
    <div class="absolute top-0 left-0 w-full h-full flex flex-col overflow-auto">
        <StickyBar />
        <AppHeader />

        <div class="flex-1 bg-zinc-200">
            <slot />
        </div>
    </div>
</template>
