<script setup lang="ts">
    import TextInput from '@/components/TextInput.vue';
    import { slugify } from '@/lib/utils';
    import type { InputHTMLAttributes } from 'vue';
    import { onMounted, onUnmounted, ref } from 'vue';

    const model = defineModel<string|undefined>({ required: true });

    interface Props extends /* @vue-ignore */ InputHTMLAttributes {
        id?: string;
        for?: string;
        type?: string;
    };

    const props = withDefaults(defineProps<Props>(), {
        for: 'name',
        id: 'slug',
        type: 'text',
    });

    const dependency = ref<HTMLInputElement>();
    const isManuallyUpdated = ref(false);

    const onDependencyInput: EventListener = async (evt: Event): Promise<void> => {
        if (isManuallyUpdated.value) {
            return;
        }
        model.value = slugify((evt.target as HTMLInputElement).value);
    };

    onMounted(() => {
        dependency.value = document.querySelector(`input[id="${props.for}"]`) as HTMLInputElement|undefined;
        dependency.value?.addEventListener('input', onDependencyInput);
    });

    onUnmounted(() => {
        dependency.value?.removeEventListener('input', onDependencyInput);
    });
</script>

<template>
    <TextInput :id :type v-bind="$attrs" v-model="model" />
</template>
