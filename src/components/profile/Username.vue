<template>
  <transition name="move">
    <div class="username" v-show="show">
      <Return :show="show" @hide="hide"></Return>
      <el-form status-icon label-width="40px" class="content-wrapper">
        <el-form-item label="昵称" class="content">
          <el-input type="text" autocomplete="off" v-model="username" placeholder="请输入昵称"></el-input>
        </el-form-item>
        <el-form-item class="content">
          <el-button type="primary" @click="confirm">确认</el-button>
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
    confirm() {
      if (this.username === "") {
        alert("请输入昵称");
      } else if (this.username === this.getUsername) {
          alert("昵称还未修改哦")
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
              alert(res.data.message);
              this.$emit("setUsername", this.username);
              this.show = false;
              this.$cookies.set('username', this.username)
            } else {
              alert(res.data.message);
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
</style>
