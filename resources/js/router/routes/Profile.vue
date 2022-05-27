<template  >

    <main class="profile-fon pb-5">
        <div class="d-flex justify-content-between m5-l-r align-items-center pb-4 pt-3">
            <h2 style="font-size: 36px">Личный кабинет</h2>
            <button type="button" @click="logout()" class="btn btn-exit">
                Выйти из аккаунта
            </button>
        </div>
        <div class="profile-menu m5-l-r ">
            <router-link class="  " :to="'/profile'" :class="{ active_menu: $route.name == 'Profile' }">
                <img src="../../../static/img/profile.png" height="55" />
            </router-link>
            <router-link class="  " :to="'/profile/token'" :class="{ active_menu: $route.name == 'Token' }">
                <img src="../../../static/img/responsive.png" height="55" />
            </router-link>
            <router-link class="  " :to="'/profile/mycard'" :class="{ active_menu: $route.name == 'MyCard' }">
                <img src="../../../static/img/id-card.png" height="55" />
            </router-link>
            <router-link class="  " :to="'/profile/collections'" :class="{ active_menu: $route.name == 'Collections' }">
                <img src="../../../static/img/bookshelf.png" height="55" />
            </router-link>
            <router-link class="  " :to="'/profile/top'" :class="{ active_menu: $route.name == 'ProgressTop' }">
                <img src="../../../static/img/podium.png" height="55" />
            </router-link>
        </div>
        <div class="overhid">
            <router-view></router-view>
        </div>

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
            const fotm = new FormData()
            fotm.append('api_token', localStorage.getItem("token"))
            fetch(LOGOUT, {
                method: "POST",
                body: fotm,
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
.overhid {
    overflow: hidden;
    position: relative;
}

.profilePlaceholder {
    top: 0;
    left: 0;
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: #f7f8ff;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;

}

.profile-menu {
    position: relative;
    margin-bottom: 20px;
    border-radius: 10px;
    background: white;
    box-shadow: rgb(2 0 51 / 10%) 0 0 30px;
    z-index: 6;
    display: flex;
    align-items: center;
    overflow: hidden;
    padding: 10px 0;
    overflow-x: scroll;
    height: 100px;

    &::-webkit-scrollbar {
        height: 5px;
        cursor: pointer;
    }

    &::-webkit-scrollbar-track {

        cursor: pointer;
        border-radius: 20px;
    }

    &::-webkit-scrollbar-thumb {
        border: transparent 3px solid;
        margin: 5px;
        background: rgb(255, 82, 2);
        border-radius: 20px;
        cursor: pointer;
    }

    a {
        transition: 0.3s;
        margin: 5px;
        border-radius: 15px;
        padding: 10px;
        display: flex;

        &:hover {
            transform: scale(0.9);
        }
    }
}
</style>
