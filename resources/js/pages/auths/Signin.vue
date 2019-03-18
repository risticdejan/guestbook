<template>
  <v-container fluid>
    <v-layout row wrap>
      <v-flex xs12 md6 offset-md3 lg4 offset-lg4>
        <h2>Sign in</h2>
      </v-flex>
    </v-layout>

    <!-- Error Alert -->
    <v-layout v-if="error" row wrap>
      <v-flex xs12 md6 offset-md3 lg4 offset-lg4>
        <form-alert :messages="error"></form-alert>
      </v-flex>
    </v-layout>

    <v-layout>
      <v-flex xs12 md6 offset-md3 lg4 offset-lg4>
        <v-form v-model="isFormValid" lazy-validation ref="form" @submit.prevent="handleSignin">
          <v-layout row>
            <v-flex xs12>
              <v-text-field :rules="emailRules" v-model="email" label="Email" type="email" required></v-text-field>
            </v-flex>
          </v-layout>

          <v-layout row>
            <v-flex xs12>
              <v-text-field
                :rules="passwordRules"
                v-model="password"
                label="Password"
                type="password"
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
                </span>Sign in
              </v-btn>
              <h3>Don't have an account?
                <router-link :to="{name: 'signup'}">Signup</router-link>
              </h3>
            </v-flex>
          </v-layout>
        </v-form>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "Signin",
  data() {
    return {
      loading: false,
      isFormValid: true,
      email: "",
      password: "",
      emailRules: [
        email => !!email || "Email is required",
        email => /.@+./.test(email) || "Email must be valid"
      ],
      passwordRules: [
        password => !!password || "Password is required",
        // Make sure password is at least 7 characters
        password =>
          password.length >= 6 || "Password must be at least 6 characters"
      ]
    };
  },
  computed: {
    ...mapGetters({ error: "auth/error" })
  },

  destroyed() {
    this.$store.commit("auth/clearError");
  },
  methods: {
    handleSignin() {
      if (this.$refs.form.validate() && this.loading == false) {
        this.loading = true;
        this.$store
          .dispatch("auth/signin", {
            email: this.email,
            password: this.password
          })
          .then(res => {
            this.loading = false;
          })
          .catch(err => {
            this.loading = false;
          });
      }
    }
  }
};
</script>

<style scope>
.custom-loader {
  animation: loader 1s infinite;
  display: flex;
}
@-moz-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-webkit-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-o-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>

