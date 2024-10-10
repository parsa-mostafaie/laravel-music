<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TracksTable from '@/Components/Tables/TracksTable.vue';
</script>

<template>
    <AppLayout title="Tracks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Manager
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <TracksTable :current-page="$page.props.currentPage" :search="$page.props.search" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
