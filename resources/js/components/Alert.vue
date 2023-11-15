<template>
    <div :class="estilo" role="alert">
        {{ titulo }}

        <ul v-if="detalhes.data.errors">
            <hr />

            <li v-for="error, key in detalhes.data.errors" :key="key">
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
