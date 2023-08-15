<template>
	<view class="container">
		<!-- <u-button @click="copyText">goods</u-button> -->
		<iframe :src="payPageUrl" frameborder="0" v-show="payPageShow" style="height: 100%"></iframe>
		<view class="" v-show="payPageShow == false">
			<view class="integral-product">
				<view class="integral-product-item" @click="chooseProduct(item, 'integral')" v-for="(item, index) in integralProduct">
					<view>{{item.name}}</view>
					<view class="line-through">${{item.old_price}} 原价</view>
					<view>${{item.price}}元</view>
					<view>限时特惠</view>
				</view>
			</view>
			<view class="member-product">
				<view class="member-product-item" @click="chooseProduct(item, 'member')" v-for="(item, index) in memberProduct">
					<view>{{item.name}}</view>
					<view>
						<view>{{item.desc}}</view>
						<view>${{item.price}}/月</view>
					</view>
				</view>
			</view>
			<view>
				<u-button :disabled="price > 0 ? false : true" @click="buy()">${{price}} 去支付</u-button>
			</view>
		</view>
	</view>

</template>

<script>
import { APIURL } from '../../config'
	// import swiperList from "@/ran-common/data/swiper.js"
	export default {
		data() {
			return {
				payPageUrl: '',
				payPageShow: false,
				integralProduct: [],
				memberProduct: [],
				storeId: 0,
				productId: 0,
				variantId: 0,
				price: 0,
				buyType: 'integral',
			}
		},
		onPageScroll(e) {
		},
		onReachBottom() {
		},
		onLoad() {
		},
		methods: {
			chooseProduct(product, buyType) {
				this.storeId = product.platform_store_id
				this.productId = product.platform_product_id
				this.variantId = product.platform_variant_id
				this.price = product.price
				this.buyType = buyType
			},
			getIntegralProduct() {
				let that = this
				uni.request({
					url: APIURL + '/v1/integral/product/lists',
					method: 'GET',
					data: {},
					header: {
						Authorization: 'Bearer ' + that.$ran.cache('token'),
					},
					success: (res) => {
						that.integralProduct = res.data.data.data
					}
				})
			},
			getMemberProduct() {
				let that = this
				uni.request({
					url: APIURL + '/v1/member/product/lists',
					method: 'GET',
					data: {},
					header: {
						Authorization: 'Bearer ' + that.$ran.cache('token'),
					},
					success: (res) => {
						that.memberProduct = res.data.data.data
					}
				})
			},
			buy() {
				let that = this
				let uri = '/v1/buy/integral';
				if (that.buyType == 'member') {
					uri = '/v1/buy/member';
				}
				uni.request({
					url: APIURL + uri,
					method: 'POST',
					data: {
						'embed': true,
						'store_id': that.storeId,
						'variant_id': that.variantId
					},
					header: {
						Authorization: 'Bearer ' + that.$ran.cache('token'),
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
			this.getIntegralProduct()
			this.getMemberProduct()
		}
	}
</script>
<style>
.container{
	display: flex;
	flex-direction: column;
	height: 100%;
}
.integral-product-item{
	border: medium double #000;
}
.member-product-item{
	border: medium double #000;
}
</style>
