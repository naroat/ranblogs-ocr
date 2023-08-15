<template>
	<view class="container">
		<u-navbar :title="title" :bgColor="bgColor">
			<view class="u-nav-slot" slot="left">
				<u-icon @click="$ran.goto('/pages/index/index')" name='home' size='30' color="#000"></u-icon>
			</view>
		</u-navbar>
		<view class="zai-box">
			<image src="../../static/images/register.png" mode='aspectFit' class="zai-logo"></image>
			<view class="zai-title">{{pageTitle}}</view>
			<view class="zai-form">
				<u--input class="zai-input" v-model="email" :disabled="emailDis" placeholder-class placeholder=""/>
				<view class="zai-input-btn">
					<input class="zai-input" v-model="code" placeholder-class placeholder="验证码"/>
					<view class="zai-checking" @click="checking" v-if="state===false">获取验证码</view>
					<view class="zai-checking zai-time" v-if="state===true">倒计时{{ currentTime }}s</view>
				</view>
				<u--input class="zai-input" v-model="password" placeholder-class password placeholder="请输入密码"/>
				<u--input class="zai-input" v-model="password_confirmation" placeholder-class password placeholder="请重复输入密码"/>
				<u-button class="zai-btn" @click="resetPassword">立即修改</u-button>
				<!-- <navigator url="/pages/user/login" open-type='navigateBack' hover-class="none" class="zai-label">已有账号，点此去登录.</navigator> -->
				<view @click="$ran.goto('/pages/user/login')" class="zai-label" v-if="type != 'reset'">已有账号，点此去登录.</view>
			</view>
		</view>
	</view>
</template>

<script>
	import { APP_NAME, APIURL } from '../../config'
	export default {
		data() {
			return {
				title: APP_NAME,
				pageTitle: '',
				bgColor: "#0081cd",
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
				password_confirmation: ''	//重复密码
			}
		},
		onLoad() {
			this.type = this.$route.query.type;
			if (this.type == 'reset') {
				//修改密码
				this.pageTitle = '修改密码'
				this.emailDis = true
				this.email = this.$ran.cache('email')
			} else {
				//忘记密码
				this.pageTitle = '忘记密码'
				this.emailDis = false
			}
		},
		methods: {
			checking() {
				//把显示时间设为总时间
				this.currentTime = this.totalTime;
				//开始倒计时
				this.state = true;
				//执行倒计时
				this.checkingTime();
				//发送验证码
				this.sendCode();
			},
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
					success: (res) => {
						uni.showToast({
							title: '发送成功',
							icon: 'success'
						})
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
					password: that.password,
					password_confirmation: that.password_confirmation
				};
				uni.request({
					url: url,
					data: data,
					header: header,
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
		background: #fff;
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
		background: #0081cd;
		color: #fff;
		border: 0;
		border-radius: 100upx;
		font-size: 36upx;
		margin-top: 60upx;
	}
	.zai-btn:after{
		border: 0;
	}
	
	/*验证码输入框*/
	.zai-input-btn{
		position: relative;
	}
	.zai-input-btn .zai-input{
		padding-right: 260upx;
	}
	.zai-checking{
		position: absolute;
		right: 0;
		top: 0;
		background: #0081cd;
		color: #fff;
		border: 0;
		border-radius: 110upx;
		font-size: 36upx;
		margin-left: auto;
		margin-right: auto;
		padding-left: 28upx;
		padding-right: 28upx;
		box-sizing: border-box;
		text-align: center;
		text-decoration: none;
		line-height: 2.55555556;
		-webkit-tap-highlight-color: transparent;
		overflow: hidden;
		padding-top: 2upx;
		padding-bottom: 2upx;
	}
	.zai-checking.zai-time{
		background: #a7b6d0;
	}
	
	/*按钮点击效果*/
	.zai-btn.button-hover{
		transform: translate(1upx, 1upx);
	}
</style>
