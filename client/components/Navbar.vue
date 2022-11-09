<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
      <router-link :to="'feature1'" class="navbar-brand">
        {{ appName }}
      </router-link>

      <button :aria-label="$t('toggle_navigation')" class="navbar-toggler" type="button"
              data-toggle="collapse" data-target="#navbarToggler"
              aria-controls="navbarToggler" aria-expanded="false"
      >
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">

        <ul class="navbar-nav ml-auto">
          <!-- Guest -->
          <template>
            <li class="nav-item">
              <router-link :to="{ name: 'feature1' }" class="nav-link" active-class="active">
                {{ $t('feature1') }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'feature2' }" class="nav-link" active-class="active">
                {{ $t('feature2') }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: process.env.appName
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
