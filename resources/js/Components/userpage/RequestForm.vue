<template>
    <section class="request-card" aria-labelledby="request-title">
        <h2 id="request-title">Tell us the car</h2>
        <p class="request-card__intro">We tell you the price before any work starts. You decide.</p>

        <form ref="formElement" class="request-form" @submit.prevent="handleSubmit">
            <div class="honeypot" aria-hidden="true">
                <label for="request-website">Website</label>
                <input id="request-website" v-model="form.website" tabindex="-1" autocomplete="off">
            </div>

            <fieldset class="request-fieldset">
                <legend>How can we help?</legend>
                <div class="form-service-grid">
                    <label
                        v-for="option in serviceOptions"
                        :key="option.value"
                        class="form-service-choice"
                        :class="{ 'form-service-choice--selected': form.service === option.value }"
                        :for="`request-service-${option.value}`"
                    >
                        <span class="form-service-choice__top">
                            <span class="form-service-choice__icon"><Icon :name="option.icon" /></span>
                            <input :id="`request-service-${option.value}`" v-model="form.service" type="radio" name="service" :value="option.value" required @change="selectService(option.value)">
                        </span>
                        <span class="form-service-choice__title">{{ option.label }}</span>
                        <span class="form-service-choice__description">{{ option.description }}</span>
                    </label>
                </div>
            </fieldset>

            <div v-if="form.service && form.service !== 'other'" class="form-grid">
                <div class="form-field">
                    <label for="request-year">Year</label>
                    <input id="request-year" v-model="form.year" name="year" inputmode="numeric" maxlength="4" autocomplete="off">
                </div>
                <div class="form-field">
                    <label for="request-make">Make</label>
                    <input id="request-make" v-model="form.make" name="make" autocomplete="off">
                </div>
                <div class="form-field">
                    <label for="request-model">Model</label>
                    <input id="request-model" v-model="form.model" name="model" autocomplete="off">
                </div>
            </div>

            <div v-if="form.service === 'other'" class="form-field">
                <label for="request-name">Your name</label>
                <input id="request-name" v-model.trim="form.name" name="name" autocomplete="name" required>
            </div>

            <div class="form-field">
                <label for="request-need">{{ needLabel }}</label>
                <textarea id="request-need" v-model.trim="form.need" name="need" rows="4" required :placeholder="needPlaceholder" />
            </div>

            <fieldset v-if="form.service === 'junk'" class="request-fieldset">
                <legend>Does it run?</legend>
                <div class="form-inline-options">
                    <label v-for="option in runOptions" :key="option.value" class="form-choice">
                        <input v-model="form.runs" type="radio" name="runs" :value="option.value" required>
                        <span>{{ option.label }}</span>
                    </label>
                </div>
                <div class="form-field form-field--narrow">
                    <label for="request-zip">ZIP where the car is</label>
                    <input id="request-zip" v-model.trim="form.zip" name="zip" inputmode="numeric" maxlength="5" autocomplete="postal-code" required>
                </div>
            </fieldset>

            <div class="form-grid">
                <div class="form-field">
                    <label for="request-phone">Phone</label>
                    <input
                        id="request-phone"
                        v-model.trim="form.phone"
                        name="phone"
                        type="tel"
                        autocomplete="tel"
                        inputmode="tel"
                        placeholder="(215) 555-0123"
                        pattern="(?:\+?1[\s.-]?)?(?:\([2-9][0-9]{2}\)|[2-9][0-9]{2})[\s.-]?[2-9][0-9]{2}[\s.-]?[0-9]{4}"
                        title="Enter a 10-digit US phone number including area code."
                        required
                        @input="clearError('phone')"
                    >
                    <p v-if="fieldErrors.phone" class="form-help" role="alert">{{ fieldErrors.phone }}</p>
                </div>

            </div>

            <div class="form-grid">
                <div class="form-field">
                    <label for="request-email">Email</label>
                    <input
                        id="request-email"
                        v-model.trim="form.email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        @input="clearError('email')"
                    >
                    <p v-if="fieldErrors.email" class="form-help" role="alert">{{ fieldErrors.email }}</p>
                </div>
            </div>

            <div class="form-field">
                <label for="request-photos">Photos <span>(optional, up to 3)</span></label>
                <input id="request-photos" type="file" accept="image/*" multiple @change="handleFiles">
                <p v-if="selectedPhotos.length" class="form-help">
                    {{ selectedPhotos.length }} photo{{ selectedPhotos.length === 1 ? '' : 's' }} selected.
                </p>
                <p v-if="tooManyPhotos" class="form-help">Only the first 3 photos can be included.</p>
            </div>

            <p v-if="formNotice" class="form-notice" role="status" aria-live="polite">{{ formNotice }}</p>
            <button class="button button--primary form-submit" type="submit" :disabled="isSubmitting">
                {{ isSubmitting ? 'Sending...' : 'Send my request' }} <Icon name="arrow" />
            </button>
            <p class="form-privacy">We use your details only to answer this request. <RouterLink to="/privacy">Privacy</RouterLink></p>
        </form>
    </section>
