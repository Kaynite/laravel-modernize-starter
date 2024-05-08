<script setup lang="ts">
import BaseBreadcrumb from "@/components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/components/shared/UiParentCard.vue";
import FullLayout from "@/layouts/full/FullLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import UserForm from './UserForm.vue';

defineOptions({
    layout: FullLayout,
});

const page = ref<{ title: string }>({ title: "Create new user" });

const breadcrumbs = ref([
    {
        title: "Users",
        to: route("users.index"),
    },
    {
        title: "Create User",
        disabled: true,
    },
]);

const form = useForm<{
    name: string | null;
    email: string | null;
    password: string | null;
    password_confirmation: string | null;
}>({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const saveUser = () => {
    form.post(route("users.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head :title="page.title" />
    <BaseBreadcrumb title="Create User" :breadcrumbs="breadcrumbs" />

    <v-row>
        <v-col cols="12">
            <UiParentCard :title="page.title">
                <UserForm
                    :form="form"
                    @saved="saveUser"
                    @cancelled="router.visit(route('users.index'))"
                />
            </UiParentCard>
        </v-col>
    </v-row>
</template>
