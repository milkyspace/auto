import Vue from 'vue'
import App from './App.vue'
import store from './store'
import $ from 'jquery'
import mixins from './mixins/custom'

$(() => {

    Vue.config.productionTip = false;

    Vue.mixin(mixins);

    Vue.filter('price', function (value) {
        let val = (value/1).toFixed(0).replace('.', ',')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    })

    new Vue({
      store,
      render: h => h(App),
    }).$mount('#vue-calc-container')

})

