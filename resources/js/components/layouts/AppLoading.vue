<template>
  <v-dialog v-model="loadingApp" persistent fullscreen>
    <v-container fill-height pa-0>
      <v-layout row justify-center align-center>
        <v-progress-circular indeterminate :size="70" :width="7" color="secondary"></v-progress-circular>
      </v-layout>
    </v-container>
  </v-dialog>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "AppLoading",
  computed: {
    ...mapGetters({ loadingApp: "layout/loadingApp" })
  }
};
</script>

<style>
</style>