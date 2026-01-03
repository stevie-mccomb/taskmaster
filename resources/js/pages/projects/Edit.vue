<script setup lang="ts">
    import Container from '@/components/Container.vue';
    import InputLabel from '@/components/InputLabel.vue';
    import SlugInput from '@/components/SlugInput.vue';
    import SmartButton from '@/components/SmartButton.vue';
    import TextInput from '@/components/TextInput.vue';
    import AppLayout from '@/layouts/AppLayout.vue';
    import { Project } from '@/types';
    import { useForm } from '@inertiajs/vue3';
    import { store, update } from '@/routes/projects';

    const props = defineProps<{
        project: Project;
    }>();

    const form = useForm({
        name: props.project.name,
        slug: props.project.slug,
    });

    const onSubmit = (e: SubmitEvent) => {
        if (props.project.id) {
            form.patch(update.url(props.project.id));
        } else {
            form.post(store.url());
        }
    };
</script>

<template>
    <AppLayout>
        <section class="py-12">
            <Container>
                <form @submit.prevent="onSubmit">
                    <h1 class="text-2xl mb-8">
                        {{ project.id ? 'Edit' : 'Create' }} Project
                    </h1>

                    <div class="mb-4">
                        <InputLabel for="name" value="Name" required />

                        <TextInput id="name" v-model="form.name" required max="255" autofocus />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="slug" value="Slug" required />

                        <SlugInput v-model="form.slug" required max="255" />
                    </div>

                    <SmartButton>
                        <span class="far fa-save mr-2"></span> Save Project
                    </SmartButton>
                </form>
            </Container>
        </section>
    </AppLayout>
</template>
