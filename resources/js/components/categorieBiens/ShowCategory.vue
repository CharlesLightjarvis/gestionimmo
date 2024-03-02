<template>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg">
      <div class="row">
        <div class="col-md-6 d-flex align-items-center">
          <div class="mb-3 w-100">
            <h2 class="text-center m-auto">{{ category.nomcategorie }}🛕</h2>
          </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
          <div class="form-group">
            <img
              v-if="category.imagecategorie"
              :src="category.imagecategorie"
              alt="Image Catégorie"
              class="img-fluid"
            />
            <p v-else>Aucune image disponible</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";

const category = ref({});
const router = useRouter();
const route = useRoute();

const fetchCategory = async () => {
  try {
    const res = await axios.get(
      `http://localhost:8000/api/categories/${route.params.id}`
    );
    category.value = res.data;
  } catch (err) {
    console.error(err);
  }
};

onMounted(() => {
  fetchCategory();
});
</script>

<style scoped>
/* Ajoutez vos styles personnalisés ici */
.text_title {
  text-shadow: 1px 1px 2px black;
}
/* Vous pouvez ajuster les styles pour correspondre à vos préférences visuelles */
.img-fluid {
  max-width: 100%;
  height: auto;
  border-radius: 15px;
}

.card {
  border-radius: 15px;
}
</style>
