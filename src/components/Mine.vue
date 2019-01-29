<template>
  <div class="mine">
    <h1 class="title">个人信息</h1>
    <div class="mine-content">
      <div class="avatar detail" @click="showAvatar">
        <span>头像</span>
        <img :src="user.userAvatar" alt="" v-if="user.userAvatar">
        <img :src="imgUrl" alt="" v-if="imgUrl">
        <img src="../components/details/header/brand@2x.png" alt v-else>
        <i class="icon-arrow_lift"></i>
      </div>
      <div class="username detail">
        <span>昵称</span>
        <span v-if="user.userName">{{ user.userName }}</span>
        <span v-else>您还没有昵称哦!</span>
        <i class="icon-arrow_lift"></i>
      </div>
      <div class="email detail">
        <span>邮箱</span>
        <span>{{ email }}</span>
      </div>
      <div class="phone detail">
        <span>手机号码</span>
        <span>321432432432</span>
        <i class="icon-arrow_lift"></i>
      </div>
      <div class="pwd detail">
        <span>修改密码</span>
        <i class="icon-arrow_lift"></i>
      </div>
    </div>
    <Avatar ref="avatar" @baseUrl="baseUrl"></Avatar>
  </div>
</template>

<script>
import Avatar from './profile/Avatar'

export default {
  components: {
    Avatar
  },
  data() {
    return {
      email: this.$cookies.get("email"),
      user: {},
      imgUrl: ""
    };
  },
  methods: {
    getUser() {
      this.$axios
        .get("ordering/api/getUser.php?email=" + this.email)
        .then(res => {
          console.log(res.data);
          this.user = res.data[0]
        })
        .catch(err => {
          console.log(err);
        });
    },
    showAvatar() {
      console.log(this.$refs.avatar)
      this.$refs.avatar.show = true
    },
    baseUrl(data) {
      this.imgUrl = data
    }
  },
  created() {
    this.getUser();
  }
};
</script>

<style lang="stylus" scoped>
.mine {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;

  .title {
    padding-top: 20%;
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
  }
}
</style>
