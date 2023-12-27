<template lang="">
    <div
        class="w-full min-w-[225px] max-w-[225px] bg-white border p-5 border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
        :class="{
            'min-h-[250px]': displaybtn === 0,
            'min-h-[320px]': displaybtn === 1,
        }"
    >
        <div class="flex flex-col items-center">
            <img
                class="w-24 h-24 mb-3 rounded-full shadow-lg"
                src="../../../../public/DefaultAvatar.webp"
                alt="Avatar"
            />
            <h5
                class="mb-1 text-xl text-center font-medium text-gray-900 dark:text-white"
            >
                {{ MentorDetails.name }}
            </h5>
            <span
                class="text-sm text-center text-gray-500 dark:text-gray-400"
                >{{ MentorDetails.fieldName }}</span
            >
            <div class="flex mt-4 md:mt-6" v-if="displaybtn">
                <a
                    @click="
                        makeAppointment(MentorDetails.id, MentorDetails.name)
                    "
                    href="#"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    >Make Appointment</a
                >
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["MentorDetails", "displaybtn"],
    methods: {
        makeAppointment(id, name) {
            this.$router.push({
                path: `/appointment/${id}`,
                query: { mentor: name },
            });
        },
    },
};
</script>
<style lang=""></style>
