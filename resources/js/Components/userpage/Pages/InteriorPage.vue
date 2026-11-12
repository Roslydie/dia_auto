<template>
    <div>
        <section v-if="pageKey !== 'not-found'" class="page-hero" :class="{ 'page-hero--junk': pageKey === 'junk' }">
            <div class="page-hero__inner">
                <p class="eyebrow">
                    <span v-if="page.number" class="page-hero__number">{{ page.number }}</span>
                    {{ page.kicker }}
                </p>
                <h1>{{ page.title }}</h1>
                <p class="page-hero__sub">{{ page.subtitle }}</p>
                <div v-if="page.showButtons" class="hero-actions page-hero__actions">
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
            <span v-if="pageKey === 'junk'" class="page-hero__caption">Illustrative photo</span>
        </section>

        <template v-if="pageKey === 'locksmith'">
            <section class="page-section">
                <ContentWrapper>
                    <div class="detail-grid">
                        <div>
                            <h2>What we do</h2>
                            <ul class="detail-list">
                                <li v-for="service in locksmithServices" :key="service">{{ service }}</li>
                            </ul>
                            <p class="section-lead">
                                We service all makes and models, in shop or on site. Tell us your car details and
                                we give you your price before we start.
                            </p>
                            <span class="tag">Supported makes to confirm</span>
                        </div>
                        <PhotoPanel
                            label="Keys"
                            :src="locksmithImage"
                            alt="Cutting a car key on a key machine in a workshop"
                            caption="Illustrative photo"
                            icon="key"
                        />
                    </div>
                </ContentWrapper>
            </section>
            <section class="page-section locksmith-service-section">
                <ContentWrapper>
                    <h2 class="locksmith-section-title">At the shop or mobile</h2>
                    <div v-reveal class="locksmith-cards">
                        <article
                            v-for="card in locksmithCards"
                            :key="card.title"
                            class="content-card"
                            :class="{ 'content-card--dark': card.dark }"
                        >
                            <span class="icon-tile" :class="{ 'icon-tile--light': card.dark }"><Icon :name="card.icon" /></span>
                            <h3>{{ card.title }}</h3>
                            <p>{{ card.body }}</p>
                        </article>
                    </div>
                </ContentWrapper>
            </section>
            <FaqList :items="locksmithFaq" />
        </template>

        <template v-else-if="pageKey === 'parts'">
            <section class="page-section">
                <ContentWrapper>
                    <div class="detail-grid">
                        <div>
                            <h2>On the shelves</h2>
                            <div class="tag-list">
                                <span v-for="part in partsList" :key="part" class="part-tag">
                                    <Icon name="gear" />
                                    {{ part }}
                                </span>
                            </div>
                            <p>Many of our parts come from the junk cars we buy. <RouterLink to="/sell-your-junk-car">Sell us yours</RouterLink>.</p>
                            <p class="service-note">
                                <Icon name="chat" />
                                <span>Tell us the year, make, model and the part. A photo of the old part helps.</span>
                            </p>
                        </div>
                        <PhotoPanel
                            label="Parts"
                            :src="partsImage"
                            alt="Used auto parts lined up on a shelf in a shop"
                            caption="Illustrative photo"
                            icon="gear"
                        />
                    </div>
                </ContentWrapper>
            </section>
            <section class="page-section">
                <ContentWrapper>
                    <div class="card-grid">
                        <article class="content-card content-card--wide">
                            <span class="red-label">Warranty</span>
                            <h3>2 weeks on engines and transmissions.</h3>
                            <p>Other parts are final sale.</p>
                        </article>
                        <article class="content-card">
                            <span class="icon-tile"><Icon name="pin" /></span>
                            <h3>Walk in</h3>
                            <p>No appointment needed. Monday to Saturday, 8:00 am to 5:00 pm.</p>
                        </article>
                        <article class="content-card content-card--dark">
                            <span class="icon-tile icon-tile--light"><Icon name="car" /></span>
                            <h3>Or we ship it</h3>
                            <p>Not close by? Tell us the part and where you are.</p>
                        </article>
                    </div>
                </ContentWrapper>
            </section>
        </template>

        <template v-else-if="pageKey === 'tires'">
            <section class="page-section">
                <ContentWrapper>
                    <div class="detail-grid tires-intro-grid">
                        <PhotoPanel
                            label="Tires"
                            :src="tiresImage"
                            alt="Used tires stacked on a rack"
                            caption="Illustrative photo"
                            icon="tire"
                            :loading="tiresImageLoading"
                        />
                        <div>
                            <h2>Checked before the rack</h2>
                            <p class="service-note">
                                <Icon name="chat" />
                                <span>Walk in Monday to Saturday. Tell us your tire size, it is printed on the side of the tire.</span>
                            </p>
                        </div>
                    </div>
                </ContentWrapper>
            </section>
            <section class="page-section tires-check-section">
                <ContentWrapper>
                    <h2 class="tires-check-heading">Before it goes on your car</h2>
                    <div v-reveal class="tire-checks-grid">
                        <div v-for="item in tireChecks" :key="item.title" class="tire-check-frame">
                            <article class="tire-check-card">
                                <span class="tire-check-card__number">{{ item.number }}</span>
                                <h3>{{ item.title }}</h3>
                                <p>{{ item.body }}</p>
                            </article>
                        </div>
                    </div>
                </ContentWrapper>
            </section>
            <FaqList :items="tiresFaq" />
        </template>

        <template v-else-if="pageKey === 'junk'">
            <section class="page-section">
                <ContentWrapper>
                    <div class="junk-content">
                        <article v-reveal class="content-card junk-buy-card">
                            <h2>What we buy</h2>
                            <ul class="detail-list detail-list--compact">
                                <li v-for="item in junkBuy" :key="item.title">
                                    <span><strong>{{ item.title }}</strong>{{ item.body }}</span>
                                </li>
                            </ul>
                            <p>Clean and running cars too. Tell us what you have and we look at every car.</p>
                        </article>
                        <div v-reveal class="benefit-panel">
                            <p><Icon name="truck" />Free towing within our service area.</p>
                            <p><Icon name="cash" />Paid in cash at pickup.</p>
                        </div>
                        <article v-reveal class="content-card junk-need-card">
                            <h2>What you need</h2>
                            <p>The vehicle title and your ID.</p>
                            <span class="tag">No title rules to confirm</span>
                        </article>
                    </div>
                </ContentWrapper>
            </section>
            <section class="page-section junk-estimate-section">
                <ContentWrapper>
                    <div class="junk-free-estimate">
                        <div>
                            <h2>Free estimate.</h2>
                            <p>Tell us the year, make, model, the condition and where the car is. Photos help. We get back to you, and you decide.</p>
                        </div>
                        <RouterLink class="button button--primary" :to="{ path: '/contact', query: { s: 'junk' } }">
                            Tell us about your car
                            <Icon name="arrow" />
                        </RouterLink>
                    </div>
                </ContentWrapper>
            </section>
        </template>

        <template v-else-if="pageKey === 'how'">
            <section class="page-section">
                <ContentWrapper>
                    <ol class="how-steps">
                        <li v-for="step in steps" :key="step.number">
                            <span class="how-steps__number">{{ step.number }}</span>
                            <h2>{{ step.title }}</h2>
                            <p>{{ step.body }}</p>
                        </li>
                    </ol>
                </ContentWrapper>
            </section>
            <section class="page-section">
                <ContentWrapper>
                    <h2>What shapes your price</h2>
                    <div class="card-grid">
                        <article v-for="factor in priceFactors" :key="factor.title" class="content-card">
                            <span class="icon-tile"><Icon :name="factor.icon" /></span>
                            <h3>{{ factor.title }}</h3>
                            <ul class="plain-list">
                                <li v-for="detail in factor.details" :key="detail">{{ detail }}</li>
                            </ul>
                        </article>
                    </div>
                </ContentWrapper>
            </section>
        </template>

        <template v-else-if="pageKey === 'contact'">
            <section class="page-section">
                <ContentWrapper>
                    <div class="contact-layout">
                        <div class="contact-grid">
                            <section class="contact-card">
                                <h2>Phone and text</h2>
                                <a class="contact-phone" href="tel:+12679242208">+1 267-924-2208</a>
                                <div class="hero-actions">
                                    <a class="button button--primary" href="tel:+12679242208"><Icon name="phone" />Call</a>
                                    <RouterLink class="button" to="/contact"><Icon name="chat" />Request service</RouterLink>
                                </div>
                            </section>
                            <section class="contact-card">
                                <h2>Write to us</h2>
                                <span class="tag">Email to confirm</span>
                                <p>Or use the form and choose Other question.</p>
                            </section>
                            <section class="contact-card">
                                <h2>Address</h2>
                                <p class="contact-address">3506 S 61st St<br>Philadelphia, PA 19153</p>
                                <a class="button contact-map-button" :href="directionsUrl" target="_blank" rel="noopener noreferrer"><Icon name="pin" />Open the map</a>
                            </section>
                            <section class="contact-card">
                                <div class="hours-heading">
                                    <h2>Hours</h2>
                                    <span class="open-pill" :class="{ 'open-pill--closed': !isOpen }">{{ isOpen ? 'Open now' : 'Shop closed' }}</span>
                                </div>
                                <table class="hours-table">
                                    <tbody>
                                        <tr><th scope="row">Monday to Saturday</th><td>8:00 am to 5:00 pm</td></tr>
                                        <tr><th scope="row">Sunday</th><td>Closed</td></tr>
                                        <tr><th scope="row">Mobile locksmith</th><td>24/7</td></tr>
                                    </tbody>
                                </table>
                            </section>
                        </div>
                        <RequestForm />
                    </div>
                </ContentWrapper>
            </section>
        </template>

        <template v-else-if="pageKey === 'privacy'">
            <section class="page-section">
                <div class="privacy-content">
                    <section>
                        <h2>What we collect</h2>
                        <p>The request form collects the service or question, vehicle details, what you need, your phone number and email, and optional photos. Junk car requests also ask whether the car runs and its ZIP code. We use these details and photos to respond to your request.</p>
                        <p>When you call or text, your phone number is handled by your phone and messaging providers.</p>
                    </section>
                    <section>
                        <h2>Why</h2>
                        <p>Your request details and any photos are sent to our team by email so we can respond and provide information about the service you requested.</p>
                    </section>
                    <section>
                        <h2>How long we keep it</h2>
                        <p>The retention period for requests has not been confirmed.</p>
                        <span class="tag">Retention period to confirm</span>
                    </section>
                    <section>
                        <h2>Site measurement</h2>
                        <p>Analytics are not configured in this version. If enabled, the site may count calls, texts, directions and form use without collecting what you type.</p>
                        <span class="tag">Analytics provider to confirm</span>
                    </section>
                    <section>
                        <h2>Your choices</h2>
                        <p>Call or text <a href="tel:+12679242208">+1 267-924-2208</a> if you have a question about information you have shared.</p>
                    </section>
                    <p class="privacy-draft-note">Draft, November 2026. Dia Auto, 3506 S 61st St, Philadelphia, PA 19153.</p>
                </div>
            </section>
        </template>

        <template v-else>
            <section class="not-found-section">
                <div class="container">
                    <span class="red-label">Page not found</span>
                    <h1>Wrong turn.</h1>
                    <p>This page is not on our sign. Pick a counter below, or call us.</p>
                    <div class="hero-actions">
                        <RouterLink class="button button--primary" to="/">Back to home <span aria-hidden="true">→</span></RouterLink>
                        <RouterLink v-for="item in pageLinks" :key="item.to" class="button" :to="item.to">{{ item.label }}</RouterLink>
                    </div>
                </div>
            </section>
        </template>

    </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import ContentWrapper from '../layouts/ContentWrapper.vue';
