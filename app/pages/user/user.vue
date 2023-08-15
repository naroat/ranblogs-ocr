<template>
	<view class="orane-content">
		<u-navbar :title="title" :bgColor="bgColor">
			<view class="u-nav-slot" slot="left">
				<u-icon @click="$ran.goto('/pages/index/index')" name='home' size='30' color="#0081cd"></u-icon>
			</view>
		</u-navbar>
		<view class="orane-usertop">
			<view class="statusbar" :style="'height:'+statusbarheight"></view>
			<!-- #ifndef H5 -->
			<view class="topfix"></view>
			<!-- #endif -->
			<view class="userline1" @tap="toUrl()">
				<image :src="userInfo.avatar" class="userimg"></image>
				<view class="username">
					<text class="name">{{userInfo.nickname}}</text>
					<view class="info">
						<text class="itxt">积分 {{userInfo.integral}}</text>
						<text class="itxt" v-if="userInfo.member_status == 1">
							<label style="border: 3rpx double #fff; border-radius: 10rpx;padding: 0 5rpx;">{{userInfo.member_name}}</label>
							<label style="color: #ebe8ee;margin-left: 5rpx;">至: {{userInfo.member_expire_time_tran}}</label>
						</text>
					</view>
				</view>
			</view>
			<!-- <view class="userline2" @tap="toUrl()">
				<text class="tagother" v-if="userInfo.gender == 1">男</text>
				<text class="tagother" v-else-if="userInfo.gender == 2">女</text>
				<text class="tagother" v-else>保密</text>
				<text class="tagother">{{userInfo.solar}}</text>
				<text class="tagother">{{userInfo.area}}</text>
				<text class="tagother">+ 编辑标签</text>
			</view> -->
			<!-- <view class="userline3"><text class="signttx">{{userInfo.bio}}</text></view> -->
		</view>
		<view class="orane-usermenus">
			<u-cell-group>
				<u-cell
				    size="large"
				    title="签到"
					label="每日签到获取5积分"
					:value="checkInValue"
					:disabled="checkInDisabled"
					@click="checkIn"
				></u-cell>
				<u-cell
				    size="large"
				    :title="userInfo.invite_code"
					label="邀请用户获取20积分"
					value="复制"
					@click="copyInvite"
				></u-cell>
				<!-- <u-cell
				    size="large"
				    title="购买积分或会员"
					@click="$ran.goto('/pages/user/pay')"
					isLink
				></u-cell> -->
				<u-cell
				    size="large"
				    title="修改密码"
					@click="$ran.goto('/pages/user/reset?type=reset')"
					isLink
				></u-cell>
			</u-cell-group>
			<view style="width:100%;">
				<u-button @click="logout" type="primary"  style="margin-top: 30rpx; width: 70%;">退出登录</u-button>
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
				bgColor: "#fff",
				statusbarheight: '',
				checkInValue: '点击签到',
				checkInDisabled: false,
				userInfo: {
					id: '',
					nickname: '登录',
					avatar: '../../static/user/avatar.png',
					email: '',
					integral: 0,
					bio:'这个家伙太懒了，什么也没写...',
					status: '',
					invite_code: '',
					other_invite_code: '',
					check_in: 0,
					member_status: 0,
					member_name: '',
					member_expire_time_tran: '',
				},
				
			}
		},
		onLoad() {
			//获取状态栏高度
			this.statusbarheight = uni.getStorageSync('statusBarHeight') + 'px'
			this.getProfile()
		},
		onPullDownRefresh() {
			this.getProfile()
		},
		methods: {
			//页面跳转
			toUrl(link) {
				// uni.showToast({
				// 	title:'',
				// 	icon:'none'
				// })
			},
			//初始化数据
			getProfile() {
				setTimeout(() => {
					uni.stopPullDownRefresh();
				}, 200)
			},
			//获取用户信息
			getUserInfo() {
				let that = this
				uni.request({
					url: APIURL + '/v1/user/info',
					method: 'GET',
					data: {
					},
					header: {
						Authorization: 'Bearer ' + that.$ran.cache('token')
					},
					success: (res) => {
						that.userInfo.nickname = res.data.data.nick_name;
						that.userInfo.avatar = res.data.data.avatar;
						if (res.data.data.avatar == '' || res.data.data.avatar == undefined) {
							that.userInfo.avatar = '../../static/user/avatar.png'
						}
						that.userInfo.integral = res.data.data.integral;
						that.userInfo.email = res.data.data.email;
						that.userInfo.id = res.data.data.id;
						that.userInfo.status = res.data.data.status;
						that.userInfo.invite_code = res.data.data.invite_code;
						that.userInfo.other_invite_code = res.data.data.other_invite_code;
						that.userInfo.check_in = res.data.data.check_in;
						that.userInfo.member_status = res.data.data.member_status;
						that.userInfo.member_name = res.data.data.member_name;
						that.userInfo.member_expire_time_tran = res.data.data.member_expire_time_tran;
						//判断是否签到
						if (that.userInfo.check_in == 1) {
							that.checkInDisabled = true;
							that.checkInValue = '今日已签到';
						}
						//记录缓存
						that.$ran.cache('email', that.userInfo.email)
					}
				})
			},
			//签到
			checkIn() {
				let that = this
				uni.request({
					url: APIURL + '/v1/check/in',
					method: 'POST',
					data: {
					},
					header: {
						Authorization: 'Bearer ' + that.$ran.cache('token')
					},
					success: (res) => {
						uni.showToast({
							title: '签到成功',
							icon: "success"
						})
						location.reload()
					}
				})
			},
			//复制邀请码
			copyInvite() {
				let that = this
				uni.setClipboardData({
					data: that.userInfo.invite_code,
					success: () => {
						uni.showToast({
							title: "复制成功",
							icon: "success"
						})
					},
				}, true)
			},
			//退出登录
			logout() {
				uni.removeStorageSync('token')
				uni.reLaunch({
					url: '/pages/index/index'
				})
			},
		},
		mounted() {
			this.getUserInfo()
			//更新签到
			if (this.userInfo.check_in == 1) {
				this.checkInDisabled = true;
				this.checkInValue = '今日已签到';
			}
		}
	}
