import axios from "axios";

export default function ({ commit }, data) {
    axios
        .get("/getTicketStatus")
        .then(({ data }) => {
            console.log(data.ticketStatus);
            commit("UPDATE_USER_TICKET_STATUS", data);
        })
        .catch((err) => {
            console.log(err);
        });
}
