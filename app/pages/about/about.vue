<template>
	<view>
		<u-navbar :is-back="false" :title="title" :bgColor="bgColor"></u-navbar>
		
		<view class="mx-30 my-30">
			欢迎来到本站~
		</view>
		<view class="mx-30 content-box">
			<view class="font-weight" style="font-size: 60rpx;">关于</view>
			<view class="mx-30 my-30" style="font-size: 32rpx; color:#484848;">
				<view style="margin-top: 10rpx;"></view>
			</view>
			<view class="font-weight my-30" style="font-size: 60rpx;">归档</view>
			<view class="mx-30" style="font-size: 32rpx; color:#484848;">
				<view style="margin-top: 10rpx;"></view>
			</view>
			<view class="font-weight my-30" style="font-size: 60rpx;">版权声明</view>
			<view class="mx-30" style="font-size: 32rpx; color:#484848;">
				<view style="margin-top: 10rpx;"></view>
			</view>
		</view>
		
		<!-- 底部bar占位 -->
		<view style="height:120rpx;"></view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				title: "关于",
				bgColor: "#3ec1d3",
			}
		},
		methods: {
			
		}
	}
</script>

<style>
.content-box{
	background-color: #fff;
	border-radius: 10rpx;
	padding: 10rpx;
}
</style>
