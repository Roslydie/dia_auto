<template>
    <div>
        <section class="home-hero">
            <div class="home-hero__content">
                <div class="hero-badges">
                    <span class="stamp">We tell you first.</span>
                    <span v-if="isOpen" class="open-pill">Open now</span>
                    <a v-else class="closed-pill" href="tel:+12679242208">Shop closed. Mobile locksmith 24/7: call now.</a>
                </div>
                <h1>Keys, parts and tires. <em>One address</em> in Southwest Philadelphia.</h1>
                <p class="home-hero__sub">Car locksmith, used auto parts, used tires, and we buy junk cars.</p>
                <div class="hero-actions">
                    <a class="button button--primary" href="tel:+12679242208">Call +1 267-924-2208</a>
                    <RouterLink class="button button--outline-light" to="/contact">
                        <Icon name="chat" />
                        Request service
                    </RouterLink>
                    <a class="button button--outline-light" :href="directionsUrl" target="_blank" rel="noopener noreferrer">
                        <Icon name="pin" />
                        Get directions
                    </a>
                </div>
                <p class="hero-address">
                    <Icon name="pin" />
                    3506 S 61st St, Philadelphia, PA 19153
                </p>
            </div>
            <span class="home-hero__caption">Illustrative photo</span>
        </section>

        <div class="ticker" aria-label="Keys, parts, tires, junk cars">
            <div class="ticker__track" aria-hidden="true">
                <div v-for="group in 2" :key="group" class="ticker__group">
                    <template v-for="repeat in 4" :key="repeat">
                        <template v-for="item in tickerItems" :key="`${group}-${repeat}-${item}`">
                            <span class="ticker__word">{{ item }}</span>
                            <span class="ticker__dot">·</span>
                        </template>
                    </template>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="container">
                <div class="section-intro">
                    <h2 class="section-heading">Four counters.<br>One shop.</h2>
                    <p class="section-lead">Walk in Monday to Saturday, or call. Our mobile locksmith works 24/7.</p>
                </div>
                <div class="card-grid">
                    <RouterLink
                        v-for="service in services"
                        :key="service.number"
                        v-reveal
                        class="service-card"
                        :to="service.to"
                    >
                        <div class="service-card__top">
                            <span class="service-card__number">{{ service.number }}</span>
                            <span class="service-card__icon"><Icon :name="service.icon" /></span>
                        </div>
                        <h3>{{ service.title }}</h3>
                        <p>{{ service.summary }}</p>
                        <span class="service-card__cta">{{ service.action }} <span aria-hidden="true">→</span></span>
                    </RouterLink>
                </div>
            </div>
        </section>

        <section class="section dark-section">
            <div class="container">
                <p class="eyebrow">How it works</p>
                <h2 class="section-heading">Ask. Hear it. Decide.</h2>
                <ol class="steps-grid">
                    <li v-for="step in steps" :key="step.number" v-reveal class="step-card">
                        <span class="step-card__number">{{ step.number }}</span>
                        <strong>{{ step.title }}</strong>
                        <span>{{ step.body }}</span>
                    </li>
                </ol>
                <div class="section-action">
                    <p style="margin:0;font-size:19px;max-width:44ch">We tell you the price before any work starts. You decide.</p>
                    <RouterLink class="button button--outline-light" to="/how-it-works">
                        How it works
                        <Icon name="arrow" />
                    </RouterLink>
                </div>
            </div>
        </section>
          
        <section class="why-section" aria-label="Why Dia Auto">
            <div class="container">
                <ul v-reveal class="why-grid">
                    <li v-for="reason in whyReasons" :key="reason.title" class="why-card">
                        <span class="why-icon">
                            <Icon :name="reason.icon" />
                        </span>
                        <span class="why-copy">
                            <strong>{{ reason.title }}</strong>
                            <span v-if="reason.toConfirm" class="tag">To confirm</span>
                        </span>
                    </li>
                </ul>
                <p class="why-location">Serving ZIP 19153 and 25 miles around.</p>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="section-intro">
                    <h2 class="section-heading">From the neighborhood</h2>
                </div>
                <div class="review-grid">
                    <figure v-for="review in reviews" :key="review.name" v-reveal class="review-card">
                        <div class="review-card__top">
                            <span role="img" :aria-label="`Rated ${review.rating} out of 5`" class="review-stars">★★★★★</span>
                            <span class="tag">Sample</span>
                        </div>
                        <blockquote>{{ review.text }}</blockquote>
                        <figcaption>
                            <strong>{{ review.name }}</strong>
                            <span>{{ review.date }}</span>
                        </figcaption>
                    </figure>
                </div>
                <div class="review-actions">
                    <button class="button" type="button" disabled>Read all reviews on Google</button>
                    <button class="button button--primary" type="button" disabled>Leave a review</button>
                    <span class="tag">Google link to confirm</span>
                </div>
            </div>
        </section>

        <section class="visit-band">
            <div class="container visit-band__inner">
                <div>
                    <p class="eyebrow">Visit the shop</p>
                    <h2>3506 S 61st St.</h2>
                    <p>Philadelphia, PA 19153. Monday to Saturday, 8:00 am to 5:00 pm. Sunday closed.</p>
                </div>
                <div class="hero-actions">
                    <a class="button button--cream" :href="directionsUrl" target="_blank" rel="noopener noreferrer">
                        <Icon name="pin" />
                        Get directions
                    </a>
                    <a class="button button--outline-light" href="tel:+12679242208">
                        <Icon name="phone" />
                        Call +1 267-924-2208
                    </a>
                </div>
            </div>
        </section>

    </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import Icon from '../Icon.vue';

const directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=3506+S+61st+St%2C+Philadelphia%2C+PA+19153';
const tickerItems = ['KEYS', 'PARTS', 'TIRES', 'JUNK CARS'];
const services = [
    { number: '01', to: '/car-locksmith', title: 'Car Locksmith', summary: 'Lost keys, locked doors, key fobs.', action: 'Locksmith services', icon: 'key' },
    { number: '02', to: '/used-auto-parts', title: 'Used Auto Parts', summary: 'Tell us the car and the part.', action: 'Find a part', icon: 'gear' },
    { number: '03', to: '/used-tires', title: 'Used Tires', summary: 'Tested tires, ready to mount.', action: 'See tires', icon: 'tire' },
    { number: '04', to: '/sell-your-junk-car', title: 'We Buy Junk Cars', summary: 'Any car, any condition. Get a free estimate.', action: 'Sell your car', icon: 'car' },
];
const steps = [
    { number: '01', title: 'Tell us the car and what you need.', body: 'Call, text or use the form.' },
    { number: '02', title: 'We tell you the price.', body: 'Before any work starts.' },
    { number: '03', title: 'You decide.', body: 'Yes or no, no pressure.' },
    { number: '04', title: 'We get to work.', body: 'Or you pick up your part.' },
];
const whyReasons = [
    { title: 'Certified and insured', icon: 'check', toConfirm: true },
    { title: 'Mobile locksmith 24/7', icon: 'key' },
    { title: 'Local shop, walk in Monday to Saturday', icon: 'pin' },
];
const reviews = [
    { name: 'Sample reviewer 1', rating: 5, date: 'Review date', text: 'Sample review text goes here. Replaced by a real Google review.' },
    { name: 'Sample reviewer 2', rating: 5, date: 'Review date', text: 'Sample review text goes here. Replaced by a real Google review.' },
];

const timeFormatter = new Intl.DateTimeFormat('en-US', {
    timeZone: 'America/New_York',
    weekday: 'short',
    hour: '2-digit',
    hourCycle: 'h23',
});
const now = ref(Date.now());
const isOpen = computed(() => {
    const parts = Object.fromEntries(timeFormatter.formatToParts(now.value).map(({ type, value }) => [type, value]));
    const hour = Number(parts.hour);
    return parts.weekday !== 'Sun' && hour >= 8 && hour < 17;
});

let clock;
onMounted(() => {
    clock = window.setInterval(() => { now.value = Date.now(); }, 60000);
});
onUnmounted(() => window.clearInterval(clock));
</script>
