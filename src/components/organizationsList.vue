<template>
  <div class="organizations-list">
    <organization v-for="org in organizations" :key="org.id" :org="org"></organization>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "organizations-list",
  components: {
    organization: () => import("./organization")
  },
  data: () => ({
    organizations: []
  }),
  methods: {
    getOrganizations() {
      axios
        .get("/api/organizations")
        .then(resp => {
          this.organizations = resp.data.organizations;
        })
        .catch(err => {
          console.log(err);
        });
    }
  },
  mounted() {
    this.getOrganizations();
  }
};
</script>

<style >
.organizations-list {
  display: grid;
  grid-gap: 20px;
  width: 700px;
  margin: 0 auto;
}
</style>
