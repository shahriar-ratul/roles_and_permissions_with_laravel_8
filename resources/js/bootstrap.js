window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');


    require('bootstrap');
    require('admin-lte')
    require('datatables.net-bs4');
    require('datatables.net-buttons-bs4');

} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseUrl = "http://localhost:8000";
