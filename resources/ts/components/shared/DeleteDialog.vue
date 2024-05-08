<script setup lang="ts">
defineProps<{
    title: string
    message: string
}>()

defineEmits(['confirmed', 'cancelled'])

const model = defineModel<boolean>({ required: true })
</script>

<template>
    <VDialog v-model="model" persistent class="dialog-mw">
        <!-- Dialog close btn -->
        <DialogCloseBtn @click="model = !model" />

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
