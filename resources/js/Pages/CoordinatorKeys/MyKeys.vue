<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import _ from "lodash";
import Pagination from "@/Components/Pagination.vue";

export default {
    components: {
        AuthenticatedLayout,
        Head,
        Pagination,
    },
    props: {
        coordinatorKeys: Object,
        roles: Array,
    },
    data() {
        return {
            searchTerm: "",
            currentPage: this.coordinatorKeys.current_page,
            totalPages: this.coordinatorKeys.last_page,
            showDialog: false,
            selectedKey: null,
            userSearchTerm: "", // For searching users in the dialog
            userSearchResults: [], // To store the search results
            loading: false // To show loading state during search
        };
    },
    methods: {
        changePage(page) {
            if (this.currentPage === page) return;
            this.currentPage = page;
            this.$inertia.get(route("coordinatorkeys.mykeys"), {
                search: this.searchTerm,
                page: this.currentPage,
            }, {
                preserveState: true,
                replace: true,
            });
        },
        fetchKeys() {
            this.$inertia.get(route("coordinatorkeys.mykeys"), { search: this.searchTerm }, {
                preserveState: true,
                replace: true,
            });
        },
        openDialog(key) {
            this.selectedKey = key;
            this.showDialog = true;
        },
        closeDialog() {
            this.showDialog = false;
            this.selectedKey = null;
            this.userSearchTerm = "";
            this.userSearchResults = [];
        },
        searchUsers: _.debounce(function() {
            if (!this.userSearchTerm || this.userSearchTerm.length < 2) {
                this.userSearchResults = [];
                return;
            }

            this.loading = true;

            axios.get(route('coordinatorkeys.search-users'), {
                params: { query: this.userSearchTerm }
            }).then(response => {
                this.userSearchResults = response.data;
            }).catch(error => {
                console.error('Error searching users:', error);
            }).finally(() => {
                this.loading = false;
            });
        }, 300),
        addAuthorization(user) {
            if (!this.selectedKey) return;

            axios.post(route('coordinatorkeys.add-authorization'), {
                user_id: user.id,
                key_id: this.selectedKey.key.id,
            }).then(() => {
                this.selectedKey.key.authorizations.push({
                    user: user,
                    is_active: true,
                });
            }).catch(error => {
                console.error('Erro ao adicionar autorização:', error);
            });
        },

        removeAuthorization(authorization) {
            axios.delete(route('coordinatorkeys.remove-authorization', { authorization: authorization.id }))
                .then(() => {
                    authorization.is_active = false;
                })
                .catch(error => {
                    console.error('Erro ao remover autorização:', error);
                });
        },
    },
    watch: {
        searchTerm: _.debounce(function () {
            this.fetchKeys();
        }, 500)
    }
};
</script>

<template>
    <Head title="Minhas Chaves" />

    <AuthenticatedLayout :roles="roles">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Minhas Chaves
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
                                <!-- Itera sobre os registros de CoordinatorsKeys e exibe os dados da chave associada -->
                                <v-col v-for="coordinatorKey in coordinatorKeys.data" :key="coordinatorKey.id" cols="12" sm="6" md="4">
                                    <v-card variant="elevated">
                                        <template #title>
                                            <div class="d-flex align-center">
                                                <span class="headline">{{ coordinatorKey.key.label }}</span>
                                            </div>
                                        </template>
                                        <template #text>
                                            {{ coordinatorKey.key.description }}
                                            <!-- Botão Gerenciar Acessos com evento de clique -->
                                            <div class="mt-3">
                                                <v-btn
                                                    block
                                                    variant="tonal"
                                                    density="compact"
                                                    @click="openDialog(coordinatorKey)"
                                                >
                                                    Gerenciar Acessos
                                                </v-btn>
                                            </div>
                                        </template>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-container>

                        <div class="flex justify-center mt-4">
                            <Pagination
                                :currentPage="currentPage"
                                :totalPages="totalPages"
                                @update:currentPage="changePage"
                            />
                        </div>

                        <div class="mt-6 text-sm text-gray-600">
                            Exibindo {{ coordinatorKeys.from }} a {{ coordinatorKeys.to }} de {{ coordinatorKeys.total }} chaves.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diálogo de Gerenciamento de Acessos -->
        <!-- Diálogo de Gerenciamento de Acessos -->
        <v-dialog v-model="showDialog" max-width="500px">
            <v-card>
                <v-toolbar>
                    <v-toolbar-title>Gerenciar Acessos</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>

                <v-card-text class="pt-4">
                    <v-text-field
                        v-model="userSearchTerm"
                        label="Adicionar pessoa..."
                        variant="outlined"
                        density="compact"
                        clearable
                        prepend-inner-icon="mdi-magnify"
                        class="mb-2"
                        @input="searchUsers"
                        :loading="loading"
                    />

                    <!-- Resultados da pesquisa -->
                    <div v-if="userSearchResults.length > 0" class="mb-4">
                        <div class="text-subtitle-1 font-weight-medium mb-2">Resultados da pesquisa:</div>
                        <v-list select-strategy="leaf">
                            <v-list-item
                                v-for="user in userSearchResults"
                                :key="user.id"
                                active-class="text-pink"
                                class="py-2"
                                rounded="lg"
                                @click="addAuthorization(user)"
                            >
                                <v-list-item-title>{{ user.name }}</v-list-item-title>
                                <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>

                                <template v-slot:append>
                                    <v-btn icon="mdi-plus" variant="text" density="comfortable" color="primary"></v-btn>
                                </template>
                            </v-list-item>
                        </v-list>
                    </div>

                    <div class="text-subtitle-1 font-weight-medium mb-2">Pessoas autorizadas:</div>

                    <v-list v-if="selectedKey && selectedKey.key.authorizations.length" select-strategy="leaf">
                        <v-list-item
                            v-for="authorization in selectedKey.key.authorizations"
                            :key="authorization.id"
                            class="py-2"
                            rounded="lg"
                        >
                            <v-list-item-title>{{ authorization.user.name }}</v-list-item-title>
                            <v-list-item-subtitle v-if="authorization.user.email">{{ authorization.user.email }}</v-list-item-subtitle>

                            <template v-slot:append>
                                <v-btn
                                    v-if="authorization.is_active"
                                    icon="mdi-delete"
                                    variant="text"
                                    density="comfortable"
                                    color="grey"
                                    @click="removeAuthorization(authorization)"
                                ></v-btn>
                                <v-btn
                                    v-else
                                    icon="mdi-undo"
                                    variant="text"
                                    density="comfortable"
                                    color="green"
                                    @click="addAuthorization(authorization.user)"
                                ></v-btn>
                            </template>
                        </v-list-item>
                    </v-list>

                    <div v-else class="py-4 text-center text-body-1 text-grey">
                        Nenhum usuário autorizado.
                    </div>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn variant="text" @click="closeDialog">Fechar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AuthenticatedLayout>
</template>
