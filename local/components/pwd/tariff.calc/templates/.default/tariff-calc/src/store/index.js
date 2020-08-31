import Vue from 'vue'
import Vuex from 'vuex'
import $ from 'jquery'

Vue.use(Vuex)

export default new Vuex.Store({

  state: {
    userName: '',
    userPhone: '',
    userEmail: '',
    checkConvention: false,
    paramsTarifs: [],
    step: 1,
    selectedOptions: {},
    calculatedTarifs: {
      tariffs: [],
      total: {
        price: 0
      }
    }
  },
  mutations: {
    setMutationTarifs: (state, data) => {
      state.paramsTarifs = data;
    },
    incrementeStep: state => {
      state.step++;
    },
    setDefaultProperty: (state, data) => {
      state.selectedOptions[data['PROPERTY']]
    },
    setCurrentParam: ( state, data ) => {

      state.selectedOptions[data.param] = data.value;

      //рассчет тарифа
      let calcTarrifs = [];
      let totalSumm = 0;
      let countUsers = parseInt(state.selectedOptions['countUsers'])
      let fullCountUsers = countUsers;

      let boolOption = false;

      if(countUsers > 0){

        if(state.paramsTarifs.tariffs){
          state.paramsTarifs.tariffs.map(function(tariffParams) {

            let paramsIds = tariffParams.PARAMS.split(',')

            let selectTarif = false;

            let intOption = false;
            let listIntOption = false;

            let resolvedListInt = {};

            state.paramsTarifs.propertys.map(function(property){

              if(property.TYPE == 'BOOL' && boolOption == false){
                boolOption = property;
              }

              if(property.TYPE == 'LIST_INT'){
                resolvedListInt[property.ID] = property;
              }

              paramsIds.map(function(idOption){
                if(property.ID == idOption){

                  let selectValue = state.selectedOptions[property.SECTION_NAME]

                  switch (property.TYPE){
                    case 'INT':
                      if(selectValue > 0){
                        intOption = {
                          property: property,
                          value: parseInt(selectValue)
                        };
                      }
                      break;
                    case 'LIST_INT':
                      if(selectValue == parseInt(property.NAME)){
                        listIntOption = {
                          property: property,
                          value: parseInt(selectValue)
                        };
                      }
                      break;
                  }
                }
              });
            });

            let count = countUsers;

            if(count > 0){
              if(intOption != false){
                if(listIntOption != false){
                  selectTarif = tariffParams;
                  //от нять от колличества пользователей для сл. итерации
                  countUsers -= count

                }else{
                  //если выбранн числовой параметр и не выбранн диапазонный найти тариф с подходящим диапазонным параметром
                  state.paramsTarifs.tariffs.map(function(tariffParamsAllowListInt) {

                    let paramsIdsAllowListInt = tariffParamsAllowListInt.PARAMS.split(',')

                    paramsIdsAllowListInt.map(function(idOptionAllowId){

                      state.paramsTarifs.propertys.map(function(propertyAllowId){
                        if(propertyAllowId.ID == idOptionAllowId) {
                          if(propertyAllowId.TYPE == 'LIST_INT'){
                            let selectValueAllowId = parseInt(state.selectedOptions[propertyAllowId.SECTION_NAME])

                            if(selectValueAllowId == parseInt(propertyAllowId.NAME)){
                              selectTarif = tariffParamsAllowListInt;


                              //от нять от колличества пользователей для сл. итерации
                              countUsers -= intOption.value
                              count = intOption.value;

                            }

                          }
                        }
                      });

                    });

                  });
                }
              }else{
                if(listIntOption != false){
                  selectTarif = tariffParams;
                  // totalSumm += parseInt(tariffParams.PRICE) * count
                }
              }

              if(selectTarif !== false){

                let dataTariff = {
                  quantity: count,
                  name: tariffParams.NAME,
                  price: parseInt(tariffParams.PRICE)
                };

                calcTarrifs.push(dataTariff);

                totalSumm += dataTariff.quantity * dataTariff.price

              }

            }

          })
        }

      }

      if(boolOption != false && state.selectedOptions['Файловое хранилище'] == true){

        calcTarrifs.push({
          quantity: fullCountUsers,
          name: boolOption.NAME,
          price: parseInt(boolOption.PRICE)
        });

        totalSumm += parseInt(boolOption.PRICE)*fullCountUsers

        // options.push({
        //   quantity: count,
        //   price: parseInt(boolOption.property.PRICE)
        // });
        //
        // if(intOption != false){
        //   totalSumm += parseInt(tariffParams.PRICE) * intOption.value
        // }
        // else{
        //   totalSumm += parseInt(tariffParams.PRICE) * countUsers
        // }
      }

      state.calculatedTarifs = {
        tariffs: calcTarrifs,
        total: {
          price: totalSumm
        }
      }

    }
  },
  actions: {
    setParamsTarifs: (context) => {
      $.post('/local/components/pwd/tariff.calc/templates/.default/ajax.php', { method: 'get-calc-params'})
          .done((data) => {
            if(data.success){
              context.commit('setMutationTarifs', data.tarifs);
            }
          });
    }
  },
  getters: {
    listParams: state => {
      return state.paramsTarifs.sections ? state.paramsTarifs.sections : [];
    },
    slider: state => {
      let result =  [];
      state.paramsTarifs.propertys.map(function (el){
        if(el.TYPE == 'LIST_INT'){
          result.push(parseInt(el.NAME));
        }
      })

      if(result.length > 0){

        return {
          current: Math.min(...result),
          min: Math.min(...result),
          max: Math.max(...result),
          all: result
        };
      }else{
        return false;
      }
    },
    calculatedTarifs: state => {
      return state.calculatedTarifs
    },
    countUsers: state => {
      return parseInt(state.selectedOptions['countUsers'])
    }
  },
  modules: {
  }
})
