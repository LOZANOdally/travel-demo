<template>
  <div>
    <!-- Bar de recherche -->
    <input 
      class="search-bar"
      v-model="searchQuery" 
      @input="searchActivities" 
      placeholder="Rechercher une activité" 
    />

    <!-- Sélecteur de catégorie -->
    <select class="category-select" v-model="selectedCategory" @change="searchActivities">
      <option value="nature">Nature</option>
      <option value="culture">Culture</option>
      <option value="sport">Sport</option>
    </select>

    <!-- Liste des activités -->
    <div v-for="activity in activities" :key="activity.id" class="activity">
      <h3 class="activity-title">{{ activity.name }}</h3>
      <p class="activity-description">{{ activity.description }}</p>
      <p class="activity-price">Prix: {{ activity.price }} €</p>
      <p class="activity-rating">Note: {{ activity.rating }}</p>
      <img :src="activity.image_url" class="activity-image" alt="Image de l'activité" />
    </div>
  </div>
</template>
  
  <script>
  export default {
    data() {
      return {
        searchQuery: '',
        selectedCategory: 'nature',
        activities: []
      };
    },
    methods: {
      async searchActivities() {
      
        const response = await fetch(`http://localhost/travel-demo/api/api.php?category=${this.selectedCategory}&searchQuery=${this.searchQuery}`);
        const data = await response.json();
        this.activities = data;
      }
    },
    mounted() {
      this.searchActivities();
    }
  };
  </script>
  