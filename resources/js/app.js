/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import Alpine from 'alpinejs';

/** ini alpine
 */

window.Alpine = Alpine;

Alpine.start();

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ChooseAndPayComponent from './components/ChooseAndPayComponent.vue';
import ShowQRComponent from './components/ShowQRComponent.vue';
import ShowWaitingNotiMessage from './components/ShowWaitingNotiMessage.vue';
import PaymentStatusComponent from './components/PaymentStatusComponent.vue';
import ShowAvailablePaymentsComponent from './components/ShowAvailablePaymentsComponent.vue';
import ShowPaymentInfoComponent from './components/ShowPaymentInfoComponent.vue';

app.component('choose-and-pay-component', ChooseAndPayComponent);
app.component('show-qr-component', ShowQRComponent);
app.component('show-waiting-message-component', ShowWaitingNotiMessage);
app.component('payment-status-message-component', PaymentStatusComponent);

app.component('show-available-payments-component', ShowAvailablePaymentsComponent);
app.component('show-payment-info-component', ShowPaymentInfoComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ChooseAndPayComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
