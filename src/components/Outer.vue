<template>
  <transition name="fade">
    <div class="outer">
      <h1 class="title">
        <img src="http://www.17sucai.com/preview/266121/2017-06-30/login/images/welcome.png" alt>
      </h1>
      <router-link :to="{name: 'register'}" class="enter" tag="div">注册</router-link>
      <router-link :to="{name: 'login'}" class="enter" tag="div">登录</router-link>
    </div>
  </transition>
</template>

<script>
export default {};
</script>

<style lang="stylus" scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

.outer {
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  background: linear-gradient(to right, #FEB692, #EA5455);

  .title {
    width: 100%;
    margin: 40% 0;

    img {
      width: 100%;
    }
  }

  .enter {
    height: 40px;
    margin: 0 30px 15px 30px;
    line-height: 40px;
    border: 1px solid #fff;
    border-radius: 25px;
    font-size: 25px;
    font-weight: bold;
    text-align: center;
    color: #fff;
  }
}
</style>
