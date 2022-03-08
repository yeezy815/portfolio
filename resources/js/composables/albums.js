import {ref} from 'vue';

export default function useAlbums(){

    let items =ref([])

    let link = ref(new Map([
                ['dairy','/api/dairies/'],
                ['album', '/api/albums/']
            ]
        )
    )

    let itemType = ref('')

    let itemLink = ref('')

    let currentPage = ref(0)

    let lastPage = ref(0)

    let createdItemId = ref(0)

    let isLastPage = ref(false)

    const headers = {
        header: {
            'Accept': 'application/json'
        }
    }

    const setItemType = (sent) => {
        itemType.value   = sent
        itemLink.value = link.value.get(itemType.value)
        console.log(link.value.get(itemType.value))
    }

    const getAlbums = async (filter) => {
        if (filter) {
            Object.keys(filter).forEach(key => {
                if (filter[key] === null || filter[key] === '') {
                    delete filter[key];
                }
            });
             currentPage.value = 0
            items.value = []
        }
        else {
            filter = {}
        }
        filter.page = currentPage.value + 1
        let response = await  axios.get(  itemLink.value, {
            params: filter,
            headers: headers
        })

        lastPage.value = response.data.last_page
        currentPage.value = response.data.current_page

        isLastPage.value = currentPage.value === lastPage.value
        if (itemType.value === "album") {
            items.value = [...items.value, ...response.data.data]
        }
        else
            console.log("no")
    }

    const destroyAlbum = async (albumItem) => {
        await  axios.delete(  itemLink.value +albumItem.id, headers)
        items.value=items.value.filter(p => p.id !== albumItem.id);
    }
    const updateAlbum = async (albumItem) => {
        await  axios.put(  itemLink.value +albumItem.id, albumItem, headers)
    }

    const createAlbum = async (albumItem) => {
       await  axios.post(  itemLink.value , albumItem, headers).then(
            response => (
                items.value.push(response.data)
            )
        )
    }



    return{
        items,
        lastPage,
        itemType,
        setItemType,
        link,
        isLastPage,
        currentPage,
        createdItemId,
        getAlbums,
        destroyAlbum,
        updateAlbum,
        createAlbum

    }
}
