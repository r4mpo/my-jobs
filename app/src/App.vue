<template>
  <router-view />
</template>

<script>
export default {
  name: 'App',
  created() {
    this.verifySession();
  },
  methods: {
    verifySession() {
      let routeName = this.$route.name;
      if (!sessionStorage.getItem('token')) {

        if (routeName != 'Home' && routeName != 'Login') {
          this.$router.push('/login');
        }

      } else {

        console.log(routeName)
        if (routeName == 'Home' || routeName == 'Login') {
          this.$router.push('/home');
        }

      }
    }
  }
}
</script>