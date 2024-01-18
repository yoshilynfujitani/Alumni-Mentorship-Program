export default function (state, payload) {
    state.ticketStatus = payload.ticketStatus;
    state.fieldToTake = payload.fieldToTake;
    state.userId = payload.userId;
    state.allowToAppoint = payload.allowToAppoint;
    localStorage.setItem("userDetails_state", JSON.stringify(state));
}
