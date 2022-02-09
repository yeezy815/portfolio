import {createRouter, createWebHistory} from "vue-router";

//import AlbumsIndex from "../components/albums/AlbumsIndex";
import AlbumList from "@/pages/AlbumList";
import DairyList from "@/pages/DairyList";
const routes = [
    {
        path: '/',
        component: AlbumList
    },
    {
        path: '/dairy',
        component: DairyList
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
