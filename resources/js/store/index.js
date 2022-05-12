import { createStore } from 'vuex'
import {
    GET_PROFILE, GET_GET_AWARDS
} from "../api-routes";


const store = createStore({
    state() {
        return {
            myId: null,
            profile: {},
            loadingBool: true,
            topAwards: []
        }
    },
    getters: {
        getprofile: (state) => state.profile,
        getawards: (state) => {
            const drr= []

            return state.topAwards.sort(function (a, b) {
                if (a.sunPoints > b.sunPoints) {
                    return -1;
                }
                if (a.sunPoints < b.sunPoints) {
                    return 1;
                }
                return 0;
            }).slice(0,100);
        },
        getloading: (state) => state.loadingBool
    },
    mutations: {
        setMyId(state, id) {
            state.myId = id
        },
        setAwards(state, Awards) {
            state.topAwards = Awards
        },
        loadingBool(state, ld) {
            state.loadingBool = ld
        },
        setProfiled(state, profile) {
            state.profile = profile
        },
    },
    actions: {
        GET_API_PROFILE({ commit }) {
            commit('loadingBool', true)
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
                    commit('loadingBool', false)
                })

        },
        GET_API_AWARDS({ commit }) {

            fetch(GET_GET_AWARDS, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((r) => {
                    if (r.status == 200) {
                        return r.json();
                    }
                })
                .then((r) => {
                    commit('setAwards', r.data)
                })

        }
    }
})
export default store
