require('./bootstrap');
import {createApp} from "vue";
import router from "@/router";
import VueHeader from "@/components/UI/VueHeader";
import directives from '@/directives';
import App from "@/components/App";
const app=createApp(App)



directives.forEach(directive => {
    app.directive(directive.name, directive)
})
app.
use(router)

    .mount('#app');

app.config.globalProperties.$link={
    artists : '/artists/',
    albums: '/albums/',
    dairies: '/dairy/'
}

