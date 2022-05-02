<template>
  <div class="top">
    <div class="top__top-img">
      <img :src="`${imageStorage}/sandal.jpg`">
      <p class="top__copy">
        New Arrivals
        <br>
        <span class="top__copy--small">
          for BOYS & GIRLS
        </span>
      </p>
    </div>
    <div class="top__products">
      <p class="top__products-title">
        Products
      </p>
      <div class="top__grid-parent">
        <div class="top__grid-child"
          v-for="(product, index) in productsList" :key="product.id">
          <div class="top__product-img" @click="toDetail(product.id)">
            <img :src="`${imageStorage}/${product.image}`">
          </div>
          <div class="top__product-info">
            <p class="top__product-name" @click="toDetail(product.id)">
              {{product.name}}
            </p>
            <br>
            <p class="top__product-price" @click="toDetail(product.id)">
              ¥{{product.price.toLocaleString()}}(税込)
            </p>
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
                  scrollToTopOf('.top__products');
                  dotState();
                  getProducts();"
        />
    </div>
  </div>
</template>

<script>
import mixin from '~/plugins/mixin'
export default {
  mixins: [mixin],
  async asyncData({$axios}) {
    const currentPage = 1;
    const res = await $axios.get(`http://127.0.0.1:8000/api/product?page=${currentPage}`);
    const range = 5;
    const sizeCheck = (res.data.last_page >= range + 6) ? true : false;
    return {
      range: range,
      productsList: res.data.data,
      currentPage: res.data.current_page,
      lastPage: res.data.last_page,
      sizeCheck: sizeCheck,
    }
  },
  data() {
    return {
      frontDot: false,
      endDot: false,
    }
  },
  methods: {
    toDetail(productId) {
      this.$router.push(`/detail/${productId}`);
    },
  },
  mounted() {
    this.dotState();
  },
}
</script>


<style lang="scss">
.top {
  max-width: 1000px;
  margin: 0 auto;

  &__top-img {
    padding: 10px 30px; 
    position: relative;
    & img {
      width: 100%;
      object-fit: cover;
    }
  }
  
  &__copy {
    position: absolute;
    top: 35%;
    left: 60%;
    font-size: 2.5em;
    line-height: 0.6em;
    &--small {
      font-size: 16px;
    }
  }

  &__products {
    padding-top: 20px;
  }

  &__products-title {
    text-align: center;
  }

  &__grid-parent {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    justify-items: center;
    column-gap: 10px;
    row-gap: 10px;
    padding: 10px 30px;
  }
  
  &__product-img {
    cursor: pointer;
    width: 225px;
    & > img {
      width: 100%;
      height: calc(225px * 2 / 3);
      object-fit: cover;
    }
  }
  
  &__product-name,
  &__product-price {
    display: inline-block;
    cursor: pointer;
  }

  &__pagination {
    width: fit-content;
    display: flex;
    justify-content: center;
    margin: 25px auto;
    position: relative;
  }

  &__page-num {
    cursor: pointer;
    display: inline-block;
    border: 1.5px solid yellowgreen;
    border-radius: 10px;
    text-align: center;
    padding: 2px 10px;
    font-size: 0.8em;
    
    &:not(:last-of-type) {
      margin-right: 5px;
    }

    &--active {
      background: yellowgreen;
      color: #fff;
    }

    &--pre,
    &--next {
      padding: 2px 5px;
      position: absolute;
    }

    &--pre {
      left: -45px;
    }

    &--next {
      right: -40px;
    }
  }
}

@media screen and (max-width: 1000px) {
  .top {
    &__product-img {
      width: 180px;
      & > img {
        height: calc(180px * 2 / 3);
      }
    }
  }
}

@media screen and (max-width: 830px) {
  .top {
    &__product-img {
      width: 145px;
      & > img {
        height: calc(145px * 2 / 3);
      }
    }
  }
}

@media screen and (max-width: 670px) {
  .top {
    &__copy {
      font-size: 1.7em;
    }

    &__grid-parent {
    grid-template-columns: repeat(2, 1fr);
  }

    &__product-img {
      width: 230px;
      & > img {
        height: calc(230px * 2 / 3);
      }
    }
  }
}
</style>