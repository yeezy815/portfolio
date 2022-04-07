import {createRouter, createWebHistory} from "vue-router";

//import AlbumsIndex from "../components/albums/AlbumsIndex";
import AlbumList from "@/pages/AlbumList";
import DairyList from "@/pages/DairyList";
import ArtistInfo from "@/pages/ArtistInfo";
import AlbumInfo from "@/pages/AlbumInfo";
const routes = [
    {
        path: '/albums',
        name: 'albums',
        component: AlbumList
    },
    {
        path: '/dairy',
        name: 'dairy',
        component: DairyList
    },
    {
        path: '/artists/:id',
        name: 'artist',
        component: ArtistInfo
    },
    {
        path: '/albums/:id',
        name: 'album',
        component: AlbumInfo
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
