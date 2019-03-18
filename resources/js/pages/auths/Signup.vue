<template>
  <v-container fluid>
    <!-- Signup Title -->
    <v-layout row wrap>
      <v-flex xs12 md6 offset-md3 lg4 offset-lg4>
        <h2>Sign up</h2>
      </v-flex>
    </v-layout>

    <!-- Error Alert -->
    <v-layout v-if="error" row wrap>
      <v-flex xs12 md6 offset-md3 lg4 offset-lg4>
        <form-alert :messages="error"></form-alert>
      </v-flex>
    </v-layout>

    <!-- Signup Form -->
    <v-layout row wrap>
      <v-flex xs12 md6 offset-md3 lg4 offset-lg4>
        <v-form v-model="isFormValid" lazy-validation ref="form" @submit.prevent="handleSignup">
          <v-layout row>
            <v-flex xs12>
              <v-text-field
                :rules="usernameRules"
                v-model="username"
                label="Username"
                type="text"
                required
              ></v-text-field>
            </v-flex>
          </v-layout>

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

          <v-layout row>
            <v-flex xs12>
              <v-text-field
                :rules="passwordRules"
                v-model="passwordConfirmation"
                label="Confirm Password"
                type="password"
                required
              ></v-text-field>
            </v-flex>
          </v-layout>

          <v-layout row>
            <v-flex xs12>
              <v-btn
                :loading="loading"
                :disabled="!isFormValid"
                block
                color="primary"
                type="submit"
              >
                <span slot="loader" class="custom-loader">
                  <v-icon light>fas fa-spinner</v-icon>
                </span>
                Sign up
              </v-btn>
              <h3>Already have an account?
                <router-link to="/signin">Signin</router-link>
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
  name: "Signup",
  data() {
    return {
      loading: false,
      isFormValid: true,
      username: "",
      email: "",
      password: "",
      passwordConfirmation: "",
      usernameRules: [
        username => !!username || "Username is required",
        username =>
          username.length < 10 || "Username cannot be more than 10 characters"
      ],
      emailRules: [
        email => !!email || "Email is required",
        email => /[\w-]+@([\w-]+\.)+[\w-]+/.test(email) || "Email must be valid"
      ],
      passwordRules: [
        password => !!password || "Password is required",
        password =>
          password.length >= 4 || "Password must be at least 4 characters",
        confirmation => confirmation === this.password || "Passwords must match"
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
    handleSignup() {
      if (this.$refs.form.validate() && this.loading == false) {
        this.loading = true;
        this.$store
          .dispatch("auth/signup", {
            name: this.username,
            email: this.email,
            password: this.password,
            password_confirmation: this.passwordConfirmation
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
