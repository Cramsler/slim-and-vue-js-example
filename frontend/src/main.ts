import { createApp } from 'vue';
import ElementPlus from 'element-plus';
import axios from "axios";
import 'element-plus/dist/index.css';
import App from './App.vue';
import router from './router';
import store from './store';


const app = createApp(App);

const axiosInstance = axios.create({
    baseURL: 'http://localhost:8000/api/',
    headers: {
        'Content-Type': 'application/json',
        'Accept': '*/*'
    },
    auth: {
        username: 'api-admin',
        password: 'secret'
    },
});

app.config.globalProperties.$axios = axiosInstance;

app.use(store).use(router).use(ElementPlus).mount('#app');
