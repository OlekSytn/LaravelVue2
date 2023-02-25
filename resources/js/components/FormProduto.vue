<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Cadastre um Produto</div>
                    <div class="card-body" >
                        <form id="formulario" v-bind:action="url" v-on:submit.prevent.self @submit="enviarForm">
                            <input class="form-control mt-1" v-model="nomeProduto" name="nomeProduto" placeholder="nomeProduto" type="text">
                            <input class="form-control mt-1" v-model="valorProduto" name="valorProduto"  placeholder="valorProduto" type="text">
                            <button class="btn btn-primary mt-1" type="submit">enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
         
    </div>
</template>

<script>
    export default {
        props: ['url'],     
        data() {
            return{    
                nomeProduto:null,
                valorProduto:null,                
            }
        },
        mounted() {
            console.log('Component mounted.a')
            //    window.Echo.channel('listing.{{$listing->id}}')
            //     .listen('ListingViewed', function (e) {
            //         console.log('oi');
            //         if(e.data.current_user != parseInt('{{ \Auth::user()->id }}')) {

            //             showNotification("Another user looking at this listing right now");
            //             console.log(e.data);
            //         }

            //     });

        },
        methods: {
            
            enviarForm: function(e){
                // this.error = this.produtos = null;  
                   
                axios
                    .post(this.url,{                        
                            nomeProduto:this.nomeProduto,
                            valorProduto:this.valorProduto
                        }
                    )
                    .then(response => {
                        console.log(response.data);
                        // if(this.produtos != response.data){
                        //     this.loading = false;
                        //     this.produtos = response.data ;
                        //     // console.log(this.users,response.data);
                        // }

                    }).catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            }
            
        },
    }
</script>

