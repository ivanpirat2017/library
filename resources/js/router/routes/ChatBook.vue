<template>
    <Placeholder v-if="loadingBool" />
    <main class="ChatBook">
        <div class="ChatBookmeseges">
            <router-link :to="'/Bookadout/' + genre + '/' + idbook">
                <div class="bookchatinfo">
                    <img :src="img" alt="" />
                    <h2 class="title">
                        {{ title }}
                    </h2>
                </div>
            </router-link>
            <div class="ChatBookmesegesContainer">
                <div class="ChatBookmeseges-p">
                    <div class="none_messege" v-if="messeges.length == 0">
                        <img src="../../../static/img/chat.png" alt="" />
                        <h2>Здесь пока нет сообщений, будь первый!</h2>
                    </div>
                    <ChatMessage :item="item" :author="author" v-for="item in messeges" :key="item.id" />
                </div>
            </div>
            <div class="ChatBookmesegesPush">
                <p contenteditable id="sendid" class="form-control" @keyup.enter="sendMessage()"></p>
                <button class="btn book_button_grean" @click="sendMessage()">
                    <img src="../../../static/img/send.png" alt="" />
                </button>
            </div>
        </div>
    </main>
</template>
<script>
import {
    GET_MESSAGES,
    ADD_MESSAGE,
    getApi,
    authCheck,
    GET_GENRE_BOOK_ID,
} from "../../api-routes";
import ChatMessage from "../../components/items/ChatBook/ChatMessage.vue";

