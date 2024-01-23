import axios from "axios";
import setUserDetails from "../Mutations/setUserDetails.js";

export default function ({ commit }, data) {
    axios
        .get("/checkuserstatus")
        .then(({ data }) => {
            commit("setUserDetails", data);
        })
        .catch((err) => {
            console.log(err);
        });
}
