<template>
  <div class="ratings">
    <div class="ratings-content">
      <div class="overview">
        <div class="overview-left">
          <h1 class="score">{{ seller.score }}</h1>
          <div class="title">综合评分</div>
          <div class="rank">高于周边商家{{ seller.rankRate }}%</div>
        </div>
        <div class="overview-right">
          <div class="score-wrapper">
            <span class="title">服务态度</span>
            <Star :size="24" :score="seller.serviceScore"></Star>
            <span class="score">{{ seller.serviceScore }}</span>
          </div>
          <div class="score-wrapper">
            <span class="title">商品评分</span>
            <Star :size="24" :score="seller.foodScore"></Star>
            <span class="score">{{ seller.foodScore }}</span>
          </div>
          <div class="delivery-wrapper">
            <span class="title">送达时间</span>
            <span class="delivery">{{ seller.deliveryTime }}分钟</span>
          </div>
        </div>
      </div>
      <Split></Split>
      <div class="rating">
        <h1 class="title">商家评价</h1>
      </div>
      <div class="rating-wrapper">
        <ul>
          <div class="no-rating">
            <li>
              <div class="user">
                <span class="username">用户名</span>
                <img :src="seller.avatar" alt class="avatar">
              </div>
              <div class="time">时间</div>
              <p class="text">
                内容
              </p>
            </li>
          </div>
        </ul>
        <div>暂无评价</div>
      </div>
    </div>
  </div>
</template>

<script>
import Star from "../../star/Star";
import Split from "../../split/Split";

export default {
  components: {
    Star,
    Split
  },
  props: {
    seller: {
      type: Object
    }
  }
};
</script>

<style lang="stylus" scoped>
@import '../../../../common/stylus/mixin.styl';

.ratings {
  position: absolute;
  top: 174px;
  bottom: 0;
  width: 100%;
  overflow: hidden;

  .overview {
    display: flex;
    padding: 18px 0;

    .overview-left {
      flex: 0 0 137px;
      padding: 6px 0;
      width: 137px;
      border-right: 1px solid rgba(7, 17, 27, 0.1);
      text-align: center;

      .score {
        margin-bottom: 6px;
        line-height: 28px;
        font-size: 24px;
        color: rgb(255, 153, 0);
      }

      .title {
        margin-bottom: 8px;
        line-height: 12px;
        font-size: 12px;
        color: rgb(7, 17, 27);
      }

      .rank {
        line-height: 10px;
        font-size: 10px;
        color: rgb(147, 153, 159);
      }
    }

    .overview-right {
      flex: 1;
      padding: 6px 0 6px 24px;

      .score-wrapper {
        margin-bottom: 8px;
        font-size: 0;

        .title {
          display: inline-block;
          line-height: 18px;
          font-size: 12px;
          color: rgb(7, 17, 27);
        }

        .star {
          display: inline-block;
          margin: 0 12px;
        }

        .score {
          display: inline-block;
          line-height: 18px;
          font-size: 12px;
          color: rgb(255, 153, 0);
        }
      }

      .delivery-wrapper {
        font-size: 0;

        .title {
          line-height: 18px;
          font-size: 12px;
          color: rgb(7, 17, 27);
        }

        .delivery {
          margin-left: 12px;
          font-size: 12px;
          color: rgb(127, 153, 159);
        }
      }
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
