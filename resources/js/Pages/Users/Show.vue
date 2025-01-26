<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

export default {
    components: {PrimaryButton, Head, AuthenticatedLayout},
    props: {
        users: Object,
        permissions: Array,
        user_roles: Array,
        user_permissions: Array,
    },
    data() {
        return {
            openPanels: [0],
        };
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

                    <v-expansion-panels
                        v-model="openPanels"
                        multiple
                    >
                        <v-expansion-panel>
                            <v-expansion-panel-title>Informações Cadastrais</v-expansion-panel-title>

                            <v-expansion-panel-text>

                                <div class="text-gray-900">
                                    ID: {{ users.id }}
                                </div>

                                <div class="text-gray-900 mt-3">
                                    Nome: {{ users.name }}
                                </div>

                                <div class="text-gray-900 mt-3">
                                    E-mail: {{ users.email }}
                                </div>

                            </v-expansion-panel-text>

                        </v-expansion-panel>

                        <v-expansion-panel>
                            <v-expansion-panel-title>Papéis do usuário no sistema</v-expansion-panel-title>

                            <v-expansion-panel-text>
                                <div class="flex"></div>
                                <div class="flex-nowrap">
                                    <v-chip
                                        v-for="(role, index) in user_roles"
                                        :key="index"
                                        class="m-1"
                                    >
                                        {{ role }}
                                    </v-chip>
                                </div>
                            </v-expansion-panel-text>

                        </v-expansion-panel>

                        <v-expansion-panel>
                            <v-expansion-panel-title>Permissões do usuario no sistema</v-expansion-panel-title>

                            <v-expansion-panel-text>
                                <div class="flex"></div>
                                <div class="flex-nowrap">
                                    <v-chip
                                        v-for="(permission, index) in user_permissions"
                                        :key="index"
                                        class="m-1"
                                    >
                                        {{ permission }}
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
