<template>
    <div
        class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
    >
        <div class="flex flex-col items-center py-5">
            <img
                class="w-24 h-24 mb-3 rounded-full shadow-lg"
                src="../../../../public/DefaultAvatar.webp"
                alt="Bonnie image"
            />
            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                {{ Alum.name }}
            </h5>
            <span class="text-sm text-gray-500 dark:text-gray-400"
                >Visual Designer</span
            >
            <div class="flex mt-4 md:mt-6">
                <a
                    @click="sendEmail(Alum.email, Alum.name)"
                    href="#"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >Invite Alumni</a
                >
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["Alum"],
    methods: {
        sendEmail(email, name) {
            axios
                .post("/sendEmail", { email: email, userName: name })
                .then(({ data }) => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success Message",
                        detail: data,
                        life: 3000,
                    });
                });
        },
    },
};
</script>
