<template>
  <div class="cartcontrol">
    <transition name="move">
      <div class="cart-decrease" v-show="food.count" @click.stop="decreaseCount">
        <transition name="imove">
          <span class="inner icon-remove_circle_outline" v-show="food.count"></span>
        </transition>
      </div>
    </transition>
    <div class="cart-count" v-show="food.count">{{ food.count }}</div>
    <div class="cart-increase icon-add_circle" @click.stop="increaseCart"></div>
  </div>
</template>

<script>
import Vue from "vue";

export default {
  props: {
    food: {
      type: Object
    }
  },
  methods: {
    increaseCart(event) {
      //better-scroll真实DOM操作，判断一下，不然在pc端点击是执行两次点击事件
      if (!event._constructed) {
        return;
      }
      if (!this.food.count) {
        //实时监听
        Vue.set(this.food, "count", 1);
      } else {
        this.food.count++;
      }
      // this.$dispatch('cart.add', event.target)
    },
    decreaseCount(event) {
      if (!event._constructed) {
        return;
      }
      if (this.food.count) {
        this.food.count--;
      }
    }
  }
};
</script>

<style lang="stylus" scoped>

.cartcontrol {
  font-size: 0;

  .cart-decrease {
    display: inline-block;
    padding: 6px;
    transition: all .4s linear;

    .inner {
      display: inline-block;
      line-height: 24px;
      font-size: 24px;
      color: rgb(0, 160, 220);
      transition: all .4s linear;
      &.imove-transition {
          transform: rotate(0)
      }
      &.imove-enter {
          transform: rotate(180deg)
      }
      &.imove-leave {
          transform: rotate(180deg)
      }
    }

    &.move-transition {
      opacity: 1;
      transform: translate3d(0, 0, 0);
    }

    &.move-enter, &.move-leave {
      opacity: 0;
      transform: translate3d(24px, 0, 0);
    }
  }

  .cart-count {
    display: inline-block;
    vertical-align: top;
    width: 12px;
    padding-top: 6px;
    line-height: 24px;
    text-align: center;
    font-size: 12px;
    color: rgb(147, 153, 159);
  }

  .cart-increase {
    display: inline-block;
    padding: 6px;
    line-height: 24px;
    font-size: 24px;
    color: rgb(0, 160, 220);
  }
}
</style>
