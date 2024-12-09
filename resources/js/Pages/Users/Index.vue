<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

export default {
    components: {Head, AuthenticatedLayout},
    props: {
        users: Array,
    },
    methods: {
        editUser(userId) {
            // Exemplo: Redirecionar para uma rota de edição
            this.$inertia.visit(`/users/${userId}/edit`);
        },
        deleteUser(userId) {
            // Exemplo: Chamar um endpoint para deletar o usuário
            if (confirm("Tem certeza que deseja excluir este usuário?")) {
                this.$inertia.delete(`/users/${userId}`);
            }
        },
        showUser(userId) {
            this.$inertia.visit(`/users/${userId}`);
        }
    },
};

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Usuarios
            </h2>
        </template>,

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="flex justify-end mb-2">
                    <button
                        class = "bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none"
                        @click="showUser(user.id)"
                    >
                        Novo Usuário
                    </button>
                </div>


                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>

                        <table class="table-auto border-collapse border border-gray-300 w-full mx-auto">
                            <thead>
                            <tr>
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Email</th>
                                <th class="border px-4 py-2">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td class="border px-4 py-2">{{ user.id }}</td>
                                <td class="border px-4 py-2">{{ user.name }}</td>
                                <td class="border px-4 py-2">{{ user.email }}</td>
                                <td class="border px-4 py-2">
                                    <button
                                        class = "bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none"
                                        @click="showUser(user.id)"
                                    >
                                        Mostrar
                                    </button>
                                    <button
                                    class = "bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none ml-2"
                                    @click="editUser(user.id)"
                                    >
                                        Editar
                                    </button>
                                    <button
                                        class = "bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 focus:outline-none ml-2"
                                        @click="deleteUser(user.id)"
                                    >
                                        Apagar
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


