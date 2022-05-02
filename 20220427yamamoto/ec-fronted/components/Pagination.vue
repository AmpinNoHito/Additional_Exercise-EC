<template>
  <ul class="top__pagination">
    <li 
      v-show="currentPage > 1"
      class="top__page-num top__page-num--pre"
      @click="clicked(currentPage - 1)">
      前へ
    </li>
    <li
      v-for="page in frontPageRange" 
      :key="page"
      @click="clicked(page)"
      class="top__page-num"
      :class="{'top__page-num--active': isCurrent(page)}">
      {{page}}
    </li>
    <li v-show="frontDot" class="top__page-num">...</li>
    <li
      v-for="page in middlePageRange" 
      :key="page"
      @click="clicked(page)"
      class="top__page-num"
      :class="{'top__page-num--active': isCurrent(page)}">
      {{page}}
    </li>
    <li v-show="endDot" class="top__page-num">...</li>
    <li
      v-for="page in endPageRange" 
      :key="page"
      @click="clicked(page)"
      class="top__page-num"
      :class="{'top__page-num--active': isCurrent(page)}">
      {{page}}
    </li>
    <li
      v-show="currentPage < lastPage"
      class="top__page-num top__page-num--next"
      @click="clicked(currentPage + 1)">
      次へ
    </li>
  </ul>
</template>

<script>
export default {
  props: [
    'range',
    'currentPage', 
    'lastPage', 
    'frontDot',
    'endDot',
    'sizeCheck',
  ],
  computed: {
    frontPageRange () {
      if (!this.sizeCheck) {
        return this.calRange(1, this.lastPage);
      }
      return this.calRange(1, 2);
    },
    middlePageRange () {
      if (!this.sizeCheck) return [];
      let start = '';
      let end = '';
      if (this.currentPage <= this.range) {
        start = 3;
        end = this.range + 2;
      } else if (this.currentPage > this.lastPage - this.range) {
        start = this.lastPage - this.range - 1;
        end = this.lastPage - 2;
      } else {
        start = this.currentPage - Math.floor(this.range / 2);
        end = this.currentPage + Math.floor(this.range / 2);
      }
      return this.calRange(start, end);
    },
    endPageRange() {
      if (!this.sizeCheck) return [];
      return this.calRange(this.lastPage-1, this.lastPage);
    }
  },
  methods: {
    clicked(e) {
      this.$emit('clicked', e);
    },
    calRange (start, end) {
      const range = [];
      for (let i = start; i <= end; i++) {
        range.push(i);
      }
      return range;
    },
    isCurrent(page) {
      return page === this.currentPage;
    },
  },
};


</script>