<template>
    <div class="profilePlaceholder " v-if="loder">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Загрузка...</span>
        </div>
    </div>
    <div class="ProgressTop m5-l-r">
        <h1>Топ 100 </h1>
        <div class="ProgressTopUsers">

            <div class="ProgressTopUsersItem " @click="$router.push('/user/' + item.awardUsers.id)"
                v-for="(item, i) in awardstop" :key="item.awardUsers.id" :class="awardstopclass(i)">
                <h1>{{ i + 1 }}</h1>
                <h3>
                    {{ item.awardUsers.last_name }}
                    {{ item.awardUsers.first_name }}
                </h3>
                <h3>{{ item.sunPoints }} баллов</h3>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            loder: true
        }
    },
    mounted() {
        this.$store.getters.getawards.length==0 ? this.$store.dispatch('GET_API_AWARDS') : null;
    },
    computed: {
        awardstop() {
            return this.$store.getters.getawards
        },
    },
    methods: {
        awardstopclass(i) {
            if (i == 0) {
                this.loder = false
                return 'ProgressTopGold'
            }
            if (i == 1) {
                return 'ProgressTopSilver'
            }
            if (i == 2) {
                return 'ProgressTopBrown '
            }
            return 'ProgressTopost'
        }
    }
}
</script>
<style lang="scss">
.ProgressTop {
    display: flex;
    flex-direction: column;
    align-items: center;

    &Gold {
        border: 4px #ffd700 solid;
    }

    &Silver {
        border: 4px #c0c0c0 solid;
    }

    &Brown {
        border: 4px #cd7f32 solid;
    }

    &ost {
        border: 4px transparent solid;
    }

    h1 {
        font-size: 3rem;
    }

    &Users {
        display: flex;
        flex-direction: column;
        max-width: 1200px;
        gap: 20px;

        &Item {
            cursor: pointer;
            background: rgb(255, 255, 255);
            box-shadow: rgba(0, 0, 0, 0.1) 0 0 40px;
            padding: 10px;
            border-radius: 15px;
            justify-content: space-between;
            display: flex;
            align-items: center;
            gap: 50px;

            h1 {
                margin: 0;
                font-size: 2rem;
            }

            h3 {
                display: flex;
                align-items: center;
                justify-content: start;
                text-align: start;
                margin: 0;

                @media (max-width: 400px) {
                    font-size: 1rem;
                }
            }
        }
    }
}
</style>


