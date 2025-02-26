<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: { PrimaryButton, Head, AuthenticatedLayout },
    props: {
        loan: Object,
        roles: Array,
    },
    data() {
        return {
            openPanels: [0],
        };
    },
    methods: {
        goBack() {
            this.$inertia.visit('/loans');
        },
    },
};
</script>

<template>
    <Head title="Detalhes do Empréstimo" />
    <AuthenticatedLayout :roles="roles">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Empréstimos - Detalhes</h2>
        </template>

        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center mb-2">
                    <PrimaryButton @click="goBack()">Voltar</PrimaryButton>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <v-expansion-panels v-model="openPanels" multiple>
                        <v-expansion-panel>
                            <v-expansion-panel-title>Informações do Empréstimo</v-expansion-panel-title>
                            <v-expansion-panel-text>
                                <div class="flex flex-col sm:flex-row">
                                    <div class="flex-1">
                                        <div class="text-gray-900">ID: {{ loan.id }}</div>
                                        <div class="text-gray-900 mt-3">Usuário: {{ loan.borrowed_by?.name || 'N/A' }}</div>
                                        <div class="text-gray-900 mt-3">Chave: {{ loan.key?.label || 'N/A' }}</div>
                                        <div class="text-gray-900 mt-3">Data de Empréstimo: {{ loan.borrowed_at ? new Date(loan.borrowed_at).toLocaleString() : 'N/A' }}</div>
                                    </div>
                                </div>
                            </v-expansion-panel-text>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-title>Responsável pela Entrega</v-expansion-panel-title>
                            <v-expansion-panel-text>
                                <div class="text-gray-900">{{ loan.given_by?.name || 'N/A' }}</div>
                            </v-expansion-panel-text>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-title>Detalhes da Devolução</v-expansion-panel-title>
                            <v-expansion-panel-text>
                                <div class="text-gray-900">Devolvido Por: {{ loan.returned_by?.name || 'N/A' }}</div>
                                <div class="text-gray-900 mt-3">Recebido Por: {{ loan.received_by?.name || 'N/A' }}</div>
                                <div class="text-gray-900 mt-3">Data de Devolução: {{ loan.returned_at ? new Date(loan.returned_at).toLocaleString() : 'Ainda não devolvido' }}</div>
                            </v-expansion-panel-text>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
