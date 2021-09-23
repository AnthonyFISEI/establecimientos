import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);


export default new Vuex.Store({
    state:{

                cafes: []
    },
    mutations:{
        AGREGAR_CAFES(state, cafes){
            state.cafes = cafes;
        }
    }
})
