<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, Head, AuthenticatedLayout},
    props: {
        campus: Object,
        permissions: Array,
    },
    methods: {
        goBack() {
            this.$inertia.visit('/campi');
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
                        {{ campus.id }}
                    </div>

                    <div class="p-6 text-gray-900">
                        Nome: {{ campus.nome }}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
