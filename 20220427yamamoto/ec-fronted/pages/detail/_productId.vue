<template>
<div class="detail">
  <div class="detail__upper">
    <div class="detail__img">
      <img :src="`${imageStorage}/${image}`">
    </div>
    <div class="detail__upper-right">
      <p class="detail__name">{{name}}</p>
      <p class="detail__price">¥{{price.toLocaleString()}}(税込)</p>
      <form class="detail__form">
        <div class="detail__quantity">
          <label class="detail__quantity-label" for="quantity">個数</label>
          <input 
            type="number"
            class="detail__quantity-input"
            id="quantity"
            v-model="quantity"
            @change="checkInputValue"
            >
        </div>
        <SubmitButton class="detail__btn" @clicked="addToCart">
          <p class="detail__btn-text">カートに入れる</p>
        </SubmitButton>
      </form>
    </div>
  </div>
  <div class="detail__bottom">
    <p class="detail__caption">{{caption}}</p>
    <p class="detail__description">{{description}}</p>
  </div>

</div>
</template>

<script>
export default {
  middleware: 'auth',
  async asyncData({params, $axios}) {
    const res = await $axios.get(`http://127.0.0.1:8000/api/product/${params.productId}`);
    const product = res.data.data;
    return {
      id: product.id,
      name: product.name,
      price: product.price,
      caption: product.caption,
      description: product.description,
      image: product.image,
    }
  },
  data() {
    return {
      quantity: 0,
    }
  },
  methods: {
    addToCart() {
      if (+this.quantity === 0) {
        alert('個数が0です。');
      } else if (+this.quantity < 0 || +this.quantity % 1 !== 0) {
        alert('個数が不適切です。');
      } else {
        const data = {
          id: this.id,
          name: this.name,
          price: this.price,
          image: this.image,
          quantity: +this.quantity,
        };
        this.$store.commit('addToCart', data);
        this.$router.push('/cart');
      }
    },
    checkInputValue () {
      const form = document.querySelector('.detail__quantity-input');
      if (!form.value.match(/^[-]?([1-9]\d*|0)(\.\d+)?$/)) {
        form.value = 0;
      }
    }
  },
};

</script>

<style lang="scss">
.detail {
  &__upper {
    margin: 100px auto;
    display: flex;
    justify-content: center;
    width: 60%;
  }

  &__img {
    width: 50%;
    height: 200px;
    margin-right: 20px;
    text-align: center;
    & > img {
      width: 200px;
      height: 100%;
      object-fit: cover;
    }
  }

  &__upper-right {
    width: 50%;
  }

  &__name {
    margin-bottom: 15px;
  }

  &__price {
    font-size: 1.5em;
    font-weight: bold;
  }

  &__quantity {
    margin: 15px 0;
    display: flex;
    align-items: center;
  }

  &__quantity-label {
    flex-shrink: 0;
    margin-right: 5px;
  }

  &__quantity-input {
    font-size: 0.6em;
    padding: 0;
    background-color: #eee;
    border: none;
    width: 40%;
  }

  &__btn-text {
    position: relative;
    &::before {
      content: '';
      filter: invert(100);
      background: url('http://127.0.0.1:8000/storage/images/cart.png') no-repeat bottom/cover;
      display: inline-block;
      width: 20px;
      height: 14px;
      position: absolute;
      left: 0;
      top: 3px;
    }
  }

  &__bottom {
    margin: 0 auto 200px auto;
    width: 60%;
  }

  &__caption {
    font-weight: bold;
    font-size: 1.1em;
    margin-bottom: 20px;
  }

  &__description {
    font-size: 0.9em;
  }
}

@media screen and (max-width: 670px) {
  .detail {
    &__img {
      width: 50%;
      height: 150px;
      margin-right: 20px;
      text-align: center;
      & > img {
        width: 150px;
        height: 100%;
        object-fit: cover;
      }
    }
  }
}
</style>