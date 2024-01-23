<template lang="">
    <Modal
        :modalContent="{
            title: 'Appointment Details',

            // content: 'Please fill out the form below:',
        }"
        type="edit"
        buttonIcon="FlPeopleSettings"
        cancelLabel="Back"
        :saveOption="false"
    >
        <div class="flex flex-col items-start w-full py-5">
            <div
                class="grid grid-cols-2 content-between text-start w-full my-5"
            >
                <div class="">
                    <h1 class="font-medium">Student's Name</h1>
                    <p>{{ this.requestDetails.name }}</p>
                </div>
                <div class="">
                    <h1 class="font-medium">Student's Course</h1>
                    <p>{{ this.requestDetails.course }}</p>
                </div>
            </div>
            <h1 class="font-medium">Start Date</h1>
            <p>
                {{ this.date }}
                <span
                    class="text-green-500 font-medium"
                    :class="{
                        'text-red-400': startSchedule.isBefore(now),
                    }"
                >
                    <span v-if="startSchedule.isBefore(now)"
                        >Started {{ reminderdate }}
                    </span>
                    <span v-else>To start in {{ reminderdate }} </span>
                </span>
            </p>
        </div>
    </Modal>
</template>
<script>
import Modal from "../Modal.vue";
import moment from "moment";

export default {
    props: ["requestDetails"],
    components: {
        Modal,
    },
    data() {
        const startSchedule = moment(this.requestDetails.startSchedule);
        const now = moment();
        return {
            date: moment(this.requestDetails.startSchedule).format(
                "YYYY-MM-DD"
            ),
        };
    },
    computed: {
        startSchedule() {
            return moment(this.requestDetails.startSchedule);
        },
        now() {
            return moment();
        },
        reminderdate() {
            return this.startSchedule.isBefore(this.now)
                ? this.startSchedule.fromNow()
                : this.startSchedule.toNow(true);
        },
    },
    methods: {},
};
</script>
<style lang=""></style>
