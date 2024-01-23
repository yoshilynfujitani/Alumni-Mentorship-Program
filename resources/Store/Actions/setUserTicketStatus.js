import axios from "axios";
import updateUserTicketStatus from "../Mutations/updateUserTicketStatus.js";

export default function ({ commit }, data) {
    axios
        .get("/getTicketStatus")
        .then(({ data }) => {
            commit("updateUserTicketStatus", data);
        })
        .catch((err) => {
            console.log(err);
        });
}
