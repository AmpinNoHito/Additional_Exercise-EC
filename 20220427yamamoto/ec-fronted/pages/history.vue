<template>
<div class="history">
  <div class="history__top">
    <p class="history__title">購入履歴</p>
    <nuxt-link to="/" class="history__link-to-top">商品一覧に戻る</nuxt-link>
  </div>
  <div v-if="!historyList.length" class="history__empty">
    <p class="history__message">購入履歴はありません</p>
  </div>
  <div v-else class="history__list">
    <div v-for="(history, index) in historyList"
      :key="history.id"
      class="history__item">
      <div class="history__img">
        <img :src="`${imageStorage}/${history.product.image}`" alt="">
      </div>
      <div class="history__text">
        <p class="history__order-id">注文番号:{{history.order_id}}</p>
        <div class="history__item-bottom">
          <div class="history__item-bottom-left">
            <p class="history__product-name">{{history.product.name}}</p>
            <nuxt-link class="history__link-to-product" :to="`/detail/${history.product.id}`">もう一度購入する</nuxt-link>
          </div>
          <div class="history__item-bottom-right">
            <p class="history__date">{{history.created_at| convertToDate }}</p>
            <p class="history__quantity">合計{{history.product_quantity}}個</p>
            <p class="history__price">¥{{history.product.price}}(税込)</p>
          </div>
        </div>
      </div>
    </div>
    <Pagination
      :range="range"
      :current-page="currentPage"
      :last-page="lastPage"
      :front-dot="frontDot"
      :end-dot="endDot"
      :size-check="sizeCheck"
      @clicked="changePage($event);
                scrollToTopOf('.history__top'); 
                dotState();
                getHistories()"
      />
  </div>
</div>
</template>

<script>
export default {
  middleware: 'auth',
  async asyncData({$axios, $auth}) {
    const res = await $axios.get(`http://127.0.0.1:8000/api/order_product/${$auth.user.id}`);
    const data = res.data.data;
    const range = 5;
    const sizeCheck = (data.last_page >= range + 4) ? true : false;
    return {
      range: range,
      historyList: data.data,
      currentPage: data.current_page,
      lastPage: data.last_page,
      sizeCheck: sizeCheck,
    }
  },
  data() {
    return {
      frontDot: false,
      endDot: false,
    }
  },
  filters: {
    convertToDate(value) {
      const date = new Date(value);
      const y = date.getFullYear();
      const m = date.getMonth() + 1;
      const d = date.getDate();
      return `${y}年${m}月${d}日`;
    }
  },
  mounted() {
    this.dotState();
  },
};
</script>

<style lang="scss">
.history {
  max-width: calc(1000px + 10%);
  margin: 0 auto;
  min-height: 500px;
  margin-top: 30px;
  padding: 0 10%;

  &__top {
    display: flex;
    align-items: flex-end;
    padding: 20px 0;
  }

  &__title {
    font-size: 1.2em;
    font-weight: bold;
    margin-right: 15px;
  }

  &__link-to-top {
    color: #666;
  }

  &__list {
    margin: 0 auto;
  }

  &__item {
    padding: 10px 0;
    display: flex;
    border-bottom: 1px solid #000;
    &:first-of-type{
      border-top: 1px solid #000;
    }
  }

  &__img {
    flex-shrink: 0;
    width: 110px;
    height: 110px;
    margin-right: 10px;
    & > img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }

  &__text {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  &__order-id {
    font-size: 0.8em;
    color: #666;
  }

  &__item-bottom {
    flex-grow: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  &__item-bottom-left {
    width: 50%;
    position: relative;
    display: flex;
    align-items: center;
  }

  &__link-to-product {
    font-size: 0.8em;
    position: absolute;
    top: 45px;
    color: #666;
  }

  &__item-bottom-right {
    width: 50%;
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8em;
    color: #666;
  }

  &__empty {
    height: 150px;
    padding: 5px 0;
    border-top: 1px solid #000;
    border-bottom: 1px solid #000;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  
  &__message {
    margin-bottom: 15px;
  }

  &__link-to-product {
    color: #666;
  }
}

@media screen and (max-width: 670px) {
  .history {
    &__img {
      width: 200px;
      height: 200px;
    }

    &__item-bottom {
      flex-direction: column;
      align-items: stretch;
    }

    &__item-bottom-left {
      flex-grow: 1;
      width: 100%;
    }

    &__link-to-product {
      top: 50%;
      transform: translateY(-50%);
      right: 0;
    }

    &__item-bottom-right {
      width: 100%;
      align-items: end;
    }
  }
}
</style>