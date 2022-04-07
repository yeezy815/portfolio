import {reactive, ref} from 'vue';

export default function useItems(){

    let items =ref([])

    let item = ref({})

    let link = ref(new Map([
                ['dairy','/api/dairy'],
                ['album', '/api/albums'],
                ['artist', '/api/artists']
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

    const getItem = async (id) =>{
      await  axios.get(  itemLink.value + "/"+ id).then(
            response => {
               // item = response.data
                Object.assign(item.value, response.data)
            }
        )
    }



    const getItemWithRelation = async (id) =>{
        await  axios.get(  itemLink.value + "/"+ id + '/dairy').then(
            response => {
                Object.assign(item.value, response.data)
            }
        )
    }

    const getItems = async (filter) => {
        if (filter) {
            items.value = []
            Object.keys(filter).forEach(key => {
                if (filter[key] === null || filter[key] === '') {
                    delete filter[key];
                }
            });
        }
        else {
            filter = {}
        }
        filter.page = currentPage.value + 1
       await  axios.get(  itemLink.value, {
            params: filter,
            headers: headers
        }).
        then( response => {
            lastPage.value = response.data.last_page
            currentPage.value = response.data.current_page
            isLastPage.value = currentPage.value === lastPage.value
            items.value = [...items.value, ...response.data.data]
        })
        .catch(
            response => {
                alert("не удалось получить данные")
            })
    }

    const destroyItem = async (albumItem) => {
        await  axios.delete(  itemLink.value + "/" +albumItem.id, headers)
            .then( items.value=items.value.filter(p => p.id !== albumItem.id))
    }
    const updateItem = async (albumItem) => {
        await  axios.put(  itemLink.value +  "/" + albumItem.id, albumItem, headers).then(
            response => {
                const foundIndex = items.value.findIndex(x => x.id === albumItem.id);
                items.value[foundIndex].status = {
                    type: "alert-success",
                    message: "успешно обновлено"};
            })
            .catch(error => {
                    fail(error, albumItem.id)
                })
    }

    const createItem = async (albumItem) => {
        let item = JSON.stringify(albumItem)
       await  axios.post(  itemLink.value , albumItem, headers).then(
           (response, albumItem = albumItem) => {
              // console.log(JSON.parse(item))
                if (itemType.value === "album")
                     items.value.unshift(response.data)

                else
                    items.value.unshift(JSON.parse(item))
            }
       )
       //     .catch(
       //         alert("не удалось создать объект")
       //
       // )
    }

    function success(response){
        console.log(response)
    }

    function fail(error, id){
        let message = ''
        if (JSON.parse(error.request.response).errors)
            message = JSON.parse(error.request.response).errors

        else {
            if (error.response.data.message)
                message = error.response.data.message
            else
                message = "не удалось изменить данные"
        }
        const foundIndex = items.value.findIndex(x => x.id === id);
        items.value[foundIndex].status = {
            type: "alert-danger",
            message: message
        }
    }

    return{
        items,
        item,
        lastPage,
        itemType,
        setItemType,
        link,
        isLastPage,
        currentPage,
        createdItemId,
        getItem,
        getItemWithRelation,
         getItems,
         destroyItem,
         updateItem,
         createItem

    }
}
