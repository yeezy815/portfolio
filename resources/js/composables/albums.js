import {ref} from 'vue';

export default function useAlbums(){

    let albums =ref([])

    const headers = {
        header: {
            'Accept': 'application/json'
        }
    }
    const getDairies = async () => {
        let response = await  axios.get('/api/albums', headers)
        albums.value = response.data

    }

    const destroyDairy = async (albumItem) => {
        await  axios.delete('/api/albums/'+albumItem.id, headers)
        albums.value=albums.value.filter(p => p.id !== albumItem.id);
    }
    const updateDairy = async (albumItem) => {
        const data = {
            name: albumItem.name,
            score: albumItem.score,
            experience: albumItem.experience,
            description: albumItem.description,
            date: albumItem.date,
            album_id:albumItem.album_id
        }

        await  axios.put('/api/albums/'+albumItem.id, data, headers)
    }

    const createDairy = async (albumItem) => {
        const newar = [];
        albumItem.artists.forEach(element => newar.push(element.name));
        const data = {
            artists: newar,
            name: albumItem.name,
            year: albumItem.year,
        }
        await  axios.post('/api/albums/', data, headers)
        albums.value.push(albumItem)
    }



    return{
        albums,
        getDairies,
        destroyDairy,
        updateDairy,
        createDairy

    }
}
