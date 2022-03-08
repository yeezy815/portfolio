import {ref} from 'vue';

export default function useDairies(){

    let dairies =ref([])

    let currentPage = ref(0)

    let lastPage = ref(0)


    let isLastPage = ref(false)

    const headers = {
        header: {
            'Accept': 'application/json'
        }
    }
    const getDairies = async (filter = null) => {
      // let response = await  axios.get('/api/dairy', headers)
      //   dairies.value = response.data.data

        if (filter) {
            console.log("filter")
            console.log(filter)
            Object.keys(filter).forEach(key => {
                if (filter[key] === null || filter[key] === '') {
                    delete filter[key];
                }
            });
            currentPage.value = 0
            dairies.value = []
        }
        else {
            filter = {}
        }
        filter.page = currentPage.value + 1
        let response = await  axios.get('/api/dairy', {
            params: filter,
            headers: headers
        })
        console.log(response.data.current_page)

        lastPage.value = response.data.last_page
        currentPage.value = response.data.current_page
        isLastPage = currentPage.value === lastPage.value
        dairies.value = [...dairies.value, ...response.data.data]
    }

    const destroyDairy = async (dairyItem) => {
      await  axios.delete('/api/dairy/'+dairyItem.id, headers)
        dairies.value=dairies.value.filter(p => p.id !== dairyItem.id);
    }
    const updateDairy = async (dairyItem) => {
        await  axios.put('/api/dairy/'+dairyItem.id, dairyItem, headers)
    }

    const createDairy = async (dairyItem) => {
        await  axios.post('/api/dairy/', dairyItem, headers)
       dairies.value.push(dairyItem)
    }



    return{
        dairies,
        getDairies,
        destroyDairy,
        updateDairy,
        createDairy

    }
}
