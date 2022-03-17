import {createRouter, createWebHistory} from "vue-router";

//import AlbumsIndex from "../components/albums/AlbumsIndex";
import AlbumList from "@/pages/AlbumList";
import DairyList from "@/pages/DairyList";
import ArtistInfo from "@/pages/ArtistInfo";
import AlbumInfo from "@/pages/AlbumInfo";
const routes = [
    {
        path: '/',
        component: AlbumList
    },
    {
        path: '/dairy',
        component: DairyList
    },
    {
        path: '/artists/:id',
        component: ArtistInfo
    },
    {
        path: '/albums/:id',
        component: AlbumInfo
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
