<template>
  <div class="d-flex justify-content-center align-items-center mt-5">
    <div class="card shadow-lg p-4">
      <h2 class="text-center mb-4 text_title">Ajouter un Bien Immobilier</h2>
      <form @submit.prevent="addBien">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="prix" class="form-label">Prix</label>
            <input
              type="number"
              class="form-control"
              id="prix"
              v-model="bien.prix"
              required
            />
          </div>
          <div class="col-md-6 mb-3">
            <label for="nombreChambres" class="form-label">Nombre de Chambres</label>
            <input
              type="number"
              class="form-control"
              id="nombreChambres"
              v-model="bien.nombre_chambres"
              required
            />
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="surface" class="form-label">Surface (m²)</label>
            <input
              type="number"
              class="form-control"
              id="surface"
              v-model="bien.surface"
              required
            />
          </div>
          <div class="col-md-6 mb-3">
            <label for="ville" class="form-label">Ville</label>
            <input
              type="text"
              class="form-control"
              id="ville"
              v-model="bien.ville"
              required
            />
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input
              type="text"
              class="form-control"
              id="adresse"
              v-model="bien.adresse"
              required
            />
          </div>
          <div class="col-md-6 mb-3">
            <label for="codePostal" class="form-label">Code Postal</label>
            <input
              type="text"
              class="form-control"
              id="codePostal"
              v-model="bien.code_postal"
              required
            />
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="type" class="form-label">Type de Bien</label>
            <input
              type="text"
              class="form-control"
              id="type"
              v-model="bien.type"
              required
            />
          </div>
          <div class="col-md-6 mb-3">
            <label for="type" class="form-label">Sous Categorie</label>
            <select class="form-control" v-model="bien.scategorieID" required>
              <option v-for="sc in Scategories" :key="sc.id" :value="sc.id">
                {{ sc.nomscategorie }}
              </option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div>
            <file-pond
              name="test"
              ref="pond"
              class-name="my-pond"
              label-idle="Drop files here..."
              allow-multiple="false"
              accepted-file-types="image/jpeg, image/png"
              v-bind:files="myFiles"
              v-on:init="handleFilePondInit"
              :server="serverOptions()"
            />
          </div>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Create FilePond component
const FilePond = vueFilePond(FilePondPluginImagePreview);
const myFiles = ref([]);

const router = useRouter();

const Scategories = ref([]);

const getscategories = () => {
  axios
    .get("http://localhost:8000/api/scategories")
    .then((res) => {
      Scategories.value = res.data;
      console.log(Scategories.value);
    })
    .catch((error) => {
      console.log(error);
    });
};

const bien = ref({
  prix: "",
  nombre_chambres: "",
  surface: "",
  ville: "",
  adresse: "",
  code_postal: "",
  type: "",
  scategorieID: "",
  imagebien: "",
});

const addBien = async () => {
  try {
    // Utilisation de category.value pour accéder aux données ref
    await axios.post("http://localhost:8000/api/biens", bien.value);
    router.push({ name: "biens" });
  } catch (error) {
    console.log(error);
  }
};

const serverOptions = () => {
  return {
    process: (fieldName, file, metadata, load, error, progress, abort) => {
      const data = new FormData();
      data.append("file", file);
      data.append("api_key", "977149949581633");
      data.append("upload_preset", "Gestion_Immoliere");
      data.append("cloud_name", "ddyynzvge");
      data.append("public_id", file.name);
      axios
        .post("https://api.cloudinary.com/v1_1/ddyynzvge/image/upload", data)
        .then((response) => {
          bien.value.imagebien = response.data.secure_url;
          load(data);
        })
        .catch((error) => {
          console.error("Error uploading file:", error);
          error("Upload failed");
          abort();
        });
    },
  };
};

const handleFilePondInit = () => {
  // Logique à exécuter lors de l'initialisation de FilePond
  console.log("FilePond initialized");
};

onMounted(() => {
  getscategories();
});
</script>

<style scoped>
.text_title {
  text-shadow: 1px 1px 2px black;
}

/* Centrage vertical et horizontal */
.container {
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Taille de la carte du formulaire avec ombre */
.card {
  width: 600px;
}

/* Taille des champs de formulaire */
.form-control {
  width: 100%;
}
</style>
