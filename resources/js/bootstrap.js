/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

const currentUrl = window.location.href;

// Create a URLSearchParams object from the URL
const urlParams = new URLSearchParams(currentUrl);

// Get the value of the 'id' parameter
const idFromUrl = urlParams.get("id");

// Check if the 'id' parameter is present
if (idFromUrl !== null) {
    console.log("ID from URL:", idFromUrl);

    // Now you can use the idFromUrl in your code
    window.Echo.channel(`chat${idFromUrl}`).listen(".newchat", (e) => {
        console.log(
            "UpdateProgressData has been updated for chat with id:",
            idFromUrl
        );
        console.log(e);
    });
} else {
    console.log("No 'id' parameter found in the URL");
}
