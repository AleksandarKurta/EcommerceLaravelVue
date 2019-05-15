<template>
    <div>
        <div class="row mt-5">
            <div class="col-md-3" v-for="product in formattedProducts" :key="product.id">
                <div class="card">
                    <img v-bind:src="product.image" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5>{{ product.name }}</h5>
                        <h5>{{ product.price }}</h5>
                        <button class="btn btn-danger"><i class="fa fa-shopping-cart"></i>Add To Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['default_products'],
        data() {
          return {
              products: this.default_products
          }
        },
        methods: {
          
        },
        computed: {
            formattedProducts() {
                return JSON.parse(this.products);
            }
        },
        created() {
            console.log("Mounted")
        }
    }
</script>