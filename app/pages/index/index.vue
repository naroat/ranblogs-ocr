<template>
	<view class="container">
		<u-navbar :title="title" :bgColor="bgColor">
			<view class="u-nav-slot" slot="left">
				<!-- <u-icon @click="$ran.goto('/pages/index/index')" name='home' size='30' color="#0081cd"></u-icon> -->
			</view>
		</u-navbar>
		<view class="u-demo-block__content" style="height: 100%; background-color: #fff; display: flex; flex-direction: column;">
			<view style="flex-grow: 2;"></view>
			<view style="flex-grow: 3; justify-content: center;">
				<u--text style="margin: 30rpx 0;" text="From" align="center"></u--text>
				<u-number-box :step="1" v-model="startValue" integer button-size="50" style="justify-content: center;margin:auto 25%;" inputWidth="100">
					<!-- <u--input
						slot="input"
						style="height: 100rpx;background-color: rgb(235, 236, 238); margin: auto 4rpx; padding: 0;"
						class="input"
						fontSize="25"
						inputAlign="center"
						v-model="startValue"
					></u--input> -->
				</u-number-box>
				<u--text style="margin: 30rpx 0;" text="To" align="center"></u--text>
				<u-number-box :step="1" v-model="endValue" integer button-size="50" style="justify-content: center;margin:auto 25%;" inputWidth="100">
					<!-- <u--input
						slot="input"
						style="height: 100rpx;background-color: rgb(235, 236, 238); margin: auto 4rpx; padding: 0;"
						class="input"
						fontSize="25"
						inputAlign="center"
						v-model="endValue"
					></u--input> -->
				</u-number-box>
				<u--text style="margin: 30rpx 0;" text="Init" align="center" color="#19be6b" @click="initNum"></u--text>
				<u-button type="primary" text="Generate" style='width: 40%;' @click="genRandom" v-if="!genStatus"></u-button>
				<u-button type="primary" text="Generate..." style='width: 30%;' disabled v-else></u-button>
			</view>
			<view style="flex-grow: 1;"></view>
		</view>
		
		<!-- 弹窗 -->
		<u-overlay :show="show" @click="show = false" style="">
			<view style="display: flex; justify-content: center; align-items: center; height: 100%;">
				<view @tap.stop style="width: 300rpx; height: 300rpx; background-color: orange; color: white; font-size: 60rpx; line-height: 300rpx; text-align: center; opacity: 0.9;">
					{{this.randomNum}}
				</view>
			</view>
		</u-overlay>

		<!-- 加载更多 -->
		<!-- <u-loadmore :status="status" /> -->
		<!-- 底部bar占位 -->
		<!-- <view style="height:100rpx;"></view> -->
	</view>

</template>

<script>
import { APP_NAME, APIURL } from '../../config'
	// import swiperList from "@/ran-common/data/swiper.js"
	export default {
		data() {
			return {
				value: '',
				title: APP_NAME,
				bgColor: "#3c9cff",//0081cd	//#3c9cff
				startValue: 1,
				endValue: 100,
				randomNum: 0,
				genStatus: false,
				show: false,
				customStyleInput: {
					width: '50px',
					textAlign: 'center',
					backgroundColor: 'rgb(235, 236, 238)',
					height: '100rpx',
					margin: 'auto 4rpx',
				    lineHeight: '100rpx',
					fontSize: '50rpx',
					padding: 0,
				}
			}
		},
		onPageScroll(e) {
		},
		onReachBottom() {
		},
		onLoad() {
			
		},
		methods: {
			//生成
			genRandom() {
				this.genStatus = true
				this.show = true
				let count = 0
				var genInterval = setInterval(() => {
				  this.randomNum = Math.floor(Math.random() * (this.endValue - this.startValue + 1)) + this.startValue; 
				  count++
				  if (count > 10) {
					clearTimeout(genInterval)
					this.genStatus = false
				  }
				}, 50)
			},
			initNum() {
				this.startValue = 1
				this.endValue = 100
			}
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
.u-number-box u-number-box__input{
	font-size: 2rem !important;
}
</style>
