<template>
    <div class="pb-5 flex flex-col">
        <div class="flex items-center gap-2.5">
            <h1 class="text-green-700 font-medium flex items-center gap-1">
                <i class="pi pi-calendar"></i> Available Day for Appointments
            </h1>
            <button
                v-if="!isEdit"
                @click="isEdit = !isEdit"
                class="text-white font-semibold bg-green-600 px-2 py-1 rounded-md"
            >
                <i class="pi pi-wrench"></i>
            </button>
        </div>

        <div
            class="flex justify-around items-center border p-2.5 rounded-md border-gray-200 my-2 gap-3"
            v-if="!isEdit"
        >
            <div class="flex flex-col gap-2.5">
                <div class="flex gap-2.5">
                    <div class="w-fit">
                        <h1 class="text-sm pb-1.5">Start Time</h1>
                        <Calendar
                            id="calendar-timeonly"
                            v-model="currenttimeStart"
                            timeOnly
                            hourFormat="12"
                            class="custom-calendar"
                            placeholder="Select Start Time"
                            disabled
                        />
                    </div>
                    <div class="w-fit">
                        <h1 class="text-sm pb-1.5">End Time</h1>
                        <Calendar
                            id="calendar-timeonly"
                            v-model="currenttimeEnd"
                            timeOnly
                            hourFormat="12"
                            class="custom-calendar"
                            placeholder="Select End Time"
                            disabled
                        />
                    </div>
                </div>
            </div>

            <div
                class="border px-2 py-1 rounded-md bg-white flex items-center justify-center h-10"
                v-for="day in daysOfTheWeek"
                :key="day.id"
                :class="{
                    'border-blue-600  text-blue-600 font-semibold': isActiveDay(
                        day.id
                    ),
                    'border-gray-200': !isActiveDay(day.id),
                }"
            >
                {{ day.name }}
            </div>
        </div>

        <div
            class="flex justify-around items-center border p-2.5 rounded-md border-gray-200 my-2 gap-3"
            v-else
        >
            <div class="flex flex-col gap-2.5">
                <div class="" v-if="errorTime">
                    <Message severity="error" :closable="false"
                        >Please enter a valid date!</Message
                    >
                </div>
                <div class="flex gap-2.5">
                    <div class="w-fit">
                        <h1 class="text-sm pb-1.5">Start Time</h1>
                        <Calendar
                            id="calendar-timeonly"
                            v-model="currenttimeStart"
                            timeOnly
                            hourFormat="12"
                            class="custom-calendar"
                            placeholder="Select Start Time"
                        />
                    </div>
                    <div class="w-fit">
                        <h1 class="text-sm pb-1.5">End Time</h1>
                        <Calendar
                            id="calendar-timeonly"
                            v-model="currenttimeEnd"
                            timeOnly
                            hourFormat="12"
                            class="custom-calendar"
                            placeholder="Select End Time"
                        />
                    </div>
                </div>
            </div>
            <div
                class="border px-2 py-1 rounded-md cursor-pointer"
                v-for="day in daysOfTheWeek"
                :key="day.id"
                :class="{
                    'border-blue-600  text-blue-600 font-semibold': isActiveDay(
                        day.id
                    ),
                    'border-gray-200': !isActiveDay(day.id),
                }"
                @click="toggleDay(day.id)"
            >
                {{ day.name }}
            </div>
            <button
                @click="saveSchedule"
                class="text-white font-semibold bg-green-600 px-4 py-1 rounded-md"
            >
                Save
            </button>
            <button
                @click="cancelEdit"
                class="border border-green-600 font-semibold text-green-600 px-2 py-1 rounded-md"
            >
                <i class="pi pi-times text-sm"></i>
            </button>
        </div>
    </div>
</template>
<script>
import Calendar from "primevue/calendar";
import moment from "moment";
export default {
    components: {
        Calendar,
    },
    data() {
        return {
            moment,
            activeAvailableDays: [],
            editAvailableDays: [],
            daysOfTheWeek: [
                {
                    id: 1,
                    name: "Sun",
                },
                {
                    id: 2,
                    name: "Mon",
                },
                {
                    id: 3,
                    name: "Tue",
                },
                {
                    id: 4,
                    name: "Wed",
                },
                {
                    id: 5,
                    name: "Thu",
                },
                {
                    id: 6,
                    name: "Fri",
                },
                {
                    id: 7,
                    name: "Sat",
                },
            ],
            isEdit: false,
            currenttimeStart: null,
            timeStart: null,
            timeEnd: null,
            currenttimeEnd: null,
            errorTime: false,
        };
    },
    methods: {
        isActiveDay(dayId) {
            return this.editAvailableDays.includes(dayId);
        },

        toggleDay(dayId) {
            if (this.isEdit) {
                if (this.editAvailableDays.includes(dayId)) {
                    this.editAvailableDays = this.editAvailableDays.filter(
                        (id) => id !== dayId
                    );
                } else {
                    this.editAvailableDays.push(dayId);
                }
            }
        },
        cancelEdit() {
            this.currenttimeStart = this.timeStart;
            this.currenttimeEnd = this.timeEnd;
            this.editAvailableDays = [...this.activeAvailableDays];
            if (this.errorTime) {
                this.errorTime = false;
            }
            this.isEdit = !this.isEdit;
        },

        saveSchedule() {
            const {
                activeAvailableDays,
                editAvailableDays,
                currenttimeEnd,
                currenttimeStart,
                timeStart,
                timeEnd,
            } = this;

            if (
                activeAvailableDays.sort().join(",") ===
                    editAvailableDays.sort().join(",") &&
                timeStart ===
                    moment(currenttimeStart, "h:mm A").format("h:mm A") &&
                timeEnd === moment(currenttimeEnd, "h:mm A").format("h:mm A")
            ) {
                this.isEdit = !this.isEdit;
            } else {
                // Only run axios if both timeStartFormatted and timeEndFormatted are valid
                axios
                    .post("/setSchedule", {
                        editAvailableDays,
                        start: moment(currenttimeStart, "h:mm A").format(
                            "h:mm A"
                        ),
                        end: moment(currenttimeEnd, "h:mm A").format("h:mm A"),
                    })
                    .then(({ data }) => {
                        this.$toast.add({
                            severity: "success",
                            summary: "Schedule Updated!",
                            detail: "Schedule succesfully saved!",
                            life: 5000,
                        });
                        this.getLatestSchedule();
                        this.isEdit = !this.isEdit;
                        this.errorTime = false;
                    });
            }
        },
        getLatestSchedule() {
            axios.post("/getLatestSchedule").then(({ data }) => {
                this.timeStart = data.start;
                this.currenttimeStart = this.timeStart;
                this.timeEnd = data.end;
                this.currenttimeEnd = this.timeEnd;
                this.activeAvailableDays = data?.daysOfTheWeek.map((day) =>
                    parseInt(day, 10)
                );
                this.editAvailableDays = [...this.activeAvailableDays];
            });
        },
    },
    mounted() {
        this.getLatestSchedule();
    },
};
</script>
