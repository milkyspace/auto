<template>
  <div class="form-send">
    <div class="form-send__row">
      <label class="form-send__label" for="">Ваше имя</label>
      <input class="text-input" type="text" v-model="name" @change="changeName" placeholder="Имя" required>
      <p v-if="errorName.length > 0" style="color: red">{{errorName}}</p>
    </div>
    <div class="form-send__row">
      <label class="form-send__label" for="">Телефон</label>
      <input class="text-input phone_input_vue" type="tel" v-model="phone" @change="changePhone" placeholder="Телефон" required>
      <p v-if="errorPhone.length > 0" style="color: red">{{errorPhone}}</p>
    </div>
    <div class="form-send__row">
      <label class="form-send__label" for="">E-mail</label>
      <input class="text-input" type="email" v-model="email" @change="changeEmail" placeholder="E-mail" required>
      <p v-if="errorMail.length > 0" style="color: red">{{errorMail}}</p>
    </div>
    <div class="check form-send__check">
      <input id="r21" type="checkbox" name="s2" v-model="check" @keypress="changeCheck" required>
      <label for="r21">Согласие на обработку персональных данных</label>
      <p v-if="errorCheck.length > 0" style="color: red">{{errorCheck}}</p>
    </div>
    <div class="form-send__row">
      <button  class="btn-blue form-send__btn" @click="send" type="button">Отправить заявку</button>
    </div>
  </div>
</template>

<script>

import $ from "jquery";

export default {
  name: "CalcUserData",
  data: function(){
    return {
      name: '',
      errorName: '',
      phone: '',
      errorPhone: '',
      email: '',
      errorMail: '',
      check: true,
      errorCheck: ''
    }
  },
  mounted() {
    var self = this;
    $(function(){
      window.jQuery('.phone_input_vue').inputmask("+7 (999) 999-99-99");
      window.jQuery('.phone_input_vue').change(function(){
        self.phone = $(this).val();
      });
    })

  },
  methods: {
    changeName: function(){
      this.errorName = '';
      if(this.name.trim().length == 0){
        this.errorName = 'обязательно для заполнения';
      }
    },
    changePhone: function(){
      console.log(this.phone)
      this.errorPhone = '';
      if(this.phone.trim().length == 0){
        this.errorPhone = 'обязательно для заполнения';
      }else{
        var regex = /^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/;
        if(regex.test(this.phone.trim()) == false){
          this.errorPhone = 'невалидный телефон';
        }
      }
    },
    changeEmail: function(){
      this.errorMail = '';
      if(this.email.trim().length == 0){
        this.errorMail = 'обязательно для заполнения';
      }else{
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if(reg.test(this.email.trim()) == false) {
          this.errorMail = 'введите корректный адресс почты';
        }
      }
    },
    changeCheck: function(){

      this.errorCheck = '';

      if(this.check == false){
        this.errorCheck = 'не активно сошлашение'
      }
    },
    send: function(){
      if(this.validate()){
        //отправить форму

        var self = this;

        $.post('/local/components/pwd/tariff.calc/templates/.default/ajax.php',
            {
              method: 'send-form',
              name: this.name,
              phone: this.phone,
              email: this.email,
              data: this.$store.state.calculatedTarifs,
              sessid: $('#sessid').val()
            })
            .done((data) => {
              if(data.success){
                self.nextStep();
              }
            });
      }
    },
    validate: function(){
      this.changeName();
      this.changePhone();
      this.changeEmail();
      this.changeCheck();

      if(
          this.errorName.length > 0 ||
          this.errorPhone.length > 0 ||
          this.errorMail.length > 0 ||
          this.errorCheck.length > 0
      ){
        return  false
      }
      return true
    }
  },
  components:{
  }
}
</script>

<style scoped>

</style>