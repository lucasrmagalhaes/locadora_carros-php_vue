<template>
    <div class="form-group">
        <label :for="id">
            {{ titulo }}
        </label>

        <slot></slot>

        <small :id="idHelp" class="form-text text-muted">
            {{ textoAjuda }}
        </small>
    </div>
</template>

<script>
    export default {
        props: ['id', 'titulo', 'idHelp', 'textoAjuda']
    }
</script>
