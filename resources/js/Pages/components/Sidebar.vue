<template>
    <aside id="logo-sidebar"
        class="fixed sidebar top-0 right-0 z-40 w-64 h-screen pt-20 shadow transition-transform translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" class="flex items-center gap-3 pb-2">
                        <span class="ml-3">الصفحة الرئيسية</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 pb-2">
                        <span class="flex-1 ml-3 whitespace-nowrap">المنتجات</span>
                        <span
                            class="inline-flex items-center gap-3 justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                    </a>
                </li>

                <li>
                    <Link href="/pos" class="flex items-center gap-3 pb-2">
                        <span class="flex-1 ml-3 whitespace-nowrap">نقطة بيع</span>
                    </Link>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 pb-2">
                        <span class="flex-1 ml-3 whitespace-nowrap">المستخدمين</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>
</template>
<script setup>
    import { Link } from "@inertiajs/vue3";
</script>