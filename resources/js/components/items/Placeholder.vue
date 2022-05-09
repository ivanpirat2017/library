<template>
  <div class="loading">
    <div class="placeholder">
       <div class="plsd"></div>
    </div>
  </div>
</template>
<script>
export default {};
</script>
<style lang="scss">
$loaderColor: #1E5945;
$bodyColor: #f8fafc;
$animSpeed: 1.4s;
$loaderAnim: $animSpeed linear infinite;
$pseudoAnim: $animSpeed 0.2s ease infinite;

@mixin anim {
  $name: unique-id();
  animation-name: $name;

  @keyframes #{$name} {
    @content;
  }
}
@mixin jump($direction: right) {
  $t: null;
  $r: null;

  @if $direction == left {
    $t: -200%, -100%;
    $r: -180;
  }
  @else {
    $t: 200%, 100%;
    $r: 180;
  }

  65% {
    transform:
      translate($t)
      scale(0.2)
      rotate($r * 1deg);
    background-color: lighten($loaderColor, 20%);
  }
  70%, 100% {
    transform:
      translate(0, 0)
      scale(1)
      rotate($r + $r * 1deg);
    background-color: darken($loaderColor, 20%);
  }
}

@mixin spin($r) {
  20% {
    transform:
      rotate(-30deg)
      scale(1);
  }
  50% {
    transform:
      rotate($r * 1deg / 2)
      scale(4);
    background-color: lighten($loaderColor, 40%);
  }
  80% {
    transform:
      rotate($r * 1deg)
      scale(0.8);
  }
  90%, 100% {
    transform:
      rotate($r * 1deg)
      scale(1);
    background-color: $loaderColor;
  }
}

.placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  width: 100vw;
  overflow: hidden;
  background-color: $bodyColor;
}

.plsd {
  position: relative;
  background-color: $loaderColor;
  width: 12px;
  height: 12px;
  border-radius: 3px;
  animation: $loaderAnim;
  @include anim {
    @include spin(720);
  }

  &:before, &:after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: darken($loaderColor, 20%);
    border-radius: 3px;
  }

  &:before {
    right: calc(100% + 2px);
    animation: $pseudoAnim;
    @include anim {
      @include jump(left);
    }
  }

  &:after {
    left: calc(100% + 2px);
    animation: $pseudoAnim;
    @include anim {
      @include jump(right);
    }
  }
}
</style>
