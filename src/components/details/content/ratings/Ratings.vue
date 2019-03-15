<template>
  <div class="ratings" ref="mainScroll">
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
      <div class="comment">
        <span @click="showCom">用户评价</span>
      </div>
      <div class="rating-wrapper">
        <ul v-if="commits.length > 0">
          <div class="no-rating">
            <li class="rating-item" v-for="(val, index) in commits" :key="index">
              <div class="user">
                <span class="username">{{ val.userName }}</span>
                <img
                  :src="'https://www.atone.shop/ordering/' + val.userAvatar.slice(3)"
                  alt
                  class="avatar"
                  v-if="val.userAvatar"
                >
                <img
                  src="https://tvax4.sinaimg.cn/default/images/default_avatar_female_50.gif"
                  alt
                  v-else
                >
              </div>
              <div class="time">{{ val.createTime }}</div>
              <p class="text">{{ val.comContent }}</p>
            </li>
          </div>
          <div class="btn">
            <el-button
              type="primary"
              @click="getCom"
              v-if="flag && commits.length >= 3"
              class="more"
              size="mini"
            >加载更多</el-button>
          </div>
        </ul>
        <div v-else class="noCom">暂无评价</div>
      </div>
    </div>
    <transition name="move">
      <div class="comments" v-show="show">
        <div @click="hideCom" class="return">
          <i class="icon-arrow_lift"></i>
          <span>返回</span>
        </div>
        <div class="comDetail">
          <h1 class="title">用户评价</h1>
          <div class="text-wrapper">
            <textarea v-model="content"></textarea>
            <div class="btn">
              <el-button type="primary" @click="commit" class="cc" size="small">评价</el-button>
              <el-button type="info" @click="hideCom" size="small">取消</el-button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import BScroll from "better-scroll";
