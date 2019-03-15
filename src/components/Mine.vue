<template>
  <div class="mine">
    <h1 class="title">个人信息</h1>
    <div class="mine-content">
      <div class="avatar detail" @click="showAvatar">
        <span>头像</span>
        <img :src="imgUrl" alt v-if="imgUrl">
        <img src="https://tvax4.sinaimg.cn/default/images/default_avatar_female_50.gif" alt v-else>
        <i class="icon-arrow_lift"></i>
      </div>
      <div class="username detail" @click="showUsername">
        <span>昵称</span>
        <span v-if="user.userName">{{ user.userName }}</span>
        <span v-else>您还没有昵称哦!</span>
        <i class="icon-arrow_lift"></i>
      </div>
      <div class="email detail">
        <span>邮箱</span>
        <span>{{ email }}</span>
      </div>
      <div class="level detail">
        <span>用户等级</span>
        <span>{{ this.level }}</span>
      </div>
      <div class="phone detail" @click="showPhone">
        <span>手机号码</span>
        <span v-if="user.phoneNumber">{{ user.phoneNumber }}</span>
        <span v-else>您还没有添加手机号码哦!</span>
        <i class="icon-arrow_lift"></i>
      </div>
      <div class="pwd detail" @click="showPassword">
        <span>修改密码</span>
        <i class="icon-arrow_lift"></i>
      </div>
      <div class="logout">
        <el-button type="primary" @click="logout" class="quit" size="medium">注销登录</el-button>
      </div>
    </div>
    <Avatar ref="avatar" @baseUrl="baseUrl"></Avatar>
    <Username ref="username" @setUsername="setUsername" :getUsername="user.userName"></Username>
    <Phone ref="phone" @setPhone="setPhone" :getPhone="user.phoneNumber"></Phone>
    <Password ref="password"></Password>
  </div>
</template>

<script>
import Avatar from "./profile/Avatar";
import Username from "./profile/Username";
import Phone from "./profile/Phone";
import Password from "./profile/Password";

export default {
  components: {
    Avatar,
    Username,
    Phone,
    Password
  },
  data() {
    return {
      email: this.$cookies.get("email"),
      user: {},
      imgUrl: "",
      level: "",
      dialogVisible: false
    };
  },
  methods: {
    getUser() {
      this.$axios
        .get("ordering/api/getUser.php?email=" + this.email)
        .then(res => {
          console.log(res.data);
          this.user = res.data[0];
          this.imgUrl =
            "https://www.atone.shop/ordering/" + this.user.userAvatar.slice(3);
          this.level = this.user.userLevel === "1" ? "普通用户" : "会员";
        })
        .catch(err => {
          console.log(err);
        });
    },
    showAvatar() {
      this.$refs.avatar.show = true;
    },
    showUsername() {
      this.$refs.username.show = true;
    },
    showPhone() {
      this.$refs.phone.show = true;
    },
    showPassword() {
      this.$refs.password.show = true;
    },
    baseUrl(data) {
      this.imgUrl = data;
    },
    setUsername(data) {
      this.user.userName = data;
    },
    setPhone(data) {
      this.user.phoneNumber = data;
    },
    logout() {
      this.$confirm("确定要注销此账号, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$Toast({
            message: "注销成功!",
            duration: 1000
          });
          setTimeout(() => {
            this.$cookies.remove("email");
            this.$router.push("/outer");
          }, 800)
        })
        .catch(() => {
          this.$Toast({
            message: "已取消注销",
            duration: 1000
          });
        });
    }
  },
  created() {
    this.getUser();
  }
};
</script>

<style lang="stylus" scoped>
$fontred = #ce3d3e
.mine {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;

  .title {
    padding-top: 10%;
    font-size: 16px;
    text-align: center;
  }

  .mine-content {
    padding: 0 20px;

    .detail {
      position: relative;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 0;
      border-bottom: 1px solid #123456;

      span {
        font-size: 14px;

        &:nth-child(2) {
          margin-right: 20px;
        }
      }

      .icon-arrow_lift {
        position: absolute;
        right: 0;
        transform: rotate(180deg);
        font-size: 14px;
        color: #000;
      }

      &.avatar {
        img {
          width: 50px;
          height: 50px;
          margin-right: 20px;
          border-radius: 50%;
        }

        .icon-arrow_lift {
          top: 38px;
        }
      }
    }

    .logout {
      padding: 20px 0;
      text-align: center;
      .quit {
        background: $fontred;
        border: none;
      }
    }
  }
}
</style>
