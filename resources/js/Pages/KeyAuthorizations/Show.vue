<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, Head, AuthenticatedLayout},
    props: {
        keyAuthorization: Object,
        permissions: Array,
    },
    data() {
        return {
            openPanels: [0],
            isActive: this.keyAuthorization.is_active,
        };
    },
    computed: {
        statusLabel() {
            return this.isActive ? "Ativo" : "Inativo";
        }
    },
    methods: {
        goBack() {
            this.$inertia.visit('/keyauthorizations');
        },
    },
};

</script>

<template>

    <Head title="Dashboard"/>

    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Keys -> Show
            </h2>
        </template>

        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="flex items-center mb-2">

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
                            <v-expansion-panel-title>Informações da autorização</v-expansion-panel-title>

                            <v-expansion-panel-text>

                                <div class="flex flex-col sm:flex-row">

                                    <div class="flex-1">
                                        <div class="text-gray-900">
                                            ID: {{ keyAuthorization.id }}
                                        </div>

                                        <div class="text-gray-900 mt-3">
                                            Nome do usuário: {{ keyAuthorization.user.name }}
                                        </div>

                                        <div class="text-gray-900 mt-3 ">
                                            Descrição da chave: {{ keyAuthorization.key.label }} - {{keyAuthorization.key.description}}
                                        </div>
                                    </div>

                                    <div class="flex-1 flex items-center">
                                        <div class="text-gray-900">
                                            Status da chave:
                                            <v-checkbox
                                                v-model="isActive"
                                                :label="statusLabel"
                                                readonly
                                            >
                                            </v-checkbox>
                                        </div>
                                    </div>

                                </div>

                            </v-expansion-panel-text>

                        </v-expansion-panel>

                    </v-expansion-panels>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
