// 页面白名单，不受拦截
const whiteList = [
	'/pages/index/index',
	'/pages/user/login',
	'/pages/user/register',
	'/pages/user/reset',
]
function hasPermission (url) {
	let toekn = uni.getStorageSync('token');//在这可以使用token,isLogin是登录成功后在本地存储登录标识
	let isLogin = false
	if (token != undefined) {
		isLogin = true
	}
    // 在白名单中或有登录判断条件可以直接跳转
    if(whiteList.indexOf(url) !== -1 || isLogin) {
        return true
    }
    return false
}
uni.addInterceptor('navigateTo', {
    // 页面跳转前进行拦截, invoke根据返回值进行判断是否继续执行跳转
    invoke (e) {
        if(!hasPermission(e.url)){
            uni.reLaunch({
                url: '/pages/user/login'
            })
            return false
        }
        return true
    },
    success (e) {
		
    }
})

/**
 * 拦截器 - request
 */
uni.addInterceptor('request', {
    // 页面跳转前进行拦截, invoke根据返回值进行判断是否继续执行跳转
    invoke (res) {
    },
    success (res) {
		let code = res.data.code
		if (code != 200) {
			uni.showToast({
				title: res.data.message,
				icon: 'error'
			})
			return false
		}
    },
	fail(err) {
		//检测失败原因
	}
})

/**
 * 拦截器 - uploadFile
 */
uni.addInterceptor('uploadFile', {
    // 页面跳转前进行拦截, invoke根据返回值进行判断是否继续执行跳转
    invoke (res) {
    },
    success (res) {
		let data = JSON.parse(res.data)
		let code = data.code
		if (code != 200) {
			uni.showToast({
				title: data.message,
				icon: 'error'
			})
			return false
		}
    },
	fail(err) {
		//检测失败原因
		console.log('ljq----uploadFile');
		console.log(err);
	}
})