<template lang="">
    <Layout>
        <h1>Mentors</h1>
        <div class="grid grid-cols-4 gap-5 mx-auto my-10">
            <div class="mx-auto" v-for="Mentor in mentors">
                <MentorCard :MentorDetails="Mentor" />
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
        };
    },
    methods: {
        getMentors() {
            const fetchby = "all";
            axios.post("/getmentorAPI", { fetchby }).then(({ data }) => {
                this.mentors = data;
            });
        },
    },
    mounted() {
        this.getMentors();
    },
};
</script>
<style lang=""></style>
