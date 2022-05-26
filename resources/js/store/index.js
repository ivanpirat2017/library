import { createStore } from 'vuex'
import {
    GET_PROFILE, GET_AWARDS, GET_TOKENS, authCheck
} from "../api-routes";


const store = createStore({
    state() {
        return {
            myId: null,
            profile: {},
            loadingBool: true,
            topAwards: [],
            tokens: [],
            auth: false
        }
    },
    getters: {
        getpauth: (state) => state.auth,
        getprofile: (state) => state.profile,
        gettokens: (state) => state.tokens,
        getawards: (state) => {
            return state.topAwards.sort(function (a, b) {
                if (a.sunPoints > b.sunPoints) {
                    return -1;
                }
                if (a.sunPoints < b.sunPoints) {
                    return 1;
                }
                return 0;
            }).slice(0, 100);
        },
        getloading: (state) => state.loadingBool
    },
    mutations: {
        setMyId(state, id) {
            state.myId = id
        },
        setAuth(state, auth) {
            state.auth = auth
        },
        setTokens(state, token) {
            state.tokens = token
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
        AUTH_CHECK({ commit }) {
            authCheck().then(r => {

                if (r.status == 200) {
                    commit('setAuth', true)
                }
                else {
                    commit('setAuth', false)
                }
            })
        },
        GET_TOKENS({ commit }) {
            fetch(GET_TOKENS, {
                method: "GET",
                headers: {
                    Accept: "multipart/form-data",
                    Authorization: "Bearer " + localStorage.getItem("token")
                }
            }).then(r => r.json()).then(r => {
                commit('setTokens', r.data)
            })
        },
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

            fetch(GET_AWARDS, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }).then((r) => {
                    if (r.status == 200) {
                        return r.json();
                    }
                })
                .then((r) => {
                    commit('setAwards', r.data)
                }).catch(r=>{r})

        }
    }
})
export default store
