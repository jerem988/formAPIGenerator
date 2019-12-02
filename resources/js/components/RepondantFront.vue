<template>
    <div>
        <div v-if="questionnaireCloturer">
            <alert-success :alertBodyText="alertBodyText" :alertHeaderText="alertHeaderText"></alert-success>
        </div>
        <div v-else>
            <body-card :text-header="libelleFormulaire">
                <form v-on:submit.prevent="submitForm()">
                    <div v-for="(quest, index) in form" :key="quest.id">
                        <div class="form-group">
                            <label>{{  index + " - "+ quest.label }}</label>
                            <div v-if="quest.element === 'radiobox'">
                                <template v-for="choice in quest.inputs">
                                    <div class="form-check">
                                        <input class="form-check-input" v-model="quest.reponse_id_radio" :name="choice.name" type="radio" :value="choice.id" v-on:change="inputListeners">
                                        <label class="form-check-label" :for="choice.id">{{ choice.libelle }}</label>
                                    </div>
                                </template>
                            </div>
                            <div v-else-if="quest.element === 'checkbox'">
                                <template v-for="choice in quest.inputs">
                                    <div class="form-check">
                                        <input class="form-check-input" v-model="quest.reponse_id_checkbox" :name="choice.name" type="checkbox" :value="choice.id" v-on:change="inputListeners">
                                        <label class="form-check-label" :for="choice.id">{{ choice.libelle }}</label>
                                    </div>
                                </template>
                            </div>
                            <div v-else>
                                <div class="form-check">
                                    <textarea class="form-control" v-model="quest.reponse_textarea" rows="4" cols="40" v-bind="$attrs" v-on:input="inputListeners"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="debug"></div>
            </body-card>
            <br>
            <div class="text-center">
                <button type="submit" class="btn-submit btn btn-primary" @click="submitForm(true)">Valider</button>
            </div>
        </div>
    </div>
</template>

<script>

    import BodyCard from './BodyCard.vue';
    import AlertSuccess from './AlertSuccess.vue';

    export default {
        components: {BodyCard,AlertSuccess},
        props: ["id_form_repondant","id_form","id_user"],
        data(){
            return {
                currentElement: '',
                libelleFormulaire: '',
                alertBodyText: "Bonjour, Merci d'avoir répondu à notre enquête de satisfaction. Nous espérons vous revoir au plus vite sur notre plateforme.",
                alertHeaderText: "Merci !",
                questionnaireCloturer: false,
                question: {
                    label: '',
                    inputs: {
                        checkbox: [],
                        radiobox: [],
                        textarea: [],
                    },
                    reponse_textarea: "",
                    reponse_id_radio: "",
                    reponse_id_checkbox:"",
                    question_id: ""
                },
                form: [],
            }
        },
        mounted() {
            console.log('FormBuilder mounted.')

        },
        created () {
            //Attendre que l'utilisateur arrête de tapper
            this.debouncedSubmitForm = _.debounce(this.submitForm, 500)

            axios.get(APP_URL+'/api/reponses-repondant/lister-formulaire-par-repondant/' + this.id_form + '/' + this.id_user)
                .then((response)=> {
                    if(response.status == 200 && response.statusText == "OK") {
                        let responseData = response.data
                        console.log(responseData)

                        //Formulaire clôturé ou non
                        if(responseData.form_repondants[0].date_validation){
                            this.questionnaireCloturer = true;
                        }

                        this.libelleFormulaire = response.data.libelle;

                        for (let i = 0; i < responseData.questions.length; ++i) {
                            this.initQuestion();

                            this.currentElement = responseData.questions[i].type
                            this.question.label = responseData.questions[i].libelle
                            this.question.id = responseData.questions[i].id;

                            for (let j = 0; j < responseData.questions[i].reponses.length; ++j) {
                                this.question.inputs[this.currentElement].push({
                                    libelle: responseData.questions[i].reponses[j].libelle,
                                    id: responseData.questions[i].reponses[j].id,
                                    name: this.currentElement == "radiobox" ? responseData.questions[i].id : responseData.questions[i].reponses[j].id,
                                })

                                if(responseData.questions[i].reponses[j].reponses_repondants.length){
                                    if(this.currentElement == "textarea") {
                                        this.question.reponse_textarea = responseData.questions[i].reponses[j].reponses_repondants[0].textarea;
                                    }

                                    if(this.currentElement == "radiobox") {
                                        this.question.reponse_id_radio = responseData.questions[i].reponses[j].reponses_repondants[0].reponse_id;
                                    }

                                    if(this.currentElement == "checkbox"){
                                        this.question.reponse_id_checkbox.push(responseData.questions[i].reponses[j].reponses_repondants[0].reponse_id);
                                    }
                                }
                            }

                            this.addQuestion();
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        methods: {
            inputListeners: function (event) {
                //Enregistrer les réponses du répondant lors du déclenchement de l'évenement input
                if(event.target.type == "textarea"){
                    //500 ms
                    this.debouncedSubmitForm()
                }
                else{
                    this.submitForm();
                }
            },
            cleanQuestion() {
                return {
                    question_id: this.question.id,
                    label: this.question.label,
                    inputs: this.question.inputs[this.currentElement],
                    element: this.currentElement,
                    reponse_textarea: this.question.reponse_textarea,
                    reponse_id_radio: this.question.reponse_id_radio,
                    reponse_id_checkbox: this.question.reponse_id_checkbox,

                }
            },
            initQuestion() {
                this.question.id = "";
                this.question.inputs[this.currentElement] = [];
                this.question.label = "";
                this.question.reponse_textarea = "";
                this.question.reponse_id_radio = "";
                this.question.reponse_id_checkbox = [];
            },
            addQuestion() {
                this.form.push(this.cleanQuestion(this.question))
            },
            submitForm: function (cloture_form = false){

                let data = {
                    form_id: this.id_form,
                    id_form_repondant: this.id_form_repondant,
                    repondant_id: this.id_user,
                    reponse: this.form,
                    cloture_form: cloture_form
                }

                axios.post(APP_URL+'/api/reponses-repondant', JSON.stringify(data))
                    .then((response)=>  {
                       // document.getElementById("debug").innerHTML = response.data;
                        if(response.status == 200 && response.statusText == "OK") {
                            console.log("Insert / Update OK");

                            if(cloture_form){
                                this.questionnaireCloturer = true;
                            }
                        }
                    })
                    .catch((error) => {
                        alert(error);
                    })
            },
        }
    }
</script>
