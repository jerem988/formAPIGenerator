<template>
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <my-repondant :id_form="id_form" ref="tableauRepondant"></my-repondant>
        </div>
        <div class="col-md-4 col-sm-12">
            <body-card :text-header="titleForm">
                <form v-on:submit.prevent="submitForm()">
                    <div class="form-group">
                        <label for="repondant-select">Choisissez le repondant à ajouter au formulaire</label>
                        <select v-model="selected" class="form-control" id="repondant-select" required>
                            <option disabled value="">Choisissez le repondant</option>
                            <option v-for="option in options" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </body-card>
        </div>

        <div id="debug"></div>
    </div>
</template>

<script>

    import BodyCard from './BodyCard.vue';
    import MyRepondant from './MyRepondant.vue';

    export default {
        components: {BodyCard, MyRepondant},
        props: ['id_form'],
        mounted() {
            console.log('RepondantFormSelect mounted.')
        },
        created() {
            this.fetchSelectData();
        },
        data(){
            return {
                titleForm: 'Ajouter un répondant au formulaire',
                selected: '',
                options: []
            }
        },
        methods: {
            fetchSelectData: function (){
                this.options = [];
                axios.get(APP_URL+'/api/repondants-forms/lister-formulaire-options-repondant/'+this.id_form)
                    .then((response)=> {
                        //document.getElementById("debug").innerHTML = response.responseText;
                        if(response.status == 200 && response.statusText == "OK") {
                            for (let i = 0; i < response.data.length; ++i) {
                                this.options.push({
                                    text: response.data[i].mail,
                                    value: response.data[i].id
                                })

                            }
                        }
                    })
                    .catch((error) => {
                        alert(error);
                    });
            },
            submitForm: function (){
                if (confirm("Valider l'ajout du répondant ? ")) {
                    let data = {
                        form_id: this.id_form,
                        repondant_id : this.selected
                    }

                    axios.post(APP_URL+'/api/repondants-forms', JSON.stringify(data))
                        .then((response)=>  {
                            if(response.status == 200 && response.statusText == "OK") {
                                document.getElementById("debug").innerHTML = response.data;
                                console.log("OK");
                            }
                        })
                        .catch((error) => {
                            alert(error);
                        })
                        .finally(() => {
                            this.$refs.tableauRepondant.fetchFormData();
                            this.fetchSelectData();
                            this.selected = "";
                        });
                } else {
                    alert("L'ajout du répondant a été annulée");
                }
            },
        }
    }
</script>

