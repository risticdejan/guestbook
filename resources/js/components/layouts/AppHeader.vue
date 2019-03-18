<template>
  <v-toolbar color="primary" app fixed>
    <v-toolbar-side-icon @click.stop="toggleSidebar">
      <v-icon>fa fa-bars</v-icon>
    </v-toolbar-side-icon>
    <v-toolbar-title>Guestbook</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn flat to="/entries">
        <v-icon class="hidden-sm-only" left>fa fa-home</v-icon>Home
      </v-btn>
      <v-btn flat to="/entry/add" v-if="isEmailVerified">
        <v-icon class="hidden-sm-only" left>fa fa-plus-square</v-icon>Add Comment
      </v-btn>
      <v-btn flat to="/signin" v-if="!isEmailVerified">
        <v-icon class="hidden-sm-only" left>fa fa-sign-in-alt</v-icon>Sign in
      </v-btn>
      <v-btn flat to="/signup" v-if="!isEmailVerified">
        <v-icon class="hidden-sm-only" left>fa fa-user-plus</v-icon>Sign up
      </v-btn>
      <v-btn flat to="/signout" v-if="isEmailVerified">
        <v-icon class="hidden-sm-only" left>fa fa-sign-out-alt</v-icon>Sign out
      </v-btn>
    </v-toolbar-items>
  </v-toolbar>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "AppHeader",
  computed: {
    ...mapGetters({
      isLogged: "auth/isLogged",
      isEmailVerified: "auth/isEmailVerified"
    })
  },
  methods: {
    toggleSidebar() {
      this.$emit("toggleSidebar");
    }
  }
};
</script>

