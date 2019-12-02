<template>
    <div>
        <body-card :text-header="titleForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <ul>
                            <li>
                                "Radiobox" avec
                                <input type="number" v-model="nbElements.radiobox" value="2" min="2" max="99"/> reponse(s)
                                <button v-on:click="addElement('radiobox')" class="btn btn-outline-primary">+</button>
                            </li>
                            <li>
                                "Checkbox" avec
                                <input type="number" v-model="nbElements.checkbox" value="2" min="2" max="99"/> reponse(s)
                                <button v-on:click="addElement('checkbox')" class="btn btn-outline-primary">+</button>
                            </li>
                            <li>
                                "Textarea"
                                <input type="hidden" v-model="nbElements.textarea" value="1" min="1" max="1"/>
                                <button v-on:click="addElement('textarea')" class="btn btn-outline-primary">+</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                        <span v-if="formVisible() && currentElement !== ''">
                            <input type="text" placeholder="Entrez la question" class="form-group col-md-12" v-model="question.label">
                            <br/>
                            <span v-if="currentElement === 'radiobox'" v-for="(input, n) in question.inputs.radiobox">
                                <input type="radio" disabled>
                                <input class="col-md-10" type="text" :placeholder="'Choix ' + n" v-model="input.value">
                                <br>
                            </span>
                            <span v-if="currentElement === 'checkbox'" v-for="(input, n) in question.inputs.checkbox">
                                <input type="checkbox" disabled>
                                <input class="col-md-10" type="text" :placeholder="'Choix ' + n" v-model="input.value">
                                <br>
                            </span>
                            <span v-if="currentElement === 'textarea'" :rows="4" v-for="(input, n) in question.inputs.textarea">
                                <textarea rows="4" cols="40" disabled v-model="input.value"></textarea>
                            </span><br>
                            <button class="btn btn-outline-danger" @click="deleteQuestion">Supprimer</button>
                            <button class="btn btn-outline-primary" @click="addQuestion">Ajouter</button>
                        </span>
                </div>
            </div>
        </body-card>
        <br>
        <body-card text-header="Formulaire à générer (Rendu)">
            <label for="label-form"><u>Nom du formulaire:</u></label>
            <input class="form-group col-md-12" id="label-form" v-model="label" placeholder="Nom du formulaire">
            <br>
            <form>
                <label for="label-form"><u>Liste de(s) question(s): </u></label>
                <div v-for="(question, index) in form" :key="question.id">
                    <label>{{  index + " - "+ question.label }}</label>
                    <div v-if="question.element === 'radiobox'">
                        <template v-for="choice in question.inputs">
                            <input type="radio" disabled>
                            <label>{{ choice.value }}</label>
                            <br>
                        </template>
                    </div>
                    <div v-else-if="question.element === 'checkbox'">
                        <template v-for="choice in question.inputs">
                            <input type="checkbox" disabled>
                            <label>{{ choice.value }}</label>
                            <br>
                        </template>
                    </div>
                    <div v-else>
                        <textarea rows="4" cols="40" disabled></textarea>
                        <br>
                    </div>
                    <button class="btn btn-outline-danger" @click.prevent="deleteFormItem(index)">Supprimer</button>
                    <br><br>
                </div>
            </form>
            <div id="debug" ref="debug"></div>
        </body-card>
        <br>
        <div class="text-center">
            <button class="btn-submit btn btn-primary" @click="submitForm">Valider</button>
        </div>
    </div>
</template>

