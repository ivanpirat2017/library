<template >
  <div>
    <h3>Интересные подборки</h3>
    <div class="slider">
      <img
        :src="img"
        class="sliderNext sliderNextr"
        @click="scrollSlider(1)"
        alt=""
      />
      <img
        :src="img"
        class="sliderNext sliderNextl"
        @click="scrollSlider(-1)"
        alt=""
      />
      <div class="sliderscrolle">
        <div class="sliderItems_all">
          <ItemAction
            v-for="(item, index) in actions"
            :item="item"
            :key="index"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Next from "../../../static/img/nextskider.png";
import ItemAction from "./ItemAction.vue";
import { getApi, GET_ACTION } from "../../api-routes";
export default {
  components: {
    ItemAction,
  },
  data() {
    return {
      actions: [],
      img: Next,
    };
  },
  methods: {
    scrollSlider(id) {
      let count = 0;
      const sliderscrolle = document.querySelector(".sliderscrolle");
      const si = setInterval(() => {
        if (sliderscrolle.clientWidth <  Math.abs(count)) {
          clearInterval(si);
        }
        count += id * 10;
        sliderscrolle.scrollBy(id * 10, 0);
      }, 1);
    },
  },
  mounted() {
    getApi(GET_ACTION).then((r) => {
      this.actions = r.data;
    });
  },
};
</script>
<style lang="scss">
.slider {
  height: 215px;
  display: flex;
  border-radius: 15px;
  width: 100%;
  position: relative;
  &scrolle {
    width: 100%;
    overflow: hidden;
    overflow-x: scroll;
    position: relative;
    display: flex;
    &::-webkit-scrollbar {
      height: 8px;
      cursor: pointer;
    }
    &::-webkit-scrollbar-track {
      background-color: rgba(0, 0, 0, 0.1);
      cursor: pointer;
      border-radius: 20px;
    }
    &::-webkit-scrollbar-thumb {
      margin: 5px;
      background: rgb(255, 82, 2);
      border-radius: 20px;
      cursor: pointer;
    }
  }
  &Next {
    z-index: 2;
    position: absolute;
    top: 50%;
    padding: 5px;
    @media (max-width: 800px) {
    height: 50px;
    }
    height: 60px;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 100%;
    &l {
      transform: translateY(-50%) rotateZ(180deg);
      left: 0;
    }
    &r {
      transform: translateY(-50%);
      right: 0;
    }
  }

  &Items_all {
        z-index: 1;
    height: 200px;
    display: flex;
    width: auto;
    cursor: pointer;
  }
}
</style>
