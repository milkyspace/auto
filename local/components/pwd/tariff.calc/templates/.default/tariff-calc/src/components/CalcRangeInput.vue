<template>
  <div id="slider-input">
    <div class="calc-values-container">
      <span class="calc-value" v-for="val in all">{{val}}</span>
    </div>
    <div class="ui-slider-handle" id="custom-handle"></div>
  </div>
</template>

<script>

import $ from 'jquery';
import 'jquery-ui/ui/widgets/slider'
export default {
  name: "CalcRangeInput",
  props: [
      'nameProperty',
      'changeEvent'
  ],
  data: function(){
    return {
      value: 1,
      min: 1,
      max: 1,
      all: [1]
    }
  },
  mounted() {

    let currentSliderPAramether = this.$store.getters.slider;

    if(currentSliderPAramether){

      this.value = currentSliderPAramether.current;
      this.min = currentSliderPAramether.min;
      this.max = currentSliderPAramether.max;
      this.all = currentSliderPAramether.all


      this.setCurrentParam(this.nameProperty, this.value);

      var self = this;

      var handle = $( "#custom-handle" );
      $( "#slider-input" ).slider({
        min: this.min,
        max: this.max,
        values: [this.value],
        step: this.all[1] - this.all[0],
        create: function() {
          //handle.text( $( this ).slider( "value" ) );
        },
        slide: function( event, ui ) {
          // handle.text( ui.value );
          self.setCurrentParam(self.nameProperty, ui.value);
        }
      });

    }

  },
}
</script>

<style lang="scss">
#slider-input{
  .calc-values-container{
    font-size: 16px;
    color: #303030;
    position: absolute;
    top: -30px;
    display: flex;
    justify-content: space-between;
    width: 100%;
    &.calc-value{

    }
  }
  #custom-handle{
    height: 0px;
  }
}
</style>