<template>
  <div id="app">
    <h1 class="welcome-title">Bienvenue sur Travel Buddy</h1>
    <ActivitySearch />
  </div>
</template>

<script>
import ActivitySearch from './components/ActivitySearch.vue';

export default {
  name: 'App',
  components: {
    ActivitySearch
  }
};
</script>
<style src="./assets/style.css"></style>
