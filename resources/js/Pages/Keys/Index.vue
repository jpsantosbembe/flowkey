<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    components: {Pagination, Link, SecondaryButton, PrimaryButton, Head, AuthenticatedLayout},
    props: {
        keys: Array,
        roles: Array,
    },
    data() {
        return {
            currentPage: this.keys.current_page,
            totalPages: this.keys.last_page,
        };
    },
    methods: {
        newKeys() {
            this.$inertia.visit(`/keys/create`);
        },
        editKeys(userId) {
            this.$inertia.visit(`/keys/${userId}/edit`);
        },
        showKeys(userId) {
            this.$inertia.visit(`/keys/${userId}`);
        },
        handlePageChange(page) {
            if (page === 1) {
                this.$inertia.get('/keys');
            } else {
                this.$inertia.get(`/keys`, { page });
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
                Keys -> Index
            </h2>
        </template>
        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="flex items-center justify-end mb-2">
                    <PrimaryButton
                        @click="newKeys()"
                    >
                        Nova Chave
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
                                    <th class="text-start">Etiqueta</th>
                                    <th class="text-start">Guarita</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="key in keys.data" :key="key.id">

                                    <td
                                        class="text-start"
                                    >
                                        {{ key.id }}
                                    </td>

                                    <td
                                        class="text-start"
                                    >
                                        {{ key.label }}
                                    </td>

                                    <td
                                        class="text-start"
                                    >
                                        {{ key.guardhouse.name }}
                                    </td>

                                    <td class="text-center">

                                        <Link
                                            class="pr-2 rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                            @click="showKeys(key.id)"
                                        >
                                            Visualizar
                                        </Link>

                                        <Link
                                            class="pr-2 rounded-md text-sm text-gray-600 underline hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                            @click="editKeys(key.id)"
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
                            Exibindo {{ keys.from }} a {{ keys.to }} de {{ keys.total }} usuários.
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
