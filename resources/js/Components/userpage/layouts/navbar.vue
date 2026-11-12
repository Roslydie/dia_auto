<template>
    <header class="site-header">
        <div class="nav-bar">
            <RouterLink class="brand" to="/" aria-label="Dia Auto, home" @click="closeMenu">
                <img :src="logoUrl" alt="Dia Auto">
            </RouterLink>

            <nav class="desktop-nav" aria-label="Main navigation">
                <RouterLink v-for="item in links" :key="item.to" :to="item.to">
                    {{ item.label }}
                </RouterLink>
                <a class="button button--primary" href="tel:+12679242208">Call now</a>
            </nav>

            <div class="nav-actions">
                <a class="button button--primary nav-call" href="tel:+12679242208">Call now</a>
                <button
                    class="menu-toggle"
                    type="button"
                    :aria-expanded="menuOpen"
                    aria-controls="mobile-menu"
                    :aria-label="menuOpen ? 'Close menu' : 'Open menu'"
                    @click="menuOpen = !menuOpen"
                    @keydown.esc.window="closeMenu"
                >
                    <span aria-hidden="true">{{ menuOpen ? '×' : '☰' }}</span>
                </button>
            </div>
        </div>

        <div v-if="menuOpen" id="mobile-menu" class="mobile-menu">
            <nav aria-label="Mobile navigation">
                <RouterLink to="/" @click="closeMenu">Home <span aria-hidden="true">→</span></RouterLink>
                <RouterLink v-for="item in links" :key="item.to" :to="item.to" @click="closeMenu">
                    {{ item.label }} <span aria-hidden="true">→</span>
                </RouterLink>
            </nav>
            <div class="mobile-menu__actions">
                <RouterLink class="button button--outline-light" to="/contact" @click="closeMenu">
                    <Icon name="chat" />
                    Request service
                </RouterLink>
                <a
                    class="button button--outline-light"
                    :href="directionsUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Get directions
                </a>
            </div>
            <p>3506 S 61st St, Philadelphia, PA 19153<br>Monday to Saturday, 8:00 am to 5:00 pm.</p>
        </div>
    </header>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import Icon from '../Icon.vue';

const links = [
    { to: '/car-locksmith', label: 'Car Locksmith' },
    { to: '/used-auto-parts', label: 'Used Parts' },
    { to: '/used-tires', label: 'Used Tires' },
    { to: '/sell-your-junk-car', label: 'Junk Cars' },
    { to: '/how-it-works', label: 'How It Works' },
    { to: '/contact', label: 'Contact' },
];

const directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=3506+S+61st+St%2C+Philadelphia%2C+PA+19153';
const logoUrl = '/assets/img/logo-main.png';
const menuOpen = ref(false);
const route = useRoute();

function closeMenu() {
    menuOpen.value = false;
}

watch(() => route.fullPath, closeMenu);
</script>
