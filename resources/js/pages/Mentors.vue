<template lang="">
    <Layout>
        <!-- <div class="" v-if="!apptAccessData">Loading...</div> -->
        <div class="">
            <h1>Mentors</h1>
            <div class="grid grid-cols-4 gap-5 mx-auto my-10">
                <div class="mx-auto" v-for="Mentor in mentors">
                    <MentorCard
                        :MentorDetails="Mentor"
                        :displaybtn="this.allowToAppoint"
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
        ...mapActions(["setUserDetails"]),
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
        this.setUserDetails();
    },
};
</script>
<style lang=""></style>
