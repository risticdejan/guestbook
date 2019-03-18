<template>
  <v-container fluid>
    <v-layout row wrap>
      <v-flex xs12 md6 offset-md3>
        <v-card class="mb-2">
          <v-card-text>
            <h1 class="mb-2">Verify Your Email Address</h1>
            <p>Before continuing, check the email for the confirmation link if you have not received an email.
              <v-btn @click="resend" color="primary">click here to request another.</v-btn>
            </p>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "EmailVerification",
  data() {
    return {
      id: 0
    };
  },
  computed: {
    ...mapGetters({
      token: "auth/token",
      isLogged: "auth/isLogged",
      isEmailVerified: "auth/isEmailVerified",
      user: "auth/authUser"
    })
  },
  destroyed() {
    this.$store.commit("auth/clearError");
    this.$store.commit("auth/clearAuthUser");
  },
  watch: {
    "$route.params.id": function(id) {
      this.id = id;
    }
  },
  methods: {
    resend() {
      this.$store
        .dispatch("auth/verificationResend", {
          id: this.id,
          token: this.token
        })
        .then(res => {
          this.$router.push("/");
        })
        .catch(err => {
          this.$router.push("/");
        });
    }
  }
};
</script>

<style>
</style>
