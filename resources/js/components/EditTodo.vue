<template>
    <div class="edit-todo">
        <h1>Edit Todo</h1>
        <input v-model="todoTitle" placeholder="Edit todo" />
        <button @click="updateTodo">Save Changes</button>
        <button @click="cancelEdit">Cancel</button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const todoTitle = ref('');
const todoId = document.location.pathname.split('/').slice(-2, -1)[0];

const fetchTodo = async () => {
    try {
        const response = await axios.get(`/api/todos/${todoId}`);
        todoTitle.value = response.data.title;
    } catch (error) {
        console.error('Error fetching todo:', error);
    }
};

const updateTodo = async () => {
    if (todoTitle.value.trim() === '') return;

    try {
        await axios.put(`/api/todos/${todoId}`, { title: todoTitle.value });
        window.location.href = '/';
    } catch (error) {
        console.error('Error updating todo:', error);
    }
};

const cancelEdit = () => {
    window.location.href = '/';
};

onMounted(fetchTodo);
</script>

<style scoped>
.edit-todo {
    text-align: center;
    margin-top: 50px;
    font-family: Arial, Helvetica, sans-serif;
}

input {
    margin-bottom: 10px;
    padding: 8px;
    font-size: 16px;
    width: 70%;
}

button {
    margin-left: 10px;
    padding: 8px 12px;
    font-size: 16px;
    background-color: #218838;
    color: white;
}
</style>
