<template>
  <view class="ln_upload_file">
    <view v-if="config.title" class="uni-file-picker__header">
      <text class="file-title">{{ config.title }}</text>
      <text class="file-count">{{ list.length }}/{{ config.limit }}</text>
    </view>
    <view style="display: flex"
      ><button
        size="mini"
        type="primary"
        class="upload_btn"
        @click.stop="changeFile"
      >
        选择文件
      </button></view
    >
    <block v-if="showFileList" v-for="(item, index) in list">
      <view class="ln-tag" :key="index">
        <text
          @click="downFile(item.url)"
          style="
            flex: 1;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            margin-right: 100rpx;
          "
          >{{ item.name }}</text
        >
        <image
          src="@/uni_modules/file-choose/components/file-choose/static/close.png"
          style="
            width: 30rpx;
            height: 30rpx;
            margin: 0 0 0 10rpx;
            position: absolute;
            right: 15rpx;
          "
          @click="deleteFile(index)"
        >
        </image>
      </view>
    </block>
  </view>
</template>

<script>
import changeFiles from "./changeFile.js";
export default {
  props: {
    value: {
      type: Array,
      default: () => [],
    },
    config: {
      type: Object,
      default: () => {
        return {
          size: 2,
          limit: 1,
          title: "",
          headers: {},
          formData: {},
          automatic: false,
          fileMediatype: "all",
        };
      },
    },
    action: {
      type: String,
      default: "",
    },
    showFileList: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      list: [],
    };
  },
  watch: {
    value: {
      handler(newV, oldV) {
        let data = [];
        for (let item of newV) {
          if (!item.name) {
            data.push({
              name: item.substring(item.lastIndexOf("/") + 1),
              url: item,
            });
          } else {
            data.push(item);
          }
        }
        this.list = data;
      },
      deep: true,
    },
  },
  methods: {
    changeFile() {
      let fileType = [];
      if (this.config.fileMediatype === "all") {
        fileType = ["视频", "图片", "文件"];
      } else if (this.config.fileMediatype === "video") {
        this.changeVideo();
        return;
      } else if (this.config.fileMediatype === "image") {
        this.changeImage();
        return;
      } else if (this.config.fileMediatype === "file") {
        this.changePaperFile();
        return;
      } else {
        return;
      }
      uni.showActionSheet({
        itemList: fileType,
        success: (res) => {
          switch (fileType[res.tapIndex]) {
            case "视频":
              this.changeVideo();
              break;
            case "图片":
              this.changeImage();
              break;
            case "文件":
              this.changePaperFile();
              break;
          }
        },
      });
    },
    changeVideo() {
      uni.chooseVideo({
        sourceType: ["camera", "album"],
        success: (res) => {
          if (this.config.automatic)
            this.uploadFile(
              res.tempFilePath,
              res.tempFilePath.substr(res.tempFilePath.lastIndexOf("/") + 1)
            );
          else
            this.pushFileList(
              res.tempFilePath.substr(res.tempFilePath.lastIndexOf("/") + 1),
              res.tempFilePath
            );
        },
      });
    },
    changeImage() {
      uni.chooseImage({
        count: 9,
        sizeType: ["original", "compressed"],
        sourceType: ["album", "camera"], //从相册选择
        success: (res) => {
          for (let item of res.tempFilePaths) {
            if (this.config.automatic)
              this.uploadFile(item, item.substr(item.lastIndexOf("/") + 1));
            else
              this.pushFileList(item.substr(item.lastIndexOf("/") + 1), item);
          }
        },
      });
    },
    changePaperFile() {
      let _this = this;
      let list = [];
      // #ifdef H5
      uni.chooseFile({
        limit: _this.config.limit,
        success: (res) => {
          for (let i = 0, len = res.tempFiles.length; i < len; i++) {
            if (
              _this.list.length > _this.config.limit ||
              _this.list.length == _this.config.limit
            ) {
              uni.showToast({
                title: `您最多选择 ${_this.config.limit} 个文件`,
                icon: "none",
              });
              return;
            } else if (
              res.tempFiles[i].size / 1024 / 1024 >
              _this.config.size
            ) {
              uni.showToast({
                title: `选择文件大于${_this.config.size}M`,
                icon: "none",
              });
              return;
            }
            if (_this.config.automatic)
              _this.uploadFile(res.tempFilePaths[i], res.tempFiles[i].name);
            else
              _this.pushFileList(res.tempFiles[i].name, res.tempFilePaths[i]);
          }
        },
      });
      // #endif

      // #ifdef MP-WEIXIN
      wx.chooseMessageFile({
        limit: _this.config.limit,
        type: "file",
        success(res) {
          for (let i = 0, len = res.tempFiles.length; i < len; i++) {
            if (
              _this.list.length > _this.config.limit ||
              _this.list.length == _this.config.limit
            ) {
              uni.showToast({
                title: `您最多选择 ${_this.config.limit} 个文件`,
                icon: "none",
              });
              return;
            } else if (
              res.tempFiles[i].size / 1024 / 1024 >
              _this.config.size
            ) {
              uni.showToast({
                title: `选择文件大于${_this.config.size}M`,
                icon: "none",
              });
              return;
            }
            list.push({
              name: res.tempFiles[i].name,
              url: res.tempFiles[i].path,
            });
            if (_this.config.automatic)
              _this.uploadFile(res.tempFiles[i].path, res.tempFiles[i].name);
            else
              _this.pushFileList(res.tempFiles[i].name, res.tempFiles[i].path);
          }
        },
      });
      // #endif

      // #ifdef APP-PLUS
      changeFiles((res) => {
        if (
          _this.list.length > _this.config.limit ||
          _this.list.length == _this.config.limit
        ) {
          uni.showToast({
            title: `您最多选择 ${_this.config.limit} 个文件`,
            icon: "none",
          });
          return;
        }
        let obj = res.lastIndexOf("/");
        list.push({
          name: res.substr(obj + 1),
          url: res,
        });
        if (_this.config.automatic) _this.uploadFile(res, res.substr(obj + 1));
        else _this.pushFileList(res.substr(obj + 1), res);
      }, "*/*");
      //  #endif
    },
    // 上传文件
    uploadFile(file, name) {
      uni.showLoading({
        mask: true,
        title: "上传中...",
      });
      uni.uploadFile({
        url: this.action,
        filePath: file,
        name: "file",
        formData: this.config.formData,
        header: this.config.headers,
        success: (uploadFileRes) => {
          uploadFileRes = JSON.parse(uploadFileRes.data);
          if (uploadFileRes.code == 200) {
            this.list.push({
              name: name,
              url: uploadFileRes.data,
            });
            this.$emit("input", this.list);
          }
        },
        complete: () => {
          uni.hideLoading();
        },
      });
    },
    deleteFile(index) {
      this.list.splice(index, 1);
      this.$emit("input", this.list);
    },
    pushFileList(name, url) {
		if(this.showFileList){
			this.list.push({
				name: name,
				url: url,
			});
		}else{
			//不显示列表（自定义附件列表）
			this.list=[{name: name,url: url}]
		}
      this.$emit("change-file", this.list);
    },
    downFile(url) {
      this.$emit("change-list", url);
    },
  },
};
</script>

<style scoped>
.ln_upload_file {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.uni-file-picker__header {
  padding-top: 5px;
  padding-bottom: 10px;
  display: flex;
  justify-content: space-between;
}

.file-title {
  font-size: 14px;
  color: #333;
}

.file-count {
  font-size: 14px;
  color: #999;
}

.ln-tag {
  position: relative;
  max-width: 500rpx;
  overflow: hidden;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  background-color: rgba(85, 170, 255, 0.2);
  padding: 8rpx 25rpx;
  border-radius: 8rpx;
  font-size: 28rpx;
  color: rgba(85, 170, 255, 1);
  border: 1rpx solid rgba(85, 170, 255, 0.8);
  margin: 10rpx 10rpx 10rpx 0;
  align-items: center;
}

.upload_btn {
  /* width: 200rpx; */
  margin: 0;
}
</style>

