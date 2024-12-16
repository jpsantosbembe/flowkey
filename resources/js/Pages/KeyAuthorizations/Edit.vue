<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: { SecondaryButton, PrimaryButton, Head, AuthenticatedLayout },
    props: {
        keyAuthorization: Object,
        users: Array,
        keys: Array,
        permissions: Array,
    },
    methods: {
        goBack() {
            this.$inertia.visit('/keyauthorizations');
        },
    },
    setup(props) {
        const form = useForm({
            user_id: props.keyAuthorization.user_id,
            key_id: props.keyAuthorization.key_id,
            is_active: props.keyAuthorization.is_active,
        });

        const submit = () => {
            form.patch(`/keyauthorizations/${props.keyAuthorization.id}`, {
                onSuccess: () => {
                    alert("Key Authorization criado com sucesso!");
                },
            });
        };

        return {form, submit};
    },
};
</script>

<template>
    <Head title="Atualizar Key Authorization"/>

    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Key Authorization -> Create
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Campo Seleção de Usuário -->
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700">Usuário</label>
                                <select
                                    v-model="form.user_id"
                                    id="user_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option disabled value="">Selecione um usuário</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>

                                <span v-if="form.errors.user_id" class="text-red-500 text-sm">{{
                                        form.errors.user_id
                                    }}</span>
                            </div>

                            <div>
                                <label for="key_id" class="block text-sm font-medium text-gray-700">Chave</label>
                                <select
                                    v-model="form.key_id"
                                    id="key_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option disabled value="">Selecione uma chave</option>
                                    <option v-for="key in keys" :key="key.id" :value="key.id">
                                        {{ key.label }} - {{key.description}}
                                    </option>
                                </select>
                                <span v-if="form.errors.key_id" class="text-red-500 text-sm">{{
                                        form.errors.key_id
                                    }}</span>
                            </div>

                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    id="is_active"
                                    v-model="form.is_active"
                                    class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                />
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                    Ativo
                                </label>
                            </div>

                            <!-- Botões -->
                            <div class="flex justify-end">
                                <SecondaryButton class="mr-2" @click="goBack">
                                    Voltar
                                </SecondaryButton>
                                <PrimaryButton type="submit">Atualizar</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
