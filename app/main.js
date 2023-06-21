import App from './App'

// #ifndef VUE3
import Vue from 'vue'
import uView from '@/uni_modules/uview-ui'
import Config from '@/config'
Vue.use(uView)

Vue.config.productionTip = false
App.mpType = 'app'
const app = new Vue({
    ...App
})

//request基础配置和拦截器
require('./config/request.js')(app)
//自用公共方法($ran)
import $ran from './ran-common/util/public.js'
Vue.prototype.$ran = $ran

app.$mount()
// #endif

// #ifdef VUE3
import { createSSRApp } from 'vue'
export function createApp() {
  const app = createSSRApp(App)
  return {
    app
  }
}
// #endif