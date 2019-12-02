<template>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">{{alertHeaderText}}</h4>
        <p>{{alertBodyText}}</p>
        <hr>
        <p class="mb-0">A bientôt ! <br>L'équipe Form Créator.</p>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('alertSuccess mounted.')
        },
        props: ['alertHeaderText', 'alertBodyText'],
    }
</script>