</template>

<script setup>
import { computed, reactive, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import Icon from './Icon.vue';

const serviceOptions = [
    { value: 'locksmith', label: 'Car Locksmith', description: 'Keys, lockouts, key fobs.', icon: 'key' },
    { value: 'parts', label: 'Used Parts', description: 'Tell us the car and the part.', icon: 'gear' },
    { value: 'tires', label: 'Used Tires', description: 'Tell us your tire size.', icon: 'tire' },
    { value: 'junk', label: 'Junk Car', description: 'Tell us about your car.', icon: 'car' },
    { value: 'other', label: 'Other question', description: 'Write to us about anything else.', icon: 'chat' },
];
const runOptions = [
    { value: 'yes', label: 'Yes' },
    { value: 'no', label: 'No' },
    { value: 'not-sure', label: 'Not sure' },
];

const route = useRoute();
const formElement = ref(null);
const formNotice = ref('');
const selectedPhotos = ref([]);
const tooManyPhotos = ref(false);
const isSubmitting = ref(false);
const fieldErrors = ref({});
const photoFiles = ref([]);
const form = reactive({
    service: '',
    year: '',
    make: '',
    model: '',
    need: '',
    name: '',
    phone: '',
    email: '',
    runs: '',
    zip: '',
    website: '',
});
const needLabel = computed(() => form.service === 'junk' ? 'Tell us about the car' : 'What do you need?');
const needPlaceholder = computed(() => ({
    locksmith: 'Example: lost my only key, the car is at home',
    parts: 'Example: driver side mirror, power, black',
    tires: 'Example: two tires, size printed on the side',
    junk: 'Does not start, body damage, missing parts, parked in driveway...',
    other: 'Example: a question about a part you bought',
}[form.service] || 'Tell us what you need'));

function updateService(value) {
    form.service = serviceOptions.some((option) => option.value === value) ? value : '';
}

function selectService(value) {
    formNotice.value = '';
    fieldErrors.value = {};
}

watch(() => route.query.s, (value) => {
    updateService(typeof value === 'string' ? value : '');
}, { immediate: true });

function handleFiles(event) {
    const files = Array.from(event.target.files ?? []);
    tooManyPhotos.value = files.length > 3;
    photoFiles.value = files.slice(0, 3);
    selectedPhotos.value = photoFiles.value.map((file) => file.name);
}

function clearError(field) {
    delete fieldErrors.value[field];
}

async function handleSubmit() {
    if (!formElement.value?.reportValidity()) {
        return;
    }

    isSubmitting.value = true;
    formNotice.value = '';
    fieldErrors.value = {};

    const data = new FormData();
    Object.entries(form).forEach(([key, value]) => {
        data.append(key, value);
    });
    photoFiles.value.forEach((file) => data.append('photos[]', file));

    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        await window.axios.post('/service-requests', data, {
            headers: {
                Accept: 'application/json',
                ...(token ? { 'X-CSRF-TOKEN': token } : {}),
            },
        });

        formNotice.value = 'Your request has been sent. We will get back to you soon.';
        formElement.value.reset();
        Object.assign(form, {
            service: '',
            year: '',
            make: '',
            model: '',
            need: '',
            name: '',
            phone: '',
            email: '',
            runs: '',
            zip: '',
            website: '',
        });
        photoFiles.value = [];
        selectedPhotos.value = [];
        tooManyPhotos.value = false;
    } catch (error) {
        if (error.response?.status === 422) {
            fieldErrors.value = Object.fromEntries(
                Object.entries(error.response.data.errors ?? {}).map(([field, messages]) => [field, messages[0]])
            );
            formNotice.value = error.response.data.message || 'Please check the information you entered and try again.';
        } else {
            formNotice.value = 'We could not send your request. Please try again or call us.';
        }
    } finally {
        isSubmitting.value = false;
    }
}
</script>
