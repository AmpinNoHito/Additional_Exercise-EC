<template>
<div>
  <header class="header">
    <p class="header__logo">
      <nuxt-link to="/">
        Trace
      </nuxt-link>
    </p>
    <div class="header__nav-list">
      <div v-if="$auth.loggedIn" class="header__nav-item header__nav-item--auth">
        Name: {{$auth.user.name}}
      </div>
      <div class="header__nav-item" @click="cartClicked">
        <img :src="`${imageStorage}/cart.png`">
      </div>
      <div class="header__nav-item" @click="userClicked">
        <img :src="`${imageStorage}/user.png`">
      </div>
      <div 
        v-if="$auth.loggedIn" 
        class="header__nav-item"
        @click="logout">
        <img :src="`${imageStorage}/logout.png`">
      </div>
    </div>
  </header>
  <Nuxt/>
  <footer class="footer">
    <p class="footer">&copy; 2021 Trace All Rights Reserved.</p>
  </footer>
</div>
</template>


<script>
export default {
  methods: {
    cartClicked() {
      if (this.$auth.loggedIn) {
        this.$router.push('/cart');
      } else {
        this.$router.push('/login');
      }
    },
    userClicked() {
      if (this.$auth.loggedIn) {
        this.$router.push('/history');
      } else {
        this.$router.push('/login');
      }
    },
    async logout() {
      await this.$auth.logout();
      this.$router.push('/');
      this.$store.commit('emptyCart');
    }
  },
};

</script>

<style lang="scss">
.header {
  max-width: 940px;
  margin: 0 auto;
  height: 30px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  display: flex;
  justify-content: space-between;
  align-items: flex-end;

  &__logo {
    font-size: 1.5em;
  }

  &__nav-list {
    display: flex;    
    align-items: center;
    height: 100%;
    padding-right: 5px;
  }

  &__nav-item {
    height: 60%;
    cursor: pointer;
    
    &:not(:last-of-type) {
      margin-right: 10px;
    }

    &--auth {
      cursor: default;
    }

    & > img {
      height: 100%;
    }
  }
}

.footer {
  padding: 5px;
  text-align: center;
  background-color: #000;
  color: #fff;
  font-size: 0.6em;
}

@media screen and (max-width: 1000px) {
  .header {
    margin: 0 30px;
  }
}
</style>