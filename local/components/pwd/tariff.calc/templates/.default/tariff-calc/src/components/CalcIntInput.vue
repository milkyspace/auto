<template>
  <div class="number">
    <span class="minus" @click="decr"><b></b></span>
      <input class="text-input" @change="changeValue" type="text" v-model="value" size="5">
    <div class="plus" @click="incr"><b></b></div>
  </div>
</template>

<script>
export default {
  name: "CalcIntInput",
  data: function(){
    return {
      value: 0
    }
  },
  mounted() {
    this.value = parseInt(this.initValue)
    this.setCurrentParam(this.nameProperty, this.value)
  },
  watch: {
    value: function(newVal, oldVal){

      if(newVal == ''){
        this.value = 0;
      }

      if(
          newVal > this.$store.state.selectedOptions['countUsers'] &&
          this.nameProperty != 'countUsers'
      ){
        this.value = parseInt(oldVal)
      }

      if(this.nameProperty == 'countUsers'){

        var selfUserComponent = this;

        this.$root.$children[0].$children[0].$children.map(function(paramComponent){

          if(paramComponent.$options._componentTag == 'CalcIntInput'){
            if(paramComponent.nameProperty != 'countUsers'){

              console.log({
                paramComponentvalue: paramComponent.value,
                paramComponent: paramComponent,
                selfUserComponent: selfUserComponent.value,
              })

              if(paramComponent.value > selfUserComponent.value){
                paramComponent.updateValue(selfUserComponent.value)
              }
            }
          }
        });
      }

      this.setCurrentParam(this.nameProperty, this.value)

    }
  },
  methods: {
    incr: function(){
      this.value = this.value + 1;
    },
    decr: function(){
      if(this.value >= 1){
        this.value = this.value - 1;
      }
    },
    updateValue: function(val){
      this.value = val;
    }
  },
  props: [
    'nameProperty',
    'changeEvent',
    'initValue'
  ]
}
</script>

<style scoped>

</style>