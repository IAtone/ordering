<template>
  <transition name="move">
    <div v-show="showFlag" class="food" ref="food">
      <div class="food-content">
        <div class="image-header">
          <img :src="food.image" alt>
          <div class="back" @click="hide">
            <i class="icon-arrow_lift"></i>
          </div>
        </div>
        <div class="content">
          <h1 class="title">{{ food.name }}</h1>
          <div class="detail">
            <span class="sell-count">月售{{ food.sellCount }}份</span>
            <span class="rating">好评率{{ food.rating }}%</span>
          </div>
          <div class="price">
            <span class="now">{{ food.price }}</span>
            <span v-show="food.oldPrice" class="old">￥{{ food.oldPrice }}</span>
          </div>
          <div class="cartcontrol-wrapper">
            <Cartcontrol :food="food"></Cartcontrol>
          </div>
          <div class="buy" v-show="!food.count || food.count == 0" @click="addFirst">加入购物车</div>
        </div>
        <Split v-show="food.info"></Split>
        <div class="info" v-show="food.info">
          <h1 class="title">商品信息</h1>
          <div class="text">{{ food.info }}</div>
        </div>
        <Split></Split>
        <div class="rating">
          <h1 class="title">商品评价</h1>
          <Ratingselect
            :selectType="selectType"
            :onlyContent="onlyContent"
            :desc="desc"
            :ratings="food.ratings"
            @ratingtype="ratingtype"
            @onlycontent="onlycontent"
          ></Ratingselect>
        </div>
        <div class="rating-wrapper">
          <ul v-show="food.ratings && food.ratings.length">
            <div class="no-rating">
              <li
                v-for="(rating, index) in food.ratings"
                :key="index"
                class="rating-item border-1px" v-show="needShow(rating.rateType, rating.text)"
              >
                <div class="user">
                  <span class="username">{{ rating.username }}</span>
                  <img :src="rating.avatar" alt class="avatar">
                </div>
                <div class="time">{{ rating.rateTime | fmtDate }}</div>
                <p class="text">
                  <span
                    :class="{'icon-thumb_up' : rating.rateType === 0, 'icon-thumb_down' : rating.rateType === 1}"
                  ></span>
                  {{rating.text}}
                </p>
              </li>
            </div>
          </ul>
          <div class="no-rating" v-show="!food.ratings || !food.ratings.length">暂无评价</div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import Vue from "vue";
import BScroll from "better-scroll";
import Cartcontrol from "../../cartcontrol/Cartcontrol";
import Split from "../../split/Split";
import Ratingselect from "../../ratingselect/Ratingselect";
import {formatDate} from '../../../../common/js/date.js'

// const POSITIVE = 0;
// const NEGATIVE = 1;
const ALL = 2;

export default {
  components: {
    Cartcontrol,
    Split,
    Ratingselect
  },
  data() {
    return {
      showFlag: false,
      selectType: ALL,
      onlyContent: false,
      desc: {
        all: "全部",
        positive: "推荐",
        negative: "吐槽"
      }
    };
  },
  props: {
    food: {
      type: Object
    }
    // showFlag: {
    //   type: Boolean
    // }
  },
  methods: {
    hide() {
      this.showFlag = false;
    },
    show() {
      this.showFlag = true;
      this.selectType = ALL;
      this.onlyContent = false;
      this.$nextTick(() => {
        if (!this.scroll) {
          this.scroll = new BScroll(this.$refs.food, {
            click: true
          });
        } else {
          this.scroll.refresh();
        }
      });
    },
    ratingtype(type) {
      this.selectType = type;
      // console.log(this.selectType);
      this.$nextTick(() => {
        this.scroll.refresh();
      })
    },
    onlycontent(flag) {
      this.onlyContent = flag;
      this.$nextTick(() => {
        this.scroll.refresh();
      })
      // console.log(this.onlyContent)
    },
    addFirst(event) {
      if (!event._constructed) {
        return;
      }
      // this.$dispatch('cart.add', event.target)
      Vue.set(this.food, "count", 1);
    },
    needShow(type, text) {
      if (this.onlyContent && !text) {
        return false;
      }
      if (this.selectType === ALL) {
        return true
      } else {
        return type === this.selectType
      }
    }
  },
  filters: {
    fmtDate(time) {
      let date = new Date(time)
      return formatDate(date, 'yyyy-MM-dd hh:mm:ss')
    }
  }
};
</script>