import Icon from '../Icon.vue';
import FaqList from '../FaqList.vue';
import PhotoPanel from '../PhotoPanel.vue';
import RequestForm from '../RequestForm.vue';
import locksmithImage from '../../../../images/locksmith-key-cutting.webp';
import partsImage from '../../../../images/parts-used-part.webp';
import tiresImage from '../../../../images/tires-intro.webp';

const props = defineProps({
    pageKey: {
        type: String,
        required: true,
    },
});

const pageDefinitions = {
    locksmith: {
        number: '01',
        kicker: 'Service',
        title: 'Car Locksmith',
        subtitle: 'Lost keys, locked doors, key fobs. At the shop, or mobile 24/7.',
        showButtons: true,
        cta: 'Tell us your car. We confirm before you come.',
    },
    parts: {
        number: '02',
        kicker: 'Service',
        title: 'Used Auto Parts',
        subtitle: 'Tell us the car and the part. Walk in without an appointment, or we ship it.',
        showButtons: true,
        cta: 'Tell us the car and the part.',
    },
    tires: {
        number: '03',
        kicker: 'Service',
        title: 'Used Tires',
        subtitle: 'Tested tires, ready to mount.',
        showButtons: true,
        cta: 'Tell us your tire size.',
    },
    junk: {
        number: '04',
        kicker: 'We buy',
        title: 'Sell Your Junk Car',
        subtitle: 'Any car, any condition. Junkers, wrecks, parked and unused cars.',
        showButtons: true,
        cta: 'Tell us about your car. Free estimate.',
    },
    how: {
        kicker: 'Every service, same steps',
        title: 'How It Works',
        subtitle: 'We tell you the price before any work starts. You decide.',
        cta: 'You always know before we start.',
    },
    contact: {
        kicker: 'Dia Auto',
        title: 'Contact',
        subtitle: 'Call, text, walk in, or send us the car and what you need.',
        cta: '',
    },
    privacy: {
        kicker: 'Draft',
        title: 'Privacy',
        subtitle: 'What we collect when you contact us, and why.',
        cta: '',
    },
    'not-found': {
        kicker: '404 · Page not found',
        title: 'We could not find that page.',
        subtitle: 'Use the navigation to find a Dia Auto service.',
        cta: '',
    },
};

