<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">List of Users</h1>
        <table class="table-auto border-collapse border border-gray-300 w-full">
            <thead>
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td class="border px-4 py-2">{{ user.id }}</td>
                <td class="border px-4 py-2">{{ user.name }}</td>
                <td class="border px-4 py-2">{{ user.email }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        users: Array, // Recebe os dados dos usuários do servidor
    },
};
</script>