</script>

<style scoped>
	page{
		background-color: #fff;
	}
	.statusbar{
		width: 750rpx;
	}
	.orane-usertop {
		width: 750rpx;
		background-color: #0081cd;
		display: flex;
		flex-direction: column;
		padding:50rpx 0 20rpx 0;
	}
	.orane-usertop .topfix{
		height: 100rpx;
	}

	.orane-usertop .userline1 {
		flex-direction: row;
		align-items: center;
		padding: 0 30rpx;
		display: flex;
		margin-bottom: 40rpx;
	}

	.orane-usertop .userline1 .userimg {
		width: 120rpx;
		height: 120rpx;
		border-radius: 100rpx;
		border: 4rpx solid #fff;
		margin-right: 20rpx;
	}

	.orane-usertop .userline1 .username {
		display: flex;
		flex-direction: column;
		width: 550rpx;
	}

	.orane-usertop .userline1 .username .name {
		color: #fff;
		font-size: 36rpx;
		margin-bottom:6rpx;
		font-weight: 600;
	}

	.orane-usertop .userline1 .username .info {
		flex-direction: row;
	}

	.orane-usertop .userline1 .username .info .itxt {
		font-size: 28rpx;
		color: #fff;
		margin-right: 20rpx;
	}

	.orane-usertop .userline2 {
		flex-direction: row;
		align-items: center;
		display: flex;
		padding: 0 30rpx;
		margin-bottom: 40rpx;
	}

	.orane-usertop .userline2 .tags {
		margin-right: 12rpx;
		flex-direction: row;
		align-items: center;
		background-color: rgba(0, 0, 0, .2);
		border-radius: 5rpx;
		padding: 6rpx 20rpx;
		display: flex;
		font-size: 28rpx;
	}

	.orane-usertop .userline2 .tags .tagimg {
		width: 26rpx;
		height: 26rpx;
		margin-right: 2rpx;
	}

	.orane-usertop .userline2 .tags .tagtxt {
		color: #1296db;
		font-size: 26rpx;
	}

	.orane-usertop .userline2 .tags .tagtxt.nv {
		color: #d4237a;
		font-size: 26rpx;
	}

	.orane-usertop .userline2 .tagother {
		margin-right: 12rpx;
		font-size: 28rpx;
		color: #fff;
		background-color: rgba(0, 0, 0, .2);
		border-radius: 6rpx;
		padding: 0 18rpx;
		height: 46rpx;
		display: flex;
		align-items: center;
	}
	
	.orane-usertop .userline3{
		display: flex;
		align-items: center;
		padding: 0 30rpx;
		margin-bottom: 30rpx;
	}
	.orane-usertop .userline3 .signttx {
		flex-direction: row;
		align-items: center;
		font-size: 28rpx;
		color: #fff;
	}

	.orane-usermenus {
		padding: 30rpx 0;
		justify-content: center;
		flex-direction: row;
		flex-wrap: wrap;
		align-items: center;
		display: flex;
	}

	.orane-usermenus .micon {
		width: 180rpx;
		justify-content: center;
		align-items: center;
		margin: 36rpx 0;
		position: relative;
		display: flex;
		flex-direction: column;
	}

	.orane-usermenus .micon .new {
		position: absolute;
		width: 16rpx;
		height: 16rpx;
		border-radius: 16rpx;
		background-color: #f30;
		right: 60rpx;
		top: 0;
	}

	.orane-usermenus .micon .mimg {
		width: 50rpx;
		height: 50rpx;
		margin-bottom: 16rpx;
	}

	.orane-usermenus .micon .txt {
		font-size: 28rpx;
	}
</style>