import { createRouter, createWebHistory } from 'vue-router';

import HomePage from '../userpage/Pages/home.vue';
import LocksmithPage from '../userpage/Pages/car_locksmith.vue';
import PartsPage from '../userpage/Pages/used_parts.vue';
import TiresPage from '../userpage/Pages/used_tired.vue';
import JunkCarsPage from '../userpage/Pages/junk_cars.vue';
import HowItWorksPage from '../userpage/Pages/how_work.vue';
import ContactPage from '../userpage/Pages/contact.vue';
import PrivacyPage from '../userpage/Pages/privacy.vue';
import NotFoundPage from '../userpage/Pages/not_found.vue';

const legacyHash = window.location.hash;
if (legacyHash.startsWith('#/')) {
    window.history.replaceState(null, '', `${window.location.pathname}${window.location.search}${legacyHash.slice(1)}`);
}

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        { path: '/', name: 'home', component: HomePage, meta: { title: 'Dia Auto | Keys, Parts and Tires', description: 'Car locksmith, used auto parts, used tires, and junk car buying in Southwest Philadelphia.' } },
        { path: '/car-locksmith', name: 'locksmith', component: LocksmithPage, meta: { title: 'Car Locksmith in Southwest Philadelphia | Dia Auto', description: 'Key duplication, remote and transponder programming, lost keys, lockouts and ignition repair. At the shop or mobile 24/7.' } },
        { path: '/used-auto-parts', name: 'parts', component: PartsPage, meta: { title: 'Used Auto Parts in Philadelphia | Dia Auto', description: 'Engines, transmissions, doors, mirrors, lights, bumpers and wheels. Walk in without an appointment, or we ship it.' } },
        { path: '/used-tires', name: 'tires', component: TiresPage, meta: { title: 'Used Tires in Philadelphia | Dia Auto', description: 'Every tire is tested and within its date. Mounting and balancing on site.' } },
        { path: '/sell-your-junk-car', name: 'junk-cars', component: JunkCarsPage, meta: { title: 'We Buy Junk Cars in Philadelphia | Dia Auto', description: 'Junkers, wrecks and cars nobody drives anymore. Bring the vehicle title and your ID.' } },
        { path: '/how-it-works', name: 'how-it-works', component: HowItWorksPage, meta: { title: 'How It Works | Dia Auto', description: 'Tell us the car. We tell you the price before any work starts. You decide.' } },
        { path: '/contact', name: 'contact', component: ContactPage, meta: { title: 'Contact and Directions | Dia Auto', description: 'Call, text, walk in or send a request. Monday to Saturday, 8:00 am to 5:00 pm. Mobile locksmith 24/7.' } },
        { path: '/privacy', name: 'privacy', component: PrivacyPage, meta: { title: 'Privacy | Dia Auto', description: 'How Dia Auto handles the information you send us.' } },
        { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFoundPage, meta: { title: 'Page not found | Dia Auto', description: 'This page is not on our sign. Car locksmith, used parts, used tires and junk cars in Southwest Philadelphia.' } },
    ],
    scrollBehavior() {
        return { top: 0 };
    },
});

router.afterEach((to) => {
    document.title = to.meta.title ?? 'Dia Auto';
    const description = document.querySelector('meta[name="description"]');
    description?.setAttribute('content', to.meta.description ?? '');
});

export default router;