<template>
  <v-app id="inspire">
    <v-app-bar
      app
      color="white"
      flat
    >
      <v-container class="py-0 fill-height">
        <v-avatar
          class="mr-10"
          color="grey darken-1"
          size="32"
        >A</v-avatar>

        <v-btn
          v-for="link in links"
          :key="link.name"
          :to="link.path"
          text
        >
          {{ link.title }}
        </v-btn>
      </v-container>
    </v-app-bar>
    <v-main class="grey lighten-3">
      <v-container>
		    <notifications group="message" position="top center" />
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    created() {
      this.links = this.$router.options.routes.filter( link => link.title !== undefined );
    },
    data: () => ( {
      links: [],
    } ),
  }
</script>