<style lang="stylus" scoped>
@import '../../../../common/stylus/mixin.styl';

.move-enter-active, .move-leave-active {
  transition: all 0.5s;
}

.move-enter, .move-leave-to {
  transform: translateX(100%);
}

.food {
  position: fixed;
  left: 0;
  top: 0;
  bottom: 48px;
  z-index: 30;
  width: 100%;
  background: #fff;

  .image-header {
    position: relative;
    width: 100%;
    height: 0;
    padding-top: 100%; // 没高度相对于宽度的大小

    img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .back {
      position: absolute;
      top: 10px;
      left: 0;

      .icon-arrow_lift {
        display: block;
        padding: 10px;
        font-size: 20px;
        color: #fff;
      }
    }
  }

  .content {
    position: relative;
    padding: 18px;

    .title {
      line-height: 14px;
      margin-bottom: 8px;
      font-size: 14px;
      font-weight: 700;
      color: rgb(7, 17, 27);
    }

    .detail {
      height: 10px;
      margin-bottom: 18px;
      line-height: 10px;
      font-size: 0;

      .sell-count, .rating {
        font-size: 10px;
        color: rgb(147, 153, 159);
      }

      .sell-count {
        margin-right: 12px;
      }
    }

    .price {
      font-weight: 700;
      line-height: 24px;

      .now {
        margin-right: 8px;
        font-size: 14px;
        color: rgb(240, 20, 20);
      }

      .old {
        text-decoration: line-through;
        font-size: 10px;
        color: rgb(147, 153, 159);
      }
    }

    .cartcontrol-wrapper {
      position: absolute;
      right: 12px;
      bottom: 12px;
    }

    .buy {
      position: absolute;
      right: 18px;
      bottom: 18px;
      z-index: 10;
      height: 24px;
      line-height: 24px;
      padding: 0 12px;
      box-sizing: borde-box;
      border-radius: 12px;
      font-size: 10px;
      color: #fff;
      background: rgb(0, 160, 220);
    }
  }

  .info {
    padding: 18px;

    .title {
      line-height: 14px;
      margin-bottom: 6px;
      font-size: 14px;
      color: rgb(7, 17, 27);
    }

    .text {
      line-height: 24px;
      padding: 0 8px;
      font-size: 12px;
      color: rgb(77, 85, 93);
    }
  }

  .rating {
    padding-top: 18px;

    .title {
      line-height: 14px;
      margin-left: 18px;
      font-size: 14px;
      color: rgb(7, 17, 27);
    }
  }

  .rating-wrapper {
    padding: 0 18px;

    .rating-item {
      position: relative;
      padding: 16px 0;
      border-1px(rgba(7, 17, 27, 0.1));

      .user {
        position: absolute;
        right: 0;
        top: 16px;
        line-height: 12px;
        font-size: 0;

        .username {
          display: inline-block;
          margin-right: 6px;
          vertical-align: top;
          font-size: 10px;
          color: rgb(147, 153, 159);
        }

        .avatar {
          width: 12px;
          height: 12px;
          border-radius: 50%;
        }
      }

      .time {
        margin-bottom: 6px;
        line-height: 12px;
        font-size: 10px;
        color: rgb(147, 153, 159);
      }

      .text {
        line-height: 16px;
        font-size: 12px;
        color: rgb(7, 17, 27);

        .icon-thumb_up, .icon-thumb_down {
          margin-right: 4px;
          line-height: 16px;
          font-size: 12px;
        }

        .icon-thumb_up {
          color: rgb(0, 160, 220);
        }

        .icon-thumb_down {
          color: rgb(147, 153, 159);
        }
      }
    }
    .no-rating {
      padding: 16px 0;
      font-size: 12px;
      color: rgb(147, 153, 159);
    }
  }
}
</style>
