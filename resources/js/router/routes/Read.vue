<template>
    <Placeholder v-if="loadingBool" />
    <div class="infoReaderror" v-if="error">
        <h1>Ошибка на сервере или файл поврежден</h1>
        <button class="btn btn-warning" @click="getBook()">Обновить</button>
        <button class="btn book_button_grean" @click="$router.back()">Вернуться назад</button>
    </div>
    <div class="Read m5-l-r">

        <div class="ReadTab "
            :style="{ 'filter': `invert(${settings.colornum == 0 || settings.colornum == 2 ? 1 : 0})` }">
            <img src="../../../static/img/nextskider.png" class="   " @click="scrollPage(-1)" alt="" />
            <img src="../../../static/img/nextskider.png" class="   " @click="scrollPage(1)" alt="" />
        </div>
        <div class="Readmenu">
            <div>
                <p>Размер шрифта</p>
                <input type="range" name="" v-model="settings.fontSize" min="12" max="48" id="">
            </div>
            <div>
                <p>Межбуквенное расстояние</p>
                <input type="range" name="" v-model="settings.letterSpacing" min="0" step="0.1" max="5" id="">
            </div>
            <div>
                <p>Высота между строками</p>
                <input type="range" name="" v-model="settings.lineHeight" min="0.5" step="0.1" max="3" id="">
            </div>
            <div>
                <p>Выбрать шрифт</p>
                <select class="form-select" v-model="settings.fontFamily" aria-label="фильтрация">
                    <option selected value="ml">Montserrat</option>
                    <option value="Arial, sans-serif">Arial</option>
                    <option value="Verdana, sans-serif">Verdana</option>
                    <option value="Trebuchet MS, sans-serif">Trebuchet MS</option>
                    <option value="Gill Sans, sans-serif">Gill Sans</option>
                    <option value="Noto Sans, sans-serif">Noto Sans</option>
                    <option value="Times, Times New Roman, serif">Times New Roman</option>

                </select>
            </div>
            <div>
                <p>Цвет</p>
                <div class="Readcolor">
                    <h5 v-for="(item, i) in settings.fullcolor" :key="item.bc" @click="settings.colornum = i"
                        :style="{ 'background': item.bc, 'color': item.color }">Hi
                    </h5>
                </div>

            </div>
        </div>

        <p v-html="bookpagin" class="ReadText"
            :style="{ 'font-size': settings.fontSize + 'px', 'letter-spacing': settings.letterSpacing + 'px', 'line-height': settings.lineHeight + 'em', 'font-family': settings.fontFamily, 'background': bccolor.bc, 'color': bccolor.color }">


        </p>
        <div class="Readpage">
            <button v-for="item in pagecount" @click="selected = item" :key="item" class="btn "
                :class="{ 'btn-primary': selected == item, 'book_button_grean': selected != item }">{{ item
                }}</button>
        </div>

    </div>
</template>
<script>
import {
    getApi,
    READ_BOOK,
} from "../../api-routes";
import Placeholder from "../../components/items/Placeholder.vue";
export default {
    components: {
        Placeholder,
    },
    data() {
        return {
            book: '',
            bookwords: [],
            selected: 1,
            error: false,
            loadingBool: true,
            settings: JSON.parse(localStorage.getItem('settingsRead')) ?? {
                fontSize: 22,
                letterSpacing: 0,
                lineHeight: 1.5,
                fontFamily: 'ml',
                colornum: 0,

                fullcolor: [
                    { color: '#000', bc: '#ffffff' },
                    { color: '#f0f0f0', bc: ' #1e1e1e' },
                    { color: '#BF6C7D', bc: '#FED7C6' },
                    { color: '#ebeefa', bc: '#2ea664' },
                    { color: '#1d3a53', bc: '#ff7875' },
                    { color: '#F0F7FA', bc: '#20b5f5' },
                    { color: '#FF4DD5', bc: '#2E2E2E' },
                ]
            }

        }
    },
    watch: {
        settings: {
            deep: true,
            handler(data) {
                localStorage.setItem('settingsRead', JSON.stringify(data))
            },
        }
    },
    computed: {
        bccolor() {
            return this.settings.fullcolor[this.settings.colornum];
        },
        pagecount() {

            return Math.ceil(this.bookwords.length / 500);
        },
        bookpagin() {
            const arr = [...this.bookwords]
            return arr.slice(500 * (this.selected - 1) + 1, 500 * this.selected).join(' ').replace(/(\r\n)+/gm, '<br>')
        }
    },
    mounted() {
        this.getBook();

    },
    methods: {
        scrollPage(num) {
            this.selected += num
            if (this.pagecount < this.selected) {
                this.selected = this.pagecount
            }
            if (this.selected <= 0) {
                this.selected = 1
            }
        },
        getBook() {
            getApi(READ_BOOK + this.$route.params.id)
                .then((r) => {
                    this.bookwords = r.data.split(" ")
                    this.error = false
                })
                .catch((r) => {
                    this.error = true
                }).finally(r => this.loadingBool = false);
        },
    }
}
</script>
<style lang="scss" scoped>
.infoReaderror {
    height: 100vh;
    width: 100vw;
    padding: 50px;
    border-radius: 15px;
    backdrop-filter: blur(20px);
    position: absolute;
    z-index: 3;
    top: 0;
    left: 0;
    justify-content: center;
    text-align: center;
    align-items: center;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.Read {
    position: relative;

    &Tab {
        width: 100%;
        position: fixed;
        pointer-events: none;
        left: 0;
        top: 80%;
        display: flex;
        justify-content: space-between;
        z-index: 2;
        padding-left: 5%;
        padding-right: 5%;

        @media (max-width: 700px) {
            padding-left: 1%;
            padding-right: 1%;
            top: 85%;
        }

        img {
            &:nth-child(1) {
                transform: rotateZ(180deg);
            }

            &:nth-child(1) {}
            pointer-events: all;
            height: 50px;
            background: rgb(140 140 140 / 20%);
            padding: 6px;
            border-radius: 100%;
            filter: invert(1);
            opacity: 0.8;
        }
    }

    &Text {
        padding: 5px;
        border-radius: 5px;
    }

    &page {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 10px;
        justify-content: center;
    }

    &color {

        display: flex;
        flex-wrap: wrap;
        gap: 5px;

        h5 {
            padding: 3px;
            border-radius: 5px;
            cursor: pointer;
            flex: 1 0;
            justify-content: center;
            text-align: center;
            align-items: center;
            display: flex;
        }
    }

    &menu {
        display: flex;
        gap: 10px;
        background: #31392e;
        padding: 10px;
        border-radius: 10px;
        margin: 10px 0;
        color: white;
        flex-wrap: wrap;

        div {
            background: rgb(255 255 255 / 10%);
            padding: 5px;
            border-radius: 5px;
            flex: 1 0 150px;


        }
    }
}
</style>
