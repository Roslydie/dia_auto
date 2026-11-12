<template>
    <section v-if="headline" class="closing-band">
        <div class="container closing-band__inner">
            <h2>{{ headline }}</h2>
            <div class="closing-band__actions">
                <a class="button button--primary" href="tel:+12679242208">
                    <Icon name="phone" />
                    Call +1 267-924-2208
                </a>
                <RouterLink class="button button--outline-light" to="/contact">
                    <Icon name="chat" />
                    Request service
                </RouterLink>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import Icon from '../Icon.vue';

const headlines = {
    home: 'Tell us what you need.',
    locksmith: 'Tell us your car. We confirm before you come.',
    parts: 'Tell us the car and the part.',
    tires: 'Tell us your tire size.',
    'junk-cars': 'Tell us about your car. Free estimate.',
    'how-it-works': 'You always know before we start.',
};
const route = useRoute();
const headline = computed(() => headlines[route.name] ?? '');
</script>
