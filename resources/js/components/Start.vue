<template>
    <div class="site-noise"></div>
    <header class="header_menu" v-show="$route.name != 'NotFound' && $route.name != 'Admin'">
        <img id="menu_next" src="../../static/img/next.png" alt="" />
        <div class="menu m5-l-r">
            <div class="menu_item">
                <router-link to="/" class="logo"> Library </router-link>
            </div>
            <div class="menu_item">
                <router-link to="/books">Книги</router-link>
                <router-link to="/search?query=">Поиск</router-link>
                <router-link to="/profile">Личный кабинет</router-link>
                <div class="menu_item_cart">
                    <router-link to="/favourites">Избраное</router-link>
                    <p :style="{ backgroundColor: couterCartBacground }" id="cartidlenthe">
                        {{ $root.cartArrId.length }}
                    </p>
                </div>
            </div>
        </div>
    </header>
    <div class="cntmain">
        <router-view></router-view>
        <div v-if="!($route.name == 'NotFound' || $route.name == 'ChatBook')"
            class="container-fluid footer-bottun bg-dark">
            <footer class="
          d-flex
          flex-wrap
          justify-content-between
          align-items-center
          py-3
          m5-l-r
        ">
                <p class="col-md-4 mb-0 text-light">© 2021 Library.net</p>
                <router-link to="/" class="
            col-md-4
            d-flex
            align-items-center
            justify-content-center
            mb-3 mb-md-0
            me-md-auto
            link-dark
            text-decoration-none
          ">
                    <img class="bi me-2" height="40" src="../../static/img/logo.png" />
                </router-link>
                <ul class="nav col-md-4 justify-content-end">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link px-2 text-light">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/books" class="nav-link px-2 text-light">Books</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/profile" class="nav-link px-2 text-light">Personal account</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/favourites" class="nav-link px-2 text-light">Favourites</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/about" class="nav-link px-2 text-light">About</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/404" class="nav-link px-2 text-light">NotFound</router-link>
                    </li>
                </ul>
            </footer>
        </div>
    </div>
    <div class="menumobile">
        <router-link to="/" class="menumobileItem" :class="{ active_menu: $route.path == '/' }" @click="vdr()">
            <img src="../../static/img/home.png" alt="" />
        </router-link>
        <router-link to="/books" class="menumobileItem" :class="{ active_menu: $route.path == '/books' }"
            @click="vdr()">
            <img src="../../static/img/books-stack-of-three.png" alt="" />
        </router-link>

        <router-link to="/search?query=" class="menumobileItem" :class="{ active_menu: $route.path == '/search' }"
            @click="vdr()">
            <img src="../../static/img/search.png" alt="" />
        </router-link>

        <router-link to="/profile" class="menumobileItem" :class="{ active_menu: $route.meta.name == 'profile' }"
            @click="vdr()">
            <img src="../../static/img/profile.png" alt="" />
        </router-link>

        <router-link to="/favourites" class="menumobileItem" :class="{ active_menu: $route.path == '/favourites' }"
            @click="vdr()">
            <img src="../../static/img/favorites.png" alt="" />
            <p class="itemfolover" :style="{ backgroundColor: couterCartBacground }">
                {{ $root.cartArrId.length }}
            </p>
        </router-link>
    </div>
</template>

<script>
import { menu } from "../script/menu";
export default {
    computed: {
        couterCartBacground() {
            if (this.$root.cartArrId.length == 0) {
                return "#4682B4";
            } else if (
                this.$root.cartArrId.length > 0 &&
                this.$root.cartArrId.length < 5
            ) {
                return "#FF8C00";
            } else if (
                this.$root.cartArrId.length > 4 &&
                this.$root.cartArrId.length < 10
            ) {
                return "#DC143C";
            } else {
                return "#4B0082";
            }
        },
    },
    methods: {
        vdr() {
            window.navigator.vibrate(50);
        }
    },
    mounted() {
        menu();
    },
};
</script>

<style lang='scss'>
.footer-bottun {
    @media (max-width: 700px) {
        padding-bottom: 60px;
    }
}

.cntmain {
    display: flex;
    height: 100vh;
    flex-direction: column;
    justify-content: space-between;
    padding-top: 100px;

    @media (max-width: 700px) {
        padding-top: 0;
    }
}

