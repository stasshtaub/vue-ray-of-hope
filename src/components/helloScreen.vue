<template>
  <section class="hello-screen">
    <div class="container">
      <h1 class="header-title">Луч надежды</h1>
      <p class="subtitle">Благотворительная информационная площадка</p>
      <a href="https://play.google.com/store/apps" class="googlePlayLink">
        <img src="assets/img/google-play.png" alt="Доступно в Google Play" class="googlePlayBtn" />
      </a>
    </div>
  </section>
</template>

<script>
export default {
  name: "hello-screen"
};
</script>

<style>
.hello-screen {
  height: 100vh;
  background: url("~@/assets/img/home-bcg.jpg");
  background-size: cover;
  overflow: auto;
}
.hello-screen * {
  color: white;
}
.header-title {
  text-transform: uppercase;
  font-weight: 300;
  font-size: 2.5rem;
  margin-top: 195px;
  letter-spacing: 0.7rem;
}
.subtitle {
  width: unset;
  font-size: 2rem;
  margin-top: 32px;
  color: white;
  font-family: "SegoeLight", sans-serif;
}
</style>