import qs from "qs";
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
  },
  data() {
    return {
      show: false,
      content: "",
      commits: [],
      flag: true
    };
  },
  computed: {
    avatar() {
      return localStorage.getItem("userAvatar")
        ? localStorage.getItem("userAvatar")
        : `data:image/jpg;base64,R0lGODlhMgAyANUAAAAAAP////7+/v39/fz8/Pv7+/r6+vn5+fj4+Pf39/b29vX19fT09PPz8/Ly
8vHx8fDw8O/v7+7u7u3t7ezs7Ovr6+rq6unp6ejo6Ofn5+bm5uXl5eTk5OPj4+Li4uHh4eDg4P//
/wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAACEALAAAAAAyADIAAAb/wItw
SCwaj8ikcslsOp/QqHRKrVqv2Ktla8lGuxqOeLzJYC5c79HC6WQmjMNB8bhsOp5OZ6M2djQNAYKD
ggQMEBISFBl9Qx8VA4SSkg8cXX0fE5Obgg8ejWwXnJwQH5deGB0Fo5wWHadaHhKsnAgeZ1mpCbSc
dl4aGAK8mxIdXhsVw5sOxlkcycqSDRxez9HS1M7Q14LTXiAW3IMNIBpYGxGR4gECCxqMVBbvwuuD
D69VGRnq9QGesFI67OonAMMGgFAs8BEkoKHDhxAfBmjgAWFAB+wiapRYgIMGi1EydDiQcWNEdhea
ZdnAwUBJkw0FUVCZpUKHZDAlJviApk8q0gQvTQawA7IKGwwMYU781MjRg6AQAxjw2FSIBQweAm0M
UCBMUWcZoMakWKEqkYVbGVgyK6SCta07v2rR4GHX1gFY5cbj8IGBWIdcMXzAoNcJmA8agOYUJmDC
Bw6ErVzl4GEDBMaL6SW4kMdcYSJX9Vx4QCBpZnoBFFTYgPhJaA4SgJo+LTEAgQYZPJhbotADBZd/
aQMOMMDBhltF9yiYLVyp7Qof4IHOG6l58266p2dibj2zoAV/TvlmN6C8+fPo06tfbz61GzAUGrKf
T5/+RD5BAAA7`;
    },
    username() {
      return this.$cookies.get("username")
        ? this.$cookies.get("username")
        : this.$cookies.get("email");
    }
  },
  methods: {
    showCom() {
      this.show = true;
    },
    hideCom() {
      this.content = "";
      this.show = false;
    },
    commit() {
      console.log(this.content);
      let obj = {
        email: this.$cookies.get("email"),
        comId: this.$cookies.get("id"),
        content: this.content,
        userAvatar: this.avatar,
        username: this.username
      };
      let data = qs.stringify(obj);
      this.$axios
        .post("ordering/api/messageSave.php", data)
        .then(res => {
          console.log(res.data);
          if (res.data.valid) {
            this.$Toast({
              message: res.data.message,
              duration: 100
            });
            this.show = false;
            this.getCommit();
            this.flag = true;
          } else {
            this.$Toast({
              message: res.data.message,
              duration: 1000
            });
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    getCom() {
      this.$axios
        .get("ordering/api/getCom.php?comId=" + this.$cookies.get("id"))
        .then(res => {
          console.log(res);
          this.commits = res.data.reverse();
          this.flag = false;
          // this.$nextTick(() => {
          //     this.initScroll();
          //   });
        })
        .catch(err => {
          console.log(err);
        });
    },
    getCommit() {
      this.$axios
        .get("ordering/api/getCom.php?comId=" + this.$cookies.get("id"))
        .then(res => {
          console.log(res);
          if (res.data) {
            if (res.data.length >= 3) {
              this.commits = res.data.reverse().slice(0, 3);
            } else {
              this.commits = res.data.reverse();
            }
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    initScroll() {
      this.mainScroll = new BScroll(this.$refs.mainScroll, {
        click: true
      });
    }
  },
  created() {
    this.getCommit();
  }
};
</script>

<style lang="stylus" scoped>
@import '../../../../common/stylus/mixin.styl';

$fontred = #ce3d3e;

.move-enter-active, .move-leave-active {
  transition: all 0.5s;
}

.move-enter, .move-leave-to {
  transform: translateX(100%);
}

.ratings {
  position: absolute;
  top: 174px;
  // bottom: 0;
  width: 100%;

  // overflow: hidden;
  .ratings-content {
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

    .comment {
      text-align: right;

      span {
        display: inline-block;
        margin-right: 18px;
        padding: 8px 15px;
        border-radius: 25px;
        font-size: 12px;
        color: #fff;
        background: $fontred;
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
            font-size: 12px;
            color: rgb(147, 153, 159);
          }

          img {
            width: 12px;
            height: 12px;
            border-radius: 50%;
          }
        }

        .time {
          margin-bottom: 6px;
          line-height: 12px;
          font-size: 12px;
          color: rgb(147, 153, 159);
        }

        .text {
          line-height: 16px;
          font-size: 12px;
          color: rgb(7, 17, 27);
        }
      }

      .btn {
        margin-top: 10px;
        text-align: center;

        .more {
          background: $fontred;
          border: none;
        }
      }

      .noCom {
        padding: 16px 0;
        font-size: 12px;
        text-align: center;
        color: rgb(147, 153, 159);
      }
    }
  }

  .comments {
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 20;
    background: #fff;

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

    .comDetail {
      .title {
        fon-size: 16px;
        text-align: center;
        color: #123456;
      }

      .text-wrapper {
        margin-top: 20px;
        padding: 0 20px;

        textarea {
          width: calc(100vw - 40px);
          height: 300px;
          padding: 20px;
          box-sizing: border-box;
          border-radius: 10px;
          outline: none;
          border: none;
          border: 1px solid #eee;
          font-size: 14px;
        }

        textarea:focus {
          border: 1px solid $fontred;
        }

        .btn {
          margin-top: 20px;
          text-align: center;

          .cc {
            background: $fontred;
            border: none;
          }
        }
      }
    }
  }
}
</style>
