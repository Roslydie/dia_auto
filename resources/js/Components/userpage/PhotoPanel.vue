<template>
    <figure class="photo-panel">
        <img
            v-if="src"
            class="photo-panel__image"
            :src="src"
            :alt="alt"
            :loading="loading"
            decoding="async"
        >
        <span class="photo-panel__label">{{ label }}</span>
        <figcaption v-if="src" class="photo-panel__caption">{{ caption }}</figcaption>
        <div v-else class="photo-panel__placeholder">
            <span class="photo-panel__icon"><Icon :name="icon" /></span>
            <span>{{ caption }}</span>
        </div>
    </figure>
</template>

<script setup>
import Icon from './Icon.vue';

defineProps({
    label: {
        type: String,
        required: true,
    },
    src: {
        type: String,
        default: '',
    },
    alt: {
        type: String,
        default: '',
    },
    loading: {
        type: String,
        default: 'lazy',
        validator: (value) => ['eager', 'lazy'].includes(value),
    },
    caption: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        required: true,
    },
});
</script>
