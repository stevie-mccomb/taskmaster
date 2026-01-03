<script setup lang="ts">
    const model = defineModel({ required: true });
</script>

<template>
    <select v-model="model">
        <slot />
    </select>
</template>
