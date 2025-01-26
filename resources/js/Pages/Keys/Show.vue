<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, Head, AuthenticatedLayout},
    props: {
        iKey: Object,
        permissions: Array,
        key_coordinators: Array,
        key_users: Array,
    },
    data() {
        return {
            openPanels: [0],
        };
    },
    methods: {
        goBack() {
            this.$inertia.visit('/keys');
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
                            <v-expansion-panel-title>Informações da Chave</v-expansion-panel-title>

                            <v-expansion-panel-text>

                                <div class="flex flex-col sm:flex-row">

                                    <div class="flex-1">
                                        <div class="text-gray-900">
                                            ID: {{ iKey.id }}
                                        </div>

                                        <div class="text-gray-900 mt-3">
                                            Etiqueta: {{ iKey.label }}
                                        </div>

                                        <div class="text-gray-900 mt-3 ">
                                            Descrição: {{ iKey.description }}
                                        </div>
                                    </div>

                                    <div class="flex-1 flex items-center">
                                        <div class="text-gray-900">
                                            Guarita: {{iKey.guardhouse.name}}
                                        </div>
                                    </div>

                                </div>

                            </v-expansion-panel-text>

                        </v-expansion-panel>

                        <v-expansion-panel>
                            <v-expansion-panel-title>Coordenadores Resposaveis</v-expansion-panel-title>

                            <v-expansion-panel-text>
                                <div class="flex"></div>
                                <div class="flex-nowrap">
                                    <v-chip
                                        v-for="(key_coordinator, index) in key_coordinators"
                                        :key="index"
                                        class="m-1"
                                    >
                                        Nome:&nbsp; <strong> {{ key_coordinator.name }} </strong> &nbsp;E-mail:&nbsp; <strong>{{ key_coordinator.email }} </strong>
                                    </v-chip>
                                </div>
                            </v-expansion-panel-text>

                        </v-expansion-panel>

                        <v-expansion-panel>
                            <v-expansion-panel-title>Pessoas Autorizadas</v-expansion-panel-title>

                            <v-expansion-panel-text>
                                <div class="flex"></div>
                                <div class="flex-nowrap">
                                    <v-chip
                                        v-for="(key_user, index) in key_users"
                                        :key="index"
                                        class="m-1"
                                    >
                                        Nome:&nbsp; <strong> {{ key_user.name }} </strong> &nbsp;E-mail:&nbsp; <strong>{{ key_user.email }} </strong>
                                    </v-chip>
                                </div>
                            </v-expansion-panel-text>

                        </v-expansion-panel>

                    </v-expansion-panels>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
