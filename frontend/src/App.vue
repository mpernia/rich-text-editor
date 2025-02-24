<template>
  <v-app>
    <v-app-bar color="primary" density="compact">
      <v-app-bar-title>Rich Text Editor</v-app-bar-title>
    </v-app-bar>

    <v-main>
      <v-container>
        <router-view></router-view>
      </v-container>
    </v-main>

    <Footer />
  </v-app>
</template>

<script setup>
import Footer from './components/Footer.vue'
</script>

<style>
.v-container {
  max-width: 1200px;
}
</style>
