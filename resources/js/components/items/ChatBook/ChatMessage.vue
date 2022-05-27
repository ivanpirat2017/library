<template>
    <div class="" :class="boolAuthor2">
        <div class="ChatBookmesegesMesege" :class="boolAuthor">
            <div class="ChatBookmesegesMesegeinfo">
                <h3>{{ item.last_name }} {{ item.first_name }}</h3>
                <h5>{{ messageDate }}</h5>
            </div>
            <p>{{ item.messages }}</p>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
export default {
    props: ["item", "author"],
    computed: {
        boolAuthor() {
            if (this.item.id == this.author) {
                return "rmesege";
            }
            return "lmesege";
        },
        messageDate() {
            return moment(this.item.date).lang("ru").fromNow();
        },
        boolAuthor2() {
            if (this.item.id == this.author) {
                return "ChatBookmesegesMesege-right";
            }
            return "ChatBookmesegesMesege-left";
        },
    },
};
</script>
<style lang="scss">
.ChatBookmesegesMesege-right {
    display: flex;
    width: 100%;
    justify-content: flex-end;
}

.ChatBookmesegesMesege-left {
    display: flex;
    width: 100%;
    justify-content: flex-start;
}
</style>
