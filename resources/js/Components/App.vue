<template>
    <div class="site">
        <a class="skip-link" href="#main" @click.prevent="focusMain">Skip to content</a>
        <Navbar />
        <main id="main" class="site-main" tabindex="-1">
            <RouterView />
            <ClosingBand />
        </main>
        <SiteFooter />
        <nav class="mobile-actions" aria-label="Quick contact">
            <a class="button button--primary" href="tel:+12679242208">Call now</a>
            <RouterLink class="button button--outline" to="/contact">
                <Icon name="chat" />
                Request service
            </RouterLink>
        </nav>
    </div>
</template>

<script setup>
import Navbar from './userpage/layouts/navbar.vue';
import SiteFooter from './userpage/layouts/footer.vue';
import ClosingBand from './userpage/layouts/ClosingBand.vue';
import Icon from './userpage/Icon.vue';

function focusMain() {
    document.getElementById('main')?.focus();
}
</script>