import Placeholder from "../../components/items/Placeholder.vue";
export default {
    components: {
        ChatMessage,
        Placeholder,
    },
    data() {
        return {
            messeges: [],
            send: "",
            title: "",
            idbook: "",
            author: null,
            loadingBool: true,
            img: null,
            genre: "",
            timeMesseges: null,
        };
    },
    beforeUnmount() {
        clearInterval(this.timeMesseges);
    },
    mounted() {
        authCheck().then((r) => {
            if (r.status != 200) {
                this.$router.push("/login");
            }
        });
        getApi(GET_GENRE_BOOK_ID + this.$route.params.id).then(
            (r) => {
                this.title = r.data.title;
                this.idbook = r.data.id;
                this.genre = r.data.genre;
                this.img = r.data.bookimg ? "/storage/" + r.data.bookimg : Bookimg;
            }
        );
        this.getMessages().then((r) => this.scrollHeightDown());
        this.timeMesseges = setInterval(() => {
            this.getMessages();
        }, 5000);
    },
    methods: {
        sendMessage() {
            const sendid = document.querySelector("#sendid");
            const form = new FormData();
            form.append("book_id", this.$route.params.id);
            form.append("messages", sendid.textContent);
            fetch(ADD_MESSAGE, {
                method: "POST",
                body: form,
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((r) => this.getMessages().then((r) => this.scrollHeightDown()))
                .then(() => {
                    document.querySelector("#sendid").textContent = "";
                });
        },
        getMessages() {
            return fetch(GET_MESSAGES + this.$route.params.id, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((r) => r.json())
                .then((r) => {
                    this.author = r.author;
                    this.messeges = r.data;
                    this.loadingBool = false;
                });
        },
        scrollHeightDown() {
            const objDiv = document.querySelector(".ChatBookmeseges-p");
            const objDiv2 = document.querySelector(".ChatBookmesegesContainer");
            objDiv2.scrollTop = objDiv.scrollHeight;
        },
    },
};
</script>
<style lang="scss"  >
$width-messege: 90%;
$height-send: 80px;

@mixin p-20-10($width) {
    padding: 10px $width/2;

    @media (max-width: 700px) {
        padding: 10px $width/10;
    }
}

@mixin m-20-10($width) {
    margin: 0 $width/2;

    @media (max-width: 700px) {
        margin: 0 $width/10;
    }
}

.none_messege {
    width: 100%;
    height: 50vh;
    padding: 10%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    img {
        height: 60%;
        padding: 15px;

        @media (max-width: 700px) {
            height: 40%;
        }
    }

    h2 {
        @media (max-width: 700px) {
            font-size: 1.2rem;
        }
    }
}

.ChatBook {
    overflow-y: hidden;
    width: 100vw;
    min-height: calc(100vh - 100px);

    @media (max-width: 700px) {
        min-height: calc(100vh - 55px);
    }

    &meseges {
        a {
            text-decoration: none;
        }

        .bookchatinfo {
            display: flex;
            align-items: flex-start;
            padding: 10px 5%;
            height: 100px;
            background: #262626;

            @media (max-width: 700px) {
                padding: 10px 1%;
                position: fixed;
                top: 0;
                width: 100%;
                left: 0;
                z-index: 3;
            }

            img {
                border-radius: 5px;
                margin-right: 10px;
                height: 100%;
            }

            h2 {
                margin: 0;
                color: white;
                font-size: 1.4em;

                @media (max-width: 700px) {
                    font-size: 1.1em;
                }
            }
        }

        &Container {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            @include m-20-10(30%);
            height: 100%;
            overflow-y: scroll;
            border-left: #1e5945 3px solid;
            background: white;

            &::-webkit-scrollbar {
                width: 8px;
                cursor: pointer;
            }

            &::-webkit-scrollbar-track {
                background-color: rgba(0, 0, 0, 0.1);
                cursor: pointer;
            }

            &::-webkit-scrollbar-thumb {
                margin: 5px;
                background: rgb(255, 82, 2);
                border-radius: 20px;
                cursor: pointer;
            }
        }

        &-p {
            position: absolute;
            padding: 10px;
            margin-top: 0;
            margin-bottom: 0;
            width: 100%;

            height: 100%;
        }

        overflow: hidden;
        width: 100%;
        height: 100%;
        box-shadow: 0 0 70px rgba(7, 7, 66, 0.116);
        display: flex;
        justify-content: flex-end;
        flex-direction: column;

        @media (max-width: 700px) {
            padding-top: 100px;
        }

        &Push {
            position: relative;

            display: flex;
            @include m-20-10(30%);
            align-items: flex-end;
            background: rgba(0, 0, 0, 0.1);

            @media (max-width: 700px) {
                padding: 10px 1%;
                padding-top: 0;
                margin: 0;
                width: 100%;
                z-index: 3;
                background: rgba(255, 255, 255, 1);
            }

            p {
                color: #000;
                border: 3px solid #1e5945;
                border-radius: 5px 0 0 5px;
                min-height: 50px;
                margin: 0;
                width: calc(100% - 100px);

                &:focus {
                    border: 3px solid #1e5945;
                    border-radius: 5px 0 0 5px;
                    background: white;
                    color: #000;
                }
            }

            button {
                border-radius: 0 10px 10px 0;
                background: #1e5945;
                overflow: hidden;
                width: 120px;
                height: 50px;

                img {
                    height: 100%;
                    padding: 0 20px;
                }

                &:focus {
                    background: #1e5945;
                }
            }
        }

        &Mesege {
            width: $width-messege;
            margin: 5px 0;
            border-radius: 10px;
            padding: 5px 15px;
            color: rgb(255, 255, 255);

            &info {
                display: flex;
                justify-content: space-between;

                h3 {
                    font-size: 0.9rem;
                }
                 h5 {
                    font-size: 0.7rem;
                }
            }

            p {
                margin: 0;
                padding: 5px;
                font-size: 0.8rem;

                font-family: "mr";
            }
        }
    }
}

.rmesege {
    background: #ff8c00;
    max-width: 70%;
    position: relative;

    @media (max-width: 600px) {
        max-width: 90%;
    }
}

.lmesege {
    background: #225c49;
    max-width: 70%;
    position: relative;

    @media (max-width: 600px) {
        max-width: 90%;
    }


}
</style>
