<template>
    <div class="flex justify-center mt-4">
        <v-pagination
            :model-value="currentPage"
            :length="totalPages"
            @update:modelValue="onPageChange"
            active-color="#1f2937"
            rounded="circle"
            variant="flat"
            total-visible="5"
        ></v-pagination>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true,
        },
        totalPages: {
            type: Number,
            required: true,
        },
    },
    emits: ["update:currentPage"],
    methods: {
        onPageChange(page) {
            this.$emit("update:currentPage", page);
        },
    },
};
</script>
