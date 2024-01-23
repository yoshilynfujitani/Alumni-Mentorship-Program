<template>
    <div class="">
        <div class="flex justify-center">
            <button
                @click="isOpen = true"
                class="transition-all bg-green-500 px-3 py-2 rounded-md text-white my-4 text-sm hover:bg-green-600"
                type="button"
                :class="{
                    'cursor-not-allowed': modalContent.disablebtn,
                    'bg-yellow-300 hover:bg-yellow-400': type === 'edit',
                }"
            >
                <span v-if="buttonLabel">{{ buttonLabel }}</span>
                <component :is="buttonIcon" v-if="buttonIcon" class="text-xl" />
            </button>

            <div
                v-if="isOpen"
                class="fixed inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50 z-50 min-h-screen"
            >
                <div class="p-6 bg-white rounded-md shadow-xl min-w-[400px]">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl">{{ modalContent.title }}</h3>
                    </div>
                    <div class="mt-4">
                        <p class="mb-4 text-sm">
                            {{ modalContent.content }}
                        </p>
                        <slot />
                        <button
                            @click="isOpen = false"
                            class="px-4 py-2 text-green-800 border border-green-600 rounded-md text-sm"
                        >
                            {{ cancelLabel }}
                        </button>
                        <button
                            v-if="saveLabel"
                            @click="saveData"
                            class="px-4 py-2 ml-2 text-white bg-green-600 rounded-md text-sm"
                        >
                            {{ saveLabel }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { FlPeopleSettings } from "@kalimahapps/vue-icons";
export default {
    props: {
        modalContent: {
            type: Object,
            required: true,
        },
        buttonLabel: {
            type: String,
        },
        buttonIcon: {},
        cancelLabel: {
            type: String,
            default: "Cancel",
        },
        saveLabel: {
            type: String,
        },
        saveOption: {
            type: Boolean,
        },
        type: {
            type: String,
        },
    },
    components: {
        FlPeopleSettings,
    },
    data() {
        return {
            isOpen: false,
        };
    },
    methods: {
        saveData() {
            this.$emit("save");

            if (this.saveOption) {
                this.isOpen = false;
            }
        },
    },
};
</script>
