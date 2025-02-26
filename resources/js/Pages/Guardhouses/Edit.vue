
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: { AuthenticatedLayout, Head, PrimaryButton, SecondaryButton },
    props: {
        guardhouse: Object,
        campuses: Array,
        roles: Array,
    },
    setup(props) {
        const form = useForm({
            name: props.guardhouse.name,
            campus_id: props.guardhouse.campus_id,
        });

        const submit = () => {
            form.patch(`/guardhouses/${props.guardhouse.id}`, {
                onSuccess: () => {
                    alert("Guardhouse atualizada com sucesso!");
                }
            });
        };
        return { form, submit };
    }
}
</script>

<template>
    <Head title="Editar Guardhouse" />

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
                                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                                <input
                                    v-model="form.name"
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                />
                                <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
                            </div>

                            <div>
                                <label for="campus" class="block text-sm font-medium text-gray-700">Campus</label>
                                <select
                                    v-model="form.campus_id"
                                    id="campus"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option v-for="campus in campuses" :key="campus.id" :value="campus.id">
                                        {{ campus.name }}
                                    </option>
                                </select>
                                <span v-if="form.errors.campus_id" class="text-red-500 text-sm">{{ form.errors.campus_id }}</span>
                            </div>

                            <div class="flex justify-end">
                                <SecondaryButton @click="$inertia.visit(route('guardhouses.index'))" class="mr-2">
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
