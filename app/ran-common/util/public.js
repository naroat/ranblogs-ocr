export default {
    //路由跳转
    goto(path) {
    	//uni.$u.route(path, params);
		// uni.navigateTo({
		// 	url: path
		// })
		uni.reLaunch({
			url: path
		})
    },
	
	//返回上一页
	gotoPre() {
		uni.navigateBack()
	},
	
	//过滤html标签
	filterHtml(val) {
		return val && val.replace(/<(?:.|\n)*?>/gm, '')
		    .replace(/(&rdquo;)/g, '\"')
		    .replace(/&ldquo;/g, '\"')
		    .replace(/&mdash;/g, '-')
		    .replace(/&nbsp;/g, '')
		    .replace(/&gt;/g, '>')
		    .replace(/&lt;/g, '<')
		    .replace(/<[\w\s"':=\/]*/, '');
	},
	
	/**
	 * 检测邮箱
	 * @param {Object} email
	 */
	checkEmail(email) {
		const regEmail = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
		if (!regEmail.test(email)) {
			//不合法
			return false;
		}
		//合法
		return true;
	},
	
	/**
	 * 检测手机号
	 * @param {Object} phone
	 */
	checkPhone(mobile) {
		const regMobile = /^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;
		if (!regMobile.test(mobile)) {
			//不合法
			return false;
		}
		//合法
		return true;
	},
	// 缓存函数，设置或获取缓存值，带有过期时间戳
	// key: 缓存的键名，必填
	// value: 缓存的值，选填，如果为空则表示获取缓存，如果不为空则表示设置缓存
	// seconds: 缓存的过期时间，单位为秒，选填，默认为7天
	cache(key, value, seconds) {
		// 获取当前时间戳，单位为秒
		const timestamp = Date.parse(new Date()) / 1000;
		//console.log(`${timestamp}===${key}`);
		// 如果key为空，直接返回
		if (!key) {
			return;
		}
		// 如果value为空，表示获取缓存
		if (value === null || value === undefined) {
			// 获取缓存值，并按照"|"分割成数组
			const val = uni.getStorageSync(key);
			const tmp = val.split("|");
			// 如果数组的第二个元素不存在或者小于等于当前时间戳，表示缓存已过期，删除缓存并返回空字符串
			if (!tmp[1] || timestamp >= tmp[1]) {
				uni.removeStorageSync(key);
				return "";
			} else {
				// 否则表示缓存未过期，返回数组的第一个元素，即缓存值
				return tmp[0];
			}
		} else {
			// 如果value不为空，表示设置缓存
			// 如果seconds为空，则使用默认值7天，否则使用传入的值
			const expire = seconds ? timestamp + seconds : timestamp + 3600 * 24 * 7;
			// 将缓存值和过期时间戳用"|"连接成一个字符串，并存入缓存
			value = `${value}|${expire}`;
			uni.setStorageSync(key, value);
		}
	},
	//验证登录
	checkLogin() {
		if (!this.cache('token')) {
			//没有登录
			return false;
		} else {
			//登录
			return true;
		}
	},
}