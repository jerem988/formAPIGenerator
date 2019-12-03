<template>
    <body-card text-header="Mes répondants" class="mb-4">
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Date Création</th>
                        <th scope="col">Suppression</th>
                        <th scope="col" v-show="id_form">Générer lien unique</th>
                    </tr>
                </thead>
                <tbody>
                    <template  v-for="item in items">
                        <tr>
                            <th scope="row">{{item.id}}</th>
                            <td>{{item.nom}}</td>
                            <td>{{item.prenom}}</td>
                            <td>{{item.mail}}</td>
                            <td>{{item.created_at}}</td>
                            <td class="text-center" v-if="id_form"><button type="button" class="btn btn-danger" @click="deleteFormItem(item.id_form_repondant)"><span class="fas fa-trash"></span></button></td>
                            <td class="text-center" v-else ><button type="button" class="btn btn-danger" @click="deleteItem(item.id)"><span class="fas fa-trash"></span></button></td>
                            <td class="text-center"v-show="id_form" ><button type="button" class="btn btn-primary" @click="generateUniqueLink(item.id, item.mail, item.id_form_repondant)"><span class="fas fa-link"></span></button></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div id="debug"></div>
    </body-card>
</template>

<script>
    export default {
        props: ['id_form'],
        data(){
            return {
                items:[],
            }
        },
        mounted() {
            console.log('MyForm mounted.')
        },
        created: function(){
            if(this.id_form) {
                this.fetchFormData()
                return
            }

            this.fetchData();
        },
        methods: {
            fetchData: function(){
                axios.get(APP_URL+'/api/repondants')
                    .then((response)=> {
                        if(response.status == 200 && response.statusText == "OK") {
                            this.items = response.data;
                        }
                    })
                    .catch((error) => {
                        alert(error);
                    });
            },
            fetchFormData: function(){
                axios.get(APP_URL+'/api/repondants-forms/'+this.id_form)
                    .then((response)=> {
                        if(response.status == 200 && response.statusText == "OK") {
                            this.items = response.data;
                        }
                    })
                    .catch((error) => {
                        alert(error);
                    });
            },
            deleteItem: function(id){
                if (confirm("Valider la suppresion de ce répondant ? ")) {
                    axios.delete(APP_URL+'/api/repondants/'+id)
                        .then((response)=> {
                            if(response.status == 200 && response.statusText == "OK") {
                                this.fetchData();
                            }
                        })
                        .catch((error) => {
                            alert(error);
                        });
                }else {
                    alert("Le répondant n'a pas été supprimé.");
                }
            },
            deleteFormItem: function(id){
                if (confirm("Valider la suppresion de ce répondant sur le formulaire ? ")) {
                    axios.delete(APP_URL+'/api/repondants-forms/'+id)
                        .then((response)=> {
                            if(response.status == 200 && response.statusText == "OK") {
                                this.fetchFormData();
                                this.$parent.fetchSelectData();
                            }
                        })
                        .catch((error) => {
                            alert(error);
                        });
                }else {
                    alert("Le répondant n'a pas été supprimé du formulaire.");
                }
            },
            generateUniqueLink: function(id, mail, id_form_repondant){
                if (confirm("Valider la génération du lien vers l'e-mail du répondant ? ")) {
                    let data = {
                        id_form_repondant: id_form_repondant,
                        form_id: this.id_form,
                        user_id: id,
                        mail: mail,
                    }

                    axios.post(APP_URL+'/api/mails', JSON.stringify(data))
                        .then(function (response) {
                            document.getElementById("debug").innerHTML = response.data;

                            if(response.status == 200 && response.statusText == "OK") {
                                alert("Le lien a été envoyé sur l'email du répondant.");
                            }
                        })
                        .catch(function (error) {
                            alert(error);
                        });
                }else {
                    alert("Le lien n'a pas été généré.");
                }
            },
        }
    }
</script>
