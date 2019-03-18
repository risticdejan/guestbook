<template>
  <li>
    <h3>
      <router-link :to="{ name: 'entry', params: {id: entry.id}}">{{ entry.name }}</router-link>
    </h3>
    <p class="stitle">
      <v-layout justify-space-between align-center>
        <span>Posted {{ entry.created_at }}.</span>
        <span v-if="this.user">
          <span v-if="this.user.id == entry.user.id || this.user.role == 'admin'">
            <button @click="editEntry" class="button success">edit</button>
            <button @click="deleteEntry" class="button error">delete</button>
          </span>
        </span>
      </v-layout>
    </p>

    <p class="description">{{ entry.subject }}</p>
  </li>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "EntryItem",
  props: ["entry"],
  computed: {
    ...mapGetters({
      isLogged: "auth/isLogged",
      user: "auth/authUser",
      cpage: "entry/current_page",
      token: "auth/token"
    })
  },
  methods: {
    deleteEntry() {
      this.$store
        .dispatch("entry/delete", {
          id: this.entry.id,
          token: this.token
        })
        .then(res => {
          if (res.status) {
            this.$emit("deleteEntry");
          }
        })
        .catch(err => {
          // console.log(err);
        });
    },
    editEntry() {
      this.$router.push({ name: "entry-edit", params: { id: this.entry.id } });
    }
  }
};
</script>

<style scoped>
.button {
  background-color: #eeeeee; /* Green */
  border-radius: 2px;
  border: none;
  color: white;
  padding: 4px 8px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  margin: 4px 4px;
  cursor: pointer;
}

.succes {
  background-color: #4caf50;
} /* Blue */
.errror {
  background-color: #f44336;
} /* Red */

p.description {
  color: #ffffff;
}

p.stitle {
  color: #797878;
  margin: 5px 0;
}
</style>