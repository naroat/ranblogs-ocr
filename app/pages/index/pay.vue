<template>
	<view class="container">
		<!-- <a href="https://ranblogs.lemonsqueezy.com/checkout/buy/ed9f557d-8706-4b1e-a691-3903ca50e160?embed=1" class="lemonsqueezy-button">Buy 会员</a><script src="https://assets.lemonsqueezy.com/lemon.js" defer></script> -->
		<u-button @click="copyText">gooooooo</u-button>
	</view>

</template>

<script>
import { APIURL, ACCESS_KEY, OPENAPI_TOKEN } from '../../config'
	// import swiperList from "@/ran-common/data/swiper.js"
	export default {
		data() {
			return {
				
			}
		},
		onPageScroll(e) {
		},
		onReachBottom() {
		},
		onLoad() {

		},
		methods: {
			//复制识别文本
			copyText() {
				let that = this
				uni.request({
					url: APIURL + '/v1/pay/checkouts', //仅为示例，并非真实接口地址。
					method: 'POST',
					data: {
						//text: 'uni.request'
					},
					header: {
						
					},
					success: (res) => {
						console.log(res.data);
						this.text = 'request success';
					}
				})
			},
		},
		mounted: function(){
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
