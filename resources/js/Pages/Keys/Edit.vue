
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: { AuthenticatedLayout, Head, PrimaryButton, SecondaryButton },
    props: {
        iKey: Object,
        guardhouses: Array,
        roles: Array,
    },
    setup(props) {
        const form = useForm({
            label: props.iKey.label,
            description: props.iKey.description,
            guardhouse_id: props.iKey.guardhouse_id,
        });

        const submit = () => {
            form.patch(`/keys/${props.iKey.id}`, {
                onSuccess: () => {
                    alert("Keys atualizada com sucesso!");
                }
            });
        };
        return { form, submit };
    }
}
</script>

<template>
    <Head title="Editar Key" />

    <AuthenticatedLayout :roles="roles">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Guardhouses -> Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Etiqueta</label>
                                <input
                                    v-model="form.label"
                                    id="label"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.label" class="text-red-500 text-sm">{{ form.errors.label }}</span>
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Descrição</label>
                                <input
                                    v-model="form.description"
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</span>
                            </div>

                            <div>
                                <label for="campus" class="block text-sm font-medium text-gray-700">Campus</label>
                                <select
                                    v-model="form.guardhouse_id"
                                    id="guardhouse_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option v-for="guardhouse in guardhouses" :key="guardhouse.id" :value="guardhouse.id">
                                        {{ guardhouse.name }}
                                    </option>
                                </select>
                                <span v-if="form.errors.guardhouse_id" class="text-red-500 text-sm">{{ form.errors.guardhouse_id }}</span>
                            </div>



                            <div class="flex justify-end">
                                <SecondaryButton @click="$inertia.visit(route('keys.index'))" class="mr-2">
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
