<template>
	<view class="container">
		<u-navbar :title="title" :bgColor="bgColor">
			<view class="u-nav-slot" slot="left">
				<u-icon @click="$ran.goto('/pages/index/index')" name='home' size='30' color="#0081cd"></u-icon>
			</view>
		</u-navbar>
		<view class="zai-box">
			<image src="../../static/images/login.png" mode='aspectFit' class="zai-logo"></image>
			<view class="zai-title">{{pageTitle}}</view>
			<view class="zai-form">
				<u--input v-model="email" placeholder="请输入邮箱" :customStyle="zaiInputCustomStyle"/>
				<u--input v-model="password" password placeholder="请输入密码" :customStyle="zaiInputCustomStyle"/>
				<!-- <navigator url="/pages/user/reset?type=forget" hover-class="none" class="zai-label">忘记密码？</navigator> -->
				<view @click="$ran.goto('/pages/user/reset?type=forget')" class="zai-label">忘记密码？</view>
				<!-- <view class="zai-label" @click="$ran.goto('/pages/user/reset?type=forget')">忘记密码？</view> -->
				<u-button :customStyle="zaiBtn" @click="login">立即登录</u-button>
				<!-- <navigator url="pages/user/register" hover-class="none" class="zai-label">还没有账号？点此注册.</navigator> -->
				<view @click="$ran.goto('/pages/user/register')" class="zai-label">还没有账号？点此注册.</view>
			</view>
		</view>
	</view>
	
</template>

<script>
import { APP_NAME,APIURL } from '../../config'
export default {
	data() {
		return {
			title: APP_NAME,
			pageTitle: '登录',
			bgColor: "#fff",
			email: '',
			password: '',
			zaiInputCustomStyle: 'background-color: #fff;margin-top: 30rpx;border-radius: 100rpx; padding: 20rpx 40rpx; font-size: 36rpx;',
			zaiBtn: 'background: #0081cd; color: #fff; border: 0; border-radius: 100rpx; font-size: 36rpx;',
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
	.container{
		display: flex;
		flex-direction: column;
		height: 100%;
	}
	.zai-box{
		padding: 0 100rpx;
		position: relative;
	}
	.zai-logo{
		width: 100%;
		width: 100%;
		height: 310rpx;
	}
	.zai-title{
		position: absolute;
		top: 0;
		line-height: 360rpx;
		font-size: 65rpx;
		color: #fff;
		text-align: center;
		width: 100%;
		margin-left: -100rpx;
	}
	.zai-form{
		margin-top: 300rpx;
	}
	.input-placeholder{
		color: #94afce;
	}
	.zai-label{
		padding: 60rpx 0;
		text-align: center;
		font-size: 30rpx;
		color: #a7b6d0;
	}
</style>
