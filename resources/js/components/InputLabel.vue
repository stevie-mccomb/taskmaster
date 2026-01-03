<script setup lang="ts">
    withDefaults(defineProps<{
        required?: boolean;
        value?: string;
    }>(), {
        required: false,
        value: '',
    });
</script>

<template>
    <label class="flex gap-2 mb-2">
        <div v-if="value?.length">
            {{ value }}
        </div>

        <div v-else>
            <slot />
        </div>

        <span v-if="required" class="text-red-500">
            *
        </span>
    </label>
</template>
