<template>
  <transition name="fade">
    <div class="login">
      <router-link :to="{path: '/outer'}" class="return">
        <i class="icon-arrow_lift"></i>
      </router-link>
      <h1 class="title">登录</h1>
      <el-form
        :model="ruleForm2"
        status-icon
        :rules="rules2"
        ref="ruleForm2"
        label-width="100px"
        class="demo-ruleForm"
      >
        <el-form-item prop="email">
          <el-input v-model="ruleForm2.email" placeholder="邮箱"></el-input>
        </el-form-item>
        <el-form-item prop="pass">
          <el-input type="password" v-model="ruleForm2.pass" autocomplete="off" placeholder="密码"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitForm('ruleForm2')">提交</el-button>
          <el-button @click="resetForm('ruleForm2')">重置</el-button>
        </el-form-item>
      </el-form>
    </div>
  </transition>
</template>

<script>
export default {
  data() {
    var checkEmail = (rule, value, callback) => {
      if (!value) {
        return callback(new Error("邮箱不能为空"));
      }
      setTimeout(() => {
        let pattern = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
        if (!pattern.test(value)) {
          callback(new Error("请输入正确的邮箱"));
        } else {
          callback();
        }
      }, 1000);
    };
    var validatePass = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("请输入密码"));
      } else if (value.length < 6) {
        callback(new Error("密码位数必须大于等于6位"));
      } else {
        callback();
      }
    };
    return {
      ruleForm2: {
        pass: "",
        email: ""
      },
      rules2: {
        pass: [{ validator: validatePass, trigger: "blur" }],
        email: [{ validator: checkEmail, trigger: "blur" }]
      }
    };
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate(valid => {
        if (valid) {
          alert("submit!");
        } else {
          console.log("error submit!!");
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

<style lang="stylus" scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

.login {
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 20px;

  .return {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 10;

    .icon-arrow_lift {
      display: block;
      padding: 20px;
      font-size: 20px;
      color: #123456;
    }
  }

  .title {
    margin-bottom: 30px;
    font-size: 25px;
  }
}
</style>
