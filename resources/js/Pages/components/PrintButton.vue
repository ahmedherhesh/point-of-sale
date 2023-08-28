<template>
    <div class="mt-5 mb-5 text-center">
        <button class="btn btn-indigo btn-print" @click="printPage">طباعه</button>
    </div>
</template>
<script setup>
const printPage = () => {
    print()
}
</script>