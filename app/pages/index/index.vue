<template>
	<view class="container">
		<u-navbar :title="title" :bgColor="bgColor"></u-navbar>
		<view class="u-demo-block__content" style="height: 100%">
			<!-- fyFrom -->
			<view class="fyFrom" v-show="showFyFrom">
				<view class="originImgBox">
					<u--image 
					:fade="true" 
					:showLoading="true" 
					:src="originImg" 
					height="380rpx" 
					mode="heightFix"
					@click="previewImg(originImg)"></u--image>
				</view>
				<view class="textFromBox">
					<view class="textFromBox-bar">
						<u-button @click="copyText">复制</u-button>
						<u-button @click="formatText">去换行</u-button>
						<u-button @click="restoreTextFrom">还原</u-button>
					</view>
					<u--textarea class="textareaFrom" v-model="textFrom" placeholder="请输入内容" count></u--textarea>
				</view> 
			</view>
			<!-- base -->
			<view class="base-show" v-show="baseShow">
				<view class="base-show-box">
					<view class="base-show-title">
						传图提取图片内文字
					</view>
					<view class="base-show-content">
						<p>使用说明：</p>
						<p>1.点击'中英文'可以选择识别的内容</p>
						<p>2.点击'拍照/相册'即可拍照或选择图片</p>
						<p>3.网速不好可能会出现延迟，请耐心等待再次选择</p>
						<p>4.识别后的图片系统将会自动删除只保留结果</p>
						<p>5.文字识别率最高可达99%，字迹清晰的图片有利于提高准确度</p>
					</view>
					<!-- <view class="base-show-share" @click="textFromTo">
						推荐给朋友>>
					</view> -->
				</view>
			</view>
			<!-- chooseImg -->
			<view class="fixed-buttom"> 
				<view class="chooseImg">
					<u-picker :show="chooseTextShow" :columns="columns" @confirm="chooseTextConfirm" @change="chooseTextChange" @cancel="chooseTextCancel"></u-picker>
					<view class="chooseText" @click="chooseTextShow = true">
						<view>{{chooseText}}</view>
						<view>
							<u-icon name="arrow-down-fill" color="#000" size="22"></u-icon>
						</view>
					</view>
					<u-button
						type="primary" 
						:hairline="true" 
						:plain="true" 
						@click="chooseImg"
						width="100%"
						height="100%"
						icon="photo"
						:disabled="chooseImgDisabled"
						text="拍照/相册">
					</u-button>
				</view>
			</view>
		</view>

		<!-- 加载更多 -->
		<!-- <u-loadmore :status="status" /> -->
		<!-- 底部bar占位 -->
		<!-- <view style="height:100rpx;"></view> -->
	</view>

</template>

