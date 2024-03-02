// BienStore.js

const state = {
    biens: [],
    cart: [],
    cartTotal: 0,
};

const mutations = {
    clearCart(state) {
        state.cart = [];
        state.cartTotal = 0;
    },
    addCart(state, bien) {
        const bienInCartIndex = state.cart.findIndex((item) => item.id === bien.id);
        if (bienInCartIndex < 0) {
            state.cart.push({ ...bien, qty: 1 });
        } else {
            state.cart[ bienInCartIndex ].qty++;
        }
        state.cartTotal = state.cart.reduce((total, item) => total + item.prix * item.qty, 0);
    },
    minusCart(state, bien) {
        const bienInCartIndex = state.cart.findIndex((item) => item.id === bien.id);
        if (bienInCartIndex >= 0) {
            state.cart[ bienInCartIndex ].qty--;
            if (state.cart[ bienInCartIndex ].qty <= 0) {
                state.cart.splice(bienInCartIndex, 1);
            }
        }
        state.cartTotal = state.cart.reduce((total, item) => total + item.prix * item.qty, 0);
    },
    removeFromCart(state, bien) {
        state.cart = state.cart.filter((item) => item.id !== bien.id);
        state.cartTotal = state.cart.reduce((total, item) => total + item.prix * item.qty, 0);
    },
    plusCart(state, bien) {
        const bienInCartIndex = state.cart.findIndex((item) => item.id === bien.id);
        if (bienInCartIndex >= 0) {
            state.cart[ bienInCartIndex ].qty++;
        }
        state.cartTotal = state.cart.reduce((total, item) => total + item.prix * item.qty, 0);
    },
};

export default {
    namespaced: true,
    state,
    mutations,
};
