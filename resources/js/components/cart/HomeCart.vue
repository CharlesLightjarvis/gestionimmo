<template>
  <div class="container mt-2">
    <div class="row">
      <div v-for="bien in biens" :key="bien.id" class="col-md-3 mb-4">
        <div class="card" @mouseover="addHoverEffect" @mouseleave="removeHoverEffect">
          <img
            :src="bien.imagebien"
            class="card-img-top"
            alt="Image du Bien"
            style="width: 100%; height: 200px; object-fit: cover"
          />
          <div class="card-body">
            <p class="card-text">Prix: {{ bien.prix }}</p>
            <p class="card-text">Chambres: {{ bien.nombre_chambres }}</p>
            <p class="card-text">Surface: {{ bien.surface }}</p>
            <p class="card-text">Ville: {{ bien.ville }}</p>
            <p class="card-text">Adresse: {{ bien.adresse }}</p>
            <p class="card-text">Code Postal: {{ bien.code_postal }}</p>
            <p class="card-text">Type: {{ bien.type }}</p>
            <button
              @click="toggleCart(bien)"
              class="btn btn-custom"
              :class="{
                'btn-primary': !isInCart(bien),
                'btn-danger': isInCart(bien),
              }"
            >
              {{ isInCart(bien) ? "Remove from Cart" : "Add to Cart" }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

const biens = ref([]);
const cart = ref([]);

import { useStore } from "vuex";

const store = useStore();

// ... Vos variables existantes

const addToCart = (bien) => {
  store.commit("bienStore/addCart", bien);
};

const removeFromCart = (bien) => {
  store.commit("bienStore/removeFromCart", bien);
};

const getBiens = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/biens");
    biens.value = response.data.map((bien, index) => ({ ...bien, id: index + 1 }));
  } catch (error) {
    console.error("Error fetching biens:", error);
  }
};

const isInCart = (bien) => {
  return cart.value.some((item) => item.id === bien.id);
};

const toggleCart = (bien) => {
  const isAlreadyInCart = isInCart(bien);

  if (isAlreadyInCart) {
    removeFromCart(bien);
  } else {
    addToCart(bien);
  }
};

const cartItemsCount = computed(() => {
  return cart.value.length;
});

onMounted(() => {
  getBiens();
});
</script>

<style>
.btn-custom {
  border-radius: 20px; /* Coins arrondis */
  padding: 8px 16px; /* Espacement intérieur */
  font-size: 14px; /* Taille de la police */
  font-weight: bold; /* Poids de la police */
  text-transform: uppercase; /* Texte en majuscules */
  transition: all 0.3s ease; /* Transition pour les effets */
}

/* Style lorsque le bouton est en mode "Add" */
.btn-custom.btn-primary {
  background-color: blue; /* Couleur par défaut */
  border-color: blue; /* Couleur de la bordure */
  color: white; /* Couleur du texte */
}

/* Style lorsque le bouton est en mode "Remove" */
.btn-custom.btn-danger {
  background-color: red; /* Couleur en mode "Remove" */
  border-color: red; /* Couleur de la bordure */
  color: white; /* Couleur du texte */
}
/* Styles pour les cartes et les boutons */
.card {
  width: 100%;
  transition: box-shadow 0.3s ease, transform 0.3s ease;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* Ombre par défaut */
}

.card-img-top {
  height: 200px; /* Hauteur désirée pour l'image */
  object-fit: cover;
}

.card-body {
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.card:hover {
  transform: scale(1.05); /* Effet de grossissement au survol */
  box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2); /* Nouvelle ombre au survol */
}

.btn-primary {
  background-color: blue; /* Couleur par défaut */
}

.btn-primary.removed {
  background-color: red; /* Couleur quand le bouton est en mode "Remove" */
}
</style>
