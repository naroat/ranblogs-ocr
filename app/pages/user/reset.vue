<template>
	<view class="container">
		<u-navbar :title="title" :bgColor="bgColor">
			<view class="u-nav-slot" slot="left">
				<u-icon @click="$ran.goto('/pages/index/index')" name='home' size='30' color="#0081cd"></u-icon>
			</view>
		</u-navbar> 
		<view class="zai-box">
			<image src="../../static/images/register.png" mode='aspectFit' class="zai-logo"></image>
			<view class="zai-title">{{pageTitle}}</view>
			<view class="zai-form">
				<u--input :customStyle="zaiInputCustomStyle" v-model="email" :disabled="emailDis" placeholder-class placeholder="请输入邮箱"/>
				<view class="zai-input-btn">
					<u--input :customStyle="zaiInputCheckCustomStyle" v-model="code" placeholder-class placeholder="验证码"/>
					<view :style="zaiCheckingCustomStyle" @click="sendCode" v-if="state===false">获取验证码</view>
					<view :style="zaiCheckingCustomStyle" v-if="state===true">倒计时{{ currentTime }}s</view>
				</view>
				<u--input :customStyle="zaiInputCustomStyle" v-model="password" placeholder-class password placeholder="请输入密码"/>
				<u--input :customStyle="zaiInputCustomStyle" v-model="password_confirmation" placeholder-class password placeholder="请重复输入密码"/>
				<u-button :customStyle="zaiBtn" @click="resetOrForgetPassword">立即修改</u-button>
				<!-- <navigator url="/pages/user/login" open-type='navigateBack' hover-class="none" class="zai-label">已有账号，点此去登录.</navigator> -->
				<view @click="$ran.goto('/pages/user/login')" class="zai-label" v-if="type != 'reset'">已有账号，点此去登录.</view>
			</view>
		</view>
	</view>
</template>

<script>
	import { APP_NAME, APIURL } from '../../config'
	import md5 from '../../js_sdk/js-md5'
	export default {
		data() {
			return {
				title: APP_NAME,
				pageTitle: '',
				bgColor: "#fff",
				type: '',
				emailDis: false,
				state: false,		//是否开启倒计时
				totalTime: 60,		//总时间，单位秒
				recordingTime: 0, 	//记录时间变量
				currentTime: 0, 	//显示时间变量
				email: '',			//邮箱
				code: '',			//验证码
				nick_name: '',		//用户名
				password: '',		//密码
				password_confirmation: '',	//重复密码
				zaiInputCustomStyle: 'background-color: #fff;margin-top: 30rpx;border-radius: 100rpx; padding: 20rpx 40rpx; font-size: 36rpx;',
				zaiInputCheckCustomStyle: 'padding-right: 260rpx; background-color: #fff;margin-top: 30rpx;border-radius: 100rpx; padding: 20rpx 40rpx; font-size: 36rpx;',
				zaiCheckingCustomStyle: 'z-index:999;position: absolute; right: 0; top: 0; background: #0081cd; color: #fff; border: 0; border-radius: 110rpx; font-size: 36rpx; margin-left: auto; margin-right: auto; padding-left: 28rpx; padding-right: 28rpx; box-sizing: border-box; text-align: center; text-decoration: none; line-height: 2.42; -webkit-tap-highlight-color: transparent; overflow: hidden; padding-top: 2rpx; padding-bottom: 2rpx;',
				zaiBtn: 'background: #0081cd; color: #fff; border: 0; border-radius: 100rpx; font-size: 36rpx;',
			}
		},
		onLoad() {
			this.type = this.$route.query.type;
			//修改密码
			this.pageTitle = '修改密码'
			this.emailDis = true
			this.email = this.$ran.cache('email')
		},
		methods: {
			checkingTime(){
				let that = this;
				//判断是否开启
				if(this.state){
					//判断显示时间是否已到0，判断记录时间是否已到总时间
					if(this.currentTime > 0 && this.recordingTime <= this.totalTime){
						//记录时间增加 1
						this.recordingTime = this.recordingTime + 1;
						//显示时间，用总时间 - 记录时间
						this.currentTime = this.totalTime - this.recordingTime;
						//1秒钟后，再次执行本方法
						setTimeout(() => { 	
							//定时器内，this指向外部，找不到vue的方法，所以，需要用that变量。
							that.checkingTime();
						}, 1000)
					}else{
						//时间已完成，还原相关变量
						this.state = false;		//关闭倒计时
						this.recordingTime = 0;	//记录时间为0
						this.currentTime = this.totalTime;	//显示时间为总时间
					}
				}else{
					//倒计时未开启，初始化默认变量
					this.state = false;
					this.recordingTime = 0;
					this.currentTime = this.totalTime;
				}
			},
			/**
			 * 发送验证码
			 */
			sendCode() {
				let that = this
				if (!that.$ran.checkEmail(that.email)) {
					uni.showToast({
						title: '邮箱格式错误',
						icon: 'error'
					})
					return
				}
				let url = APIURL + '/v1/send/forget/password/code';
				let data = {
					email: that.email,
				};
				let header = {};
				if (this.type == 'reset') {
					url = APIURL + '/v1/send/reset/password/code';
					data = {}
					header = {
						'Authorization': 'Bearer ' + that.$ran.cache('token')
					};
				}
				
				uni.request({
					url: url,
					data: data,
					header: header,
					method: "POST",
					success: (res) => {
						uni.showToast({
							title: '发送成功',
							icon: 'success'
						})
						
						//把显示时间设为总时间
						that.currentTime = that.totalTime;
						//开始倒计时
						that.state = true;
						//执行倒计时
						that.checkingTime();
					}
				})
			},
			/**
			 * 修改或忘记密码提交
			 */
			resetOrForgetPassword() {
				let that = this
				if (!that.$ran.checkEmail(that.email)) {
					uni.showToast({
						title: '邮箱格式错误',
						icon: 'error'
					})
					return
				}
				//两次密码验证
				if (that.password != that.password_confirmation) {
					uni.showToast({
						title: '两次密码输入不一致',
						icon: 'error'
					})
					return
				}
				
				let url = APIURL + '/v1/forget/password';
				let header = {};
				if (this.type == 'reset') {
					url = APIURL + '/v1/reset/password';
					header = {
						'Authorization': 'Bearer ' + that.$ran.cache('token')
					};
				}
				let data = {
					email: that.email,
					code: that.code,
					password: md5(that.password),
					password_confirmation: md5(that.password_confirmation)
				};
				uni.request({
					url: url,
					data: data,
					header: header,
					method: "POST",
					success: (res) => {
						//跳转登录
						if (this.type == 'reset') {
							//修改密码后，退出登录，跳转登录页面
							uni.removeStorageSync('token')
							that.$ran.goto('/pages/user/login')
						} else {
							//忘记密码，跳转登录页面
							that.$ran.goto('/pages/user/login')
						}
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
		font-size: 68rpx;
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
	.zai-btn{
		background: #0081cd;
		color: #fff;
		border: 0;
		border-radius: 100rpx;
		font-size: 36rpx;
		margin-top: 60rpx;
	}
	.zai-btn:after{
		border: 0;
	}
	
	/*验证码输入框*/
	.zai-input-btn{
		position: relative;
	}
	.zai-input-btn .zai-input{
		padding-right: 260rpx;
	}
</style>
