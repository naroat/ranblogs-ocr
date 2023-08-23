<template>
	<view class="container">
		<u-navbar :title="title" :bgColor="bgColor">
			<view class="u-nav-slot" slot="left">
				<u-icon @click="$ran.goto('/pages/index/index')" name='home' size='30' color="#0081cd"></u-icon>
			</view>
		</u-navbar>
		<view class="u-demo-block__content" style="height: 100%">
			<!-- fyFrom -->
			<view class="fyFrom" v-show="showFyFrom">
				<view class="originImgBox">
					<audio v-if="nowChooseType == 'audio'" :src="originAudio" style="height: 380rpx;"></audio>
					<u--image 
					v-else
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
					<u--textarea class="textareaFrom" v-model="textFrom" placeholder="请输入内容" count height="450rpx"></u--textarea>
				</view> 
			</view>
			<!-- base -->
			<view class="base-show" v-show="baseShow">
				<view class="base-show-box">
					<view class="base-show-title">
						提取图片或音视频内文字
					</view>
					<view class="base-show-content">
						<p>使用说明：</p>
						<!-- <p>1.点击'中英文'可以选择识别的内容</p> -->
						<p>1.点击下方按钮即可拍照或选择图片或音视频</p>
						<p>2.网速不好可能会出现延迟，请耐心等待再次选择</p>
						<p>3.识别后的媒体系统将会自动删除只保留结果</p>
						<p>4.文字识别率最高可达99%，字迹清晰的图片有利于提高准确度</p>
						<p>5.音视频文件大小限制20M</p>
						<p>6.个人中心签到或邀请用户注册可获得积分</p>
					</view>
					<!-- <view class="base-show-share" @click="textFromTo">
						每日分享获取积分>>
					</view> -->
				</view>
			</view>
			<!-- chooseImg -->
			<view class="fixed-buttom" style=""> 
				<!-- 左侧按钮 -->
				<view class="chooseImg" style="width:33%;">
					<!-- <u-picker :show="chooseTextShow" :columns="columns" @confirm="chooseTextConfirm" @change="chooseTextChange" @cancel="chooseTextCancel"></u-picker>
					<view class="chooseText" @click="chooseTextShow = true">
						<view>{{chooseText}}</view>
						<view>
							<u-icon name="arrow-down-fill" color="#000" size="22"></u-icon>
						</view>
					</view> -->
					<u-button
						type="primary" 
						:hairline="true" 
						:plain="true" 
						@click="chooseImg"
						width="100%"
						height="100%"
						:disabled="chooseImgDisabled"
						:text="uploadText">
					</u-button>
				</view>
				<!-- 中间按钮 -->
				<view style="width:33%;height: 100%;">
					<u-button
						type="primary" 
						@click="goto('/pages/user/user')"
						v-if="$ran.checkLogin() === true"
						width="100%"
						height="100%"
						text="个人中心">
					</u-button>
					<u-button
						type="primary" 
						@click="goto('/pages/user/login')"
						v-else
						width="100%"
						height="100%"
						text="登录">
					</u-button>
				</view>
				<!-- 右侧按钮 -->
				<view class="chooseImg" style="width:33%;">
					<!-- <u-picker :show="chooseTextShow" :columns="columns" @confirm="chooseTextConfirm" @change="chooseTextChange" @cancel="chooseTextCancel"></u-picker>
					<view class="chooseText" @click="chooseTextShow = true">
						<view>{{chooseText}}</view>
						<view>
							<u-icon name="arrow-down-fill" color="#000" size="22"></u-icon>
						</view>
					</view> -->
					<uni-file-picker 
					v-if="$ran.checkLogin() === false"
					width="100%"
					height="100%"
					limit="1"
					return-type="object"
					mode="grid"
					file-mediatype="all"
					:file-extname="extensionAudioTran"
					disabled>
						<!-- <u-button
							type="primary" 
							:hairline="true" 
							:plain="true" >
						</u-button> -->
						<u-button
							type="primary" 
							:hairline="true" 
							:plain="true"
							:text="uploadMediaText"
							disabled
							>
						</u-button>
					</uni-file-picker>
					<uni-file-picker 
					v-else
					width="100%"
					height="100%"
					limit="1"
					return-type="object"
					mode="grid"
					file-mediatype="all"
					:showPlan="false"
					:file-extname="extensionAudioTran"
					:auto-upload="false"
					:readonly="chooseImgDisabled"
					@select="chooseMedia">
						<!-- <u-button
							type="primary" 
							:hairline="true" 
							:plain="true" 
							@click="chooseMedia"
							>
						</u-button> -->
						<u-button
							type="primary" 
							:hairline="true" 
							:plain="true" 
							:text="uploadMediaText"
							:disabled="chooseImgDisabled"
							>
						</u-button> 
					</uni-file-picker>
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
import { APP_NAME, APIURL } from '../../config'
	// import swiperList from "@/ran-common/data/swiper.js"
	export default {
		data() {
			return {
				value: '',
				title: APP_NAME,
				bgColor: "#fff",//0081cd
				originImg: 'https://cdn.uviewui.com/uview/demo/upload/positive.png',
				originAudio: '',
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
				uploadText: "拍照/相册(免费)",
				uploadMediaText: "音频/视频(2积分)",
				nowChooseType: 'img', //当前选择类型，图片img，音视频audio
				token: '',
				extensionAudioTran: 'mp3,mp4,m4a,wav,webm,ogg'
				// extensionAudioTran: 'wav'
			}
		},
		onPageScroll(e) {
		},
		onReachBottom() {
		},
		onLoad() {

		},
		methods: {
			 goto(path) {
				 if (path == "/pages/user/login" && this.$ran.checkLogin()) {
					//检查是否登录，登录后不能进入登录页面
					return
					 
				 }
				 this.$ran.goto(path)
			},
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
			//选择音视频
			chooseMedia(res) {
				let that = this
				that.nowChooseType = 'audio'
				that.chooseImgDisabled = true
				//发送请求
				that.transcriptions(res.tempFilePaths[0])
			},
			//拍照选择图片
			chooseImg() {
				let that = this
				uni.chooseImage({
					count: 1, //默认9
					sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
					sourceType: ['album','camera'],   //album 从相册选图，camera 使用相机
					success: function (res) {
						that.nowChooseType = 'img'
						that.chooseImgDisabled = true
						//发送请求
						that.Ocr(res.tempFilePaths[0])
					},
				});
			}, 
			Ocr(url) {
				let that = this;
				that.uploadText = "识别中...";
				return new Promise((resolve, reject) => {
					uni.uploadFile({
						url: APIURL + '/v1/openapi/ocr/general/basic', 
						type: "POST",
						header: {
						},
						filePath: url,
						name: 'file',
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
							//使用说明区域隐藏
							that.baseShow = false;
							//初始化上传按钮
							that.initUploadButton()
						},
						fail(err) {
							//初始化上传按钮
							that.initUploadButton()
							reject(err)
						}
					});
				})
			},
			/**
			 * 音视频转录文本
			 */
			transcriptions(url) {
				let that = this;
				that.uploadMediaText = "识别中...";
				return new Promise((resolve, reject) => {
					uni.uploadFile({
						url: APIURL + '/v1/openapi/audio/transcriptions', 
						type: "POST",
						header: {
							Authorization: 'Bearer ' + that.$ran.cache('token'),
						},
						filePath: url,
						name: 'file',
						success: (res) => {
							let result = JSON.parse(res.data)
							let wordsResult = result.data.text
							// debugger
							that.textFrom = wordsResult
							that.originTextFrom = that.textFrom
							//显示识别音视频
							that.originAudio = url
							//显示识别区域
							that.showFyFrom = true;
							//使用说明区域隐藏
							that.baseShow = false;
							//初始化上传按钮
							that.initUploadButton()
						},
						fail(err) {
							//初始化上传按钮
							that.initUploadButton()
							reject(err)
						}
					});
				})
			},
			//初始化上传按钮
			initUploadButton() {
				//取消拍照/相册禁用
				this.chooseImgDisabled = false;
				//上传按钮文本恢复
				this.uploadText = "拍照/相册(免费)";
				this.uploadMediaText = "音频/视频(2积分)";
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
			},
			// 获取上传状态
			select(e){
				console.log('选择文件：',e)
			},
			// 获取上传进度
			progress(e){
				console.log('上传进度：',e)
			},
			
			// 上传成功
			success(e){
				console.log('上传成功')
			},
			
			// 上传失败
			fail(e){
				console.log('上传失败：',e)
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
.originImgBox{
	display: flex;
	justify-content: center;
}
.textFromBox{
	display: flex;
	flex-direction: column;
	flex: 1;
	/* height:600rpx; */
}
.textFromBox-bar{
	display: flex;
}
.textareaFrom{
	/* min-height: 350rpx; */
	/* max-height: 200rpx; */
}
.fixed-buttom{
	position: fixed;
	bottom: 15rpx;
	/* display: block; */
	display: flex;
	width: 100%;
	align-items: center;
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
