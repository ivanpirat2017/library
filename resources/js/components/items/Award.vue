<template >
    <div class="Award">
        <img :src="getimg" alt="" />
        <h2>{{ awarditem.name }}</h2>
    </div>
</template>
<script>
import img1 from "../../../static/img/award/1.png";
import img2 from "../../../static/img/award/2.png";
import img3 from "../../../static/img/award/3.png";
import img4 from "../../../static/img/award/4.png";
import img5 from "../../../static/img/award/5.png";
export default {
    data() {
        return {
            award1: img1,
            award2: img2,
            award3: img3,
            award4: img4,
            award5: img5,
            awarditem: this.item.taskitem,
        };
    },
    props: ["item"],

    computed: {
        getimg() {
            if (this.awarditem.level == 0) {
                return this.award1;
            }
            if (this.awarditem.level == 1) {
                return this.award2;
            }
            if (this.awarditem.level == 2) {
                return this.award3;
            }
            if (this.awarditem.level == 3) {
                return this.award4;
            }
            if (this.awarditem.level == 4) {
                return this.award5;
            }
        },
    },
};
</script>
<style lang="scss">
.Award {
    max-width: 400px;
    flex: 1 1 200px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow: hidden;
    border-radius: 15px;
    background: rgb(255, 255, 255);
    transition: cubic-bezier(0.86, 0, 0.07, 1) 1s;
    border: dashed transparent 3px;
    cursor: pointer;
    box-shadow: rgba(0, 0, 0, 0.1) 0 0 20px 5px;
    &:hover {
        border: dashed rgb(255, 102, 0) 3px;
        animation: deg 2s infinite ease-in-out;
        @keyframes deg {
            from {
                transform: rotateZ(0deg) scale(1);
            }
            25% {
                transform: rotateZ(-15deg) scale(0.7);
            }
            75% {
                transform: rotateZ(15deg) scale(0.7);
            }
            to {
                 transform: rotateZ(0deg) scale(1);
            }
        }
    }
    img {
        width: 100px;
        object-fit: cover;
    }
    h2 {
        font-size: 1rem;
        text-align: center;
    }
}
</style>
