export default function (state, payload) {
    state.ticketStatus = payload.ticketStatus;
    state.fieldToTake = payload.fieldToTake;
    state.userId = payload.userId;
    state.rating = payload.rating;
    state.allowToAppoint = payload.allowToAppoint;
    state.username = payload.username;
    localStorage.setItem("userDetails_state", JSON.stringify(state));
}
