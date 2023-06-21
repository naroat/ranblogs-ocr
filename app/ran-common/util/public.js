export default {
    //路由跳转
    goto(path, params) {
    	uni.$u.route(path, params);
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
	}
}