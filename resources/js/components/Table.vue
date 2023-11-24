<template>
    <div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th v-for="value, key in titulos" :key="key" scope="col">
                        {{ value.titulo }}
                    </th>

                    <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel"></th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'texto'">
                            {{ valor }}
                        </span>

                        <span v-if="titulos[chaveValor].tipo == 'data'">
                            {{ valor | formataTimestampGlobal }}
                        </span>

                        <span v-if="titulos[chaveValor].tipo == 'datetime'">
                            {{ valor | formataDateTimeGlobal }}
                        </span>

                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/' + valor" width="30" height="30" />
                        </span>

                        <span v-if="titulos[chaveValor].tipo == 'boolean'">
                            {{ valor == '1' ? 'Sim' : 'Não' }}
                        </span>
                    </td>

                    <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                        <button
                            type="button"
                            v-if="visualizar.visivel"
                            class="btn btn-outline-primary btn-sm"
                            :data-bs-toggle="visualizar.dataToggle"
                            :data-bs-target="visualizar.dataTarget"
                            @click="setStore(obj)"
                        >
                            Visualizar
                        </button>

                        <button
                            type="button"
                            v-if="atualizar.visivel"
                            class="btn btn-outline-primary btn-sm"
                            :data-bs-toggle="atualizar.dataToggle"
                            :data-bs-target="atualizar.dataTarget"
                            @click="setStore(obj)"
                        >
                            Atualizar
                        </button>

                        <button
                            type="button"
                            v-if="remover.visivel"
                            class="btn btn-outline-danger btn-sm"
                            :data-bs-toggle="remover.dataToggle"
                            :data-bs-target="remover.dataTarget"
                            @click="setStore(obj)"
                        >
                            Remover
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'atualizar', 'visualizar', 'remover'],
        methods: {
            setStore(obj) {
                this.$store.state.transacao.status = '';
                this.$store.state.transacao.mensagem = '';
                this.$store.state.transacao.dados = '';
                this.$store.state.item = obj;
            }
        },
        computed: {
            dadosFiltrados() {
                let campos = Object.keys(this.titulos);
                let dadosFiltrados = [];

                this.dados.map((item, chave) => {
                    let itemFiltrado = {};

                    campos.forEach(campo => {
                        itemFiltrado[campo] = item[campo];
                    })

                    dadosFiltrados.push(itemFiltrado);
                })

                return dadosFiltrados;
            }
        }
    }
</script>
