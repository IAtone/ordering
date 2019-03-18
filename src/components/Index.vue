<template>
  <div class="index">
    <keep-alive>
      <router-view></router-view>
    </keep-alive>
    <div class="bottom">
      <router-link :to="{path: '/'}"><i class="el-icon-menu"></i>首页</router-link>
      <router-link :to="{path: '/mine'}"><i class="el-icon-edit"></i>我的</router-link>
    </div>
  </div>
</template>

<script>
export default {
};
</script>

<style lang="stylus" scoped>
$fontred = #ce3d3e
.index {
  .bottom {
    position: fixed;
    left: 0;
    bottom: 0;
    display: flex;
    width: 100%;
    height: 50px;
    padding: 10px 20px;
    box-sizing: border-box;
    box-shadow: 0 -5px 10px #f1f1f1;
    background: #fff;

    a {
      flex: 1;
      font-size: 14px;
      font-weight: 700;
      line-height: 30px;
      text-align: center;
      color: #ccc;

      &:first-child {
        border-right: 1px solid #eee;
      }

      &.router-link-exact-active {
        color: $fontred;
        .el-icon-edit,
        .el-icon-menu {
          color: $fontred;
        }
      }
      .el-icon-edit,
      .el-icon-menu {
        margin-right: 5px;
        font-size: 14px;
      }
    }
  }
}
</style>
