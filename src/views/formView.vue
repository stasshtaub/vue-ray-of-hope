<template>
  <section class="form-view">
    <router-view></router-view>
  </section>
</template>

<script>
export default {};
</script>

<style>
.form-view {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  width: 100vw;
  background-image: url("~@/assets/img/form-view-bcg.svg");
  background-size: cover;
}
.form-view .form-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
}
form {
  display: grid;
  width: 270px;
  grid-gap: 25px;
  margin-top: 40px;
}
.form-title {
  display: inline-block;
  text-align: center;
  color: white;
  font-size: 1.2rem;
  letter-spacing: 0.2rem;
  font-family: "SegoeLight", sans-serif;
  font-weight: lighter;
}
form input,
form > button {
  width: 100%;
  height: 100%;
  border-radius: 17px;
}
form input {
  padding: 0 30px 0 20px;
  width: calc(100% - 52px);
  height: calc(100% - 2px);
  border: 1px solid white;
  background: transparent;
  color: white;
}
form button {
  border: none;
}
.form-wrapper a {
  display: inline-block;
  margin-top: 11px;
  opacity: 0.8;
  color: #ffffff99;
}
.form-wrapper a:hover {
  color: white;
  transition: all 0.3s ease;
}
</style>