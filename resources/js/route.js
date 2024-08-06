import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

const router = new Router({
    mode: 'history',
    base: process.env.APP_URL,
    hash: false,
   
    routes: [
        
    ]
});
  
  export default router;
