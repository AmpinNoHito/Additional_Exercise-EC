export default {
  state: () => ({
    cart: [],
  }),

  getters : {
    getItems(state) {
      return state.cart;
    }
  },

  mutations : {
    addToCart(state, data) {
      const item = state.cart.find(item => item.id === data.id);
      if (item) {
        item.quantity += +data.quantity;
      } else {
        state.cart.push({
          id: data.id,
          name: data.name,
          price: data.price,
          image: data.image,
          quantity: +data.quantity,
        });
      }
    },
    deleteFromCart(state, id) {
      state.cart = state.cart.filter(item => {
        if (item.id !== id) return item;
      });
    },
    updateCart(state, data) {
      const item = state.cart.find(item => item.id === data.id);
      item.quantity = +data.quantity;
    },
    emptyCart(state) {
      state.cart = [];
    }
  },
};
