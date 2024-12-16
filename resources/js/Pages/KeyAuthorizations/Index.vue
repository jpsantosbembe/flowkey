<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: {Link, SecondaryButton, PrimaryButton, Head, AuthenticatedLayout},
    props: {
        keyAuthorizations: Array,
        permissions: Array,
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
    },
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                KeyAuthorizations -> Index
            </h2>
        </template>
        <div class="py-1">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-end mb-2">
                    <PrimaryButton
                        @click="newKeyAuthorization()"
                    >
                        Nova Autorização
                    </PrimaryButton>
                </div>
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="m-7">
                        <table class="table-auto w-full rounded-lg overflow-hidden">
                            <thead>
                            <tr class=" bg-gray-800 text-white">
                                <th class="px-2">ID</th>
                                <th class="px-2">Nome do Usuario</th>
                                <th class="px-2">Etiqueta da Chave</th>
                                <th class="px-2">Status</th>
                                <th class="px-2">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="keyAuthorization in keyAuthorizations" :key="keyAuthorization.id" class="border">
                                <td class="text-center border">{{ keyAuthorization.id }}</td>
                                <td class="px-2 border">{{ keyAuthorization.user.name }}</td>
                                <td class="px-2 border">{{ keyAuthorization.key.label }}</td>
                                <td class="px-2 border">
                                    <div>
                                        <!-- Checkbox readonly -->
                                        <label>
                                            <input
                                                type="checkbox"
                                                :checked="keyAuthorization.is_active"
                                                disabled
                                            />
                                            {{ keyAuthorization.is_active ? "Ativo" : "Inativo" }}
                                        </label>
                                    </div>
                                </td>
                                <td class="text-center p-2 border">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
