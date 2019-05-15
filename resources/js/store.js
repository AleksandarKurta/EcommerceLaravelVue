export default {
    state: {
        brands: {"1":"samsung"}
    },
    getters: {
        brands(state){
            return state.brands;
        },
    },
    mutations: {
        updateBrands(state, payload){
            state.brands = payload;
        }
    },
    actions: {
        getBrands(context){
            axios.get('/api/brands')
                .then((response) => {
                    context.commit('updateBrands', response.data.brands);
                })
        }
    }
}