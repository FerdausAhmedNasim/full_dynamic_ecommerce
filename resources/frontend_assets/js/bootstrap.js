import axios from 'axios';
import moment from "moment";
window.moment = moment;

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.BASE_URL = getBaseUrl();
window.axios.defaults.headers.common['CSRF-TOKEN'] = getToken();

function getToken()
{
    return document.getElementsByName("csrf-token")[0].getAttribute('content');
}

function getBaseUrl()
{
    return document.getElementsByName("base-url")[0].getAttribute('content');
}



