<template>
  <v-container fluid>
    <v-layout row wrap>
      <v-flex xs12 md6 offset-md3>
        <v-card class="mb-2">
          <v-card-text class="text-xs-center">
            <h1 class="mb-2">Guestbook</h1>
            <app-loading-page v-if="!loading"></app-loading-page>

            <div v-else class="entries-area">
              <div v-if="entries.length > 0">
                <ul class="entry_list">
                  <entry-item v-for="entry in entries" :key="entry.id" :entry="entry"></entry-item>
                </ul>
              </div>
              <div v-else>
                <p>There are no entries.</p>
              </div>
            </div>
            <div class="mb-2" v-if="length != 1">
              <v-pagination
                v-model="page"
                :length="length"
                :total-visible="7"
                prev-icon="fa fa-caret-left"
                next-icon="fa fa-caret-right"
                @input="update"
              ></v-pagination>
            </div>
            <div v-if="isLogged">
              <h3>
                <router-link :to="{name: 'entry-add'}">Add your comment</router-link>
              </h3>
            </div>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";

import EntryItem from "../components/shared/EntryItem";
import AppLoadingPage from "../components/layouts/AppLoadingPage";

export default {
  name: "EntryList",
  components: {
    EntryItem,
    AppLoadingPage
  },
  data() {
    return {
      page: 1,
      perPage: 5
    };
  },
  computed: {
    ...mapGetters({
      isLogged: "auth/isLogged",
      loading: "layout/loading",
      user: "auth/authUser",
      entries: "entry/entries",
      cpage: "entry/current_page",
      length: "entry/length"
    })
  },
  watch: {
    $route: "fetchData"
  },
  created() {
    this.fetchData();
  },
  methods: {
    update(val) {
      let page = parseInt(val) || 1;

      this.$router.push({
        name: "entry-list-page",
        params: { page: page }
      });
    },
    fetchData() {
      this.page = parseInt(this.$route.params.page) || 1;
      this.$store.commit("layout/setLoading", false);
      this.$store
        .dispatch("entry/getEntries", this.page)
        .then(res => {
          this.$store.commit("layout/setLoading", true);
        })
        .catch(err => {
          this.$store.commit("layout/setLoading", true);
        });
    }
  }
};
</script>

<style>
.entries-area {
  min-height: 550px;
}
.entry_list {
  list-style: none;
  margin: 0;
  padding: 0;
}

.theme--dark.v-pagination .v-pagination__navigation,
.theme--dark.v-pagination .v-pagination__item {
  background: #353535;
}

@media screen and (max-width: 440px) {
  ul.v-pagination > li {
    display: none;
  }

  ul.v-pagination > li:first-child {
    display: flex;
  }

  ul.v-pagination > li:last-child {
    display: flex;
  }
}
</style>