<template>
<div class="cart">
  <div class="cart__top">
    <p class="cart__title">ショッピングカート</p>
    <nuxt-link to="/" class="cart__link">商品一覧に戻る</nuxt-link>
  </div>
  <div v-if="!itemList.length" class="cart__empty">
    <p class="cart__message">カートは空です</p>
  </div>
  <div v-else class="cart__content">
    <div class="cart__item-list">
      <div 
        v-for="(item, index) in reverseItemList" 
        :key="item.id"
        class="item">
        <div class="item__img">
          <img :src="`${imageStorage}/${item.image}`">
        </div>
        <div class="item__text">
          <div class="item__left">
            <p class="item__name">
              {{item.name}}
            </p>
            <p class="item__delete" @click="deleteItem(item.id)">
              削除する
            </p>
          </div>
          <div class="item__right">
            <form class="item__form">
              <div class="item__quantity">
                <label class="item__quantity-label" for="quantity">個数</label>
                <input 
                  type="number"
                  class="item__quantity-input"
                  :class="`item__quantity-input--${item.id}`"
                  id="quantity"
                  v-model="quantityList[index]"
                  @input="update(item.id)"
                  >
              </div>
            </form>
            <span class="item__price">
              ¥{{item.price.toLocaleString()}}(税込)
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="cart__order">
      <p class="cart__sum">合計：¥{{getSum.toLocaleString()}} 税込</p>
      <SubmitButton 
        class="cart__btn"
        @clicked="orderItems">
        注文する
      </SubmitButton>
    </div>
  </div>
</div>
</template>

<script>
export default {
  middleware: ['auth'],
  data() {
    return {
      itemList: this.$store.getters.getItems,
      quantity: this.quantityList,
    }
  },
  computed: {
    reverseItemList() {
      return this.itemList.slice().reverse();
    },
    quantityList() {
      const list = [];
      this.reverseItemList.forEach(item => list.push(item.quantity));
      return list;
    },
    getSum() {
      const initial = {
        price: 0,
        quantity: 1,
      };
      const sum = this.itemList.reduce((prev, curr) => {
        if (!prev.price && !prev.quantity) {
          return prev + curr.price * curr.quantity;
        } else {
          return prev.price * prev.quantity + curr.price * curr.quantity;
        }
      }, initial);
      return sum;
    },
  },
  methods: {
    deleteItem(id) {
      this.$store.commit('deleteFromCart', id);
      this.itemList = this.$store.getters.getItems;
    },
    update(id) {
      const form = document.querySelector(`.item__quantity-input--${id}`);
      if (+form.value < 0 && form.value !== null) {
        alert('個数が不適切です。');
        form.value = 0;
      }
      const data = {
        id: id,
        quantity: form.value,
      }
      this.$store.commit('updateCart', data);
    },
    async orderItems() {
      const ch1 = this.itemList.filter(item => item.quantity === 0);
      const ch2 = this.itemList.filter(item => item.quantity % 1 !== 0);
      if (ch1.length === this.itemList.length) {
        alert('カートは空です。');
        return;
      } else if (ch1.length || ch2.length) {
        alert('個数が不適切です。');
        return;
      }
      const sendData= {
        userId: this.$auth.user.id,
        products: this.itemList,
      };
      const res = await this.$axios.post('http://127.0.0.1:8000/api/order', sendData);
      this.$store.commit('emptyCart');
      this.$router.push(`/thanks/${res.data.data.id}`);
    },
  },
}
</script>

<style lang="scss">
.cart {
  max-width: 1000px;
  margin: 0 auto;
  min-height: 500px;
  padding: 0 30px;
  
  &__top {
    display: flex;
    align-items: flex-end;
    padding-bottom: 20px;
  }
  
  &__title {
    font-size: 1.2em;
    font-weight: bold;
    margin: 50px 15px 0 0;
  }

  &__content {
    display: flex;
    justify-content: space-between;
  }

  &__item-list {
    margin-bottom: 20px;
    flex-grow: 2;
    flex-shrink: 1;
  }

  &__order {
    text-align: center;
    background-color: #eee;
    height: fit-content;
    margin-left: 30px;
    padding: 20px 30px;
    flex-grow: 1;
    flex-shrink: 1;
  }

  &__sum {
    font-weight: bold;
    margin-bottom: 20px;
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

  &__link {
    color: #666;
  }
}

.item {
  display: flex;
  justify-content: space-between;
  height: 150px;
  padding: 5px 0;
  border-bottom: 1px solid #000;
  &:first-of-type {
    border-top: 1px solid #000;
  }

  &__text {
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  &__img {
    height: 100%;
    & > img {
      height: 100%;
      object-fit: contain;
    }
  }
  
  &__left {
    flex-grow: 1;
    padding: 0 20px;
    position: relative;
  }

  &__delete {
    cursor: pointer;
    font-size: 0.8em;
    position: absolute;
    top: 30px;
    left: 30px;
  }

  &__right {
    display: flex;
    align-items: center;
  }

  &__form {
    display: inline-block;
  }

  &__quantity-input {
    width: 50px;
    margin-right: 5px;
  }
}

@media screen and (max-width: 780px) {
  .item {
    &__text {
      flex-direction: column;
      align-items: stretch;
      justify-content: space-between;
    }

    &__left,
    &__right {
      flex-grow: 1;
    }

    &__left {
      display: flex;
      align-items: center;
    }

    &__right {
      justify-content: flex-end;
      padding: 0 20px;
      font-size: 0.8em;
    }

    &__name {
      flex-grow: 1;
    }

    &__delete {
      position: relative;
      top: 0;
      left: 0;
    }
  }
}

</style>