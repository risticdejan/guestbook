<template>
  <v-navigation-drawer v-model="ndrawer" temporary fixed app>
    <v-toolbar color="primary" dark flat>
      <v-toolbar-side-icon @click.stop="toggleSidebar">
        <v-icon>fa fa-bars</v-icon>
      </v-toolbar-side-icon>
      <v-toolbar-title>Guestbook</v-toolbar-title>
    </v-toolbar>

    <v-divider></v-divider>

    <v-list>
      <v-list-tile to="/entries">
        <v-list-tile-action>
          <v-icon>fa fa-newspaper</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>Entries</v-list-tile-content>
      </v-list-tile>
      <v-list-tile to="/entry/add" v-if="isLogged">
        <v-list-tile-action>
          <v-icon>fa fa-plus-square</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>Add Entry</v-list-tile-content>
      </v-list-tile>
      <v-list-tile to="/signin" v-if="!isLogged">
        <v-list-tile-action>
          <v-icon>fa fa-sign-in-alt</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>Sign in</v-list-tile-content>
      </v-list-tile>
      <v-list-tile to="/signup" v-if="!isLogged">
        <v-list-tile-action>
          <v-icon>fa fa-user-plus</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>Sing up</v-list-tile-content>
      </v-list-tile>
      <v-list-tile to="/signout" v-if="isLogged">
        <v-list-tile-action>
          <v-icon>fa fa-sign-out-alt</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>Sign out</v-list-tile-content>
      </v-list-tile>
    </v-list>

  </v-navigation-drawer>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "AppSidebar",
  props: ["drawer"],
  computed: {
    ...mapGetters({
      isLogged: "auth/isLogged"
    }),
    ndrawer: {
      get: function() {
        return this.drawer;
      },
      set: function(val) {
        if (val != this.drawer) {
          this.$emit("toggleSidebar");
        }
      }
    }
  },
  methods: {
    toggleSidebar() {
      this.$emit("toggleSidebar");
    }
  }
};
</script>

<style>
</style>
