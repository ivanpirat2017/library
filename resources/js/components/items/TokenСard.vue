<template>
    <div class="TokenСard bg-dark">
        <div class="TokenСardImgs">
            <img :src="TokenСard" alt="" :key="Math.random() * 100">
            <img :src="deviceimg" :key="Math.random() * 100" alt="">
        </div>

        <div class="imgwhate"></div>
        <div class="TokenСardText">
            <h5 v-if="item.ip != ''">IP: <span>{{ item.ip }}</span></h5>
            <h5 v-if="item.type != ''">Протокол: <span>{{ item.type }}</span></h5>
            <h5 v-if="item.continent != ''">Континент: <span>{{ item.continent }}</span></h5>
            <h5 v-if="item.country != ''">Страна: <span>{{ item.country }}</span></h5>
            <h5 v-if="item.city != ''">Город: <span>{{ item.city }}</span></h5>
            <h5 v-if="item.postal != ''">Почтовый индекс: <span>{{ item.postal }}</span></h5>
            <button class="btn btn-danger" @click="logout()" v-if="item.api_token != token">выйти</button>
            <div class="btn book_button_grean" v-else>Это ваш аккаунт</div>
        </div>
    </div>
</template>
<script>
import imgsab from '../../../static/img/sad.png'
import android from '../../../static/img/device/android.png'
import ios from '../../../static/img/device/ios.png'
import mac from '../../../static/img/device/mac.png'
import windows from '../../../static/img/device/windows.png'
import {
    LOGOUT,
} from "../../api-routes";
export default {
    props: ['item'],
    data() {
        return {
            token: localStorage.getItem("token"),
        }
    },
    methods: {
        logout() {
            const fotm = new FormData()
            fotm.append('api_token', this.item.api_token)
            fetch(LOGOUT, {
                method: "POST",
                body: fotm,
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }).then((r) => {
                if (r.status == 204) {
                    this.$store.dispatch('GET_TOKENS')
                } else {
                    alert("ошибка на сервере");
                }
            });
        },

    },
    computed: {
        deviceimg() {
            const devices =this.item.browser;
            if (devices.search("iphone") > -1) {
                return ios;
            }
            if (devices.search("ipad") > -1) {
                return ios;
            }
            if (devices.search("android") > -1) {
                return android;
            }
            if (devices.search("windows") > -1) {
                return windows;
            }
            if (devices.search("mac os") > -1) {
                return mac;
            }
        },
        TokenСard() {
            return this.item.flagimg != '' ? this.item.flagimg : imgsab
        }
    }
}
</script>
<style lang="scss" scoped>
.imgwhate {
    position: absolute;
    left: 0;
    top: 0;
    width: 170px;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
}

.TokenСard {
    overflow: hidden;
    position: relative;
    padding: 10px;
    border-radius: 15px;
    display: flex;
    gap: 15px;
    flex: 0 1 400px;

    @media (max-width: 350px) {
        flex-direction: column;
    }

    &Text {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    &Imgs {
        display: flex;
        flex-direction: column;
        width: 150px;
        justify-content: space-between;
        gap: 5px;
        img {
            width: 150px;
            height: 80px;
            object-fit: contain;
            border-radius: 5px;
            position: relative;
            z-index: 2;
            @media (max-width: 350px) {
                width: 100%;
            }
        }
    }
    h5 {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
        span {
            font-family: 'mm';
            color: white;
        }
    }
}
</style>
