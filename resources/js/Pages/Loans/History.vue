<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import { VTable } from "vuetify/components";

export default {
    components: { Pagination, Head, AuthenticatedLayout, VTable },
    props: {
        events: {
            type: Object,
            default: () => ({
                data: [],
                current_page: 1,
                last_page: 1,
                from: 0,
                to: 0,
                total: 0,
            }),
        },
        permissions: Array,
    },
    data() {
        return {
            currentPage: this.events?.current_page || 1,
            totalPages: this.events?.last_page || 1,
            dialog: false,
            selectedLoan: null,
        };
    },
    computed: {
        // Tenta obter o nome do usuário que pegou a chave usando os dados retornados
        selectedLoanUser() {
            if (!this.selectedLoan) return "Usuário desconhecido";
            // Primeiro, tenta em camelCase
            if (this.selectedLoan.borrowedBy && this.selectedLoan.borrowedBy.name) {
                return this.selectedLoan.borrowedBy.name;
            }
            // Em seguida, tenta em snake_case
            if (this.selectedLoan.borrowed_by && this.selectedLoan.borrowed_by.name) {
                return this.selectedLoan.borrowed_by.name;
            }
            // Se não encontrou, tenta buscar na lista de usuários da chave
            if (
                this.selectedLoan.key &&
                this.selectedLoan.key.users &&
                this.selectedLoan.borrowed_by_user_id
            ) {
                const found = this.selectedLoan.key.users.find(
                    (u) => u.id === this.selectedLoan.borrowed_by_user_id
                );
                if (found && found.name) return found.name;
            }
            return "Usuário desconhecido";
        }
    },
    methods: {
        handlePageChange(page) {
            this.$inertia.get('/history', { page });
        },
        formatDate(date) {
            return date ? new Date(date).toLocaleString() : 'Sem data';
        },
        openDialog(eventItem) {
            this.selectedLoan = eventItem.loan || null;
            this.dialog = true;
        },
        closeDialog() {
            this.dialog = false;
            this.selectedLoan = null;
        }
    },
};
</script>

<template>
    <Head title="Histórico de Empréstimos" />
    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Histórico de Empréstimos
            </h2>
        </template>
        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <VTable height="250px" fixed-header>
                            <thead>
                            <tr>
                                <th class="text-start">Chave</th>
                                <th class="text-start">Evento</th>
                                <th class="text-start">Usuário</th>
                                <th class="text-start">Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr
                                v-for="event in events.data"
                                :key="event.loan_id + '-' + event.type"
                                @click="openDialog(event)"
                                class="cursor-pointer hover:bg-gray-100"
                            >
                                <td class="text-start">{{ event.key || 'Sem chave' }}</td>
                                <td class="text-start">
                                    {{ event.type === 'retirada' ? 'Retirada' : 'Devolução' }}
                                </td>
                                <td class="text-start">{{ event.user || 'Usuário desconhecido' }}</td>
                                <td class="text-start">{{ formatDate(event.timestamp) }}</td>
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
                            Exibindo {{ events.from || 0 }} a {{ events.to || 0 }} de {{ events.total || 0 }} registros.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diálogo com as informações completas do empréstimo -->
        <v-dialog v-model="dialog" max-width="600">
            <v-card>
                <v-card-title class="text-xl font-bold">
                    Detalhes do Empréstimo - ID: {{ selectedLoan?.id || 'N/A' }}
                </v-card-title>
                <v-card-text v-if="selectedLoan">
                    <p><strong>Chave:</strong> {{ selectedLoan.key?.label || 'Sem chave' }}</p>
                    <p>
                        <strong>Tipo:</strong>
                        {{ selectedLoan.returned_at ? 'Devolução' : 'Retirada' }}
                    </p>
                    <p>
                        <strong>Usuário que pegou:</strong>
                        {{ selectedLoan.borrowedBy?.name || selectedLoan.borrowed_by?.name || selectedLoanUser }}
                    </p>
                    <p><strong>Data de Retirada:</strong> {{ formatDate(selectedLoan.borrowed_at) }}</p>
                    <p v-if="selectedLoan.returned_at">
                        <strong>Usuário que devolveu:</strong>
                        {{ selectedLoan.returnedBy?.name || selectedLoan.returned_by?.name || 'Desconhecido' }}
                    </p>
                    <p v-if="selectedLoan.returned_at">
                        <strong>Data de Devolução:</strong> {{ formatDate(selectedLoan.returned_at) }}
                    </p>
                    <p>
                        <strong>Dado por:</strong>
                        {{ selectedLoan.givenBy?.name || selectedLoan.given_by?.name || 'Desconhecido' }}
                    </p>
                    <p v-if="selectedLoan.receivedBy?.name || selectedLoan.received_by?.name">
                        <strong>Recebido por:</strong>
                        {{ selectedLoan.receivedBy?.name || selectedLoan.received_by?.name || 'Desconhecido' }}
                    </p>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn text @click="closeDialog">Fechar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AuthenticatedLayout>
</template>
