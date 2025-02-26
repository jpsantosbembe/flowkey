<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, Head, AuthenticatedLayout},
    props: {
        guardhouse: Object,
        roles: Array,
        guardhouse_campus: Array,
    },
    data() {
        return {
            openPanels: [0],
        };
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
    <AuthenticatedLayout :roles="roles">

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Campus -> Show
            </h2>
        </template>

        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="flex items-center justify-start mb-6">
                    <PrimaryButton
                        @click="goBack()"
                    >
                        Voltar
                    </PrimaryButton>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <v-expansion-panels
                        v-model="openPanels"
                        multiple
                    >
                        <v-expansion-panel>
                            <v-expansion-panel-title>Informações do Campus</v-expansion-panel-title>

                            <v-expansion-panel-text>
                                <div class="text-gray-900">
                                    ID: {{ guardhouse.id }}
                                </div>

                                <div class="text-gray-900 mt-3">
                                    Nome: {{ guardhouse.name }}
                                </div>
                            </v-expansion-panel-text>
                        </v-expansion-panel>

                        <v-expansion-panel>
                            <v-expansion-panel-title>Campus da guarita</v-expansion-panel-title>
                            <v-expansion-panel-text>
                                    <v-chip
                                        v-for="(campus, index) in guardhouse_campus"
                                        :key="index"
                                        class="m-1"
                                    >
                                        {{ campus.name }}
                                    </v-chip>
                            </v-expansion-panel-text>
                        </v-expansion-panel>
                    </v-expansion-panels>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
