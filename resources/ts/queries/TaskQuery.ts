import axios from "axios"
import { useQuery } from "react-query"
import { Task } from "../types/task"
import * as api from "../api/TaskAPI"

const useTasks = () => {
    return useQuery('tasks',  () => api.getTasks())
}

export {
    useTasks
}