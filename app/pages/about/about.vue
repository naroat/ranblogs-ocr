<template>
	<view>
		<u-navbar :is-back="false" :title="title" :bgColor="bgColor"></u-navbar>
		
		<view class="mx-30 my-30">
			欢迎来到本站~
		</view>
		<view class="mx-30 content-box">
			<view class="font-weight" style="font-size: 60rpx;">关于</view>
			<view class="mx-30 my-30" style="font-size: 32rpx; color:#484848;">
				<view style="margin-top: 10rpx;">作者：一线码农，后端开发，热爱编程；喜欢电影，乒乓球</view>
				<view style="margin-top: 10rpx;">建站原因：闲的</view>
				<view style="margin-top: 10rpx;">网站定位：技术分享，学习笔记 问题记录</view>
			</view>
			<view class="font-weight my-30" style="font-size: 60rpx;">博客历史</view>
			<view class="mx-30" style="font-size: 32rpx; color:#484848;">
				<view style="margin-top: 10rpx;">2021.12.26 首页和网址导航页面改版</view>
				<view style="margin-top: 10rpx;">2021.12.10 老博客文章迁移</view>
				<view style="margin-top: 10rpx;">2021.11.30 优化前后端问题，提升访问速度， 添加网址导航功能</view>
				<view style="margin-top: 10rpx;">2021.10.30 搭建博客</view>
			</view>
			<view class="font-weight my-30" style="font-size: 60rpx;">版权声明</view>
			<view class="mx-30" style="font-size: 32rpx; color:#484848;">
				<view style="margin-top: 10rpx;">本站的原创博文转载请务必注明作者ranblogs以及原文出处链接</view>
				<view style="margin-top: 10rpx;">另外，本站博文未经授权不得用于任何商业目的</view>
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
