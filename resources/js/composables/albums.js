import {ref} from 'vue';

export default function useAlbums(){

    let albums =ref([])

    let currentPage = ref(0)

    let lastPage = ref(0)

    let createdItemId = ref(0)

    const headers = {
        header: {
            'Accept': 'application/json'
        }
    }
    const getAlbums = async (filter, page = 1) => {
        console.log("pressed")

        if (filter) {
            // page+=1
            Object.keys(filter).forEach(key => {
                if (filter[key] === null || filter[key] === '') {
                    delete filter[key];
                }
            });
            filter.page = page
            albums.value = []
        }
        else {
            filter = {}
        }

        let response = await  axios.get('/api/albums', {
            params: filter,
            headers: headers
        })
        console.log(response.data.last_page)
        lastPage.value = response.data.last_page
        currentPage.value = response.data.current_page
        albums.value = [...albums.value, ...response.data.data]
    }

    const destroyAlbum = async (albumItem) => {
        await  axios.delete('/api/albums/'+albumItem.id, headers)
        albums.value=albums.value.filter(p => p.id !== albumItem.id);
    }
    const updateAlbum = async (albumItem) => {
        const newar = [];
        albumItem.artists.forEach(element => newar.push(element.name));
        const data = {
            artists: newar,
            name: albumItem.name,
            year: albumItem.year,
        }
        await  axios.put('/api/albums/'+albumItem.id, data, headers)
    }

    const createAlbum = async (albumItem) => {
        const newar = [];
        albumItem.artists.forEach(element => newar.push(element.name));
        const data = {
            artists: newar,
            name: albumItem.name,
            year: albumItem.year,
        }
       await  axios.post('/api/albums/', data, headers).then(
            response => (createdItemId = response.data)
        )
        albums.value.push(albumItem)
      // createdItemId = response.data
    }



    return{
        albums,
        lastPage,
        currentPage,
        createdItemId,
        getAlbums,
        destroyAlbum,
        updateAlbum,
        createAlbum

    }
}
