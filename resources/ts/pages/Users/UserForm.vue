<script setup lang="ts">
import { UserIcon, MailIcon, LockIcon } from "vue-tabler-icons";
import { InertiaForm } from "@inertiajs/vue3";

const { form } = defineProps<{
    form: InertiaForm<{
        name: string | null;
        email: string | null;
        password: string | null;
        password_confirmation: string | null;
    }>;
}>();

defineEmits(['saved', 'cancelled'])
</script>

<template>
    <v-row>
        <v-col cols="6">
            <v-label class="font-weight-medium mb-2">Name</v-label>
            <v-text-field color="primary" variant="outlined" type="text" placeholder="Example: John Doe"
                :error-messages="form.errors.name" v-model="form.name">
                <template v-slot:prepend-inner>
                    <UserIcon stroke-width="1.5" size="22" class="text-medium-emphasis mr-3" />
                </template>
            </v-text-field>
        </v-col>
        <v-col cols="6">
            <v-label class="font-weight-medium mb-2">Email</v-label>
            <v-text-field color="primary" variant="outlined" type="email" placeholder="Example: example@email.com"
                :error-messages="form.errors.email" v-model="form.email">
                <template v-slot:prepend-inner>
                    <MailIcon stroke-width="1.5" size="22" class="text-medium-emphasis mr-3" />
                </template>
            </v-text-field>
        </v-col>
        <v-col cols="6">
            <v-label class="font-weight-medium mb-2"> Password </v-label>
            <v-text-field color="primary" variant="outlined" type="password" placeholder="Enter password"
                :error-messages="form.errors.password" v-model="form.password">
                <template v-slot:prepend-inner>
                    <LockIcon stroke-width="1.5" size="22" class="text-medium-emphasis mr-3" />
                </template>
            </v-text-field>
        </v-col>
        <v-col cols="6">
            <v-label class="font-weight-medium mb-2">
                Confirm Password
            </v-label>
            <v-text-field color="primary" variant="outlined" type="password" placeholder="Confirm password"
                :error-messages="form.errors.password_confirmation" v-model="form.password_confirmation">
                <template v-slot:prepend-inner>
                    <LockIcon stroke-width="1.5" size="22" class="text-medium-emphasis mr-3" />
                </template>
            </v-text-field>
        </v-col>
        <v-col cols="12">
            <v-btn color="primary" class="px-8 me-5" flat @click="$emit('saved')" v-text="'Save'" />
            <v-btn color="error" class="px-8" flat @click="$emit('cancelled')" v-text="'Cancel'" />
        </v-col>
    </v-row>
</template>
