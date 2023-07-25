<template>
	<view class="container">
		<u-button @click="copyText">goods</u-button>
		<!-- <iframe :src="payPageUrl" frameborder="0" v-show="payPageShow" style="height: 100%"></iframe> -->
	</view>

</template>

<script>
import { APIURL, ACCESS_KEY, OPENAPI_TOKEN } from '../../config'
	// import swiperList from "@/ran-common/data/swiper.js"
	export default {
		data() {
			return {
				//测试卡号：4242424242424242
				//payPageUrl: 'https://ranblogs.lemonsqueezy.com/checkout/custom/ce488e35-84cd-42b8-80c4-66ca65fd3910?signature=f034e016e77792f95945b2fc3ff4168dae13442b8a8d7d5f1ee69b32d40df7cf',
				payPageUrl: '',
				payPageShow: false,
				
			}
		},
		onPageScroll(e) {
		},
		onReachBottom() {
		},
		onLoad() {
		},
		methods: {
			copyText() {
				let that = this
				uni.request({
					url: APIURL + '/v1/recharges', //仅为示例，并非真实接口地址。
					method: 'POST',
					data: {
						'embed': true,
						'store_id': 36267,
						'variant_id': 102178
					},
					header: {
						Authorization: "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiI2NGJlMzVjOGM2OTdmIiwiaWF0IjoxNjkwMTg3MjA4LCJuYmYiOjE2OTAxODcyMDgsImV4cCI6MTY5MDc5MjAwOCwidXNlcl9pZCI6NTQyNzUsInBob25lIjoiMTUwMTMwNzA3OTQifQ.fOd1I87IsUOOfgOije3h3z2kmeMt4vG1g7_BApKRUzY",
					},
					success: (res) => {
						console.log(res.data);
						//window.location.url = res.data.data.attributes.url
						that.payPageShow = true;
						that.payPageUrl = res.data.data.data.attributes.url
						//LemonSqueezy.Url.Open(res.data.data.attributes.url);
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
