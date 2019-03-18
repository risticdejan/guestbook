<template>
  <v-container fluid>
    <v-layout row wrap>
      <v-flex xs12 md6 offset-md3>
        <v-card class="mb-2">
          <v-card-text>
            <div v-if="entry">
              <h1>
                <b>Name:</b>
                {{ entry.name }}
              </h1>
              <p>
                <b>Subject:</b>
                {{ entry.subject }}
              </p>
              <p v-if="entry.email">
                <b>Email:</b>
                {{ entry.email }}
              </p>
              <p>
                <b>Comment:</b>
                {{ entry.body }}
              </p>
              <p>
                <v-btn @click="backToEntries" type="button" color="primary">back</v-btn>
                <span v-if="this.user">
                  <span v-if="this.user.id == entry.user.id || this.user.role == 'admin'">
                    <v-btn @click="editEntry" type="button" color="success">edit</v-btn>
                    <v-btn @click="deleteEntry" type="button" color="error">delete</v-btn>
                  </span>
                </span>
              </p>
            </div>
            <div v-else>
              <p>There are no entry.</p>
            </div>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "Entry",
  data() {
    return {
      entry: null
    };
  },
  computed: {
    ...mapGetters({
      isLogged: "auth/isLogged",
      entry: "entry/entry",
      token: "auth/token",
      cpage: "entry/current_page",
      user: "auth/authUser"
    })
  },
  watch: {
    $route: "fetchData"
  },
  created() {
    this.fetchData();
  },
  methods: {
    backToEntries() {
      this.$router.push({
        name: "entry-list-page",
        params: { page: this.cpage }
      });
    },
    fetchData() {
      this.id = parseInt(this.$route.params.id);

      this.$store
        .dispatch("entry/getEntry", this.id)
        .then(res => {
          this.entry = res.data.entry;
        })
        .catch(err => {});
    },
    deleteEntry() {
      this.$store
        .dispatch("entry/delete", {
          id: this.entry.id,
          token: this.token
        })
        .then(res => {
          if (res.status) {
            this.$router.push({
              name: "entry-list-page",
              params: { page: this.cpage }
            });
          }
        })
        .catch(err => {});
    },
    editEntry() {
      this.$router.push({ name: "entry-edit", params: { id: this.entry.id } });
    }
  }
};
</script>

<style scoped>
</style>