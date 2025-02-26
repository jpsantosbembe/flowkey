<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Pagination from "@/Components/Pagination.vue";

export default {
    components: { Pagination, Link, SecondaryButton, PrimaryButton, Head, AuthenticatedLayout },
    props: {
        loans: Object,
        roles: Array,
    },
    data() {
        return {
            currentPage: this.loans?.current_page || 1,
            totalPages: this.loans?.last_page || 1,
        };
    },
    methods: {
        newLoan() {
            this.$inertia.visit(`/loans/create`);
        },
        editLoan(loanId) {
            this.$inertia.visit(`/loans/${loanId}/edit`);
        },
        showLoan(loanId) {
            this.$inertia.visit(`/loans/${loanId}`);
        },
        handlePageChange(page) {
            this.$inertia.get('/loans', { page });
        },
    },
};
</script>

<template>
    <Head title="Empréstimos" />
    <AuthenticatedLayout :roles="roles">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Empréstimos - Gestão</h2>
        </template>
        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-end mb-2">
                    <PrimaryButton @click="newLoan()">Novo Empréstimo</PrimaryButton>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <VTable height="250px" fixed-header >
                            <thead>
                            <tr>
                                <th class="text-start">ID</th>
                                <th class="text-start">Chave</th>
                                <th class="text-start">Retirado Por</th>
                                <th class="text-start">Retirado Em</th>
                                <th class="text-start">Devolvido Em</th>
                                <th class="text-start">Devolvido Por</th>
                                <th class="text-start">Entregue Por</th>
                                <th class="text-start">Recebido Por</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="loan in loans.data" :key="loan.id">
                                <td class="text-start">{{ loan.id }}</td>
                                <td class="text-start">{{ loan.key?.label || 'N/A' }}</td>
                                <td class="text-start">{{ loan.borrowed_by?.name || 'N/A' }}</td>
                                <td class="text-start">{{ loan.borrowed_at ? new Date(loan.borrowed_at).toLocaleString() : 'N/A' }}</td>
                                <td class="text-start">{{ loan.returned_at ? new Date(loan.returned_at).toLocaleString() : 'N/A' }}</td>
                                <td class="text-start">{{ loan.returned_by?.name || 'N/A' }}</td>
                                <td class="text-start">{{ loan.given_by?.name || 'N/A' }}</td>
                                <td class="text-start">{{ loan.received_by?.name || 'N/A' }}</td>

                                <td class="text-center">
                                    <Link class="pr-2 text-gray-600 underline hover:text-gray-900" @click="showLoan(loan.id)">Visualizar</Link>
                                    <Link class="pr-2 text-blue-600 underline hover:text-blue-900" @click="editLoan(loan.id)">Editar</Link>
                                </td>
                            </tr>
                            </tbody>
                        </VTable>
                        <div class="flex justify-center mt-4">
                            <Pagination :currentPage="currentPage" :totalPages="totalPages" @update:currentPage="handlePageChange" />
                        </div>
                        <div class="mt-6 text-sm text-gray-600">
                            Exibindo {{ loans.from }} a {{ loans.to }} de {{ loans.total }} empréstimos.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
