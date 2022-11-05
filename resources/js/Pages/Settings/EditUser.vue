<template>
    <AppLayout>
        <div
            class="max-w-7xl mx-auto border border-slate-300 rounded-lg shoadow-lg my-6"
        >
            <div class="bg-slate-300 p-4 rounded-t-lg">
                <p class="uppercase tracking-wider font-bold">Edit User</p>
            </div>
            <form @submit.prevent="updateUser">
                <div class="p-4 grid grid-cols-2 gap-3">
                    <div class="mt-3">
                        <InputLabel value="Name" />
                        <TextInput
                            type="text"
                            class="w-full"
                            v-model="form.name"
                        />
                        <span
                            v-for="error in v$.name.$silentErrors"
                            :key="error.$uid"
                        >
                            <p class="text-red-500 text-sm mt-1">
                                {{ error.$message }}
                            </p>
                        </span>
                    </div>
                    <div class="mt-3">
                        <InputLabel value="Email" />
                        <TextInput
                            type="text"
                            class="w-full"
                            v-model="form.email"
                        />
                        <span
                            v-for="error in v$.email.$silentErrors"
                            :key="error.$uid"
                        >
                            <p class="text-red-500 text-sm mt-1">
                                {{ error.$message }}
                            </p>
                        </span>
                    </div>
                    <div class="mt-3">
                        <InputLabel value="Phone" />
                        <TextInput
                            type="text"
                            class="w-full"
                            v-model="form.phone"
                        />
                        <span
                            v-for="error in v$.phone.$silentErrors"
                            :key="error.$uid"
                        >
                            <p class="text-red-500 text-sm mt-1">
                                {{ error.$message }}
                            </p>
                        </span>
                    </div>
                    <div class="mt-3">
                        <InputLabel value="Active Until" />
                        <TextInput
                            type="date"
                            class="w-full"
                            v-model="form.active_until"
                        />
                        <span
                            v-for="error in v$.active_until.$silentErrors"
                            :key="error.$uid"
                        >
                            <p class="text-red-500 text-sm mt-1">
                                {{ error.$message }}
                            </p>
                        </span>
                    </div>
                    <div class="mt-3">
                        <InputLabel for="role" value="Role" />
                        <select
                            name="role"
                            id=""
                            class="rounded-lg border border-slate-300 w-full"
                            v-model="form.role"
                        >
                            <option
                                v-for="role in data.roles"
                                :key="role.id"
                                :value="role.name"
                                :selected="role.id == form.role"
                            >
                                {{ role.name }}
                            </option>
                        </select>
                        <span
                            v-for="error in v$.role.$silentErrors"
                            :key="error.$uid"
                        >
                            <p class="text-red-500 text-sm mt-1">
                                {{ error.$message }}
                            </p>
                        </span>
                    </div>
                </div>
                <div class="px-4 pb-4 flex gap-3">
                    <PrimaryButton
                        class="mt-3"
                        type="submit"
                        value="Update User"
                        >Update</PrimaryButton
                    >
                    <DangerButton
                        class="mt-3"
                        value="Back"
                        @click="backToSettings"
                        >Back</DangerButton
                    >
                </div>
            </form>
        </div>
    </AppLayout>
</template>
<script setup>
import { reactive, computed } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/Textinput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, email } from "@vuelidate/validators";
import { Inertia } from "@inertiajs/inertia";

const data = defineProps({
    user: {
        type: Object,
        required: true,
    },
    roles: {
        type: Object,
        required: true,
    },
});

// To show selected role
const userRole = reactive({
    name: data.user.roles[0].name,
});

const form = reactive({
    id: data.user.id,
    name: data.user.name,
    email: data.user.email,
    phone: data.user.phone,
    active_until: data.user.active_until,
    role: userRole.name,
});

const rules = computed(() => ({
    name: {
        required,
        minLength: minLength(3),
    },
    email: {
        required,
        email,
    },
    phone: {
        required,
        minLength: minLength(10),
    },
    active_until: {
        required,
    },
    role: {
        required,
    },
}));

const v$ = useVuelidate(rules, form);

const updateUser = async () => {
    const result = await v$.value.$validate();
    if (result) {
        Inertia.put(route("user.update"), form);
    } else {
        console.log("failed");
    }
};

const backToSettings = () => {
    Inertia.get(route("settings"));
};
</script>