<script>
import { APIURL, ACCESS_KEY, OPENAPI_TOKEN } from '../../config'
	// import swiperList from "@/ran-common/data/swiper.js"
	export default {
		data() {
			return {
				title: "免费识别文字",
				bgColor: "#3ec1d3",
				originImg: 'https://cdn.uviewui.com/uview/demo/upload/positive.png',
				textFrom: '',
				originTextFrom : '',
				ocrImg: [],
				chooseTextShow: false,
				chooseText: '中英文',
				columns: [
					['中英文']
				],
				showFyFrom: false,
				baseShow: true,
				chooseImgDisabled: false,
			}
		},
		onPageScroll(e) {
		},
		onReachBottom() {
		},
		onLoad() {

		},
		methods: {
			// 删除图片
			deletePic(event) {
				this[`fileList${event.name}`].splice(event.index, 1)
			},
			//选择翻译文本类型-确认时
			chooseTextConfirm(e){
				if (e.value[0]) {
					this.chooseText = e.value[0]
				} else {
					this.chooseText = "中英文"
				}
				this.chooseTextShow = false
			},
			//选择翻译文本类型 - 变更时
			chooseTextChange(e){
			},
			//选择翻译文本类型 - 取消时
			chooseTextCancel()
			{
				this.chooseTextShow = false;
			},
			share(){},
			//拍照选择图片
			chooseImg() {
				let that = this
				that.chooseImgDisabled = true
				uni.chooseImage({
					count: 6, //默认9
					sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
					sourceType: ['album','camera'],   //album 从相册选图，camera 使用相机
					success: function (res) {
						//发送请求
						that.Ocr(res.tempFilePaths[0])
					},
				});
			}, 
			Ocr(url) {
				let that = this;
				return new Promise((resolve, reject) => {
					uni.uploadFile({
						url: APIURL + '/v1/baidu/ocr/general/basic', 
						type: "POST",
						header: {
							'content-type':'multipart/form-data;charset=utf-8',
							Accesskey: ACCESS_KEY,
							OpenapiToken: OPENAPI_TOKEN,
						},
						filePath: url,
						name: 'image',
						success: (res) => {
							let result = JSON.parse(res.data)
							let wordsResult = result.data.words_result
							// debugger
							for (let index in wordsResult) {
								//显示识别文本
								that.textFrom += wordsResult[index].words + '\n'
							}
							that.originTextFrom = that.textFrom
							//显示识别图片
							that.originImg = url
							//显示识别区域
							that.showFyFrom = true;
							//取消拍照/相册禁用
							that.chooseImgDisabled = false;
							//使用说明区域隐藏
							that.baseShow = false;
							
							
						},
						fail(err) {
							//取消拍照/相册禁用
							that.chooseImgDisabled = false;
							reject(err)
						}
					});
				})
			},
			//点击放大图片
			previewImg(img) {
				let arr = [];
				arr.push(img)
				uni.previewImage({
					current: 0,
					urls: arr,
				})
			},
			//复制识别文本
			copyText() {
				let that = this
				uni.setClipboardData({
					data: that.textFrom,
					success: () => {
						uni.showToast({
							title: "复制成功",
							icon: "success"
						})
					},
				}, true)
			},
			//去换行
			formatText() {
				let that = this
				let strList = that.textFrom.split('\n')
				let newStr = '';
				for (let index in strList) {
					newStr += strList[index]
				}
				that.textFrom = newStr
			},
			//还原初始文本
			restoreTextFrom() {
				this.textFrom = this.originTextFrom
			},
			//文本发送到
			textFromTo() {
				/**
					scene 属性值
					WXSceneSession 分享到聊天界面
					WXSceneTimeline 分享到朋友圈
					WXSceneFavorite 分享到微信收藏
				*/
			   //l:{"errMsg":"share:fail method 'share' not supported"}
			    let that = this
				uni.share({
					provider: "weixin",
					scene: "WXSceneSession",
					type: 1,
					summary: that.textFrom,
					success: function(res) {
						console.log("success:" + JSON.stringify(res));
					},
					fail: function(err) {
						console.log("fail:" + JSON.stringify(err));
					}
				})
			}
		},
		mounted: function(){
			console.log(APIURL);
			console.log(ACCESS_KEY);
		}
	}
</script>
<style>
.container{
	display: flex;
	flex-direction: column;
	height: 100%;
}
.fyFrom .base-show{
	display: flex;
	flex-direction: column;
	/* flex:1; */
	height: 100%;
}
.chooseImg{
	display: flexbox;
	padding: 20rpx;
	/* position: absolute; */
	flex-direction: column;
}
.chooseText{
	display: flex;
	justify-content: center;
	padding: 20rpx;
}
.textFromBox-bar{
	display: flex;
}
.originImgBox{
	display: flex;
	justify-content: center;
}
.textareaFrom{
	/* min-height: 350rpx; */
	/* max-height: 200rpx; */
	height: 100%;
}
.textFromBox{
	display: flex;
	flex-direction: column;
	flex: 1;
}
.fixed-buttom{
	position: fixed;
	bottom: 15rpx;
	display: block;
	width: 100%;
}
.base-show{
	display: flex;
	flex-direction: column;
	height: 90%;
}
.base-show-box{
	display: flex;
	flex-direction: column;
	text-align: center;
	align-content: center;
	margin: auto;
}
.base-show-title{
	display: flex;
	font-size: 50rpx;
	margin: 0 auto 0 auto;
}
.base-show-content{
	display: flex;
	flex-direction: column;
	background-color: #fff;
	text-align: left;
	border-radius: 15rpx;
	margin: 20rpx;
	padding: 20rpx;
}
.base-show-content p{
	margin: 5rpx 0;
}
.base-show-share{
	display: flex;
	margin: 0 auto 0 auto;
}
</style>
