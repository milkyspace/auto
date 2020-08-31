export default {
    computed: {
        listParams: function(){
            return this.$store.getters.listParams;
        },
        countUsers: function(){
            return this.$store.getters.countUsers
        },
        step: function(){
            return this.$store.state.step;
        },
        calculatedTarifs: function(){
            return this.$store.getters.calculatedTarifs;
        }
    },
    methods: {
        setCurrentParam: function(param, value){
            this.value = value;

            this.$store.commit('setCurrentParam', { param: param, value: value})
        },
        nextStep: function(){
            this.$store.commit('incrementeStep')
        },
        changeValue: function(){
            this.setCurrentParam(this.nameProperty, this.value);
        }
    }
}