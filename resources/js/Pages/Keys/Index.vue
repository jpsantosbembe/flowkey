<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: {Link, SecondaryButton, PrimaryButton, Head, AuthenticatedLayout},
    props: {
        keys: Array,
        permissions: Array,
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
                Keys -> Index
            </h2>
        </template>
        <div class="py-1">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-end mb-2">
                    <PrimaryButton
                        @click="newKeys()"
                    >
                        Nova Chave
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
                                <th class="px-2">Etiqueta</th>
                                <th class="px-2">Guarita</th>
                                <th class="px-2">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="key in keys" :key="key.id" class="border">
                                <td class="text-center border">{{ key.id }}</td>
                                <td class="px-2 border">{{ key.label }}</td>
                                <td class="px-2 border">{{ key.guardhouse.name }}</td>
                                <td class="text-center p-2 border">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
