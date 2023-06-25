import Vue from 'vue';
import Index from './components/Index';
require('./bootstrap');

const app = new Vue({
    el: '#app',
    components: {
        Index
    }
});
