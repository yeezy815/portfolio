import {ref} from 'vue';

export default function useDairies(){

    let dairies =ref([])

    const headers = {
        header: {
            'Accept': 'application/json'
        }
    }
    const getDairies = async () => {
      let response = await  axios.get('/api/dairy', headers)
        dairies.value = response.data

    }

    const destroyDairy = async (dairyItem) => {
      await  axios.delete('/api/dairy/'+dairyItem.id, headers)
        dairies.value=dairies.value.filter(p => p.id !== dairyItem.id);
    }
    const updateDairy = async (dairyItem) => {
        const data = {
            name: dairyItem.name,
            score: dairyItem.score,
            experience: dairyItem.experience,
            description: dairyItem.description,
            date: dairyItem.date,
            album_id:dairyItem.album_id
        }

        await  axios.put('/api/dairy/'+dairyItem.id, data, headers)
    }

    const createDairy = async (dairyItem) => {
        const data = {
            name: dairyItem.name,
            score: dairyItem.score,
            experience: dairyItem.experience,
            description: dairyItem.description,
            date: dairyItem.date,
            album_id:dairyItem.album_id
        }
        await  axios.post('/api/dairy/', data, headers)
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
