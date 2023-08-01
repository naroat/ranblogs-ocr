import App from './App'

// #ifndef VUE3
import Vue from 'vue'
//引入uView-ui
import uView from '@/uni_modules/uview-ui'
//引入配置
import Config from '@/config'
Vue.use(uView)

Vue.config.productionTip = false
App.mpType = 'app'
const app = new Vue({
    ...App
})

//request基础配置和拦截器
// require('./config/request.js')(app)
//自用公共方法($ran)
import $ran from './ran-common/util/public.js'
Vue.prototype.$ran = $ran

//引入拦截器
import '@/components/Interceptor.js'

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