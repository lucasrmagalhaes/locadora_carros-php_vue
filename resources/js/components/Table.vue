<template>
    <div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th v-for="titulo, key in titulos" :key="key" scope="col">
                        {{ titulo }}
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="marca in dados" :key="marca.id">
                    <th scope="row">
                        {{ marca.id }}
                    </th>

                    <td>
                        {{ marca.nome }}
                    </td>

                    <td>
                        <img :src="'/storage/' + marca.imagem" width="30" height="30" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos']
    };
</script>
