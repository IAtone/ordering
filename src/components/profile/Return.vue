<template>
  <div class="return-wrapper">
    <div @click="hide" class="return">
      <i class="icon-arrow_lift"></i>
      <span>返回</span>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    hide() {
      this.$emit('hide', false)
    }
  }
};
</script>

<style lang="stylus" scoped>
.return-wrapper {
  .return {
    width: 100px;

    .icon-arrow_lift {
      display: inline-block;
      padding: 20px 5px 20px 10px;
      font-size: 20px;
      color: #123456;
    }

    span {
      display: inline-block;
      vertical-align: top;
      height: 60px;
      line-height: 60px;
      font-size: 14px;
      color: #000;
    }
  }
}
</style>
