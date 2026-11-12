import './bootstrap';
import { createApp } from 'vue';
import router from './Components/routers/index.js';
import App from './Components/App.vue';

const app = createApp(App);

app.directive('reveal', {
    mounted(element) {
        if (window.matchMedia?.('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        if (!('IntersectionObserver' in window)) {
            return;
        }

        element.classList.add('reveal-pending');
        const observer = new IntersectionObserver(([entry]) => {
            if (!entry.isIntersecting) {
                return;
            }

            element.classList.add('is-revealed');
            observer.unobserve(element);
        }, { rootMargin: '0px 0px -5% 0px' });

        observer.observe(element);
        element.__revealObserver = observer;
    },
    unmounted(element) {
        element.__revealObserver?.disconnect();
    },
});

app.use(router).mount('#app');