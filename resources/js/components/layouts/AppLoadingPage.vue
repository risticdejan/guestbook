<template>
  <div class="entries-area">
    <v-layout fill-height justify-center align-center>
      <v-progress-circular indeterminate :size="70" :width="7" color="secondary"></v-progress-circular>
    </v-layout>
  </div>
</template>

<script>
export default {
  name: "AppLoadingPage"
};
</script>

<style>
.entries-area {
  height: 550px;
}
</style>