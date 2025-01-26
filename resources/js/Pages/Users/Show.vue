<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, Head, AuthenticatedLayout},
    props: {
        users: Object,
        permissions: Array,
    },
    methods: {
        goBack() {
            this.$inertia.visit('/users');
        },
    }
};
</script>

<template>
    <Head title="Dashboard"/>
    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Usuarios -> Show
            </h2>
        </template>

        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="flex items-center justify-start mb-6">
                    <PrimaryButton
                        @click="goBack()">
                        Voltar
                    </PrimaryButton>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="text-gray-900 m-6">
                        ID: {{ users.id }}
                    </div>

                    <div class="text-gray-900 ml-6 mb-6">
                        Nome: {{ users.name }}
                    </div>

                    <div class="text-gray-900 ml-6 mb-6">
                        E-mail: {{ users.email }}
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
