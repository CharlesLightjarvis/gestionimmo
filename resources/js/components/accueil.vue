<template>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header bg-primary text-white">Bienvenue sur notre site</div>
          <div class="card-body">
            <h5 class="card-title">
              Bienvenue dans notre plateforme de gestion immobilière
            </h5>
            <p class="card-text">Vous êtes à la page d'accueil.</p>
            <button class="btn btn-primary">Consultez la liste des Biens</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  },
};
</script>

<style>
/* Ajoutez des styles personnalisés ici si nécessaire */
</style>
