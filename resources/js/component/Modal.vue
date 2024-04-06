<template>
    <div class="">
        <div class="flex justify-center cursor-auto">
            <button
                @click="modalopened"
                class="transition-all px-4 py-2 rounded-md text-white text-sm"
                type="button"
                :disabled="modalContent.disablebtn"
                :class="{
                    'bg-green-500 hover:bg-green-600': !type,
                    'bg-blue-500 hover:bg-blue-600': type === 'rate',
                    'cursor-not-allowed': modalContent.disablebtn,
                    'bg-yellow-300 hover:bg-yellow-400': type === 'edit',
                }"
            >
                <span v-if="buttonLabel">{{ buttonLabel }}</span>
                <div class="flex items-center gap-1">
                    <component
                        :is="buttonIcon"
                        v-if="buttonIcon"
                        class="text-xl"
                    />
                    <h1>{{ iconLabel }}</h1>
                </div>
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
                            :disabled="modalContent.disableSaveBtn"
                            v-if="saveLabel"
                            @click="saveData"
                            class="px-4 py-2 ml-2 text-white bg-green-600 rounded-md text-sm"
                            :class="{
                                'cursor-not-allowed':
                                    modalContent.disableSaveBtn,
                            }"
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
import { AkChatDots } from "@kalimahapps/vue-icons";
import { FlFilledPersonStar } from "@kalimahapps/vue-icons";
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
        iconLabel: {
            type: String,
        },
        color: {
            type: String,
        },
    },
    components: {
        FlPeopleSettings,
        AkChatDots,
        FlFilledPersonStar,
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
        modalopened() {
            this.isOpen = true;
            this.$emit("modalopen");
        },
    },
    mounted() {},
};
</script>
