<template>
    <div
        class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
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
            <span class="text-sm text-gray-500 dark:text-gray-400">{{
                Alum.CollegeName
            }}</span>
            <div class="flex mt-4 md:mt-6">
                <a
                    @click="sendEmail(Alum.email, Alum.name)"
                    href="#"
                    :class="{ 'opacity-80': isLoading }"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:outline-none dark:bg-blue-600 dark:hover:bg-blue-700"
                    >{{ isLoading ? "Sending..." : "Invite Alumni" }}</a
                >
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["Alum"],
    data() {
        return {
            isLoading: false,
        };
    },
    methods: {
        sendEmail(email, name) {
            this.isLoading = true;
            axios
                .post("/sendEmail", { email: email, userName: name })
                .then(({ data }) => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Success Message",
                        detail: data,
                        life: 3000,
                    });
                    this.isLoading = false;
                });
        },
    },
};
</script>
