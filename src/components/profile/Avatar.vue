<template>
  <div class="item">
    <my-upload
      img-format="jpg"
      img-bgc="#fff"
      v-model="show"
      field="avatar"
      ki="0"
      @crop-success="cropSuccess"
      @crop-upload-success="cropUploadSuccess"
      @crop-upload-fail="cropUploadFail"
      :no-rotate="false"
      :headers="headers"
      :params="otherParams"
    ></my-upload>
  </div>
</template>

<script>
import myUpload from "vue-image-crop-upload";
import qs from "qs";
export default {
  data() {
    return {
      show: false,
      avatarUrl: null,
      otherParams: {
        token: "123456798",
        name: "img"
      },
      headers: {
        smail: "*_~"
      }
    };
  },
  components: {
    myUpload
  },
  methods: {
    cropSuccess(data, field, key) {
      if (field == "avatar") {
        this.avatarUrl = data;
      }
      console.log("-------- 剪裁成功 --------");
      this.upLoad();
      this.$emit("baseUrl", this.avatarUrl);
    },
    cropUploadSuccess(data, field, key) {
      console.log("-------- 上传成功 --------");
      console.log(data);
      console.log("field: " + field);
      console.log("key: " + key);
    },
    cropUploadFail(status, field, key) {
      console.log("-------- 上传失败 --------");
      console.log(status);
      console.log("field: " + field);
      console.log("key: " + key);
      alert("上传失败");
    },
    upLoad() {
      let obj = {
        send: 1,
        email: this.$cookies.get("email"),
        userAvatar: this.avatarUrl
      };
      let data = qs.stringify(obj);
      this.$axios
        .post("ordering/api/avatarSave.php", data)
        .then(res => {
          // console.log(res);
          if (res.data.valid) {
            this.$Toast({
              message: res.data.message,
              duration: 1000
            });
            // console.log(this.avatarUrl)
            localStorage.setItem('userAvatar', this.avatarUrl)
            // console.log(localStorage.getItem('userAvatar'))
          } else {
            this.$Toast({
              message: res.data.message,
              duration: 1000
            });
          }
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>

<style scoped>
label {
  display: block;
  margin-bottom: 10px;
}

.wrap {
  margin-bottom: 5px;
}
</style>
