<script setup lang="ts">
    import Container from '@/components/Container.vue';
    import SelectInput from '@/components/SelectInput.vue';
    import AppLayout from '@/layouts/AppLayout.vue';
    import { debounce, randomString } from '@/lib/utils';
    import { create as createProject, show as showProject } from '@/routes/projects';
    import { destroy as destroyTask, prioritize as prioritizeTasks, store as storeTask, update as updateTask } from '@/routes/tasks';
    import { Project, Task, TaskStatus } from '@/types';
    import { Head, router, usePage } from '@inertiajs/vue3';
    import axios, { AxiosResponse } from 'axios';
    import { nextTick, ref, watch } from 'vue';
    import draggable from 'vuedraggable';

    interface PendingTask extends Omit<Task, 'id'> {
        id: number|string;
    };

    const props = defineProps<{
        project: Project;
        projects: Project[];
        tasks: Task[];
        taskStatuses: TaskStatus[];
    }>();

    const root = ref<HTMLDivElement>();

    const selectedProjectSlug = ref<string>(props.project.slug);
    watch(selectedProjectSlug, (slug) => {
        if (parseInt(slug) === 0) { // This is the "status code" for creating a new project.
            return router.visit(createProject.url());
        }

        return router.visit(showProject.url(slug));
    });
    const mutableTasks = ref<(PendingTask|Task)[]>(props.tasks);

    const defaultTask = (taskStatus: TaskStatus): PendingTask => {
        return {
            id: randomString(),
            project_id: props.project.id,
            task_status_id: taskStatus.id,
            user_id: usePage().props.auth.user.id,
            title: 'Untitled Task',
            content: '',
            priority: 0,
            created_at: '',
            updated_at: '',
        };
    };

    const addTask = async (taskStatus: TaskStatus) => {
        const task = defaultTask(taskStatus);
        mutableTasks.value.push(task);
        await nextTick();
        const input = root.value?.querySelector(`li[data-id="${task.id}"] input`) as HTMLInputElement|undefined;
        // input?.focus();
        input?.select();

        axios.post(storeTask.url(selectedProjectSlug.value), task)
            .then((response: AxiosResponse<Task>) => {
                const index = mutableTasks.value.findIndex(t => t.id === task.id);
                mutableTasks.value[index].id = response.data.id;
            })
            .catch(err => console.error(err.response?.data || err));
    };

    const editingStatusOf = ref<number|string>();

    const updateStatus = (task: PendingTask|Task, status: TaskStatus) => {
        task.task_status_id = status.id;
        editingStatusOf.value = undefined;
        onUpdateTask(task);
    };

    const onUpdateTask = (task: PendingTask|Task) => {
        axios.patch(updateTask.url({ project: selectedProjectSlug.value, task: task.id }), task)
            .then((response: AxiosResponse<Task>) => {
                const index = mutableTasks.value.findIndex(t => t.id === task.id);
                mutableTasks.value[index] = response.data;
            })
            .catch(err => console.error(err.response?.data || err));
    };
    const onUpdateTaskDebounced = debounce(onUpdateTask);

    const onTaskTitleInput = (task: PendingTask|Task) => onUpdateTaskDebounced(task);

    const isInStatus = (task: PendingTask|Task, status: TaskStatus): boolean => {
        return task.task_status_id === status.id;
    };

    const tasksInStatus = (status: TaskStatus) => {
        return mutableTasks.value.filter(task => task.task_status_id === status.id);
    };

    const onTaskPrioritiesChanged = (taskStatus: TaskStatus) => {
        const data = tasksInStatus(taskStatus).map((task, index) => {
            return { [task.id]: index };
        });
        axios.patch(prioritizeTasks.url(selectedProjectSlug.value), data)
            .then((response: AxiosResponse<Task[]>) => {
                console.log(response);
            })
            .catch(err => console.error(err.response?.data || err));
    };

    const onDeleteTask = (task: PendingTask|Task) => {
        if (!confirm('Are you sure? This is permanent!')) {
            return false;
        }

        mutableTasks.value = mutableTasks.value.filter(t => t.id !== task.id);
        axios.delete(destroyTask.url({ project: selectedProjectSlug.value, task: task.id }))
            .catch(err => console.error(err.response?.data || err));
    };
</script>

<template>
    <Head title="TaskMaster" />

    <AppLayout>
        <section ref="root" class="py-12 text-sm">
            <Container>
                <header class="flex justify-between items-center pb-2 mb-4 border-b border-zinc-300">
                    <h1 class="text-2xl">
                        Tasks
                    </h1>

                    <SelectInput v-model="selectedProjectSlug">
                        <option v-for="project in projects" :value="project.slug">
                            {{ project.name }}
                        </option>

                        <option value="0">
                            Create a new project
                        </option>
                    </SelectInput>
                </header>

                <section v-for="status in taskStatuses" class="mb-8">
                    <h2 class="text-lg mb-2">
                        {{ status.name }}
                    </h2>

                    <ul ref="taskList" class="shadow rounded">
                        <draggable v-model="mutableTasks" item-key="id" handle=".fa-arrows" @change="() => onTaskPrioritiesChanged(status)">
                            <template #item="{element: task}">
                                <li v-if="isInStatus(task, status)" class="bg-white" :data-id="task.id">
                                    <div class="flex">
                                        <button type="button" class="p-2 cursor-move hover:bg-cyan-100">
                                            <span class="fas fa-arrows"></span>
                                        </button>

                                        <div class="relative p-2">
                                            <button @click="editingStatusOf = editingStatusOf === task.id ? undefined : task.id" type="button" class="cursor-pointer p-2">
                                                <span :class="status.border_style === 'dotted' ? 'fas fa-spinner' : 'far fa-circle'" :style="`color: ${status.color_border}`"></span>
                                            </button>

                                            <ul v-if="editingStatusOf === task.id" class="absolute top-full left-1/2 bg-white shadow whitespace-nowrap">
                                                <li v-for="status in taskStatuses">
                                                    <button @click="updateStatus(task, status)" type="button" class="cursor-pointer p-2 w-full text-left transition-colors hover:bg-cyan-100 hover:text-black">
                                                        <span class="mr-1" :class="status.border_style === 'dotted' ? 'fas fa-spinner' : 'far fa-circle'" :style="`color: ${status.color_border};`"></span> {{ status.name }}
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                        <input @input="() => onTaskTitleInput(task)" :id="`task.${task.id}.title`" v-model="task.title" class="my-4 flex-1 px-2 py-0 border-b border-transparent focus:outline-0 transition-colors hover:border-cyan-500 focus:border-purple-500" />

                                        <button @click="() => onDeleteTask(task)" type="button" class="p-2 cursor-pointer hover:bg-red-500 hover:text-white">
                                            <span class="fas fa-trash"></span>
                                        </button>
                                    </div>
                                </li>
                            </template>
                        </draggable>
    
                        <li class="mt-2">
                            <button @click="() => addTask(status)" type="button" class="border border-dashed border-cyan-500 rounded px-4 py-2 w-full text-left transition-colors hover:bg-cyan-500 hover:text-white active:bg-cyan-300 active:text-black cursor-pointer">
                                <span class="far fa-plus"></span> Add New Task
                            </button>
                        </li>
                    </ul>
                </section>
            </Container>
        </section>
    </AppLayout>
</template>
