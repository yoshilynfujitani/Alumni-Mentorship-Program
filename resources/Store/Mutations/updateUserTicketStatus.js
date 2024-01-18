export default function (state, payload) {
    let userDetailsString = localStorage.getItem("userDetails_state");
    let userDetails = userDetailsString ? JSON.parse(userDetailsString) : {};
    state.ticketStatus = payload.ticketStatus;
    userDetails.ticketStatus = payload.ticketStatus;
    localStorage.setItem("userDetails_state", JSON.stringify(userDetails));
}
