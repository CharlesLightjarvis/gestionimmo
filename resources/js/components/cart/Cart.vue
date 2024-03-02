<template>
  <div class="container mt-2">
    <div class="drag cart-container">
      <h2>Shopping Cart</h2>
      <div v-if="$store.state.bienStore.cart.length <= 0" class="cart-empty">
        <p>Panier Vide</p>
        <div class="start-shopping">
          <router-link to="/HomeCart">Take me to Products Page</router-link>
          <span>Start Shopping</span>
        </div>
      </div>
      <div v-else>
        <div class="cart-items">
          <div
            v-for="item in $store.state.bienStore.cart"
            :key="item.id"
            class="cart-item"
          >
            <div class="cart-product">
              <img :src="item.imagebien" :alt="item.imagebien" class="product-image" />
              <div class="separation">
                <div class="details">
                  <p class="product-name">Nom: {{ item.type }}</p>
                  <p class="product-price">Prix: {{ item.prix }} TND</p>
                </div>
                <div>
                  <button @click="removeFromCart(item)" class="remove-button">
                    Retirer du Panier
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="cart-summary">
          <p class="cart-total">Total du Panier: {{ cartTotal }} TND</p>
          <button @click="clearCart()" class="clear-cart-button">Vider le Panier</button>
          <router-link :to="{ name: 'Payment' }">
            <button class="btn btn-primary m-2">Procéder au paiement</button>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useStore } from "vuex";
import { ref, onMounted, computed } from "vue";
import axios from "axios";

const store = useStore();
const biens = ref([]);

const removeFromCart = (item) => {
  store.commit("bienStore/removeFromCart", item);
};

const clearCart = () => {
  store.commit("bienStore/clearCart");
};

const cartTotal = computed(() => {
  return store.state.bienStore.cart.reduce((acc, item) => acc + item.prix, 0);
});

const getBiens = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/biens");
    biens.value = response.data.map((item, index) => ({ ...item, id: index + 1 }));
  } catch (error) {
    console.error("Error fetching biens:", error);
  }
};

onMounted(() => {
  getBiens();
});
</script>

<style>
/* Styles pour le panier */

.separation {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  gap: 40rem;
}

.cart-empty,
.cart-summary {
  text-align: center;
  margin-top: 20px;
}

.cart-empty .start-shopping {
  margin-top: 10px;
}

.cart-item {
  border-bottom: 1px solid #ccc;
  padding: 10px 0;
  display: flex;
  align-items: center;
}

.cart-product {
  display: flex;
  align-items: center;
}

.product-image {
  width: 100px;
  height: 100px;
  object-fit: cover;
  margin-right: 20px;
}

.details {
  display: flex;
  flex-direction: column;
}

.product-name {
  font-weight: bold;
  margin-bottom: 5px;
}

.remove-button {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 4px;
  cursor: pointer;
}

.remove-button:hover {
  background-color: #d32f2f;
}

.cart-summary {
  margin-top: 20px;
}

.cart-total {
  font-weight: bold;
}

.clear-cart-button {
  background-color: #757575;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 4px;
  cursor: pointer;
}

.clear-cart-button:hover {
  background-color: #424242;
}
</style>
