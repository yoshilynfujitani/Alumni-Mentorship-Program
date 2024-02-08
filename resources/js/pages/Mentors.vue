<template lang="">
    <Layout>
        <!-- <div class="" v-if="!apptAccessData">Loading...</div> -->
        <div class="">
            <h1>Mentors</h1>
            <div class="" v-if="this.allowToAppoint === 2">
                <h1>
                    You have already sent an appointment request to a mentor.
                    Please wait before sending another one.
                </h1>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-5 mx-auto my-10"
            >
                <div class="mx-auto" v-for="Mentor in mentors">
                    <MentorCard
                        :MentorDetails="Mentor"
                        :displaybtn="this.allowToAppoint === 1"
                    />
                </div>
            </div>
        </div>
    </Layout>
</template>
<script>
import MentorCard from "../component/MentorComponents/MentorCard.vue";
import { mapState, mapActions } from "vuex";
export default {
    components: {
        MentorCard,
    },
    data() {
        return {
            mentors: [],
        };
    },
    computed: {
        ...mapState([
            "userId",
            "ticketStatus",
            "fieldToTake",
            "allowToAppoint",
        ]),
    },
    methods: {
        ...mapActions(["setUserDetailsAction"]),
        getMentors() {
            const { fieldToTake, allowToAppoint } = this;
            axios
                .post("/getmentorstudent", {
                    fieldToTake,
                    allowToAppoint,
                })
                .then(({ data }) => {
                    console.log(this.fieldToTake);
                    this.mentors = data;
                });
        },
        handleAppointmentAccessData(data) {
            console.log(data);
            this.apptAccessData = data;
            this.getMentors();
        },
    },

    mounted() {
        this.getMentors();
        this.setUserDetailsAction();
    },
};
</script>
<style lang=""></style>
