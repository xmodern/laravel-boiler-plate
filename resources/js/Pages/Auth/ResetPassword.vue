<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Reset Password"/>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo/>
        </template>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email"/>
                <input id="email" v-model="form.email" autocomplete="username"
                       autofocus class="input input-bordered w-full"
                       placeholder="Type here"
                       required type="email"/>
                <InputError :message="form.errors.email" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password"/>
                <input id="password"
                       v-model="form.password"
                       autocomplete="new-password"
                       autofocus class="input input-bordered w-full"
                       required
                       type="password"/>
                <InputError :message="form.errors.password" class="mt-2"/>
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password"/>
                <input id="password_confirmation" v-model="form.password_confirmation"
                       autocomplete="new-password"
                       class="input input-bordered w-full"
                       placeholder="Type here"
                       required type="password"/>
                <InputError :message="form.errors.password_confirmation" class="mt-2"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reset Password
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
