<script setup lang="ts">
    import InputLabel from '@/components/InputLabel.vue';
    import SmartButton from '@/components/SmartButton.vue';
    import TextInput from '@/components/TextInput.vue';
    import AuthLayout from '@/layouts/AuthLayout.vue';
    import { login, register } from '@/routes';
    import { Link, useForm } from '@inertiajs/vue3';

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });
</script>

<template>
    <AuthLayout>
        <template #header>
            <h1 class="text-xl">
                Create Account
            </h1>
        </template>

        <form @submit.prevent="form.post(register.url())">
            <div class="mb-4">
                <InputLabel for="name" value="Name" required />

                <TextInput id="name" type="text" v-model="form.name" required max="255" autofocus />
            </div>

            <div class="mb-4">
                <InputLabel for="email" value="Email" required />

                <TextInput id="email" type="email" v-model="form.email" required max="255" />
            </div>

            <div class="mb-4">
                <InputLabel for="password" value="Password" required />

                <TextInput id="password" type="password" v-model="form.password" required />
            </div>

            <div class="mb-4">
                <InputLabel for="password_confirmation" value="Confirm Password" required />

                <TextInput id="password_confirmation" type="password" v-model="form.password_confirmation" required />
            </div>

            <SmartButton class="w-full rounded! flex justify-between items-center gap-2">
                Create Account <span class="fas fa-long-arrow-right"></span>
            </SmartButton>
        </form>

        <template #footer>
            <div class="w-full flex justify-end">
                <Link :href="login.url()" class="text-cyan-500 underline">
                    Already have an account?
                </Link>
            </div>
        </template>
    </AuthLayout>
</template>
