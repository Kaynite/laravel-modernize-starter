<script setup lang="ts">
import BaseBreadcrumb from "@/components/shared/BaseBreadcrumb.vue";
import UiParentCard from "@/components/shared/UiParentCard.vue";
import FullLayout from "@/layouts/full/FullLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import { inject, ref } from "vue";
import UserForm from "./UserForm.vue";
import { User } from "@/types";
import { route as routeFn } from '../../../../vendor/tightenco/ziggy/src/js';

defineOptions({
    layout: FullLayout,
});

const route = inject('route', routeFn)

const { user } = defineProps<{
    user: User;
}>();

const page = ref<{ title: string }>({ title: "Update user" });

const breadcrumbs = ref([
    {
        title: "Users",
        to: route("users.index"),
    },
    {
        title: "Update User",
        disabled: true,
    },
]);

const form = useForm<{
    name: string | null;
    email: string | null;
    password: string | null;
    password_confirmation: string | null;
}>({
    name: user.name,
    email: user.email,
    password: "",
    password_confirmation: "",
});

const saveUser = () => {
    form.put(route("users.update", { user: user.id }), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head :title="page.title" />
    <BaseBreadcrumb title="Update User" :breadcrumbs="breadcrumbs" />

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
