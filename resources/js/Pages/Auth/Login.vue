<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
    laravelVersion: String,
    phpVersion: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <div class="h-screen relative bg-white">
        <div class="max-w-10xl mx-auto">
            <div
                class="lg:h-screen relative z-10 pb-8 bg-slate-200 dark:bg-slate-800 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32"
            >
                <svg
                    class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-slate-200 dark:text-slate-800 transform translate-x-1/2"
                    fill="currentColor"
                    viewBox="0 0 100 100"
                    preserveAspectRatio="none"
                    aria-hidden="true"
                >
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>
                <div>
                    <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
                        <nav
                            class="relative flex items-center justify-between sm:h-10 lg:justify-start"
                            aria-label="Global"
                        >
                            <div
                                class="flex justify-between items-center flex-grow flex-shrink-0 ml-0 sm:ml-6 mt-0 sm:mt-4"
                            >
                                <div
                                    class="flex items-center justify-start w-full md:w-auto"
                                >
                                    <a href="#">
                                        <img
                                            alt="TheNextLevel"
                                            class="h-8 w-auto sm:h-10"
                                            src="img/icon.svg"
                                        />
                                    </a>
                                    <a
                                        href=""
                                        class="ml-3 text-orange-600 hover:text-orange-500 sm:text-lg md:text-xl font-bold"
                                    >
                                        TheNextLevel
                                        <span class="font-normal"
                                            >Solution</span
                                        >
                                    </a>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div
                        class="absolute z-10 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden"
                    ></div>
                </div>

                <main
                    class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28"
                >
                    <div class="sm:text-center lg:text-left ml-0 sm:ml-6">
                        <h1
                            class="text-4xl tracking-tight font-black text-slate-900 dark:text-slate-300 sm:text-5xl md:text-5xl"
                        >
                            <span class="block md:inline">Point of Sales </span>
                            <span
                                class="block text-orange-600 md:inline font-normal"
                                >Management</span
                            >
                        </h1>
                        <p
                            class="mt-3 text-base text-slate-500 dark:text-slate-200"
                        >
                            Point of Sales Management System is a web
                            application that allows you to manage your point of
                            sales administration.
                        </p>

                        <div class="max-w-full lg:max-w-lg mt-10 sm:mt-16">
                            <div
                                v-if="status"
                                class="mb-4 font-medium text-sm text-green-600"
                            >
                                {{ status }}
                            </div>

                            <form @submit.prevent="submit">
                                <div>
                                    <InputLabel for="email" value="Email" />
                                    <TextInput
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        required
                                        autofocus
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.email"
                                    />
                                </div>

                                <div class="mt-4">
                                    <InputLabel
                                        for="password"
                                        value="Password"
                                    />
                                    <TextInput
                                        id="password"
                                        v-model="form.password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="current-password"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.password"
                                    />
                                </div>

                                <div class="block mt-4">
                                    <label class="flex items-center">
                                        <Checkbox
                                            v-model:checked="form.remember"
                                            name="remember"
                                        />
                                        <span class="ml-2 text-sm text-gray-600"
                                            >Remember me</span
                                        >
                                    </label>
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <Link
                                        v-if="canResetPassword"
                                        :href="route('password.request')"
                                        class="underline text-sm text-gray-600 hover:text-gray-900"
                                    >
                                        Forgot your password?
                                    </Link>

                                    <PrimaryButton
                                        class="ml-4"
                                        :class="{
                                            'opacity-25': form.processing,
                                        }"
                                        :disabled="form.processing"
                                    >
                                        Log in
                                    </PrimaryButton>
                                </div>
                            </form>
                            <!-- <div
                                class="ml-4 mt-12 text-center text-xs text-slate-400 sm:text-right sm:ml-0"
                            >
                                Laravel v{{ laravelVersion }} (PHP v{{
                                    phpVersion
                                }})
                            </div> -->
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-2/3">
            <img
                class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                src="img/login.jpg"
                alt="Background"
            />
        </div>
    </div>
</template>