.menumobile {
    display: none;

    @media (max-width: 700px) {
        padding: 5px;
        width: 100%;
        background: #aeaec2;
        z-index: 10;
        position: fixed;
        bottom: 0;
        left: 0;
        display: flex;
        justify-content: space-around;
        width: 100%;

        .itemfolover {
            position: absolute;
            top: -3px;
            right: -5px;
            width: 20px;
            height: 20px;
            padding: 5px;
            font-family: "mm";
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border-radius: 100%;
        }

        &Item {
            position: relative;
            padding: 2px;
            border: transparent 3px solid;
            background: rgb(255, 255, 255);
            border-radius: 10px;
            transition: 0.05s cubic-bezier(0.47, 0, 0.745, 0.715);
            height: 45px;
            width: 45px;

            &:active {
                transform: scale(0.9);
                box-shadow: 0 0 15px #00000065;
            }

            img {
                height: 35px;
            }
        }
    }
}

.active_menu {
    box-shadow: #4e24e4 0 0 0 3px;

    &:hover {
        box-shadow: #4e24e4 0 0 0 3px;
    }

    &:active {
        box-shadow: #4e24e4 0 0 0 3px;
    }
}

header {
    width: 100vw;
    background: url(../../static/img/forest.jpg);
    background-position: center;
    background-size: cover;
    display: flex;
    position: fixed;
    top: 0;
    z-index: 10;
    height: 100px;

    img {
        display: none;

        @media (max-width: 700px) {
            display: flex;
            height: 100px;
            position: fixed;
            top: 50%;
            right: 0%;
            transform: translateY(-50%) rotateY(180deg);
            z-index: 10;
            transition: 0.5s;
        }
    }

    @media (max-width: 700px) {
        display: none;
    }
}

.menu {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding-top: 25px;
    padding-bottom: 25px;

    @media (max-width: 700px) {
        flex-direction: column;
        padding: 0;
        height: 20vh;
        align-items: flex-start;
        width: 100%;
    }

    &_item {
        @media (max-width: 700px) {
            color: white;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            font-size: 1.6rem;
            gap: 15px;
        }

        h3 {
            @media (max-width: 700px) {
                font-size: 2rem;
            }
        }

        color: white;
        display: flex;
        align-items: center;

        &_cart {
            display: flex;
            align-items: center;
            position: relative;

            h3 {
                @media (max-width: 700px) {
                    padding: 10px 0;
                }
            }

            a {
                padding: 0 4px;

                @media (max-width: 700px) {
                    padding: 10px 0;
                }
            }

            p {
                @media (max-width: 700px) {
                    right: -20px;
                    top: 5px;
                }

                position: absolute;
                right: -17px;
                top: -12px;
                margin: 0;
                transition: 5s;
                padding: 3px;
                width: 25px;
                height: 25px;
                font-weight: bolder;
                color: rgb(255, 255, 255);
                font-size: 0.8rem;
                border-radius: 100%;
                text-align: center;
            }
        }

        a {
            color: white;
            text-decoration: none;
            padding: 0 10px;
        }
    }
}

.site-noise {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100vw;
    overflow: hidden;
    pointer-events: none;
    z-index: 90;
    &::before {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        height: 300%;
        width: 300%;
        background: url(../../static/img/noise.png);
        pointer-events: none;
        display: block;
        opacity: .4;
        animation: grain 2s steps(10) infinite;
        will-change: transform;
    }


    @keyframes grain {

        0%,
        to {
            -webkit-transform: translate(0);
            transform: translate(0);
        }

        10% {
            -webkit-transform: translate(-5%, -10%);
            transform: translate(-5%, -10%);
        }

        20% {
            -webkit-transform: translate(-15%, 5%);
            transform: translate(-15%, 5%);
        }

        30% {
            -webkit-transform: translate(7%, -25%);
            transform: translate(7%, -25%);
        }

        40% {
            -webkit-transform: translate(21%, 25%);
            transform: translate(21%, 25%);
        }

        50% {
            -webkit-transform: translate(-25%, 10%);
            transform: translate(-25%, 10%);
        }

        60% {
            -webkit-transform: translate(15%, 5%);
            transform: translate(15%, 5%);
        }

        70% {
            -webkit-transform: translateY(15%);
            transform: translateY(15%);
        }

        80% {
            -webkit-transform: translate(25%, 35%);
            transform: translate(25%, 35%);
        }

        90% {
            -webkit-transform: translate(-10%, 10%);
            transform: translate(-10%, 10%);
        }
    }

}
</style>
