<template lang="">
    <Layout>
        <!-- <div class="" v-if="!apptAccessData">Loading...</div> -->
        <div class="my-10 flex justify-center flex-col items-center">
            <div class="self-start">
                <h1 class="flex items-center text-2xl gap-1 font-medium">
                    <i class="pi pi-users text-2xl text-yellow-400"></i>
                    <span class="text-green-700">Mentors</span>
                </h1>
            </div>
            <div class="w-fit" v-if="this.allowToAppoint === 2">
                <Message severity="warn">
                    You have already sent an appointment request to a mentor.
                    Please wait before sending another one.</Message
                >
            </div>
            <div class="bg-white border border-gray-200 rounded-md p-5 my-5">
                <div class="">
                    <div class=""><h1>Business</h1></div>
                </div>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-5 mx-auto"
                >
                    <div class="mx-auto" v-for="Mentor in mentors">
                        <MentorCard
                            :MentorDetails="Mentor"
                            :displaybtn="this.allowToAppoint === 1"
                        />
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
<script>
import MentorCard from "../component/MentorComponents/MentorCard.vue";
import Message from "primevue/message";
import { mapState, mapActions } from "vuex";
export default {
    components: {
        MentorCard,
        Message,
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
