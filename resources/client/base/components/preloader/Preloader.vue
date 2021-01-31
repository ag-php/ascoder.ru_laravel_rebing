<template>
  <div class="preloader">
    <div id="preloader" :style="style"></div>
  </div>
</template>

<script>
export default {
  name: 'Preloader',
  setup () {
    const size = 100
    const style = {
      '--width': size + 'px',
      '--height': size + 'px',
      '--margin': Math.ceil(size / -2) + 'px 0 0 ' + Math.ceil(size / -2) + 'px',
      '--color1': '#ccc',
      '--color2': '#ccc',
      '--color3': '#ccc'
    }

    return {
      style
    }
  }
}
</script>

<style type="scss" scoped>
.preloader {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  cursor: wait;
  z-index: 9999;
}

#preloader {
  display: block;
  position: relative;
  left: 50%;
  top: 50%;
  width: var(--width);
  height: var(--height);
  margin: var(--margin);
  border-radius: 50%;
  border: 3px solid transparent;
  border-top-color: var(--color1);
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

#loader:before {
  content: "";
  position: absolute;
  top: 5px;
  left: 5px;
  right: 5px;
  bottom: 5px;
  border-radius: 50%;
  border: 3px solid transparent;
  border-top-color: var(--color2);
  -webkit-animation: spin 3s linear infinite;
  animation: spin 3s linear infinite;
}

#loader:after {
  content: "";
  position: absolute;
  top: 15px;
  left: 15px;
  right: 15px;
  bottom: 15px;
  border-radius: 50%;
  border: 3px solid transparent;
  border-top-color: var(--color3);
  -webkit-animation: spin 1.5s linear infinite;
  animation: spin 1.5s linear infinite;
}

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
