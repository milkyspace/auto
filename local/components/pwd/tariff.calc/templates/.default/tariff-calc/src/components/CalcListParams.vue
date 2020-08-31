<template>
  <div class="form-send">
    <div class="form-send__row">
      <label class="form-send__label" for="">Количество пользователей:</label>
      <CalcIntInput nameProperty="countUsers" changeEvent="recalculate" initValue="1"/>
    </div>
    <div class="form-send__row" v-for="( param, index) in listParams" :key="index" >
      <label class="form-send__label" for="">{{param.NAME}}:</label>
      <CalcBoolInput v-if="param.TYPE === 'BOOL'" v-bind:key="index" v-bind:nameProperty="param.NAME" v-bind:changeEvent="recalculate" />
      <CalcRangeInput v-if="param.TYPE === 'LIST_INT'" v-bind:key="index" v-bind:nameProperty="param.NAME" v-bind:changeEvent="recalculate" />
      <CalcIntInput v-if="param.TYPE === 'INT'" v-bind:key="index" v-bind:nameProperty="param.NAME" v-bind:changeEvent="recalculate" v-bind:initValue="0" />
    </div>
    <div class="form-send__row">
      <button class="btn-blue form-send__btn" @click="nextStep" type="submit">Отправить заявку</button>
    </div>
  </div>
</template>

<script>

import CalcRangeInput from './CalcRangeInput'
import CalcIntInput from './CalcIntInput'
import CalcBoolInput from "./CalcBoolInput";

export default {
  name: "CalcListParams",
  computed: {
  },
  methods: {
  },
  components: {
    CalcRangeInput,
    CalcIntInput,
    CalcBoolInput
  }
}
</script>

<style scoped>

</style>