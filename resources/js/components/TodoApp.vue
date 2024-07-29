<template>
    <div class="todo-app">
      <h1>Todo App</h1>
      <input v-model="newTodo" placeholder="Add a new todo" />
      <button @click="addTodo">Save Todo</button>
      <ul>
        <li v-for="todo in todos" :key="todo.id" class="todo-item">
          <div class="todo-text">
            <span @click="toggleDone(todo.id)" :class="{ done: todo.done }">{{ todo.title }}</span>
          </div>
          <div class="todo-buttons">
            <button class="edit" @click="editTodo(todo.id)">Edit</button>
            <button class="del" @click="deleteTodo(todo.id)">Delete</button>
          </div>
        </li>
      </ul>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';

  const newTodo = ref('');
  const todos = ref([]);

  const fetchTodos = async () => {
    try {
      const response = await axios.get('/api/todos');
      todos.value = response.data.map(todo => ({ ...todo, done: false }));
    } catch (error) {
      console.error('Error fetching todos:', error);
    }
  };

  const addTodo = async () => {
    if (newTodo.value.trim() === '') return;

    try {
      const response = await axios.post('/api/todos', { title: newTodo.value });
      todos.value.push({ ...response.data, done: false });
      newTodo.value = '';
    } catch (error) {
      console.error('Error adding todo:', error);
    }
  };

  const deleteTodo = async (id) => {
    try {
      await axios.delete(`/api/todos/${id}`);
      todos.value = todos.value.filter(todo => todo.id !== id);
    } catch (error) {
      console.error('Error deleting todo:', error);
    }
  };

  const toggleDone = (id) => {
    const todo = todos.value.find(todo => todo.id === id);
    if (todo) {
      todo.done = !todo.done;
    }
  };

  const editTodo = (id) => {
    window.location.href = `/todos/${id}/edit`;
  };

  onMounted(fetchTodos);
  </script>

  <style>
  .todo-app {
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
    padding: 8px 12px;
    font-size: 16px;
    color: green;
  }

  .todo-item {
    list-style-type: none;
    margin: 10px 0;
    padding: 8px;
    cursor: pointer;
    border: 1px solid #ccc;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .todo-text {
    flex: 1;
    text-align: left;
  }

  .todo-buttons {
    display: flex;
    gap: 10px;
  }

  .done {
    text-decoration: line-through;
    cursor: pointer;
  }

  .edit {
    background-color: #007bff;
    color: white;
  }

  .del {
    background-color: red;
    color: white;
  }
  </style>
