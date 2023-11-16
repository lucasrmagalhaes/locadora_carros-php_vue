<template>
    <div :class="estilo" role="alert">
        {{ titulo }}

        <hr />

        <p>
            {{ detalhes.mensagem }}
        </p>

        <br />

        <ul v-if="detalhes.dados">
            <li v-for="error, key in detalhes.dados" :key="key">
                {{ error[0] }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['tipo', 'titulo', 'detalhes'],
        computed: {
            estilo() {
                return 'alert alert-' + this.tipo
            }
        }
    }
</script>
