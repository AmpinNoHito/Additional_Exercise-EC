<template>
  <div class="login">
    <div class="login__inner">
      <div class="login__item">  
        <p class="login__title">
          ログイン
        </p>
        <p class="login__customer-type">
          会員のお客さま
        </p>
        <p class="login__indication">
          メールアドレスとパスワードを入力してログインしてください。
        </p>
        <EntranceForm
          @clicked="login($event)"
          :square-btn="true"
          :black-btn="true"
          :name-required="false"
          >
          <p>ログイン</p>
        </EntranceForm>
      </div>


      <div class="login__item">
        <p class="login__title">
          新規会員登録
        </p>
        <p class="login__customer-type">
          初めてご利用の方・会員以外の方
        </p>
        <p class="login__indication">
          初めてご利用のお客様は、こちらから会員登録を行って下さい。
        </p>
        <EntranceForm
          @clicked="register($event)"
          :square-btn="true"
          >
          <p>新規会員登録</p>
        </EntranceForm>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  methods: {
    async register(data) {
      if (!data.name || !data.email || !data.password) {
        alert('すべての項目を入力してください。');
        return;
      }
      const sendData = {
        name: data.name,
        email: data.email,
        password: data.password,
      }; 
      try {
        const res = await this.$axios.post('http://127.0.0.1:8000/api/auth/register', sendData);
        alert(res.data.message);
      } catch {
        alert('エラーが発生しました。しばらくしてからもう一度お試しください。');
      }
    },
    async login(data) {
      if (!data.email || !data.password) {
        alert('すべての項目を入力してください。');
        return;
      }
      if (this.$auth.loggedIn) {
        this.$auth.logout();
      }
      const sendData = {
        data: {
          email: data.email,
          password: data.password,
        }
      }
      try {
        await this.$auth.loginWith("laravelJWT", sendData);
        this.$router.push('/');
      } catch {
        alert('ログインできませんでした。メールアドレスとパスワードを確認してもう一度お試しください。');
      }
    },
  },
};
</script>

<style lang="scss">
.login {
  &__inner {
    width: 70%;
    margin: 100px auto;
    display: flex;
    justify-content: space-between;
  }

  &__item {
    width: 47%;
  }

  &__title {
    font-size: 1.3em;
    margin-bottom: 20px;
  }

  &__customer-type {
    font-weight: bold;
    text-indent: 5px;
    border-bottom: 2px solid #000;
    margin-bottom: 20px;
  }

  &__indication {
    font-size: 0.8em;
    margin-bottom: 20px;
  }
}
</style>