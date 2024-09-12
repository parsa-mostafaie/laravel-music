<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UsersTable from '@/Components/Tables/UsersTable.vue';
</script>

<template>
    <AppLayout title="Manager">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Manager
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <UsersTable :current-page="$page.props.currentPage" :search="$page.props.search"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
