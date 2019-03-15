<template>
  <v-container fill-height pa-0>
    <v-layout row justify-center align-center>
      <v-progress-circular indeterminate :size="70" :width="7" color="secondary"></v-progress-circular>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: "AppLoadingPage"
};
</script>

<style>
</style>