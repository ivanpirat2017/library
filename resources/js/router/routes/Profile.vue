<template  >
    <main class="profile-fon pb-5">
        <div class="d-flex justify-content-between m5-l-r align-items-center pb-4 pt-3">
            <h2 style="font-size: 36px">Личный кабинет</h2>
            <button type="button" @click="logout()" class="btn btn-exit">
                Выйти из аккаунта
            </button>
        </div>
        <div class="profile-menu m5-l-r ">
            <router-link class="btn  " :to="'/profile'">
                <img src="../../../static/img/profile.png" height="40" />
            </router-link>
            <router-link class="btn  " :to="'/profile/mycard'">
                <img src="../../../static/img/id-card.png" height="60" />
            </router-link>
             <router-link class="btn  " :to="'/profile/top'">
                <img src="../../../static/img/podium.png" height="50" />
            </router-link>
        </div>
        <router-view></router-view>
    </main>
</template>
<script>
import {
    LOGOUT,
} from "../../api-routes";
export default {
    mounted() {
        this.$store.dispatch('GET_API_PROFILE')
    },
    methods: {
        logout() {
            fetch(LOGOUT, {
                method: "POST",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }).then((r) => {
                if (r.status == 204) {
                    this.$router.push("/");
                } else {
                    alert("ошибка на сервере");
                }
            });
        },

    },
};
</script>
<style scope  lang='scss' >
.profile-menu {
    position: relative;
    margin-bottom: 20px;
    border-radius: 10px;
    background: white;
    box-shadow: rgb(2 0 51 / 10%) 0 0 30px;
    z-index: 5;
    display: flex;
    align-items: center;

    a {
        transition: 0.3s;
        margin: 5px;
        border-radius: 15px;

        &:hover {
            transform: scale(0.8);
        }
    }
}
</style>
