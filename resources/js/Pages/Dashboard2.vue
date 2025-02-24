<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import _ from "lodash";

export default {
    components: {
        PrimaryButton,
        SecondaryButton,
        AuthenticatedLayout,
        Head,
    },
    props: {
        keys: Array,
        permissions: Array,
    },
    data() {
        return {
            dialog: false,
            selectedKey: null,
            selectedUser: null,
            searchTerm: "",
        };
    },
    computed: {
        activeLoan() {
            if (!this.selectedKey) return null;
            return this.selectedKey.loans.find(
                (loan) => loan.returned_at === null
            );
        },
        activeLoanUser() {
            if (!this.activeLoan || !this.selectedKey) return null;
            if (this.activeLoan.borrowedBy && this.activeLoan.borrowedBy.name) {
                return this.activeLoan.borrowedBy;
            }
            return this.selectedKey.users.find(
                (user) => user.id === this.activeLoan.borrowed_by_user_id
            );
        },
    },
    methods: {
        fetchKeys() {
            this.$inertia.get(route("dashboard"), { search: this.searchTerm }, {
                preserveState: true,
                replace: true,
            });
        },
        isAvailable(key) {
            if (!key || !key.loans) return false; // Adiciona essa verificação
            return key.loans.every((loan) => loan.returned_at !== null);
        },
        openDialog(key) {
            this.selectedKey = key;
            this.selectedUser = null;
            this.dialog = true;
        },
        formatDate(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            const day = date.getDate();
            const month = date.toLocaleString('pt-BR', { month: 'long' });
            const year = date.getFullYear();
            const time = date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
            return `${day} de ${month} de ${year} às ${time}`;
        },
        saveDialog() {
            if (!this.selectedKey) {
                console.error("Nenhuma chave selecionada.");
                return;
            }

            if (this.isAvailable(this.selectedKey)) {
                if (!this.selectedUser) {
                    console.error("Selecione um usuário para emprestar a chave.");
                    return;
                }
                const authUserId = this.$page.props.auth.user.id;
                const payload = {
                    borrowed_by_user_id: this.selectedUser,
                    given_by_user_id: authUserId,
                    borrowed_key_id: this.selectedKey.id,
                    borrowed_at: new Date().toISOString(),
                    returned_at: null,
                    redirect_to: route("dashboard"),
                };

                this.dialog = false;

                this.$inertia.post(route("loans.store"), payload, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.selectedKey = null;
                        this.selectedUser = null;
                    },
                    onError: (errors) => {
                        console.error("Erro ao criar empréstimo:", errors);
                        this.dialog = true;
                    },
                });
            } else {
                const activeLoan = this.activeLoan;
                if (!activeLoan) {
                    console.error("Nenhum empréstimo ativo encontrado para essa chave.");
                    return;
                }
                if (!this.selectedUser) {
                    console.error("Selecione o usuário que está devolvendo a chave.");
                    return;
                }
                const authUserId = this.$page.props.auth.user.id;
                const payload = {
                    returned_at: new Date().toISOString(),
                    returned_by_user_id: this.selectedUser,
                    receiver_user_id: authUserId,
                    redirect_to: route("dashboard"),
                };

                this.dialog = false;

                this.$inertia.patch(route("loans.update", activeLoan.id), payload, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.selectedKey = null;
                        this.selectedUser = null;
                    },
                    onError: (errors) => {
                        console.error("Erro ao atualizar empréstimo:", errors);
                        this.dialog = true;
                    },
                });
            }
        }
    },
    watch: {
        searchTerm: _.debounce(function () {
            this.fetchKeys();
        }, 500)
    }

};
</script>

<template>
    <Head title="Painel - Chaves" />

    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Painel de Controle - Chaves
            </h2>
        </template>

        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <v-container fluid>

                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="searchTerm"
                                        label="Pesquisar chave..."
                                        variant="outlined"
                                        dense
                                        clearable
                                    />
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col
                                    v-for="key in keys"
                                    :key="key.id"
                                    cols="12"
                                    sm="6"
                                    md="4"
                                >
                                    <v-card
                                        variant="elevated"
                                        class="cursor-pointer"
                                        @click="openDialog(key)"
                                    >
                                        <template #title>
                                            <div class="d-flex align-center">
                                                <span class="headline">{{ key.label }}</span>
                                                <v-spacer></v-spacer>
                                                <v-avatar :color="isAvailable(key) ? 'green' : 'red'" size="40">
                                                </v-avatar>
                                            </div>
                                        </template>
                                        <template #text>
                                            {{ key.description }}
                                        </template>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-container>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dialog para Emprestar ou Devolver Chave -->
        <v-dialog v-model="dialog" persistent max-width="500">
            <v-card>
                <v-card-title>
                    {{ isAvailable(selectedKey) ? "Emprestar Chave" : "Devolver Chave" }}
                </v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <!-- Formulário para empréstimo -->
                        <template v-if="isAvailable(selectedKey)">
                            <v-select
                                label="Usuário que está pegando a chave"
                                :items="selectedKey ? selectedKey.users : []"
                                item-title="name"
                                item-value="id"
                                v-model="selectedUser"
                                dense
                                outlined
                            />
                        </template>
                        <!-- Formulário para devolução -->
                        <template v-else>
                            <div v-if="activeLoan">
                                <p>
                                    <strong>Retirado por:</strong>
                                    {{ activeLoanUser ? activeLoanUser.name : '' }}
                                </p>
                                <p>
                                    <strong>Horário da retirada:</strong>
                                    {{ formatDate(activeLoan.borrowed_at) }}
                                </p>
                            </div>
                            <v-select
                                label="Quem está devolvendo a chave"
                                :items="selectedKey ? selectedKey.users : []"
                                item-title="name"
                                item-value="id"
                                v-model="selectedUser"
                                dense
                                outlined
                            />
                        </template>
                    </v-form>
                </v-card-text>
                <v-card-actions class="justify-end">
                    <SecondaryButton @click="dialog = false">
                        Fechar
                    </SecondaryButton>
                    <PrimaryButton @click="saveDialog">
                        Salvar
                    </PrimaryButton>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AuthenticatedLayout>
</template>
