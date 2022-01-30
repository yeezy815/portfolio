import {createRouter, createWebHistory} from "vue-router";

import AlbumsIndex from "../components/albums/AlbumsIndex";

const routes = [
    {
        path: '/',
        component: AlbumsIndex
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
