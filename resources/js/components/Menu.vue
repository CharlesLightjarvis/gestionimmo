<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-white">
      <div class="container">
        <router-link class="navbar-brand" :to="{ path: '/' }">
          <img src="../../../logo-gestion-immo-logis-2.png" alt="Votre Logo" width="60" />
        </router-link>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <router-link class="nav-link text-dark" to="/" exact>Accueil</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link text-dark" to="/categoriebiens"
                >Categorie Biens</router-link
              >
            </li>
            <li class="nav-item">
              <router-link class="nav-link text-dark" to="/biens"
                >Liste des Biens</router-link
              >
            </li>

            <li class="nav-item">
              <router-link class="nav-link text-dark" to="/HomeCart"
                >Cart Biens</router-link
              >
            </li>
            <!-- Ajoutez d'autres liens de navigation si nécessaire -->
          </ul>
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item me-3 cart-icon">
              <router-link
                class="nav-link position-relative"
                :class="$route.name == 'Cart' ? 'active' : ''"
                aria-current="page"
                :to="{ name: 'Cart' }"
              >
                <i class="fa-solid fa-cart-shopping fa-lg" style="color: #00bff7"></i>
                <span
                  v-if="$store.state.bienStore.cart.length > 0"
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                >
                  {{ $store.state.bienStore.cart.length }}
                </span>
              </router-link>
              <!-- Contenu du panier -->
              <!-- ... -->
            </li>
            <li class="nav-item">
              <router-link class="nav-link active btn btn-primary m-2" to="/login"
                >Login
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link active btn btn-secondary m-2" to="/register"
                >Register
              </router-link>
            </li>
            <li class="nav-item">
              <router-link
                class="nav-link active btn btn-danger m-2"
                to=""
                @click="logout"
                >Logout
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Le reste de votre contenu ici -->
    <div class="container">
      <!-- Votre contenu -->
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
const logout = async () => {
  let token = "";

  token = localStorage.getItem("token");
  console.log(token);
  axios
    .post("http://localhost:8000/api/logout", null, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })

    .then((response) => {
      console.log(response);
      localStorage.removeItem("token");
      localStorage.removeItem("user");
      router.push("/login");
    })
    .catch((err) => {
      console.log(err);
      alert(err);
    });
};
</script>

<style>
/* Styles pour le panier et le badge */
.cart-icon {
  position: relative;
}

.badge {
  position: absolute;
  top: -10px;
  right: -10px;
}

.cart-content {
  position: absolute;
  top: 100%;
  right: 0;
  background: #fff;
  border: 1px solid #ccc;
  padding: 10px;
  max-height: 200px;
  overflow-y: auto;
  z-index: 999;
  display: none;
}

.cart-content ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.cart-content ul li {
  margin-bottom: 5px;
}
</style>
