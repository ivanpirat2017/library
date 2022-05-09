import { createStore } from 'vuex'

 
const store = createStore({
    state() {
        return {
            count: 0
        }
    },
    mutations: {
        increment(state, n) {
            state.count += n
        },
        deduction(state) {
            state.count--
        }
    },
    actions: {
        increment({ commit }) {
            commit('increment', 1)
        },
        deduction({ commit }) {
            commit('deduction')
        },
        incrementasync({ commit }, n) {
            setTimeout(() => {
                commit('increment', n)
            }, 100*n);

        }
    }
})
export default store
