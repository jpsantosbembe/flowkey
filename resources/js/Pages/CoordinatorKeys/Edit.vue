<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: { SecondaryButton, PrimaryButton, Head, AuthenticatedLayout },
    props: {
        coordinatorsKeys: Object,
        users: Array,
        keys: Array,
        permissions: Array,
    },
    methods: {
        goBack() {
            this.$inertia.visit('/coordinatorkeys');
        },
    },
    setup(props) {
        const form = useForm({
            user_id: props.coordinatorsKeys.user_id,
            key_id: props.coordinatorsKeys.key_id,
        });

        const submit = () => {
            form.patch(`/coordinatorkeys/${props.coordinatorsKeys.id}`, {
                onSuccess: () => {
                    alert("Coordinator Keys atualizado com sucesso!");
                },
            });
        };

        return {form, submit};
    },
};
</script>

<template>
    <Head title="Coordinator Keys Authorization"/>

    <AuthenticatedLayout :permissions="permissions">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                CoordinatorKeys -> Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">

                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700">Usuário</label>
                                <select
                                    v-model="form.user_id"
                                    id="user_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option  disabled v-for="user in users" :key="user.id" :value="user.id">
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
