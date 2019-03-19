<template>
  <transition name="move">
    <div class="username" v-show="show">
      <Return :show="show" @hide="hide"></Return>
      <el-form status-icon label-width="40px" class="content-wrapper">
        <el-form-item label="昵称" class="content">
          <el-input type="text" autocomplete="off" v-model="username" placeholder="请输入昵称"></el-input>
        </el-form-item>
        <el-form-item class="content">
          <el-button type="primary" @click="confirm" size="small" class="b-submit">确认</el-button>
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
      getUsername: {
          type: String,
          default: ""
      }
  },
  data() {
    return {
      show: false,
      username: this.getUsername
    };
  },
  methods: {
    hide(flag) {
      this.show = false;
    },
    close() {
      this.username = '';
      this.hide();
    },
    confirm() {
      if (this.username === "") {
        this.$Toast({
          message: "请输入昵称",
          duration: 1000,
          position: 'top'
        });
      } else if (this.username === this.getUsername) {
          this.$Toast({
            message: "昵称还未修改哦",
            duration: 1000,
            position: 'top'
          });
      } else {
        let obj = {
          send: 1,
          email: this.$cookies.get("email"),
          username: this.username
        };
        let data = qs.stringify(obj);
        console.log(data);
        this.$axios
          .post("ordering/api/usernameSave.php", data)
          .then(res => {
            if (res.data.valid) {
              this.$Toast({
                message: res.data.message,
                duration: 1000
              });
              this.$emit("setUsername", this.username);
              this.show = false;
              this.$cookies.set('username', this.username)
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

.username {
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
