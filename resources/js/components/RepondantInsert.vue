<template>
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <my-repondant ref="tableauRepondant"></my-repondant>
        </div>
        <div class="col-md-4 col-sm-12">
            <body-card :text-header="titleForm">
                <form v-on:submit.prevent="submitForm()">
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" v-model="nom" class="form-control" id="nom" placeholder="Entrez le nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" v-model="prenom" class="form-control" id="prenom" placeholder="Entrez le prénom" required>
                    </div>
                    <div class="form-group">
                        <label for="mail">E-mail:</label>
                        <input type="email" v-model="mail" class="form-control" id="mail" placeholder="Entrez l'e-mail" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </body-card>
        </div>
    </div>
</template>

<script>

    import BodyCard from './BodyCard.vue';
    import MyRepondant from './MyRepondant.vue';

    export default {
        components: {BodyCard, MyRepondant},
        mounted() {
            console.log('RepondantInsert mounted.')
        },
        data(){
            return {
                titleForm: 'Ajouter un répondant',
                nom: '',
                prenom: '',
                mail: ''
            }
        },
        methods: {
            emptyForm:function () {
                this.nom = '';
                this.prenom = '';
                this.mail = '';
            },
            submitForm: function (){
                if (confirm("Valider la création du répondant ? ")) {

                    let data = {
                        nom: this.nom,
                        prenom:this.prenom,
                        mail: this.mail
                    }

                    axios.post(APP_URL+'/api/repondants', JSON.stringify(data))
                        .then((response)=>  {
                            if(response.status == 200 && response.statusText == "OK") {
                                console.log("OK");
                            }
                        })
                        .catch((error) => {
                            alert(error);
                        })
                        .finally(() => {
                             this.$refs.tableauRepondant.fetchData();
                             this.emptyForm();
                        });

                } else {
                    alert("La création du répondant a été annulée");
                }
            },
        }
    }
</script>

