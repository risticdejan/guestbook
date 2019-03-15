<template>
  <v-alert
    ref
    :value="visibility"
    type="error"
    outline
    dismissible
    transition="scale-transition"
    v-model="visibility"
  >
    <h3 v-for="(m,i) in messages" :key="i">{{m}}</h3>
  </v-alert>
</template>

<script>
export default {
  props: ["messages"],
  data() {
    return {
      visibility: true
    };
  }
};
</script>