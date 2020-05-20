<template>
  <section class="about-screen">
    <a name="about"></a>
    <div class="round">
      <logo />
    </div>
    <div class="container">
      <div class="right">
        <h2 class="title">«Люди хотят, но не могут помочь»</h2>
        <p>
          Из этой фразы родилось наше мобильное приложение, а затем и сайт.
          <br />Наша команда состоит из людей, которые хотят, чтобы эта фраза
          стала ложью.
        </p>
        <p>
          Мы реализуем информационную благотворительную площадку, главная цель
          которой - сделать проще и понятней процесс помощи нуждающимся.
          <br />Мы создаем информационную платформу, объединяющую неравнодушных
          людей, готовых помочь, и людей, которым эта помощь нужна.
        </p>
        <p>
          Площадка, ориентированная под нужды благотворительных организаций…
          <br />Площадка, на которой граждане увидят информацию в одном месте и
          смогут помочь, просто нажав на кнопку… <br />Площадка, чтобы творить
          добро! <br />Площадка, которую освещает луч надежды!
        </p>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "about-screen",
  components: {
    logo: () => import("./svg/logo"),
  },
};
</script>

<style>
a[name="about"] {
  position: absolute;
  height: 65px;
  top: -65px;
}
.about-screen {
  position: relative;
  background-color: #f7f4fa;
  min-height: calc(100vh - 65px);
  overflow: hidden;
  display: flex;
  align-items: center;
}
.round {
  border-radius: 50%;
  background-color: #5bacd3;
  box-shadow: 0 0 30px #00000021;
  width: 116.458333vw;
  height: 116.458333vw;
  position: absolute;
  display: flex;
  transform: translateX(-71%);
  justify-content: center;
  align-items: center;
}
.right {
  margin: 20px 0;
  float: right;
  width: 560px;
  display: grid;
  grid-gap: 33px;
  max-width: 60%;
}
.right > p {
  letter-spacing: 0rem;
  line-height: 1.8rem;
  font-size: 0.95rem;
}
.about > h2.title {
  font-family: "SegoeSB", sans-serif;
  font-weight: bold;
}
.about-screen .logo {
  height: 28.6458333vw;
  margin-left: 47.1457936523%;
}
.about-screen path {
  fill: white !important;
}
</style>
