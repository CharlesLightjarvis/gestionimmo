<template>
  <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
    <form @submit.prevent="handleSubmit">
      <div class="card" style="width: 50rem">
        <div class="card-body text-center">
          <h5 class="card-title">Montant à payer : {{ amount }} TND</h5>
          <br />
          <div id="card-element"></div>
          <br />
          <button type="submit" class="btn btn-success">Procéder au paiement</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { loadStripe } from "@stripe/stripe-js";
import store from "../../store";
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();
const stripePromise = loadStripe(
  "pk_test_51OMVJvKF86N7LxxEsDMo9KOrjSnIQtJY5gpP2demufYvULI56u1XDNhUiB7VOR65a89TFM1wY7CCnZTZQWhyijjS00WVUF4GLS"
);
const stripe = ref(null);
let cardElement; // Déclarer cardElement comme variable globale
let amount = ref(0);
onMounted(async () => {
  amount.value = store.state.bienStore.cartTotal;
  stripe.value = await stripePromise;
  const elements = stripe.value.elements();
  cardElement = elements.create("card"); // Affecter cardElement
  cardElement.mount("#card-element");
});
const handleSubmit = async () => {
  const { token, error } = await stripe.value.createToken(cardElement);
  if (error) {
    console.error(error);
  } else {
    // Envoie le token au serveur pour traiter le paiement
    const response = await axios.post("/api/createpayment", {
      token: token.id,
      amount: amount.value * 100, // Convertir le montant en cents
    });
    if (response.data.message) {
      console.log(response.data.message);
      // Le paiement est réussi
      alert(response.data.message);
      //Vider le cart
      store.commit("bienStore/clearCart");
      //Redirection
      router.push("/HomeCart");
    } else {
      console.error(response.data.error);
    }
  }
};
</script>
