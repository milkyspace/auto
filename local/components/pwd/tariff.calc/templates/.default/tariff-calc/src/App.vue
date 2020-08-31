<template>
  <div class="calc-content">
    <div class="calc-content__left">
      <CalcListParams v-if="step === 1"/>
      <CalcUserData v-if="step === 2"/>
      <CalcSuccessSend v-if="step === 3"/>
    </div>
    <div class="calc-content__right">
      <CalcSelectedTarifs/>
    </div>
  </div>
</template>

<script>
import CalcSelectedTarifs from './components/CalcSelectedTarifs'
import CalcListParams from './components/CalcListParams'
import CalcUserData from './components/CalcUserData'
import CalcSuccessSend from "./components/CalcSuccessSend";

export default {
  name: 'App',
  components: {
    CalcListParams,
    CalcSelectedTarifs,
    CalcUserData,
    CalcSuccessSend
  },
  mounted: function() {
    this.$store.dispatch('setParamsTarifs');
  }
}
</script>

<style lang="scss">

</style>
