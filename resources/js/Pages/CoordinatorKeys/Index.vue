<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    components: {Pagination, Link, SecondaryButton, PrimaryButton, Head, AuthenticatedLayout},
    props: {
        coordinatorsKeys: Array,
        roles: Array,
    },
    data() {
        return {
            currentPage: this.coordinatorsKeys.current_page,
            totalPages: this.coordinatorsKeys.last_page,
        };
    },
    methods: {
        newKeyAuthorization() {
            this.$inertia.visit(`/coordinatorkeys/create`);
        },
        editKeyAuthorization(userId) {
            this.$inertia.visit(`/coordinatorkeys/${userId}/edit`);
        },
        showKeyAuthorization(userId) {
            this.$inertia.visit(`/coordinatorkeys/${userId}`);
        },
        handlePageChange(page) {
            if (page === 1) {
                this.$inertia.get('/coordinatorkeys');
            } else {
                this.$inertia.get(`/coordinatorkeys`, { page });
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
                Coordinatorkeys -> Index
            </h2>
        </template>
        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="flex items-center justify-end mb-2">
                    <PrimaryButton
                        @click="newKeyAuthorization()"
                    >
                        Novo Coordenador
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
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>

                            <tbody>

                            <tr v-for="coordinatorsKey in coordinatorsKeys.data" :key="coordinatorsKey.id">

                                <td class="text-start">{{ coordinatorsKey.id }}</td>

                                <td class="text-start">{{ coordinatorsKey.user.name }}</td>

                                <td class="text-start">{{ coordinatorsKey.key.label }}</td>

                                <td class="text-center">

                                    <Link
                                        class="pr-2 rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        @click="showKeyAuthorization(coordinatorsKey.id)"
                                    >
                                        Visualizar
                                    </Link>

                                    <Link
                                        class="pr-2 rounded-md text-sm text-gray-600 underline hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        @click="editKeyAuthorization(coordinatorsKey.id)"
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
                            Exibindo {{ coordinatorsKeys.from }} a {{ coordinatorsKeys.to }} de {{ coordinatorsKeys.total }} usuários.
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
