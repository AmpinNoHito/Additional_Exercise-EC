import Vue from 'vue';

const mixin = Vue.mixin({
  data() {
    return {
      imageStorage: 'http://127.0.0.1:8000/storage/images',
    }
  },
  methods: {
    async getProducts() {
      const res = await this.$axios.get(`http://127.0.0.1:8000/api/product?page=${this.currentPage}`);
      this.productsList = res.data.data;
    },
    async getHistories() {
      const res = await this.$axios.get(`http://127.0.0.1:8000/api/order_product/${this.$auth.user.id}?page=${this.currentPage}`);
      this.historyList = res.data.data.data;
    },
    dotState() {
      if (!this.sizeCheck) {
        this.frontDot = false;
        this.endDot = false;
      } else if (this.currentPage <= this.range) {
        this.frontDot = false;
        this.endDot = true;
      } else if (this.currentPage > this.lastPage - this.range) {
        this.frontDot = true;
        this.endDot = false;
      } else {
        this.frontDot = true;
        this.endDot = true;
      }
    },
    changePage (page) {
      if (page > 0 && page <= this.lastPage) {
        this.currentPage = page;
      }
    },
    scrollToTopOf(selector) {
      const products = document.querySelector(selector);
      const top = products.getBoundingClientRect().top;
      const offset = window.scrollY;
      const target = top + offset
      scrollTo({
        top: target,
        behavior: 'smooth',
      });
    },
  },
});

export default { mixin };
