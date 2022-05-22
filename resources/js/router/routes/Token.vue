<template>
    <div class="m5-l-r Token">
        <h2>
            Aктивные сеансы
        </h2>
        <div class="TokenAll">
            <TokenСard v-for="item in tokens" :item="item" :key="item.id" />
        </div>

    </div>
</template>
<script>
import TokenСard from "../../components/items/TokenСard.vue";
export default {
    components: {
        TokenСard
    },

    computed: {
        tokens() {
            return this.$store.getters.gettokens
        }
    },
    mounted() {
        this.$store.dispatch('GET_TOKENS')
    },

}
</script>
<style lang="scss">
.Token {
    h2 {
        font-size: 2.5rem;
    }

    &All {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }
}
</style>

