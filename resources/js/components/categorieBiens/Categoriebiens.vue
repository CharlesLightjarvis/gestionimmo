<template>
  <div class="mt-2">
    <div class="d-flex justify-content-center">
      <div class="shadow-lg w-100">
        <div class="link">
          <h3 class="text-center mb-4">Liste des Catégories de Biens</h3>
          <router-link :to="{ name: 'createCategory' }" class="btn btn-primary">
            + Nouvelle Catégorie
          </router-link>
        </div>
        <table class="table table-bordered">
          <!-- En-têtes de la table -->
          <thead>
            <tr>
              <th class="text-center" scope="col">Nom Categorie</th>
              <th class="text-center" scope="col">Image Categorie</th>
              <th class="text-center" scope="col">Actions</th>
            </tr>
          </thead>
          <!-- Corps de la table -->
          <tbody>
            <tr v-for="category in categories" :key="category.id">
              <!-- Affichage des données -->
              <td class="align-middle text-center">{{ category.nomcategorie }}</td>
              <div class="d-flex justify-content-center align-items-center">
                <td>
                  <img
                    :src="category.imagecategorie"
                    class="shadow-lg"
                    alt="Image Catégorie"
                    style="max-width: 300px; max-height: 200px"
                  />
                </td>
              </div>

              <td class="align-middle text-center">
                <!-- Boutons d'action (Edit, Delete, etc.) -->
                <div class="btn-group" role="group">
                  <router-link
                    :to="{}"
                    class="btn btn-outline-success"
                    @click="openEditDialog(category.id)"
                  >
                    <i class="fas fa-edit"> </i> Edit
                  </router-link>

                  <button
                    class="btn btn-outline-danger"
                    @click="deleteCategory(category.id)"
                  >
                    <i class="fas fa-trash-alt"> </i> Delete
                  </button>
                  <router-link
                    :to="{ name: 'showCategory', params: { id: category.id } }"
                    class="btn btn-outline-primary"
                  >
                    <i class="fas fa-eye"> </i> Show
                    <!-- Icône Show -->
                  </router-link>
                </div>
              </td>
            </tr>
          </tbody>
          <Dialog v-model:visible="visible" modal>
            <div class="container d-flex justify-content-center align-items-center mt-5">
              <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4 text_title">Modifier une Catégorie</h2>
                <form @submit.prevent="editCategory">
                  <div class="mb-3">
                    <label for="nomCategorie" class="form-label"
                      >Nom de la Catégorie</label
                    >
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
                    <router-link
                      to="/categoriebiens"
                      class="btn btn-outline-danger mx-2"
                      @click="closeDialog"
                    >
                      <i class="fa-solid fa-xmark"> </i>Cancel
                    </router-link>
                  </div>
                </form>
              </div>
            </div>
          </Dialog>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
const visible = ref(false);
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

const closeDialog = () => {
  visible.value = false;
};

let token = "";
token = localStorage.getItem("token");
const config = {
  headers: { Authorization: `Bearer ${token}` },
};

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

const openEditDialog = async (id) => {
  // Récupérez les détails de la catégorie spécifique par ID
  await fetchCategory(id);
  visible.value = true; // Affichez le dialog d'édition
};

const fetchCategory = async (id) => {
  try {
    const res = await axios.get(
      `http://localhost:8000/api/categories/${id || route.params.id}`
    );
    category.value = res.data;
    // Réglez les fichiers pour FilePond si une image existe déjà
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
    .put(`http://localhost:8000/api/categories/${category.value.id}`, category.value)
    .then(() => {
      // Fermer la boîte de dialogue après l'édition
      visible.value = false;

      // Rafraîchir la liste des catégories
      getCategories();

      // Naviguer vers la page des catégories après édition
      router.push("/categoriebiens");
    })
    .catch((error) => {
      console.error("Erreur lors de la modification de la catégorie :", error);
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

const categories = ref([]);

const getCategories = async () => {
  await axios
    .get("http://localhost:8000/api/categories", config)
    .then((response) => {
      categories.value = response.data;
      console.log(categories.value);
    })
    .catch((error) => {
      console.error("Error fetching categories:", error);
    });
};

const deleteCategory = async (id) => {
  if (window.confirm("Êtes-vous sûr de vouloir supprimer ?")) {
    await axios.delete(`http://localhost:8000/api/categories/${id}`).then(() => {
      let i = categories.value.map((data) => data.id).indexOf(id);
      categories.value.splice(i, 1);
    });
  }
};

onMounted(() => {
  getCategories();
});
</script>

<style lang="css" scoped>
table {
  background-color: transparent !important;
}

/* Pour annuler les styles de fond sur les cellules de la table */
td,
th {
  background-color: transparent !important;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.562);
}

h3 {
  color: blue;
  margin-top: 20px;
  margin-left: 60px;
  text-shadow: 1px 1px 2px blue;
}

.link {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.btn-primary {
  margin-right: 60px;
}

/* Largeur totale */
.shadow-lg {
  width: 100%;
}
</style>
