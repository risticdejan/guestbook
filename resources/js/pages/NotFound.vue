<template>
  <v-container>
    <v-layout mb-4>
      <v-flex xs12>
        <v-layout row wrap>
          <v-flex>
            <h1>Page not found</h1>
            <p>Ooops, we couldn't find what you are looking for.</p>
            <p>Why don't you
              <router-link :to="{name:'home'}">go home instead</router-link>?
            </p>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: "NotFound"
};
</script>

<style>
</style>
