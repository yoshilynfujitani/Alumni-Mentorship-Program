import { createStore } from "vuex";
import setUserDetailsAction from "./Actions/setUserDetails";
import setUserTicketStatusAction from "./Actions/setUserTicketStatus";
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
        };
    },
    getters: {
        userDetails(state) {
            return [
                state.ticketStatus,
                state.fieldToTake,
                state.userId,
                state.allowToAppoint,
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
        initializeStoreAction,
    },
});
