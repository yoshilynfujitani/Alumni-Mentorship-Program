import { createStore } from "vuex";
import setUserDetailsAction from "./Actions/setUserDetails";
import setUserTicketStatusAction from "./Actions/setUserTicketStatus";
import setUserUsername from "./Actions/setUserUsername";
import setUserRatingStatus from "./Actions/setUserRatingStatus";
import initializeStoreAction from "./Actions/initializeStore";
import setUserDetails from "./mutations/setUserDetails";
import updateUserTicketStatus from "./mutations/updateUserTicketStatus";

export default createStore({
    state() {
        return {
            ticketStatus: null,
            fieldToTake: null,
            userId: null,
            allowToAppoint: null,
            rating: null,
            username: null,
        };
    },
    getters: {
        userDetails(state) {
            return [
                state.ticketStatus,
                state.fieldToTake,
                state.userId,
                state.allowToAppoint,
                state.rating,
                state.username,
            ];
        },
    },
    mutations: {
        setUserDetails,
        updateUserTicketStatus,
    },
    actions: {
        setUserTicketStatusAction,
        setUserDetailsAction,
        setUserUsername,
        setUserRatingStatus,
        initializeStoreAction,
    },
});
