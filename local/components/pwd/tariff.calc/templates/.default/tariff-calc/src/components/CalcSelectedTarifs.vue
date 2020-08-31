<template>
  <div class="calc-sum">
    <div class="calc-sum-item" v-for="(tariff, index) in calculatedTarifs.tariffs" v-bind:key="index">
      <div class="calc-sum-item__price">{{tariff.quantity * tariff.price | price}} руб. / мес.</div>
      <p v-for="(option, indexOption) in tariff.options" v-bind:key="index + '_' + indexOption">
        {{option.quantity}}x * <span class='medium'>{{option.price | price}} руб.</span>
      </p>
      <p>{{tariff.quantity}}x * <span class="medium">{{tariff.price | price}} руб.</span></p>
      <p>{{tariff.name}}</p>
    </div>
    <div class="calc-sum-total">
      <div class="calc-sum-total__title">{{calculatedTarifs.total.price | price}} руб/мес.</div>
      <div class="calc-sum-total__desc">Общая стоимость</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CalcSelectedTarifs"
}
</script>

<style scoped>

</style>