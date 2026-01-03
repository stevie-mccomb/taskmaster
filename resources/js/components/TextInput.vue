<script setup lang="ts">
    import { type InputHTMLAttributes } from 'vue';
    
    const model = defineModel<string|undefined>({ required: true });

    // @vue-ignore
    interface Props extends InputHTMLAttributes {};

    const props = withDefaults(defineProps<Props>(), {
        type: 'text',
    });
</script>

<template>
    <input :type="props.type" v-bind="$attrs" v-model="model" class="w-full px-4 py-2 rounded border border-zinc-500 bg-white text-black focus:outline-1 focus:outline-purple-500" />
</template>
