import axios from "axios";

export default function ({ commit }, data) {
    axios
        .get("/checkuserstatus")
        .then(({ data }) => {
            commit("SET_USER_DETAILS", data);
        })
        .catch((err) => {
            console.log(err);
        });
}
