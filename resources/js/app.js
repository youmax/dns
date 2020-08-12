import Popper from 'popper.js'
import moment from 'moment'


import '@fortawesome/fontawesome-free/css/all.css'

try {
  window.$ = window.jQuery = require('jquery')
  window.Popper = Popper;
  window.moment = moment;
  require('bootstrap');
} catch (e) {
  console.error(e);
}

import Vue from 'vue'
import VueMeta from 'vue-meta'
import { InertiaApp } from '@inertiajs/inertia-vue'
import PortalVue from 'portal-vue'
import clipboard from 'clipboard'
import Axios from 'axios'
import store from '@/Store'
import Layout from '@/Layout/Master/Layout'

Vue.config.productionTip = false
Vue.prototype.clipboard = clipboard
Axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content')
Vue.prototype.$http = Axios
Vue.mixin({ methods: { route: window.route } })
Vue.use(InertiaApp)
Vue.use(PortalVue)
Vue.use(VueMeta)

let app = document.getElementById('app')
let page = JSON.parse(app.dataset.page)
page.props['date'] = moment().format("YYYY MMM")
console.log(page.props)
new Vue({
  metaInfo: {
    title: `${page.props['app']['name']} - ${page.props['title']}`
  },
  store,
  render: h => h(InertiaApp, {
    props: {
      initialPage: page,
      resolveComponent: name => {
        const componentOptions = require(`./Pages/${name}`).default;
        if (componentOptions.layout == undefined) {
          componentOptions.layout = (h, page) => h(Layout, [page]);
        }
        return componentOptions;
      },
    },
  }),
}).$mount(app)
