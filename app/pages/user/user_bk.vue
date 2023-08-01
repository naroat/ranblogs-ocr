<template>
	<view class="container">
		<u-navbar :title="title" :bgColor="bgColor">
			<view class="u-nav-slot" slot="left">
				<u-icon @click="goto('/pages/index/index')" name='home' size='30' color="#000"></u-icon>
			</view>
		</u-navbar>
		user loading...
		<!-- 头像，名称, 积分展示 -->
		<!-- 签到 -->
		<!-- 历史识别记录 -->
		<!-- 关于 -->
		<!-- 隐私协议 -->
		<!-- 退出登录 -->
		
		<!-- other -->
		<!-- email register input send code -->
		<!-- check code register success; one time auto login -->
		
	</view>
</template>

<script>
	export default {
		data() {
			return {
				
			}
		},
		methods: {
			
		}
	}
</script>

<style>
.container{
	display: flex;
	flex-direction: column;
	height: 100%;
}
</style>
