<template>
  <div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="card shadow-lg p-4">
      <h2 class="text-center mb-4 text_title">Ajouter une Catégorie</h2>
      <form @submit.prevent="addCategory">
        <div class="mb-3">
          <label for="nomCategorie" class="form-label">Nom de la Catégorie</label>
          <input
            type="text"
            class="form-control"
            id="nomCategorie"
            v-model="category.nomcategorie"
            required
          />
        </div>
        <!-- <div class="mb-3">
          <label for="imageCategorie" class="form-label">URL de l'Image</label>
          <input
            type="text"
            class="form-control"
            id="imageCategorie"
            v-model="category.imagecategorie"
            required
          />
        </div> -->
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
import { ref } from "vue";
import { useRouter } from "vue-router";

import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Create FilePond component
const FilePond = vueFilePond(FilePondPluginImagePreview);
const myFiles = ref([]);

const router = useRouter();

// Utilisation de ref pour créer des réactivités sur les données du formulaire
const category = ref({
  nomcategorie: "",
  imagecategorie: "",
});

const addCategory = async () => {
  try {
    // Utilisation de category.value pour accéder aux données ref
    await axios.post("http://localhost:8000/api/categories", category.value);
    router.push({ name: "categorieBiens" });
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
          category.value.imagecategorie = response.data.secure_url;
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
