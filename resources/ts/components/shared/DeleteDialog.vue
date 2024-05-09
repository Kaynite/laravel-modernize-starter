<script setup lang="ts">
import { XIcon } from 'vue-tabler-icons';

defineProps<{
    title: string
    message: string
}>()

defineEmits(['confirmed', 'cancelled'])

const model = defineModel<boolean>({ required: true })
</script>

<template>
    <VDialog v-model="model" persistent class="dialog-mw">
        <VBtn
            @click="model = !model"
            variant="flat"
            class="v-dialog-close-btn"
        >
            <VIcon>
                <XIcon size="20" />
            </VIcon>
        </VBtn>

        <!-- Dialog Content -->
        <VCard :title="title">
            <VCardText>
                {{ message }}
            </VCardText>

            <VCardText class="d-flex justify-end gap-3 flex-wrap">
                <VBtn color="secondary" variant="tonal" @click="$emit('cancelled')">
                    No
                </VBtn>
                <VBtn color="error" @click="$emit('confirmed')">
                    Yes
                </VBtn>
            </VCardText>
        </VCard>
    </VDialog>
</template>

<style>
.v-dialog-close-btn {
    position: absolute;
    z-index: 1;
    color: rgba(var(--v-theme-on-surface), var(--v-disabled-opacity)) !important;
    inset-block-start: 0.5rem;
    inset-inline-end: 0.5rem;
}
</style>
