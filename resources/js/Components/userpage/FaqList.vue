<template>
    <section class="page-section" aria-labelledby="questions-title">
        <div class="faq-container">
            <h2 id="questions-title">Questions</h2>
            <div class="faq-list">
                <section v-for="(item, index) in items" :key="item.question" class="faq-item">
                    <h3>
                        <button
                            type="button"
                            :aria-expanded="openIndex === index"
                            :aria-controls="`faq-answer-${index}`"
                            @click="toggle(index)"
                        >
                            {{ item.question }}
                            <span aria-hidden="true">{{ openIndex === index ? '−' : '+' }}</span>
                        </button>
                    </h3>
                    <p v-show="openIndex === index" :id="`faq-answer-${index}`">{{ item.answer }}</p>
                </section>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
    items: {
        type: Array,
        required: true,
    },
});

const openIndex = ref(null);

function toggle(index) {
    openIndex.value = openIndex.value === index ? null : index;
}
</script>
