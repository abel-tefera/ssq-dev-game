<template>
  <div>
    <div class="top-right links">
      <template>
        <router-link :to="{ name: 'feature1' }">
          {{ $t("feature_1") }}
        </router-link>
        <router-link :to="{ name: 'feature2' }">
          {{ $t("feature_1") }}
        </router-link>
      </template>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  layout: "simple",

  data: () => ({
    title: process.env.appName,
  }),

  head() {
    return { title: this.$t("home") };
  },

  computed: mapGetters({
    authenticated: "auth/check",
  }),
};
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}

.laravel {
  color: #2e495e;
}

.nuxt {
  color: #00c48d;
}
</style>
