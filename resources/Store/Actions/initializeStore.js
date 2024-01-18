// actions/initializeStore.js
export default function ({ commit }) {
    const storedState = localStorage.getItem("userDetails_state");
    if (storedState) {
        const parsedState = JSON.parse(storedState);
        commit("SET_USER_DETAILS", parsedState);
    }
}
