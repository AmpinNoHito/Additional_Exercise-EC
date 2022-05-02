<template>
  <button 
    class="btn"
    :class="btnClass"
    @click.prevent="clicked">
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: {
    squareBtn: {
      type: Boolean,
      default: false,
    },
    blackBtn: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      btnClass : {
        'btn--square': this.squareBtn,
        'btn--black': this.blackBtn,
      }
    }
  },
  methods: {
    clicked() {
      this.$emit('clicked');
    }
  },
};
</script>

<style lang="scss" scoped>
.btn {
  cursor: pointer;
  color: #fff;
  font-weight: bold;
  background-color: yellowgreen;
  width: 150px;
  border: none;
  border-radius: 20px;
  transition: 0.1s;
  transform: scale(1);

  &:disabled {
    filter: brightness(60%);
  }
  
  &:not(:disabled):active {
    transform: scale(0.98);
  }

  &--black {
    background-color: #000;
  }

  &--square {
    border-radius: 0;
  }
}
</style>