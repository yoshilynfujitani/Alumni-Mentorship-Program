<template>
    <div v-if="!activeCourses">Loading</div>
    <div class="pb-5" v-else>
        <div class="flex items-center gap-2.5 my-2.5">
            <h1 class="text-green-700 font-medium flex items-center gap-1">
                <i class="pi pi-building"></i> Preferred Field for Appointments
            </h1>
            <div v-if="!isEditCourses">
                <button
                    @click="isEditCourses = !isEditCourses"
                    class="text-white font-semibold bg-green-600 px-2 py-1 rounded-md"
                >
                    <i class="pi pi-wrench"></i>
                </button>
            </div>
        </div>
        <div
            class="flex gap-x-2 flex-wrap border border-gray-200 rounded-md px-5 py-2.5"
        >
            <div v-for="course in selectedCourses" :key="course?.id" class="">
                <div
                    class="px-2 py-1 my-1.5 rounded-md flex items-center gap-1 font-semibold border border-gray-300"
                >
                    {{ course?.name }}
                    <i
                        class="pi pi-times cursor-pointer text-xs font-bold text-red-500"
                        :class="{ hidden: !isEditCourses }"
                        @click="toggleCourse(course)"
                    ></i>
                </div>
            </div>
            <br />
        </div>
        <div class="" v-if="isEditCourses">
            <div>
                <h1 class="font-semibold">Available Fields</h1>
                <div
                    class="flex flex-wrap border my-2.5 p-2.5 border-gray-200 rounded-md"
                    v-if="!allCoursesSelected"
                >
                    <div
                        v-for="course in availableCourses"
                        :key="course?.id"
                        class=""
                    >
                        <button
                            @click="toggleCourse(course)"
                            class="px-2 py-1 my-1.5 rounded-md flex items-center gap-1 font-semibold border border-gray-300"
                            :class="{
                                hidden: isActive(course),
                                'mr-2': !isActive(course),
                            }"
                        >
                            {{ course?.name }}
                        </button>
                    </div>
                </div>
                <div v-else>
                    <div
                        class="flex justify-center border my-2.5 p-2.5 border-gray-200 rounded-md text-center w-full"
                    >
                        <h1 class="font-bold">No available courses</h1>
                    </div>
                </div>
                <div class="space-x-2">
                    <button
                        @click="saveCourses"
                        class="text-white font-semibold bg-green-600 px-4 py-1 rounded-md"
                    >
                        Save Courses
                    </button>
                    <button
                        @click="cancelEditCourses"
                        class="font-bold border px-4 py-1 rounded-md"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            availableCourses: null,
            selectedCourses: [],
            activeCourses: [],
            isEditCourses: false,
        };
    },
    computed: {
        allCoursesSelected() {
            return (
                this.availableCourses &&
                this.selectedCourses.length === this.availableCourses.length
            );
        },
    },
    methods: {
        cancelEditCourses() {
            this.selectedCourses = [...this.activeCourses];
            this.isEditCourses = !this.isEditCourses;
        },
        toggleCourse(course) {
            if (course && course.id) {
                const index = this.selectedCourses?.findIndex(
                    (c) => c.id === course.id
                );
                if (index === -1) {
                    // Course not found in selectedCourses, add it
                    this.selectedCourses.push(course);
                } else {
                    // Course found in selectedCourses, remove it
                    this.selectedCourses.splice(index, 1);
                }
            } else {
                console.error("Course or course id is undefined or null.");
            }
        },
        isActive(course) {
            return this.selectedCourses?.some((c) => c?.id === course?.id);
        },
        saveCourses() {
            const CourseId = this.selectedCourses.map((course) => course.id);
            const FieldId = CourseId.join(",");

            axios
                .post("/updatefield", { FieldId: FieldId })
                .then((data) => {
                    this.getField();
                    this.isEditCourses = !this.isEditCourses;
                })
                .catch((error) => {
                    console.error("Error saving courses:", error);
                });
        },
        getFields() {
            axios.post("/getfields").then(({ data }) => {
                this.availableCourses = data;
            });
        },
        getField() {
            axios
                .get("/getfield")
                .then((data) => {
                    if (!data.data || data.data.length === 0) {
                        // If the response data is empty, set activeCourses and selectedCourses to an empty array
                        this.activeCourses = [];
                        this.selectedCourses = [];
                    } else {
                        // Split the response data and map each course ID to its corresponding name
                        const idStrings = data.data.toString().split(",");
                        this.activeCourses = idStrings.map((courseId) => {
                            return this.availableCourses?.find(
                                (course) => course.id === parseInt(courseId, 10)
                            );
                        });
                        this.selectedCourses = [...this.activeCourses];
                    }
                })
                .catch((error) => {
                    // Handle error
                    console.error("Error saving courses:", error);
                });
        },

        compareEditandActiveCourses() {
            const { selectedCourses, availableCourses } = this;
            var objectsAreSame = true;
            for (var propertyName in selectedCourses) {
                if (
                    selectedCourses[propertyName] ===
                    availableCourses[propertyName]
                ) {
                    objectsAreSame = false;
                    break;
                }
            }
            return objectsAreSame;
        },
    },
    mounted() {
        this.getFields();
        this.getField();
    },
};
</script>
