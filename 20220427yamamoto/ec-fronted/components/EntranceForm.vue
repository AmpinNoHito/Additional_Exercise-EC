<template>
  <div class="entrance-form">
    <div class="entrance-form__container">
      <validation-observer 
        ref="obs"
        v-slot="ObserverProps"
        class="entrance-form__items-wrapper">
        <form>

          <validation-provider
            v-slot="{errors}"
            rules="required|email">
            <p v-show="errors[0]" class="entrance-form__error">※{{errors[0]}}</p>
            <div class="entrance-form__item">
              <label class="entrance-form__label">メールアドレス:
                <input
                  class="entrance-form__input"
                  v-model="sendData.email" 
                  type="email"
                  name="メールアドレス"
                  placeholder="email">
              </label>
            </div>
          </validation-provider>
          
          <validation-provider
            v-slot="{errors}"
            rules="required|min:6|">
            <p v-show="errors[0]" class="entrance-form__error">※{{errors[0]}}</p>
            <div class="entrance-form__item">
              <label class="entrance-form__label">パスワード: 
                <input
                  class="entrance-form__input"
                  v-model="sendData.password"
                  type="password"
                  name="パスワード"
                  placeholder="password">
              </label>
            </div>
          </validation-provider>

          <validation-provider
            v-if="nameRequired" 
            v-slot="{errors}" 
            rules="required|min:4">
            <p v-show="errors[0]" class="entrance-form__error">※{{errors[0]}}</p>
            <div class="entrance-form__item">
              <label class="entrance-form__label">お名前:
                <input
                  class="entrance-form__input"
                  v-model="sendData.name"
                  type="text" 
                  name="お名前"
                  placeholder="name"
                  >
              </label>
            </div>
          </validation-provider>

          <div class="entrance-form__btn-wrapper">
            <SubmitButton 
              @clicked="clicked"
              :disabled="ObserverProps.invalid||!ObserverProps.validated"
              :square-btn="squareBtn"
              :black-btn="blackBtn"
            >
              <slot></slot>
            </SubmitButton>
          </div>
        </form>
      </validation-observer>
    </div>
  </div>
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
    nameRequired: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      sendData : {
        name: '',
        email: '',
        password: '',
      }
    }
  },
  methods: {
    clicked() {
      this.$emit('clicked', this.sendData);
    }
  },
}
</script>

<style lang="scss">
.entrance-form {
  &__container {
    padding: 0 0 0 20px;
  }

  &__items-wrapper {
    display: flex;
    justify-content: center;
  }

  &__item {
    margin-bottom: 2px;
    text-align: right;
  }

  &__label {
    font-size: 0.8em;
    font-weight: bold;
    display: flex;
    justify-content: flex-end;
    align-items: center;
  }

  &__input {
    border: 1px solid rgba(0, 0, 0, 0.5);
    width: 200px;
  }

  &__error {
    color: red;
    font-size: 0.6em;
    font-weight: bold;
    margin: 5px 0 2px 0;
    text-align: right;
  }

  &__btn-wrapper {
    text-align: center;
    margin-top: 30px;
  }
}

@media screen and (max-width: 1000px) {
  .entrance-form {
    &__input {
      width: 150px;
    }
  }
}

@media screen and (max-width: 830px) {
  .entrance-form {
    &__input {
      width: 120px;
    }
    &__label {
      font-size: 0.6em;
    }
  }
}
</style>