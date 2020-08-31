<template>
  <div class="check form-send__check--custom">
    <input id="r23" type="checkbox" @change="changeValue" name="s2" v-model="value">
    <label for="r23"></label>
  </div>
</template>

<script>
export default {
  name: "CalcBoolInput",
  props: [
    'nameProperty',
    'changeEvent'
  ],
  data: function(){
    return {
      value: false
    }
  },
  mounted() {
    this.setCurrentParam(this.nameProperty, this.value)
  },
}
</script>

<style scoped>

</style>