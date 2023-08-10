<template>
	<view class="zai-box">
		<image src="../../static/images/login.png" mode='aspectFit' class="zai-logo"></image>
		<view class="zai-title">{{title}}</view>
		<view class="zai-form">
			<u--input class="zai-input" v-model="email" placeholder="请输入邮箱" />
			<u--input class="zai-input" v-model="password" password placeholder="请输入密码"/>
			<navigator url="/pages/user/reset?type=forget" hover-class="none" class="zai-label">忘记密码？</navigator>
			<!-- <view class="zai-label" @click="$ran.goto('/pages/user/reset?type=forget')">忘记密码？</view> -->
			<u-button class="zai-btn" @click="login">立即登录</u-button>
			<navigator url="/pages/user/register" hover-class="none" class="zai-label">还没有账号？点此注册.</navigator>
		</view>
	</view>
</template>

<script>
import { APP_NAME,APIURL } from '../../config'
export default {
	data() {
		return {
			title: '',
			email: '',
			password: '',
		}
	},
	onLoad() {
		//检查是否登录，登录后不能进入登录页面
		if (this.$ran.checkLogin()) {
			uni.reLaunch({
				url: '/pages/index/index'
			})
		}
	},
	methods: {
		/**
		 * login
		 */
		login() {
			let that = this
			if (!that.$ran.checkEmail(that.email)) {
				uni.showToast({
					title: '邮箱格式错误',
					icon: 'error'
				})
				return
			}
			uni.request({
				url: APIURL + '/v1/login',
				method: 'POST',
				data: {
					email: that.email,
					password: that.password
				},
				header: {},
				success: (res) => {
					//登录成功
					//记录缓存token
					that.$ran.cache('token', res.data.data.token)
					//登录后跳转首页
					uni.reLaunch({
						url: '/pages/index/index'
					});
				}
			})
		}
	}
}
</script>

<style>
	.zai-box{
		padding: 0 100upx;
		position: relative;
	}
	.zai-logo{
		width: 100%;
		width: 100%;
		height: 310upx;
	}
	.zai-title{
		position: absolute;
		top: 0;
		line-height: 360upx;
		font-size: 68upx;
		color: #fff;
		text-align: center;
		width: 100%;
		margin-left: -100upx;
	}
	.zai-form{
		margin-top: 300upx;
	}
	.zai-input{
		background: #e2f5fc;
		margin-top: 30upx;
		border-radius: 100upx;
		padding: 20upx 40upx;
		font-size: 36upx;
	}
	.input-placeholder, .zai-input{
		color: #94afce;
	}
	.zai-label{
		padding: 60upx 0;
		text-align: center;
		font-size: 30upx;
		color: #a7b6d0;
	}
	.zai-btn{
		background: #ff65a3;
		color: #fff;
		border: 0;
		border-radius: 100upx;
		font-size: 36upx;
	}
	.zai-btn:after{
		border: 0;
	}
	/*按钮点击效果*/
	.zai-btn.button-hover{
		transform: translate(1upx, 1upx);
	}
</style>
