<template>
  <div class="main">
    <div class="search-wrapper">
      <input type="text" placeholder="搜索商家名称" class="search" v-model="search">
    </div>
    <div ref="mainScroll" class="mainScroll">
      <div>
        <!-- 用这个BScroll 得用一个div包着 两个就不行了 -->
        <div class="swiper-wrapper">
          <mt-swipe :auto="3000" class="my-swipeimg" :showIndicators="false">
            <mt-swipe-item v-for="(item, index) in swiperArr" :key="index">
              <img :src="item" alt="">
            </mt-swipe-item>
          </mt-swipe>
        </div>
        <div class="sort">
          <h1 class="title">排序</h1>
          <span class="sellCount" @click="countSort">月销售量</span>
          <span class="deliveryTime" @click="timeSort">配送时间</span>
          <span class="score" @click="scoreSort">评分</span>
        </div>
        <div class="content-wrapper">
          <div class="content">
            <ul>
              <li
                v-for="(seller, index) in filterSellers"
                :key="index"
                class="item"
                @click="setId(seller.id)"
              >
                <router-link tag="div" :to="{path: '/details'}" class="route">
                  <div class="avatar">
                    <img :src="seller.avatar" alt>
                  </div>
                  <div class="content-detail">
                    <h1 class="title">{{ seller.name }}</h1>
                    <div class="num">
                      <Star :size="24" :score="seller.score"></Star>
                      <span class="score text">{{ seller.score }}</span>
                      <span class="text">月售{{ seller.sellCount }}单</span>
                      <span v-if="seller.description" class="desc">{{ seller.description }}</span>
                    </div>
                    <div class="arrive">
                      <div class="arrive-left">
                        <span>￥{{ seller.minPrice }}起送</span>
                        <span class="border"></span>
                        <span v-if="seller.deliveryPrice">配送费￥{{ seller.deliveryPrice }}</span>
                        <span v-else>免配送费</span>
                      </div>
                      <div class="arrive-right">
                        <span>{{ seller.deliveryTime }}分钟</span>
                      </div>
                    </div>
                  </div>
                </router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Star from "./details/star/Star";
import BScroll from "better-scroll";

export default {
  components: {
    Star
  },
  data() {
    return {
      sellers: [],
      swiperArr: [
        "http://img4.imgtn.bdimg.com/it/u=1761033308,3594420462&fm=26&gp=0.jpg",
        "https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=3725100111,4075611937&fm=26&gp=0.jpg",
        "https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=1874150882,3864376148&fm=26&gp=0.jpg",
        "http://img2.imgtn.bdimg.com/it/u=2292070531,2026965857&fm=26&gp=0.jpg",
        "https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=1443205896,2241628519&fm=200&gp=0.jpg"
      ],
      search: ""
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
          data.forEach(value => {
            this.sellers.push(value.seller);
          });
          this.$nextTick(() => {
            this.initScroll();
          });
          // console.log(this.sellers);
        })
        .catch(err => {
          console.log(err);
        });
    },
    setId(id) {
      // console.log(id)
      this.$cookies.set("id", id);
      // console.log(this.$cookies.get("id"))
    },
    compare(attr, toDown) {
      return function(a, b) {
        if (toDown) {
          return b[attr] - a[attr];
        } else {
          return a[attr] - b[attr];
        }
      };
    },
    countSort() {
      this.sellers.sort(this.compare("sellCount", true));
    },
    timeSort() {
      this.sellers.sort(this.compare("deliveryTime"));
    },
    scoreSort() {
      this.sellers.sort(this.compare("score", true));
    },
    initScroll() {
      this.mainScroll = new BScroll(this.$refs.mainScroll, {
        click: true
      });
    }
  },
  computed: {
    filterSellers() {
      return this.sellers.filter(seller => {
        return seller.name.match(this.search);
      });
    }
  }
};
</script>

<style lang="stylus" scoped>
$fontred = #ce3d3e
.main {
  .search-wrapper {
    position: fixed;
    left: 0;
    top: 0;
    z-index: 10;
    width: 100%;
    box-sizing: border-box;
    padding: 10px 20px;
    text-align: center;
    background: $fontred;

    .search {
      height: 40px;
      width: 100%;
      padding: 5px 20px;
      outline: none;
      border: none;
      transition: border 0.3s;
      box-sizing: border-box;
      box-shadow: 3px 3px 5px rgba(255, 255, 255, .5);
      color: #000;
      font-size: 16px;
      transition: 0.5s;

      // &:focus {
      //   border: 1px solid #123456;
      // }
    }
  }

  .mainScroll {
    position: absolute;
    top: 60px;
    left: 0;
    bottom: 50px;
    width: 100%;
    overflow: hidden;
    .swiper-wrapper {
      padding: 20px;
      .my-swipeimg {
        height: 25vh;  
        font-size: 30px;
        text-align: center;
        border-radius: 5px;
        box-shadow: 3px 3px 5px rgba(0, 0, 0, .3);
        color: #fff;
        img {
          width: 100%;
          height: 100%;
        }
      }
    }
    .sort {
      padding: 0 20px;

      .title {
        padding-bottom: 13px;
        text-align: center;
        font-size: 13px;
      }

      span {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        background: #eee;
        color: $fontred;
        font-size: 10px;
        margin-right: 6px;
      }
    }

    .content-wrapper {
      margin-top: 20px;
      border-top: 1px solid #ccc;
      padding: 20px;

      .content {
        .item {
          padding-top: 20px;
          border-bottom: 1px solid #ccc;

          &:first-child {
            padding-top: 0;
          }

          .route {
            display: flex;
            padding-bottom: 20px;

            .avatar {
              flex: 0 0 64px;
              width: 64px;
              height: 64px;
              margin-right: 12px;
              border: 1px solid #ccc;
              border-radius: 2px;

              img {
                width: 100%;
                height: 100%;
              }
            }

            .content-detail {
              flex: 5;

              .title {
                margin-bottom: 8px;
                line-height: 14px;
                font-size: 14px;
                color: rgb(7, 17, 27);
              }

              .num {
                position: relative;
                display: flex;
                width: 100%;

                .text {
                  line-height: 10px;
                  font-size: 10px;
                  color: rgb(77, 85, 93);

                  &.score {
                    margin: 0 6px;
                  }
                }

                .desc {
                  position: absolute;
                  right: 0;
                  padding: 3px;
                  border-radius: 2px;
                  font-size: 10px;
                  color: #fff;
                  background: $fontred;
                }
              }

              .arrive {
                margin-top: 8px;
                overflow: hidden;

                span {
                  line-height: 10px;
                  font-size: 10px;
                  color: rgb(77, 85, 93);

                  &.border {
                    display: inline-block;
                    width: 1px;
                    height: 10px;
                    background: #ccc;
                    margin: 0 3px;
                  }
                }

                .arrive-left {
                  float: left;
                }

                .arrive-right {
                  float: right;
                }
              }
            }
          }
        }
      }
    }
  }
}
</style>
