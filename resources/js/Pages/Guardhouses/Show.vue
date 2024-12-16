<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, Head, AuthenticatedLayout},
    props: {
        guardhouse: Object,
        permissions: Array,
    },
    methods: {
        goBack() {
            this.$inertia.visit('/guardhouses');
        },
    },
};

</script>

<template>

    <Head title="Dashboard"/>

    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Campus -> Show
            </h2>
        </template>
        ,

        <div class="py-1">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="flex items-center mb-2">

                    <PrimaryButton
                        @click="goBack()"
                    >
                        Voltar
                    </PrimaryButton>
                </div>

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>

                    <div class="p-6 text-gray-900">
                        {{ guardhouse.id }}
                    </div>

                    <div class="p-6 text-gray-900">
                        Nome: {{ guardhouse.name }}
                    </div>
                    <div class="p-6 text-gray-900">
                        Guarita: {{ guardhouse.campus.name }}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
