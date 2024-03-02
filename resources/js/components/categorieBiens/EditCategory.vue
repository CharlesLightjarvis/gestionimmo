<template>
  <div class="container d-flex justify-content-center align-items-center mt-5">
    <div class="card shadow-lg p-4">
      <h2 class="text-center mb-4 text_title">Modifier une Catégorie</h2>
      <form @submit.prevent="editCategory">
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
          <router-link to="/categoriebiens" class="btn btn-outline-danger mx-2">
            <i class="fa-solid fa-xmark"> Cancel</i>
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import axios from "axios";

const FilePond = vueFilePond(FilePondPluginImagePreview);
const myFiles = ref([]);
const router = useRouter();
const route = useRoute();

const category = ref({});

const serverOptions = () => {
  console.log("server pond");
  return {
    load: (source, load, error, progress, abort, headers) => {
      console.log("Source : ", source);
      var myRequest = new Request(source);
      fetch(myRequest).then(function (response) {
        response.blob().then(function (myBlob) {
          load(myBlob);
        });
      });
    },
    process: (fieldName, file, metadata, load, error, progress, abort) => {
      const data = new FormData();
      data.append("file", file);
      data.append("upload_preset", "Gestion_Immoliere");
      data.append("cloud_name", "ddyynzvge");
      data.append("public_id", file.name);
      axios
        .post("https://api.cloudinary.com/v1_1/ddyynzvge/upload", data)
        .then((response) => response.data)
        .then((data) => {
          category.value.imagecategorie = data.url;
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

const fetchCategory = async () => {
  try {
    const res = await axios.get(
      `http://localhost:8000/api/categories/${route.params.id}`
    );
    category.value = res.data;
    if (category.value.imagecategorie) {
      myFiles.value = [
        {
          source: category.value.imagecategorie,
          options: { type: "local" },
        },
      ];
    }
  } catch (err) {
    console.error(err);
  }
};

const editCategory = () => {
  axios
    .put(`http://localhost:8000/api/categories/${route.params.id}`, category.value)
    .then(() => {
      router.push("/categoriebiens");
    })
    .catch((error) => {
      console.error("There was an error!", error);
    });
};

const handleFilePondInit = () => {
  if (category.value.imagecategorie) {
    myFiles.value = [
      {
        source: category.value.imagecategorie,
        options: { type: "local" },
      },
    ];
  }
};

onMounted(() => {
  fetchCategory();
});
</script>

<style lang="scss" scoped></style>
