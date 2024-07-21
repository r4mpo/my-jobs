<template>
  <router-view />
</template>

<script>
export default {
  name: 'App',
  mounted() {
    this.verifySession();
  },
  methods: {
    verifySession() {
      let routeName = window.location.pathname ;
      if (!sessionStorage.getItem('token')) {

        if (!routeName.match('register') && !routeName.match('login')) {
          this.$router.push('/login');
        }

      } else {

        if (routeName.match('register') || routeName.match('login')) {
          this.$router.push('/home');
        }

      }
    }
  }
}
</script>