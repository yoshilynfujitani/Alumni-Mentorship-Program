// actions/initializeStore.js
import setUserDetails from "../Mutations/setUserDetails.js";
export default function ({ commit }) {
    const storedState = localStorage.getItem("userDetails_state");
    if (storedState) {
        const parsedState = JSON.parse(storedState);
        commit("setUserDetails", parsedState);
    }
}
