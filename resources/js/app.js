import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, usePage } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { pageDirectives as isDirectives } from './directives';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        isDirectives.forEach(name => {
            app.directive(name instanceof Function? name() : name, {
                beforeMount(el, binding, vnode) {
                    const is = name instanceof Function? !!name(usePage().props) :!!usePage().props[name];

                    if (!is) {
                        el.style.display = "none"; // Hide the element if not a name
                    }
                },
            });
        });

        return app.use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
