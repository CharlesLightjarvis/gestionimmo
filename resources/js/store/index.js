import { createStore } from 'vuex'
import bienStore from './modules/bienStore';
import createPersistedState from 'vuex-persistedstate';

export default createStore({
    modules: {
        bienStore
    },
    plugins: [ createPersistedState() ],
})
