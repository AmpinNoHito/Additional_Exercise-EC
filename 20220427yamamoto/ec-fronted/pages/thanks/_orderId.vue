<template>
<div class="thanks">
  <div class="thanks__top">
    <p class="thanks__header">ありがとうございます。注文が確定されました。</p>
    <p class="thanks__small-text">注文内容と配送状況についてはEメールでお知らせをご確認ください。</p>
  </div>
  <div class="thanks__inner">
    <p class="thanks__number">
      注文番号
    </p>
    <p class="thanks__number">
      {{$route.params.orderId}}
    </p>
    <p class="thanks__text">
      で承りました。
    </p>
    <SubmitButton
      class="thanks__btn"
      @clicked="$router.push('/')">
      ショッピングを続ける
    </SubmitButton>
  </div>
</div>
</template>

<script>
export default {
  middleware: 'auth',
};
</script>

<style lang="scss">
.thanks {
  min-height: 500px;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  margin-top: 50px;

  &__header {
    font-size: 1.3em;
    font-weight: bold;
    margin-bottom: 15px;
  }
  
  &__small-text {
    font-size: 0.7em;
    margin-bottom: 25px;
  }

  &__inner {
    font-size: 0.8em;
    width: 50%;
    background-color: #dedede;
    padding: 25px 40px;
  }

  &__number {
    font-weight: bold;
    margin-bottom: 15px;
  }

  &__text {
    margin-bottom: 15px;
  }

  &__btn {
    font-size: 0.7em;
    padding-top: 3px;
    padding-bottom: 3px;
  }
}
</style>