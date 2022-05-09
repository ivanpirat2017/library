<template >
  <div class="NotFound">
    <div class="NotFoundtwinkling"></div>
    <div class="NotFoundstars"></div>
    <div class="NotFound404 transition" :style="{ transform: rotate }">
      <h2>4</h2>
      <div class="NotFound404planet"></div>
      <h2>4</h2>
      <div class="NotFound404rocket">
        <img src="../../../static/img/rocket.png" alt="" />
        <div class="NotFound404rocketimg"></div>
      </div>
      <div class="NotFound404moon">
        <img src="../../../static/img/moon.png" alt="" />
        <div class="NotFound404moonimg"></div>
      </div>
    </div>
    <div class="NotFoundtext">
      <h6>Вы тут уже {{ setSec }}</h6>
      <h6>Может домой ? - <router-link to="/">Home</router-link></h6>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      sec: 0,
      pageX: 0,
      pageY: 0,
    };
  },
  computed: {
    rotate() {
      return `translateX(${this.pageX}px) translateY(${this.pageY}px)`;
    },

    setSec() {
      if (this.sec == 0) {
        return this.sec + " секунд";
      }
      if (this.sec == 1) {
        return this.sec + " секунду";
      }
      if (this.sec > 1 && this.sec < 5) {
        return this.sec + " секунды";
      }
      return this.sec + " секунд";
    },
  },
  mounted() {
    addEventListener("mousemove", (e) => {
      this.pageX = (
        ((window.innerWidth / 2 - e.pageX) / window.innerWidth) *
        10
      ).toFixed(3);
      this.pageY = (
        ((window.innerHeight / 2 - e.pageY) / window.innerHeight) *
        10
      ).toFixed(3);
    });
    addEventListener("touchmove", (e) => {
      this.pageX = (
        ((window.innerWidth / 2 - e.touches[0].clientX) / window.innerWidth) *
        10
      ).toFixed(3);
      this.pageY = (
        ((window.innerHeight / 2 - e.touches[0].clientY) / window.innerHeight) *
        10
      ).toFixed(3);
    });
    setInterval(() => {
      this.sec++;
    }, 1000);
  },
};
</script>
<style lang="scss">
.transition {
  transition: 0.1s;
}
.NotFound {
  width: 100vw;
  height: 100vh;

  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  position: relative;
  &text {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding-top: 50px;
  }
  h6 {
    color: white;
    text-shadow: rgba(255, 255, 255, 0.527) 0 0 35px;
    font-size: 20px;
    font-family: "mb";
    text-align: start;
    a {
      text-decoration: none;
      color: orange;
      font-size: 24px;
      font-family: "mr";
    }
    @media (max-width: 700px) {
      font-size: 16px;
    }
  }
  &404 {
    display: flex;
    justify-content: center;
    align-items: center;
    h2 {
      margin: 0 30px;
      color: white;
      font-size: 96px;
      font-family: "mb";
      @media (max-width: 500px) {
        font-size: 86px;
        margin: 0 20px;
      }
    }
    &rocket {
      position: absolute;
      animation: rocket-animation 5s linear infinite;
      img {
        height: 50px;
        transform: translateX(115px);
        filter: drop-shadow(0 0 5px rgb(255, 81, 0));
        @media (max-width: 500px) {
          transform: translateX(85px);
          height: 30px;
        }
      }
      @keyframes rocket-animation {
        0% {
          transform: rotateZ(0deg);
        }
        100% {
          transform: rotateZ(-360deg);
        }
      }
    }
    &moon {
      position: absolute;

      animation: moon-animation 15s cubic-bezier(0.645, 0.045, 0.355, 1)  infinite;
      transition: 1s;

      img {
        height: 50px;
       animation: moon2-animation 15s linear infinite;
        @keyframes moon2-animation {
          0% {
            transform:    rotateZ(00deg);
          }
          100% {
            transform:   rotateZ(360deg);
          }
        }
      }
      @keyframes moon-animation {
        0% {
          transform: rotateZ(120deg) translateX(-190px) scale(0.6);
        }
        50% {
          transform: rotateZ(120deg) translateX(190px) scale(1.4);
        }
        100% {
          transform: rotateZ(120deg) translateX(-190px) scale(0.6);
          z-index: 1;
        }
      }
    }
    &planet {
      height: 200px;
      width: 200px;
      animation: planet-rotat-animation 200s linear infinite;
      background: url(../../../static/img/planet.png);
      background-size: cover;
      background-position: center;
      border-radius: 100%;
      z-index: 1;
      box-shadow: inset 0 0 60px rgba(0, 153, 255, 0.6),
        0 0 500px rgba(0, 153, 255, 0.6), 0 0 50px rgba(0, 81, 255, 0.473);
      @keyframes planet-rotat-animation {
        0% {
          transform: rotatez(0deg);
        }
        100% {
          transform: rotatez(360deg);
        }
      }
      @media (max-width: 500px) {
        height: 150px;
        width: 150px;
      }
    }
    position: relative;
  }
  &stars,
  &twinkling {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    display: block;
  }
  &stars {
    background: #000 url(../../../static/img/stars.png) repeat;
    background-size: cover;
    z-index: -2;
  }
  &twinkling {
    background: transparent
      url(http://www.script-tutorials.com/demos/360/images/twinkling.png) repeat
      top center;
    z-index: -1;
    -moz-animation: move-twink-back 200s linear infinite;
    -ms-animation: move-twink-back 200s linear infinite;
    -o-animation: move-twink-back 200s linear infinite;
    -webkit-animation: move-twink-back 200s linear infinite;
    animation: move-twink-back 200s linear infinite;
    @keyframes move-twink-back {
      from {
        background-position: 0 0;
      }
      to {
        background-position: -10000px 5000px;
      }
    }
    @-webkit-keyframes move-twink-back {
      from {
        background-position: 0 0;
      }
      to {
        background-position: -10000px 5000px;
      }
    }
    @-moz-keyframes move-twink-back {
      from {
        background-position: 0 0;
      }
      to {
        background-position: -10000px 5000px;
      }
    }
    @-ms-keyframes move-twink-back {
      from {
        background-position: 0 0;
      }
      to {
        background-position: -10000px 5000px;
      }
    }

    @keyframes move-clouds-back {
      from {
        background-position: 0 0;
      }
      to {
        background-position: 10000px 0;
      }
    }
    @-webkit-keyframes move-clouds-back {
      from {
        background-position: 0 0;
      }
      to {
        background-position: 10000px 0;
      }
    }
    @-moz-keyframes move-clouds-back {
      from {
        background-position: 0 0;
      }
      to {
        background-position: 10000px 0;
      }
    }
    @-ms-keyframes move-clouds-back {
      from {
        background-position: 0;
      }
      to {
        background-position: 10000px 0;
      }
    }
  }
}
</style>
