import axios from "axios";
import { Task } from "../types/task";

const getTasks = async () => {
    const { data } = await axios.get<Task[]>('api/tasks')
    return data
}

const updateDoneTask = async ({ id, is_done }) => {
    const { data } = await axios.patch<Task>(
        `api/tasks/update-done/${id}`,
        { is_done: !is_done }
    )
    return data
}

const createTask = async ( title: string ) => {
    const { data } = await axios.post<Task>(
        'api/tasks', { title: title }
    )
    return data
}

export {
    getTasks,
    updateDoneTask,
    createTask
}