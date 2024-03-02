<template>
  <div class="mt-2">
    <div class="d-flex justify-content-center">
      <div class="shadow-lg w-100">
        <div class="link">
          <h3 class="text-center mb-4">Liste des Biens</h3>
          <router-link :to="{ name: 'createBien' }" class="btn btn-primary">
            + Nouveau Bien
          </router-link>
        </div>
        <DataTable
          :value="biens"
          ref="dt"
          paginator
          :rows="5"
          :rowsPerPageOptions="[5, 10, 20, 50]"
          tableStyle="min-width: 50rem"
        >
          <template #header>
            <div style="text-align: left">
              <Button
                icon="pi pi-external-link"
                label="Export"
                @click="exportCSV($event)"
              />
            </div>
          </template>
          <Column header="Image Bien">
            <template #body="rowData">
              <img
                :src="rowData.data.imagebien"
                class="shadow-lg"
                alt="Image Catégorie"
                style="max-width: 250px; max-height: 250px"
              />
            </template>
          </Column>
          <!-- Autres colonnes existantes -->

          <Column field="prix" header="Prix" sortable style="width: 25px"></Column>
          <Column
            field="nombre_chambres"
            header="Nombre de Chambres"
            sortable
            style="width: 25px"
          ></Column>
          <Column field="surface" header="Surface" sortable style="width: 25px"></Column>
          <Column field="ville" header="Ville" sortable style="width: 25px"></Column>
          <Column field="adresse" header="Adresse" sortable style="width: 25px"></Column>
          <Column
            field="code_postal"
            header="Code Postal"
            sortable
            style="width: 25px"
          ></Column>
          <Column field="type" header="Type" sortable style="width: 25px"></Column>
          <Column header="Actions">
            <template #body="rowData">
              <!-- Boutons d'action ici -->
              <div class="btn-group" role="group">
                <!-- Utilisation de router-link ou de boutons pour les actions -->
                <router-link :to="{}" class="btn btn-outline-success">
                  <i class="fas fa-edit"> </i>
                </router-link>
                <button
                  class="btn btn-outline-danger"
                  @click="deleteBien(rowData.data.id)"
                >
                  <i class="fas fa-trash-alt"> </i>
                </button>
                <router-link :to="{}" class="btn btn-outline-primary">
                  <i class="fas fa-eye"> </i>
                </router-link>
              </div>
            </template>
          </Column>
        </DataTable>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import DataTable from "primevue/datatable";
import Column from "primevue/column";

const biens = ref([]);
const dt = ref();
const exportCSV = () => {
  dt.value.exportCSV();
};

const deleteBien = async (id) => {
  if (window.confirm("Êtes-vous sûr de vouloir supprimer ?")) {
    try {
      await axios.delete(`http://localhost:8000/api/biens/${id}`);
      const index = biens.value.findIndex((bien) => bien.id === id);
      if (index !== -1) {
        biens.value.splice(index, 1);
      }
      // Rafraîchir la liste des biens après suppression
      await getBiens();
    } catch (error) {
      console.error("Error deleting bien:", error);
    }
  }
};

const getBiens = async () => {
  await axios
    .get("http://localhost:8000/api/biens")
    .then((response) => {
      biens.value = response.data;
      console.log(biens.value);
    })
    .catch((error) => {
      console.error("Error fetching categories:", error);
    });
};

onMounted(() => {
  getBiens();
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
