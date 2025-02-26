<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    components: {Pagination, Link, SecondaryButton, PrimaryButton, Head, AuthenticatedLayout},
    props: {
        keyAuthorizations: Array,
        roles: Array,
    },
    data() {
        return {
            currentPage: this.keyAuthorizations.current_page,
            totalPages: this.keyAuthorizations.last_page,
        };
    },
    methods: {
        newKeyAuthorization() {
            this.$inertia.visit(`/keyauthorizations/create`);
        },
        editKeyAuthorization(userId) {
            this.$inertia.visit(`/keyauthorizations/${userId}/edit`);
        },
        showKeyAuthorization(userId) {
            this.$inertia.visit(`/keyauthorizations/${userId}`);
        },
        handlePageChange(page) {
            if (page === 1) {
                this.$inertia.get('/keyauthorizations');
            } else {
                this.$inertia.get(`/keyauthorizations`, { page });
            }
        },
    },
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout :roles="roles">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                KeyAuthorizations -> Index
            </h2>
        </template>
        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="flex items-center justify-end mb-2">
                    <PrimaryButton
                        @click="newKeyAuthorization()"
                    >
                        Nova Autorização
                    </PrimaryButton>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">

                    <div class="p-6">

                        <VTable
                            height="250px"
                            fixed-header
                        >

                            <thead>
                                <tr>
                                    <th class="text-start">ID</th>
                                    <th class="text-start">Nome do Usuario</th>
                                    <th class="text-start">Etiqueta da Chave</th>
                                    <th class="text-start">Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>

                            <tbody>

                            <tr v-for="keyAuthorization in keyAuthorizations.data" :key="keyAuthorization.id">

                                <td class="text-start">{{ keyAuthorization.id }}</td>

                                <td class="text-start">{{ keyAuthorization.user.name }}</td>

                                <td class="text-start">{{ keyAuthorization.key.label }}</td>

                                <td class="text-start">
                                    {{ keyAuthorization.is_active ? "Ativo" : "Inativo" }}
                                </td>

                                <td class="text-center">

                                    <Link
                                        class="pr-2 rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        @click="showKeyAuthorization(keyAuthorization.id)"
                                    >
                                        Visualizar
                                    </Link>

                                    <Link
                                        class="pr-2 rounded-md text-sm text-gray-600 underline hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        @click="editKeyAuthorization(keyAuthorization.id)"
                                    >
                                        Editar
                                    </Link>

                                </td>

                            </tr>

                            </tbody>

                        </VTable>

                        <div class="flex justify-center mt-4">
                            <Pagination
                                :currentPage="currentPage"
                                :totalPages="totalPages"
                                @update:currentPage="handlePageChange"
                            />
                        </div>

                        <div class="mt-6 text-sm text-gray-600">
                            Exibindo {{ keyAuthorizations.from }} a {{ keyAuthorizations.to }} de {{ keyAuthorizations.total }} usuários.
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
