<template>
  <div class="return-wrapper">
    <router-link :to="{path: '/outer'}" class="return">
      <i class="icon-arrow_lift"></i>
      <span>返回</span>
    </router-link>
  </div>
</template>

<script>
export default {};
</script>

<style lang="stylus" scoped>
.return-wrapper {
    padding: 20px 0;
  .return {
    .icon-arrow_lift {
      display: block;
      padding: 20px;
      font-size: 20px;
      color: #123456;
    }
    span {
        font-size: 14px;
        color: #000;
    }
  }
}
</style>
