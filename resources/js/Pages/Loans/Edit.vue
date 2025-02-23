<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: { AuthenticatedLayout, Head, PrimaryButton, SecondaryButton },
    props: {
        loan: Object,
        permissions: Array,
        users: Array,
        keys: Array,
    },
    setup(props) {
        const form = useForm({
            borrowed_by_user_id: props.loan.borrowed_by_user_id || "",
            given_by_user_id: props.loan.given_by_user_id || "",
            borrowed_key_id: props.loan.borrowed_key_id || "",
            returned_by_user_id: props.loan.returned_by_user_id || "",
            receiver_user_id: props.loan.receiver_user_id || "",
            // Ajuste para input datetime-local: removendo segundos, se necessário
            borrowed_at: props.loan.borrowed_at ? props.loan.borrowed_at.substring(0, 16) : "",
            returned_at: props.loan.returned_at ? props.loan.returned_at.substring(0, 16) : "",
        });

        const submit = () => {
            form.patch(`/loans/${props.loan.id}`, {
                onSuccess: () => {
                    alert("Empréstimo atualizado com sucesso!");
                },
            });
        };

        return { form, submit };
    },
    methods: {
        goBack() {
            this.$inertia.visit('/loans');
        },
    },
};
</script>

<template>
    <Head title="Editar Empréstimo"/>
    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Empréstimos -> Edit
            </h2>
        </template>

        <div class="pt-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">

                            <!-- Usuário que tomou emprestado -->
                            <div>
                                <label for="borrowed_by_user_id" class="block text-sm font-medium text-gray-700">
                                    Usuário que tomou emprestado
                                </label>
                                <select
                                    v-model="form.borrowed_by_user_id"
                                    id="borrowed_by_user_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option disabled value="">Selecione um usuário</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                                <span v-if="form.errors.borrowed_by_user_id" class="text-red-500 text-sm">
                                    {{ form.errors.borrowed_by_user_id }}
                                </span>
                            </div>

                            <!-- Usuário que concedeu o empréstimo -->
                            <div>
                                <label for="given_by_user_id" class="block text-sm font-medium text-gray-700">
                                    Usuário que concedeu o empréstimo
                                </label>
                                <select
                                    v-model="form.given_by_user_id"
                                    id="given_by_user_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option disabled value="">Selecione um usuário</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                                <span v-if="form.errors.given_by_user_id" class="text-red-500 text-sm">
                                    {{ form.errors.given_by_user_id }}
                                </span>
                            </div>

                            <!-- Chave emprestada -->
                            <div>
                                <label for="borrowed_key_id" class="block text-sm font-medium text-gray-700">
                                    Chave emprestada
                                </label>
                                <select
                                    v-model="form.borrowed_key_id"
                                    id="borrowed_key_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option disabled value="">Selecione uma chave</option>
                                    <option v-for="key in keys" :key="key.id" :value="key.id">
                                        {{ key.name || key.id }}
                                    </option>
                                </select>
                                <span v-if="form.errors.borrowed_key_id" class="text-red-500 text-sm">
                                    {{ form.errors.borrowed_key_id }}
                                </span>
                            </div>

                            <!-- Usuário que recebeu a chave (opcional) -->
                            <div>
                                <label for="returned_by_user_id" class="block text-sm font-medium text-gray-700">
                                    Usuário que recebeu a chave (opcional)
                                </label>
                                <select
                                    v-model="form.returned_by_user_id"
                                    id="returned_by_user_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">Nenhum</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                                <span v-if="form.errors.returned_by_user_id" class="text-red-500 text-sm">
                                    {{ form.errors.returned_by_user_id }}
                                </span>
                            </div>

                            <!-- Usuário receptor (opcional) -->
                            <div>
                                <label for="receiver_user_id" class="block text-sm font-medium text-gray-700">
                                    Usuário receptor (opcional)
                                </label>
                                <select
                                    v-model="form.receiver_user_id"
                                    id="receiver_user_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">Nenhum</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                                <span v-if="form.errors.receiver_user_id" class="text-red-500 text-sm">
                                    {{ form.errors.receiver_user_id }}
                                </span>
                            </div>

                            <!-- Data do empréstimo -->
                            <div>
                                <label for="borrowed_at" class="block text-sm font-medium text-gray-700">
                                    Data do empréstimo
                                </label>
                                <input
                                    v-model="form.borrowed_at"
                                    id="borrowed_at"
                                    type="datetime-local"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.borrowed_at" class="text-red-500 text-sm">
                                    {{ form.errors.borrowed_at }}
                                </span>
                            </div>

                            <!-- Data de retorno (opcional) -->
                            <div>
                                <label for="returned_at" class="block text-sm font-medium text-gray-700">
                                    Data de retorno (opcional)
                                </label>
                                <input
                                    v-model="form.returned_at"
                                    id="returned_at"
                                    type="datetime-local"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.returned_at" class="text-red-500 text-sm">
                                    {{ form.errors.returned_at }}
                                </span>
                            </div>

                            <div class="flex justify-end">
                                <SecondaryButton class="mr-2" @click="goBack()">
                                    Voltar
                                </SecondaryButton>

                                <PrimaryButton type="submit">
                                    Salvar Alterações
                                </PrimaryButton>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
