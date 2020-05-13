<template>
  <div class="organizations-view">
    <router-view :key="$route.fullPath"></router-view>
    <!-- <organizations-list :organizations="organizations"></organizations-list> -->
  </div>
</template>

<script>
// import axios from "axios";
// import { mapGetters } from "vuex";
export default {
  name: "organizations-view",
  // components: {
  //   organizationsList: () => import("../components/organizationsList")
  // },
  // data: () => ({
  //   activity: null,
  //   organizations: []
  // }),
  // computed: {
  //   ...mapGetters(["PROFILE"])
  // },
  // methods: {
  //   getOrganizations() {
  //     if (this.PROFILE) {
  //       axios
  //         .get("/api/organizations")
  //         .then(resp => {
  //           this.organizations = resp.data.organizations;
  //         })
  //         .catch(err => {
  //           console.log(err);
  //         });
  //     }
  //   }
  // },
  // mounted() {
  //   this.getOrganizations();
  // }
};
</script>

<style>
</style>