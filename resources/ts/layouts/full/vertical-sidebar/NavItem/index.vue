<script setup>
import Icon from "../Icon.vue";

const props = defineProps({ item: Object, level: Number });
</script>

<template>
    <!---Single Item-->
    <v-list-item
        rounded
        class="mb-1"
        :disabled="item.disabled"
    >
        <!---If icon-->
        <template v-slot:prepend>
            <Icon :item="item.icon" :level="level" />
        </template>
        <Link :href="item.route ? route(item.route) : item.to" class="text-decoration-none" style="color: inherit">
            <v-list-item-title>{{ $t(item.title) }}</v-list-item-title>
            <!---If Caption-->
            <v-list-item-subtitle
                v-if="item.subCaption"
                class="text-caption mt-n1 hide-menu"
            >
                {{ item.subCaption }}
            </v-list-item-subtitle>
        </Link>
        <!---If any chip or label-->
        <template v-slot:append v-if="item.chip">
            <v-chip
                :color="item.chipColor"
                :class="'sidebarchip hide-menu bg-' + item.chipBgColor"
                :size="item.chipIcon ? 'small' : 'small'"
                :variant="item.chipVariant"
                :prepend-icon="item.chipIcon"
            >
                {{ item.chip }}
            </v-chip>
        </template>
    </v-list-item>
</template>
