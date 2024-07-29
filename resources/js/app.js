import { createApp } from 'vue';
import TodoApp from './components/TodoApp.vue';
import EditTodo from './components/EditTodo.vue';

const app = createApp({});

app.component('todo-app', TodoApp);
app.component('edit-todo', EditTodo);

app.mount('#app');
