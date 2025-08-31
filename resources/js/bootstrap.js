import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/*
// resources/js/bootstrap.js

import axios from 'axios';

window.axios = axios;

// Set common headers
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
*/
// Get the CSRF token from the <meta> tag
const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found in meta tag. Ensure it exists in your Blade template.');
}
