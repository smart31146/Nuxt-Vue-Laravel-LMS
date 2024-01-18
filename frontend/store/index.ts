import Vue from 'vue';
import Vuex, { StoreOptions } from 'vuex';
import { RootState } from './types';

const store:StoreOptions<RootState> = {
  state:{
    stateIsMenuOpen: false,
  },
  modules:{

  }
}
export default new Vuex.Store<RootState>(store)