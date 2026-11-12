<template>
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <RouterLink to="/" aria-label="Dia Auto, home">
                        <img :src="logoUrl" alt="Dia Auto">
                    </RouterLink>
                    <span class="stamp">We tell you first.</span>
                </div>

                <section class="footer-column" aria-labelledby="footer-visit">
                    <h2 id="footer-visit">Visit</h2>
                    <p>3506 S 61st St<br>Philadelphia, PA 19153</p>
                    <a :href="directionsUrl" target="_blank" rel="noopener noreferrer">Get directions</a>
                    <a href="tel:+12679242208">+1 267-924-2208</a>
                </section>

                <section class="footer-column" aria-labelledby="footer-hours">
                    <h2 id="footer-hours">Hours</h2>
                    <p>Monday to Saturday<br>8:00 am to 5:00 pm</p>
                    <p>Sunday closed</p>
                    <p>Mobile locksmith 24/7</p>
                </section>

                <nav class="footer-nav" aria-label="Footer navigation">
                    <h2>Pages</h2>
                    <RouterLink v-for="item in links" :key="item.to" :to="item.to">
                        {{ item.label }}
                    </RouterLink>
                    <RouterLink to="/privacy">Privacy</RouterLink>
                </nav>
            </div>

            <div class="footer-bottom">
                <p>
                    &copy; {{ currentYear }}
                    <a href="https://revoryxandpartners.com" target="_blank" rel="noopener noreferrer">
                        Revoryx and Partners
                    </a>. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</template>

<script setup>
const logoUrl = '/assets/img/logo-cream-navy.png';
const currentYear = new Date().getFullYear();
const directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=3506+S+61st+St%2C+Philadelphia%2C+PA+19153';
const links = [
    { to: '/car-locksmith', label: 'Car Locksmith' },
    { to: '/used-auto-parts', label: 'Used Parts' },
    { to: '/used-tires', label: 'Used Tires' },
    { to: '/sell-your-junk-car', label: 'Junk Cars' },
    { to: '/how-it-works', label: 'How It Works' },
    { to: '/contact', label: 'Contact' },
];
</script>
