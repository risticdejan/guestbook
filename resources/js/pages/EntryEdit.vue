<template>
  <v-container fluid>
    <v-layout row wrap v-if="entry">
      <v-flex xs12 md6 offset-md3>
        <h2>Edit: {{ entry.subject }}</h2>
      </v-flex>
    </v-layout>

    <!-- Error Alert -->
    <v-layout v-if="error" row wrap>
      <v-flex xs12 md6 offset-md3 lg4 offset-lg4>
        <form-alert :messages="error"></form-alert>
      </v-flex>
    </v-layout>

    <v-layout row wrap v-if="entry">
      <v-flex xs12 md6 offset-md3>
        <div class="add-new-entry" v-if="isLogged">
          <v-form
            class="text-xs-center"
            v-model="isFormValid"
            lazy-validation
            ref="form"
            @submit.prevent="handleUpdateEntry"
          >
            <v-layout row>
              <v-flex xs12>
                <v-text-field
                  align="center"
                  :rules="nameRules"
                  v-model="name"
                  label="Name"
                  type="text"
                  required
                ></v-text-field>
              </v-flex>
            </v-layout>

            <v-layout row>
              <v-flex xs12>
                <v-text-field
                  :rules="subjectRules"
                  v-model="subject"
                  label="Subject"
                  type="text"
                  required
                ></v-text-field>
              </v-flex>
            </v-layout>

            <v-layout row>
              <v-flex xs12>
                <v-textarea :rules="bodyRules" v-model="body" label="Comment" value></v-textarea>
              </v-flex>
            </v-layout>

            <v-layout row>
              <v-flex xs12>
                <v-text-field
                  :rules="emailRules"
                  v-model="email"
                  label="Email"
                  type="email"
                  required
                ></v-text-field>
              </v-flex>
            </v-layout>

            <v-layout row wrap>
              <v-flex xs12>
                <v-btn
                  block
                  :loading="loading"
                  :disabled="!isFormValid"
                  type="submit"
                  color="primary"
                >
                  <span slot="loader" class="custom-loader">
                    <v-icon light>fas fa-spinner</v-icon>
                  </span>Update
                </v-btn>
                <v-btn block @click="backToEntries" type="button" color="success">back</v-btn>
              </v-flex>
            </v-layout>
          </v-form>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "EntryEdit",
  data() {
    return {
      loading: false,
      isFormValid: true,
      email: "",
      emailRules: [
        email => !email || /.@+./.test(email) || "Email must be valid",
        email => email.length < 80 || "Email must be less than 80 characters"
      ],
      name: "",
      nameRules: [
        name => !!name || "Name is required",
        name => name.length < 80 || "Name must be less than 80 characters"
      ],
      body: "",
      bodyRules: [
        body => !!body || "Comment is required",
        body =>
          body.length < 20000 || "Comment must be less than 20000 characters"
      ],
      subject: "",
      subjectRules: [
        subject => !!subject || "Name is required",
        subject =>
          subject.length < 255 || "Name must be less than 255 characters"
      ]
    };
  },
  computed: {
    ...mapGetters({
      isLogged: "auth/isLogged",
      entry: "entry/entry",
      token: "auth/token",
      error: "entry/error",
      cpage: "entry/current_page"
    })
  },
  destroyed() {
    this.$store.commit("entry/clearError");
    this.$store.commit("entry/clearEntry");
  },
  watch: {
    $route: "fetchData"
  },
  created() {
    this.fetchData();
  },
  methods: {
    handleUpdateEntry() {
      if (this.$refs.form.validate() && this.loading == false) {
        this.loading = true;
        var data = {
          id: this.entry.id,
          token: this.token,
          name: this.name,
          subject: this.subject,
          body: this.body
        };

        if (this.email) data.email = this.email;

        this.$store
          .dispatch("entry/update", data)
          .then(res => {
            this.$router.push({
              name: "entry-list-page",
              params: { page: this.cpage }
            });
            this.loading = false;
          })
          .catch(err => {
            this.loading = false;
          });
      }
    },
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
          var entry = res.data.entry;
          this.name = entry.name;
          this.email = entry.email || "";
          this.subject = entry.subject;
          this.body = entry.body;
        })
        .catch(err => {});
    }
  }
};
</script>

<style>
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