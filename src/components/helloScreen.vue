<template>
  <section class="hello-screen">
    <div class="container">
      <h1 class="header-title">Луч надежды</h1>
      <p class="subtitle">Благотворительная информационная площадка</p>
      <a href="https://play.google.com/store/apps" class="googlePlayLink">
        <google-play-icon />
      </a>
    </div>
  </section>
</template>

<script>
export default {
  name: "hello-screen",
  components: {
    googlePlayIcon: () => import("./svg/googlePlayIcon"),
  },
};
</script>

<style>
.hello-screen {
  height: 100vh;
  background: url("~@/assets/img/home-bcg.jpg");
  background-size: cover;
  overflow: auto;
}
.hello-screen .container {
  position: relative;
  height: calc(100% - 250px);
  margin-top: 250px;
}
a.googlePlayLink {
    display: block;
    line-height: 0;
    position: absolute;
    bottom: 150px;
}
.hello-screen * {
  color: white;
}
.header-title {
  text-transform: uppercase;
  font-weight: 300;
  font-size: 2.5rem;
  letter-spacing: 0.7rem;
}
.subtitle {
  width: unset;
  font-size: 2rem;
  color: white;
  font-family: "SegoeLight", sans-serif;
}
</style>
