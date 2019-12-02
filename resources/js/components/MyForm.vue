<template>
    <body-card text-header="Mes formulaires">
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Libelle</th>
                    <th scope="col">Date Création</th>
                    <th scope="col">Date Modification</th>
                    <th scope="col">Edition</th>
                    <th scope="col">Suppression</th>
                    <th scope="col">Répondant</th>
                </tr>
                </thead>
                <tbody>
                    <template  v-for="item in items">
                        <tr>
                            <th scope="row">{{item.id}}</th>
                            <td>{{item.libelle}}</td>
                            <td>{{item.created_at}}</td>
                            <td>{{item.updated_at}}</td>
                            <td class="text-center"><button type="button" class="btn btn-warning" @click="updateItem(item.id)"><span class="fas fa-edit"></span></button></td>
                            <td class="text-center"><button type="button" class="btn btn-danger" @click="deleteItem(item.id)"><span class="fas fa-trash"></span></button></td>
                            <td class="text-center"><button type="button" class="btn btn-primary" @click="listFormRepondant(item.id)"><span class="fas fa-users"></span></button></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </body-card>
</template>

<script>
    export default {
        data(){
            return {
                items:[],
            }
        },
        mounted() {
            console.log('MyForm mounted.')
        },
        created: function(){
            this.fetchData();
        },
        props: [],
        methods: {
            fetchData: function(){
                axios.get(APP_URL+'/api/formulaires/')
                    .then((response)=> {
                        //document.getElementById("debug").innerHTML = response.responseText;
                        if(response.status == 200 && response.statusText == "OK") {
                            this.items = response.data;
                        }
                    })
                    .catch((error) => {
                        alert(error);
                    });
            },
            deleteItem: function(id){
                if (confirm("Valider la suppresion de ce formulaire ? ")) {
                    axios.delete(APP_URL+'/api/formulaires/'+id)
                        .then((response)=> {
                            //document.getElementById("debug").innerHTML = response.responseText;
                            if(response.status == 200 && response.statusText == "OK") {
                                console.log(response);
                                this.fetchData();
                            }
                        })
                        .catch((error) => {
                            alert(error);
                        });
                }else {
                    alert("Le formulaire n'a pas été supprimé.");
                }
            },
            updateItem: function(id){
                window.location.href = APP_URL+'/editer-un-formulaire/'+id;
            },
            listFormRepondant: function(id){
                window.location.href = APP_URL+'/mes-repondants-formulaires/'+id;
            }
        }
    }
</script>
