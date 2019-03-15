<template>
  <transition name="move">
    <div class="phone" v-show="show">
      <Return :show="show" @hide="hide"></Return>
      <el-form status-icon label-width="70px" class="content-wrapper">
        <el-form-item label="手机号码" class="content">
          <el-input type="number" autocomplete="off" v-model="phoneNumber" placeholder="请输入手机号码"></el-input>
        </el-form-item>
        <el-form-item class="content">
          <el-button type="primary" @click="confirm" size="small" class="confirm">确认</el-button>
          <el-button @click="close" size="small">取消</el-button>
        </el-form-item>
      </el-form>
    </div>
  </transition>
</template>

<script>
import qs from "qs";
import Return from "./Return";
export default {
  components: {
    Return
  },
  props: {
      getPhone: {
          type: String,
          default: ""
      }
  },
  data() {
    return {
      show: false,
      phoneNumber: this.getPhone
    };
  },
  methods: {
    hide(flag) {
      this.show = false;
    },
    close() {
      this.phoneNumber = '';
      this.hide();
    },
    confirm() {
        let pattern = /^1[34578]\d{9}$/;
      if (this.getPhone === "") {
        this.$Toast({
          message: "请输入手机号码",
          duration: 1000,
          position: 'top'
        });
      } else if (this.phoneNumber === this.getPhone) {
          this.$Toast({
            message: "手机号码还未修改哦",
            duration: 1000,
            position: 'top'
          });
      } else if (!pattern.test(this.phoneNumber)) {
          this.$Toast({
            message: "请输入正确的手机号码",
            duration: 1000,
            position: 'top'
          });
      } else {
        let obj = {
          send: 1,
          email: this.$cookies.get("email"),
          phoneNumber: this.phoneNumber
        };
        let data = qs.stringify(obj);
        console.log(data);
        this.$axios
          .post("ordering/api/phoneSave.php", data)
          .then(res => {
            if (res.data.valid) {
              this.$Toast({
                message: res.data.message,
                duration: 1000
              });
              this.$emit("setPhone", this.phoneNumber);
              this.show = false;
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
    },
  }
};
</script>

<style scoped>
.move-enter-active,
.move-leave-active {
  transition: all 0.5s;
}

.move-enter,
.move-leave-to {
  transform: translateX(100%);
}

.phone {
  position: fixed;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  z-index: 10;
  background: #fff;
}

.content-wrapper {
  margin: 0 auto;
}

/* .confirm {
  background: #ce3d3e;
  border: none;
} */
</style>