<script>

    import BodyCard from './BodyCard.vue';

    export default {
        components: {BodyCard},
        props: ['action','id'],
        mounted() {
            console.log('FormBuilder mounted.')
        },
        created () {
            if(this.action == 'edition' && this.id > 0){
                this.titleForm = "Mon formulaire N°" + this.id + ": Edition"
                axios.get(APP_URL+'/api/formulaireBuilders/'+this.id)
                .then((response)=> {
                    if(response.status == 200 && response.statusText == "OK") {
                        let responseData = response.data

                        this.label = responseData.libelle

                        for (let i = 0; i < responseData.questions.length; ++i) {
                            this.currentElement = responseData.questions[i].type
                            this.question.label = responseData.questions[i].libelle
                            this.question.inputs[this.currentElement] = [];

                            for (let j = 0; j < responseData.questions[i].reponses.length; ++j) {
                                this.question.inputs[this.currentElement].push({ value: responseData.questions[i].reponses[j].libelle })
                            }

                            this.addQuestion();
                        }
                    }
                })
                .catch((error) => {
                    alert(error);
                });

            }
        },
        data(){
            return {
                titleForm: 'Mon Formulaire: Création',
                label: '',
                currentElement: '',
                nbElements: {
                    checkbox: 2,
                    radiobox: 2,
                    textarea: 1
                },
                question: {
                    label: '',
                    inputs: {
                        checkbox: [],
                        radiobox: [],
                        textarea: []
                    }
                },
                form: [],
            }
        },
        methods: {
            cleanQuestion() {
                return { label: this.question.label, inputs: this.question.inputs[this.currentElement], element: this.currentElement }
            },
            addQuestion() {
                this.form.push(this.cleanQuestion(this.question))
                this.deleteQuestion()
            },
            deleteFormItem(index){
                this.form.splice(index, 1)
                return
            },
            deleteQuestion() {
                this.currentElement = ''
                this.question = {
                    label: '',
                    inputs: {
                        checkbox: Array.from({ length: this.nbElements.checkbox }, (v, k) => ({ value: '' })),
                        radiobox: Array.from({ length: this.nbElements.radiobox }, (v, k) => ({ value: '' })),
                        textarea: Array.from({ length: this.nbElements.textarea }, (v, k) => ({ value: '' }))
                    }
                }
            },
            addElement(el) {
                //Vider le tableau de données
                this.deleteQuestion();

                this.currentElement = el // ex: checkbox

                // Ajouter l'input le nombre de fois saisie
                while(this.question.inputs[el].length < this.nbElements[el]){
                    this.question.inputs[el].push({ value: '' })
                }

            },
            formVisible() {
                return this.question.inputs.checkbox.length > 0 || this.question.inputs.radiobox.length > 0 || this.question.inputs.textarea.length > 0
            },
            submitForm: function (){
                if(this.action == "creation"){
                    this.submitCreate();
                }
                else{
                    this.submitEdit();
                }
            },
            submitCreate: function () {
                if(this.label == "" ){
                    alert("Libellé du formulaire obligatoire");
                    return
                }

                if (confirm("Valider la création du formulaire ? ")) {

                    let data = {
                        libelle: this.label,
                        questions:this.form
                    }

                    axios.post(APP_URL+'/api/formulaireBuilders', JSON.stringify(data))
                        .then(function (response) {
                            if(response.status == 200 && response.statusText == "OK") {
                                console.log("Insert OK");
                                window.location.href = APP_URL;
                            }
                        })
                        .catch(function (error) {
                            alert(error);
                        });
                } else {
                    alert("La création du questionnaire a été annulée");
                }
            },
            submitEdit: function () {
                if(this.label == "" ){
                    alert("Libellé du formulaire obligatoire");
                    return
                }

                if (confirm("Valider la modification de formulaire ? ")) {
                    let data = {
                        libelle: this.label,
                        questions:this.form,
                        id: this.id
                    }


                    axios.put(APP_URL+'/api/formulaireBuilders/'+this.id+'/', JSON.stringify(data))
                        .then(function (response) {
                            //document.getElementById("debug").innerHTML = response.data;
                            if(response.status == 200 && response.statusText == "OK") {
                                console.log("Update OK");
                                window.location.href = APP_URL;
                            }
                        })
                        .catch(function (error) {
                            alert(error);
                        });
                } else {
                    alert("La modification du questionnaire a été annulée");
                }
            }
        }
    }
</script>
