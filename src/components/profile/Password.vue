<template>
  <transition name="move">
    <div class="password" v-show="show">
      <Return :show="show" @hide="hide"></Return>
      <el-form
        :model="ruleForm2"
        status-icon
        :rules="rules2"
        ref="ruleForm2"
        label-width="70px"
        class="demo-ruleForm content-wrapper"
      >
        <el-form-item label="旧密码" prop="oldPwd">
          <el-input type="password" v-model="ruleForm2.oldPwd" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="密码" prop="newPwd">
          <el-input type="password" v-model="ruleForm2.newPwd" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="确认密码" prop="checkPwd">
          <el-input type="password" v-model="ruleForm2.checkPwd" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitForm('ruleForm2')">修改</el-button>
          <el-button @click="resetForm('ruleForm2')">重置</el-button>
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
  data() {
    var checkPwd = (rule, value, callback) => {
      if (value && value.length >= 6) {
        callback();
      } else {
        callback(new Error("密码不能为空且大于等于6位"));
      }
    };
    var validatePass = (rule, value, callback) => {
      if (value && value.length >= 6) {
        if (this.ruleForm2.checkPwd !== "") {
          this.$refs.ruleForm2.validateField("checkPwd");
        }
        callback();
      } else {
        callback(new Error("密码不能为空且大于等于6位"));
      }
    };
    var validatePass2 = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("请再次输入密码"));
      } else if (value !== this.ruleForm2.newPwd) {
        callback(new Error("两次输入密码不一致!"));
      } else {
        callback();
      }
    };
    return {
      show: false,
      ruleForm2: {
        oldPwd: "",
        newPwd: "",
        checkPwd: ""
      },
      rules2: {
        oldPwd: [{ validator: checkPwd }],
        newPwd: [{ validator: validatePass, trigger: "blur" }],
        checkPwd: [{ validator: validatePass2 }]
      }
    };
  },
  methods: {
    hide(flag) {
      this.show = false;
    },
    confirm() {
      let obj = {
        send: 1,
        email: this.$cookies.get("email"),
        oldPassword: this.ruleForm2.oldPwd,
        newPassword: this.ruleForm2.newPwd,
        checkPassword: this.ruleForm2.checkPwd
      };
      let data = qs.stringify(obj);
      console.log(data);
      this.$axios
        .post("ordering/api/passwordSave.php", data)
        .then(res => {
          if (res.data.valid) {
            alert(res.data.message);
            this.show = false;
            this.resetForm('ruleForm2')
          } else {
            alert(res.data.message);
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    submitForm(formName) {
      this.$refs[formName].validate(valid => {
        if (valid) {
          this.confirm();
        } else {
          return false;
        }
      });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
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

.password {
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
