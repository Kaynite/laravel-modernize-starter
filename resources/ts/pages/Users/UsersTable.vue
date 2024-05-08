<script setup lang="ts">
import { PaginatedCollection, User } from '@/types';
import { router } from '@inertiajs/vue3';
import { ref, inject } from 'vue';
import { PencilIcon, TrashIcon } from 'vue-tabler-icons';
import { route as routeFn } from '../../../../vendor/tightenco/ziggy/src/js';
import DeleteDialog from '@/components/shared/DeleteDialog.vue';

const route = inject('route', routeFn)

const { users } = defineProps<{
    users: PaginatedCollection<User>
}>();

const headers = [
    { title: '#', key: 'id' },
    { title: 'Name', key: 'name' },
    { title: 'Email', key: 'email' },
    { title: 'Created At', key: 'created_at' },
    { title: 'Actions', key: 'actions' },
];

const search = ref<string>("")
const isLoaded = ref(false);

const updateOptions = (options: any) => {
    if (!isLoaded.value) {
        return isLoaded.value = true
    }
    const data: any = {
        page: options.page,
        per_page: options.itemsPerPage,
    }

    if (options.sortBy[0]?.key)
        data.sort = (options.sortBy[0]?.order === 'desc' ? '-' : '') + options.sortBy[0]?.key

    if (search.value)
        data.filter = { q: search.value }

    router.get(route('users.index'), data, {
        preserveState: true,
        only: ['users'],
    })
}

const toDelete = ref<User|null>(null);

const deleteItem = () => {
    if (toDelete.value) {
        router.delete(route('users.destroy', toDelete.value.id), {
            onFinish: () => {
                isDialogVisible.value = false;
            }
        })
    }
}

const isDialogVisible = ref(false)
</script>

<template>
    <v-row class="mb-5">
        <v-col cols="12" lg="4" md="6">
            <v-text-field density="compact" v-model="search" label="Search" hide-details
                variant="outlined"></v-text-field>
        </v-col>
        <v-col cols="12" lg="8" md="6" class="text-right">
            <v-btn color="primary" flat class="ml-auto" :to="route('users.create')">
                <v-icon class="mr-2" icon="mdi-account-multiple-plus" />
                Create New User
            </v-btn>
        </v-col>
    </v-row>
    <v-data-table-server :headers="headers" :items="users.data" :items-length="users.meta.total"
        :items-per-page="users.meta.per_page" :search="search" @update:options="updateOptions" :multi-sort="false">
        <template #item.actions="{ item }">
            <div class="d-flex align-center">
                <v-tooltip text="Edit">
                    <template v-slot:activator="{ props }">
                        <v-btn icon flat :to="route('users.edit', { id: (item as User).id })" v-bind="props">
                            <PencilIcon stroke-width="1.5" size="20" class="text-primary" />
                        </v-btn>
                    </template>
                </v-tooltip>
                <v-tooltip text="Delete">
                    <template v-slot:activator="{ props }">
                        <v-btn icon flat @click="isDialogVisible = true; toDelete = item" v-bind="props">
                            <TrashIcon stroke-width="1.5" size="20" class="text-error" />
                        </v-btn>
                    </template>
                </v-tooltip>
            </div>
        </template>
    </v-data-table-server>

    <DeleteDialog
        title="Delete User"
        message="Are you sure you want to delete selected user?"
        @cancelled="isDialogVisible = false"
        @confirmed="deleteItem"
        v-model="isDialogVisible"
    />
</template>
