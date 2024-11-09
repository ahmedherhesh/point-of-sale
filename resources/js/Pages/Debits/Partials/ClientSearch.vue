<template>
    <div class="d-flex justify-content-center">
        <AutoComplete class="w-100" v-model="value" dropdown :suggestions="items" @complete="search"
            optionLabel="name" />
    </div>
</template>

<script setup>
import axios from "axios";
import { AutoComplete } from "primevue";
import { ref, watch } from "vue";
const props = defineProps({
    suggestions: Object,
    value: String
})
const emit = defineEmits(["change"]);
const value = ref(props.value);
const items = ref([]);
const suggestions = ref(props.suggestions);
watch(value, (newVal) => {
    emit("change", newVal);
})
const search = (event) => {
    items.value = suggestions.value
        .filter(item => item.name.toLowerCase().includes(event.query.toLowerCase()));
    if (!items.value.length) {
        axios.get(`/clients/?q=${event.query}&output_type=json`)
            .then(res => {
                const newItems = res.data.data.filter(newItem =>
                    !suggestions.value.some(existingItem => existingItem.id === newItem.id)
                );
                suggestions.value = [...suggestions.value, ...newItems];
                items.value = [...items.value, ...newItems];
            })
    }
}
</script>