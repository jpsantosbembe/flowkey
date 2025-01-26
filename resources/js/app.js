import '../css/app.css';
import './bootstrap';
import 'vuetify/styles'; // Importa os estilos do Vuetify
import '@mdi/font/css/materialdesignicons.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createVuetify } from 'vuetify'; // Importa a função createVuetify
import * as components from 'vuetify/components'; // Importa os componentes do Vuetify
import * as directives from 'vuetify/directives'; // Importa as diretivas do Vuetify

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const vuetify = createVuetify({
            components,
            directives,
            icons: {
                defaultSet: 'mdi'
            }
        });

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify) // Adiciona o Vuetify ao aplicativo Vue
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
