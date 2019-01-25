<template>
  <transition name="move">
    <div class="details">
      <Header :seller="seller"></Header>
      <div class="tab border-1px">
        <div class="tab-item">
          <router-link :to="{path: '/details/goods'}">商品</router-link>
        </div>
        <div class="tab-item">
          <router-link :to="{path: '/details/ratings'}">评论</router-link>
        </div>
        <div class="tab-item">
          <router-link :to="{path: '/details/seller'}">商家</router-link>
        </div>
      </div>
      <keep-alive>
        <router-view :seller="seller"></router-view>
      </keep-alive>
    </div>
  </transition>
</template>

<script>
import Header from "./header/Header.vue";
import { urlParse } from "../../common/js/utils.js";
export default {
  name: "Details",
  data() {
    return {
      seller: {
        // id: (() => {
        //   let queryParam = urlParse();
        //   return queryParam.id;
        // })()
      }
    };
  },
  created() {
    this.getData();
  },
  methods: {
    getData() {
      this.$axios
        .get("ordering/api/datas.php")
        .then(res => {
          const data = JSON.parse(res.data);
          let id = this.$cookies.get("id");
          // console.log(typeof this.seller)
          this.seller = data[id].seller;
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  components: {
    Header
  }
};
</script>

<style lang="stylus" scoped>
@import '../../common/stylus/mixin.styl';

.move-enter-active, .move-leave-active {
  transition: all .3s;
}

.move-enter, .move-leave-to {
  transform: translateX(-100%)
}

.details {
  .tab {
    display: flex;
    width: 100%;
    height: 40px;
    line-height: 40px;
    border-1px(rgba(7, 17, 27, 0.1));

    .tab-item {
      flex: 1;
      text-align: center;

      a {
        display: block;
        text-decoration: none;
        font-size: 14px;
        color: rgb(77, 85, 93);

        &.active {
          color: rgb(240, 20, 20);
        }
      }
    }
  }
}
</style>
