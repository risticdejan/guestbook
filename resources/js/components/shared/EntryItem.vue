<template>
  <li>
    <h3>
      <router-link :to="{ name: 'entry', params: {id: entry.id}}">{{ entry.name }}</router-link>
    </h3>
    <p class="stitle">Posted {{ entry.created_at }}.</p>
    <p class="description">{{ entry.subject }}</p>
  </li>
</template>

<script>
export default {
  name: "EntryItem",
  props: ["entry"]
};
</script>

<style scoped>
p.description {
  color: #ffffff;
}

p.stitle {
  color: #797878;
  margin: 5px 0;
}
</style>