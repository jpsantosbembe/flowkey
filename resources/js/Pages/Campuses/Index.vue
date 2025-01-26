<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    components: {Pagination, Link, SecondaryButton, PrimaryButton, Head, AuthenticatedLayout},
    props: {
        campuses: Array,
        permissions: Array,
    },
    data() {
        return {
            currentPage: this.campuses.current_page,
            totalPages: this.campuses.last_page,
        };
    },
    methods: {
        newCampus() {
            this.$inertia.visit(`/campuses/create`);
        },
        editCampus(userId) {
            this.$inertia.visit(`/campuses/${userId}/edit`);
        },
        showCampus(userId) {
            this.$inertia.visit(`/campuses/${userId}`);
        },
        handlePageChange(page) {
            if (page === 1) {
                this.$inertia.get('/campuses');
            } else {
                this.$inertia.get(`/campuses`, { page });
            }
        },
    },
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Campi -> Index
            </h2>
        </template>

        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="flex items-center justify-end mb-2">
                    <PrimaryButton
                        @click="newCampus()"
                    >
                        Novo Campus
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
                                <th class="text-start">Nome</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="campus in campuses.data" :key="campus.id">
                                <td class="text-start">
                                    {{ campus.id }}
                                </td>

                                <td class="text-start">
                                    {{ campus.name }}
                                </td>

                                <td class="text-center">
                                    <Link
                                        class="pr-2 rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        @click="showCampus(campus.id)"
                                    >
                                        Visualizar
                                    </Link>

                                    <Link
                                        class="pr-2 rounded-md text-sm text-gray-600 underline hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        @click="editCampus(campus.id)"
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
                            Exibindo {{ campuses.from }} a {{ campuses.to }} de {{ campuses.total }} campi.
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
