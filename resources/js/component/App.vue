<template>
    <Layout>
        <div class="h-screen w- screen flex items-center justify-center">
            <div class="shadow-lg p-5 rounded-xl">Test</div>
        </div>
    </Layout>
</template>

<script>
import Layout1 from "../Layout/Layout1.vue";

export default {
    components: {
        Layout1,
    },
    data() {
        return {};
    },
    methods: {
        // getter() {
        //     axios.get("/get-students").then(({ data }) => {
        //         console.log(data);
        //         this.students = data;
        //     });
        // },

        checkAuth() {
            axios.get("/checkUser").then(({ data }) => {
                console.log(data);
                if (!data) {
                    this.$router.push("/");
                }
            });
        },
    },

    mounted() {
        // this.getter();
        this.checkAuth();
    },
    watch: {
        authenticated(newValue) {
            if (!newValue) {
                this.$router.push("/login");
            }
        },
    },
};
</script>
