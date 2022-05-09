import { createStore } from 'vuex'
import {
    GET_PROFILE,
} from "../api-routes";


const store = createStore({
    state() {
        return {
            myId: null,
            profile: {}
        }
    },
    getters: {
        getprofile: (state) => state.profile
    },
    mutations: {
        setMyId(state, id) {
            state.myId = id
        },
        setProfiled(state, profile) {
            state.profile = profile
        },
    },
    actions: {
        GET_API_PROFILE({ commit }) {
            fetch(GET_PROFILE, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((r) => {
                    if (r.status == 200) {
                        return r.json();
                    } else {
                        alert("ошибка на сервере");
                    }
                })
                .then((r) => {
                    commit('setProfiled', r.data)
                })

        }
    }
})
export default store
