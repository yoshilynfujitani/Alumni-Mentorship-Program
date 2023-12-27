<template lang="">
    <Layout @appointment-access-data="handleAppointmentAccessData">
        <div class="" v-if="!apptAccessData">Loading...</div>
        <div class="" v-else>
            <h1>Mentors</h1>
            <div class="grid grid-cols-4 gap-5 mx-auto my-10">
                <div class="mx-auto" v-for="Mentor in mentors">
                    <MentorCard
                        :MentorDetails="Mentor"
                        :displaybtn="apptAccessData.allowedToAppoint"
                    />
                </div>
            </div>
        </div>
    </Layout>
</template>
<script>
import MentorCard from "../component/MentorComponents/MentorCard.vue";

export default {
    components: {
        MentorCard,
    },
    data() {
        return {
            mentors: [],
            apptAccessData: null,
        };
    },
    methods: {
        getMentors() {
            if (this.apptAccessData) {
                const { fieldToTake, allowedToAppoint } = this.apptAccessData;
                axios
                    .post("/getmentorstudent", {
                        fieldToTake,
                        allowedToAppoint,
                    })
                    .then(({ data }) => {
                        console.log(data);
                        this.mentors = data;
                    });
            } else {
                console.warn(
                    "apptAccessData is not available yet. Skipping getMentors call."
                );
            }
        },
        handleAppointmentAccessData(data) {
            console.log(data);
            this.apptAccessData = data;
            this.getMentors();
        },
    },

    mounted() {
        this.getMentors();
    },
};
</script>
<style lang=""></style>