const locksmithServices = ['Key duplication', 'Remote and transponder programming', 'Lost key replacement', 'Car lockouts', 'Ignition repair'];
const locksmithCards = [
    { title: 'At the shop', body: 'Bring the car to 3506 S 61st St. Walk in Monday to Saturday, 8:00 am to 5:00 pm.', icon: 'pin' },
    { title: 'Mobile, 24/7', body: 'Locked out or lost your key away from the shop? We come to you, day or night. Call and tell us where you are.', icon: 'car', dark: true },
    { title: 'What to bring', body: 'Bring your ID, and the vehicle title for a lost key.', icon: 'check' },
];
const partsList = ['Engines', 'Transmissions', 'Doors', 'Mirrors', 'Lights', 'Bumpers', 'Wheels'];
const tireChecks = [
    { number: '01', title: 'Tested', body: 'Every tire is checked before it is sold.' },
    { number: '02', title: 'Within its date', body: 'We check the age of every tire.' },
    { number: '03', title: 'Mounted here', body: 'Mounting and balancing on site.' },
];
const junkBuy = [
    { title: 'Any condition. ', body: 'Running, not running, or mechanical failure.' },
    { title: 'Damaged or wrecked. ', body: 'Total loss, body damage, or scrap.' },
    { title: 'Unwanted or parked. ', body: 'Sitting idle, high mileage, or end of life.' },
    { title: 'All vehicle types. ', body: 'Sedans, SUVs, trucks, and vans.' },
];
const steps = [
    { number: '01', title: 'Tell us the car and what you need.', body: 'Call, text or use the form.' },
    { number: '02', title: 'We tell you the price.', body: 'Before any work starts.' },
    { number: '03', title: 'You decide.', body: 'Yes or no, no pressure.' },
    { number: '04', title: 'We get to work.', body: 'Or you pick up your part.' },
];
const priceFactors = [
    { title: 'Locksmith', details: ['Year', 'Make', 'Model', 'Type of key', 'Shop or mobile'], icon: 'key' },
    { title: 'Parts', details: ['The part', 'The car', 'Condition'], icon: 'gear' },
    { title: 'Tires', details: ['Size', 'Condition'], icon: 'tire' },
    { title: 'Junk car', details: ['Condition', 'Parts value', 'Location'], icon: 'car' },
];
const locksmithFaq = [
    { question: 'How much does a new key cost?', answer: 'It depends on the car and the key. Tell us the year, make and model and we tell you the price before we do anything.' },
    { question: 'I lost all my keys. Can you still help?', answer: 'Yes. Bring your ID and the vehicle title. Tell us the car first and we confirm before you come.' },
    { question: 'Can you program a remote or key fob?', answer: 'Yes. Tell us the year, make and model and we confirm first.' },
    { question: 'Do you come to me?', answer: 'Yes. Our mobile locksmith works 24/7. Call, tell us where you are and what car it is.' },
];
const tiresFaq = [
    { question: 'How much are your tires?', answer: 'It depends on the size and the condition. Tell us your tire size and we tell you the price before we mount anything.' },
    { question: 'How do you check a used tire?', answer: 'The planned check is tread, damage and the date code on the sidewall. The exact inspection method still needs to be confirmed with the owner.' },
    { question: 'Do you mount and balance?', answer: 'Yes, on site.' },
];
const directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=3506+S+61st+St%2C+Philadelphia%2C+PA+19153';
const page = computed(() => pageDefinitions[props.pageKey] ?? pageDefinitions['not-found']);
const pageLinks = [
    { to: '/car-locksmith', label: 'Car Locksmith' },
    { to: '/used-auto-parts', label: 'Used Parts' },
    { to: '/used-tires', label: 'Used Tires' },
    { to: '/sell-your-junk-car', label: 'Junk Cars' },
    { to: '/how-it-works', label: 'How It Works' },
    { to: '/contact', label: 'Contact' },
];

const phillyTime = new Intl.DateTimeFormat('en-US', {
    timeZone: 'America/New_York',
    weekday: 'short',
    hour: '2-digit',
    hourCycle: 'h23',
});
const currentTime = ref(Date.now());
const tiresImageLoading = ref(
    typeof window !== 'undefined' && window.matchMedia('(min-width: 900px)').matches ? 'eager' : 'lazy',
);
const isOpen = computed(() => {
    const parts = Object.fromEntries(phillyTime.formatToParts(currentTime.value).map(({ type, value }) => [type, value]));
    const hour = Number(parts.hour);
    return parts.weekday !== 'Sun' && hour >= 8 && hour < 17;
});
let clock;
let tireImageMediaQuery;
function updateTiresImageLoading(event) {
    tiresImageLoading.value = event.matches ? 'eager' : 'lazy';
}
onMounted(() => {
    clock = window.setInterval(() => { currentTime.value = Date.now(); }, 60000);
    tireImageMediaQuery = window.matchMedia('(min-width: 900px)');
    updateTiresImageLoading(tireImageMediaQuery);
    tireImageMediaQuery.addEventListener('change', updateTiresImageLoading);
});
onUnmounted(() => {
    window.clearInterval(clock);
    tireImageMediaQuery?.removeEventListener('change', updateTiresImageLoading);
});
</script>
