<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component
                    titulo="Busca de marcas"
                >
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col">
                                <input-container-component
                                    id="inputId"
                                    titulo="ID"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID da marca."
                                >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="inputId"
                                        aria-describedby="idHelp"
                                        placeholder="ID"
                                        v-model="busca.id"
                                    />
                                </input-container-component>
                            </div>

                            <div class="col">
                                <input-container-component
                                    id="inputNome"
                                    titulo="Nome"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o nome da marca"
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="inputNome"
                                        aria-describedby="idHelp"
                                        placeholder="Nome"
                                        v-model="busca.nome"
                                    />
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm float-end"
                            @click="pesquisar()"
                        >
                            Pesquisar
                        </button>
                    </template>
                </card-component>

                <card-component
                    titulo="Relação de marcas"
                >
                    <template v-slot:conteudo>
                        <table-component
                            :dados="marcas.data"
                            :visualizar="{
                                visivel: true,
                                dataToggle: 'modal',
                                dataTarget: '#modalMarcaVisualizar'
                            }"
                            :atualizar="{
                                visivel: true,
                                dataToggle: 'modal',
                                dataTarget: '#modalMarcaAtualizar'
                            }"
                            :remover="{
                                visivel: true,
                                dataToggle: 'modal',
                                dataTarget: '#modalMarcaRemover'
                            }"
                            :titulos="{
                                id: { titulo: '#', tipo: 'texto' },
                                nome: { titulo: 'Nome', tipo: 'texto' },
                                imagem: { titulo: 'Imagem', tipo: 'imagem' },
                                created_at: { titulo: 'Criação', tipo: 'data' },
                            }"
                        />
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li
                                        v-for="link, key in marcas.links"
                                        :key="key"
                                        :class="link.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(link)"

                                    >
                                        <a class="page-link" v-html="link.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col-2">
                                <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalMarcaAdicionar">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>

        <modal-component id="modalMarcaAdicionar" titulo="Adicionar Marca">
            <template v-slot:alertas>
                <alert-component
                    tipo="success"
                    :detalhes="transacaoDetalhaes"
                    titulo="Cadastro realizado com sucesso."
                    v-if="transacaoStatus == 'adicionado'"
                />

                <alert-component
                    tipo="danger"
                    :detalhes="transacaoDetalhaes"
                    titulo="Erro ao tentar cadastrar."
                    v-if="transacaoStatus == 'erro'"
                />
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component
                        id="novoNome"
                        titulo="Nome"
                        id-help="novoNomeHelp"
                        texto-ajuda="Informe o nome da marca"
                    >
                        <input
                            type="text"
                            class="form-control"
                            id="novoNome"
                            aria-describedby="novoNomeHelp"
                            placeholder="Nome"
                            v-model="nomeMarca"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novaImagem"
                        titulo="Imagem"
                        id-help="novaImagemHelp"
                        texto-ajuda="Selecione uma imagem no formato PNG"
                    >
                        <input
                            type="file"
                            class="form-control-file"
                            id="novaImagem"
                            aria-describedby="novaImagemHelp"
                            placeholder="Selecione uma imagem"
                            @change="carregarImagem($event)"
                        />
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>

        <modal-component id="modalMarcaVisualizar" titulo="Visualizar Marca">
            <template v-slot:alertas>
                <alert-component
                    tipo="success"
                    :detalhes="transacaoDetalhaes"
                    titulo="Cadastro realizado com sucesso."
                    v-if="transacaoStatus == 'adicionado'"
                />

                <alert-component
                    tipo="danger"
                    :detalhes="transacaoDetalhaes"
                    titulo="Erro ao tentar cadastrar."
                    v-if="transacaoStatus == 'erro'"
                />
            </template>

            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input
                        type="text"
                        class="form-control"
                        :value="$store.state.item.id"
                        disabled
                    />
                </input-container-component>

                <input-container-component titulo="Nome">
                    <input
                        type="text"
                        class="form-control"
                        :value="$store.state.item.nome"
                        disabled
                    />
                </input-container-component>

                <div class="col-12 text-center">
                    <img
                        width="400"
                        :src="'storage/' + $store.state.item.imagem"
                        v-if="$store.state.item.imagem"
                    />
                </div>

                <input-container-component titulo="Data de criação">
                    <input
                        type="text"
                        class="form-control"
                        :value="$store.state.item.created_at | formataTimestampGlobal"
                        disabled
                    />
                </input-container-component>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>

        <modal-component id="modalMarcaAtualizar" titulo="Atualizar Marca">
            <template v-slot:alertas>
                <alert-component
                    tipo="success"
                    titulo="Transação realizada com sucesso."
                    :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'sucesso'"
                />

                <alert-component
                    tipo="danger"
                    titulo="Erro na transação."
                    :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'erro'"
                />
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component
                        id="atualizarNome"
                        titulo="Nome"
                        id-help="atualizarNomeHelp"
                        texto-ajuda="Informe o nome da marca"
                    >
                        <input
                            type="text"
                            class="form-control"
                            id="atualizarNome"
                            aria-describedby="atualizarNomeHelp"
                            placeholder="Nome"
                            v-model="$store.state.item.nome"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarImagem"
                        titulo="Imagem"
                        id-help="atualizarImagemHelp"
                        texto-ajuda="Selecione uma imagem no formato PNG"
                    >
                        <input
                            type="file"
                            class="form-control-file"
                            id="atualizarImagem"
                            aria-describedby="atualizarImagemHelp"
                            placeholder="Selecione uma imagem"
                            @change="carregarImagem($event)"
                        />
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>

        <modal-component id="modalMarcaRemover" titulo="Remover Marca">
            <template v-slot:alertas>
                <alert-component
                    tipo="success"
                    titulo="Transação realizada com sucesso."
                    :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'sucesso'"
                />

                <alert-component
                    tipo="danger"
                    titulo="Erro na transação."
                    :detalhes="$store.state.transacao"
                    v-if="$store.state.transacao.status == 'erro'"
                />
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input
                        type="text"
                        class="form-control"
                        :value="$store.state.item.id"
                        disabled
                    />
                </input-container-component>

                <input-container-component titulo="Nome">
                    <input
                        type="text"
                        class="form-control"
                        :value="$store.state.item.nome"
                        disabled
                    />
                </input-container-component>
            </template>

            <template v-slot:rodape>
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Fechar
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    @click="remover()"
                    v-if="$store.state.transacao.status != 'sucesso'"
                >
                    Remover
                </button>
            </template>
        </modal-component>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['base_url'],
        computed: {
            token() {
                let token = document.cookie.split(';').find(indice => {
                    return indice.includes('token=');
                });

                token = token.split('=')[1];
                token = 'Bearer ' + token;

                return token;
            }
        },
        data() {
            return {
                urlBase: `${this.base_url}/api/v1/marca`,
                urlPaginacao: '',
                urlFiltro: '',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhaes: {},
                marcas: { data: [] },
                busca: { id: '', nome: '' }
            }
        },
        methods: {
            pesquisar() {
                let filtro = '';

                for (let chave in this.busca) {
                    if (this.busca[chave]) {
                        if (filtro != '') {
                            filtro += ';';
                        }

                        filtro += chave + ':like:' + this.busca[chave];
                    }
                }

                if (filtro != '') {
                    this.urlPaginacao = 'page=1';
                    this.urlFiltro = '&filtro=' + filtro;
                } else {
                    this.urlFiltro = '';
                }

                this.carregarLista();
            },
            paginacao(link) {
                if (link.url) {
                    this.urlPaginacao = link.url.split('?')[1]
                    this.carregarLista();
                }
            },
            carregarLista() {
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro;

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                };

                axios.get(url, config)
                    .then(response => {
                        this.marcas = response.data;
                    }).catch(errors => {
                        console.log(errors);
                    });
            },
            carregarImagem(event) {
                this.arquivoImagem = event.target.files;
            },
            salvar() {
                let formData = new FormData();

                formData.append('nome', this.nomeMarca);
                formData.append('imagem', this.arquivoImagem[0]);

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                };

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'adicionado';

                        this.transacaoDetalhaes = {
                            mensagem: 'ID do registro: ' + response.data.id
                        };

                        this.carregarLista();
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhaes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        }
                    });
            },
            atualizar() {
                let url = this.urlBase + '/' + this.$store.state.item.id;

                let formData = new FormData();

                formData.append('_method', 'patch');
                formData.append('nome', this.$store.state.item.nome);

                if (this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0]);
                }

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                };

                axios.post(url, formData, config)
                    .then((response) => {
                        atualizarImagem.value = '';

                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = 'Registro atualizado com sucesso.';

                        this.carregarLista();
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = errors.response.data.message;
                        this.$store.state.transacao.dados = errors.response.data.errors;
                    });
            },
            remover() {
                let confirmacao = confirm('Tem certeza que deseja remover esse registro?')

                if (!confirmacao) {
                    return false;
                }

                let url = this.urlBase + '/' + this.$store.state.item.id;

                let formData = new FormData();
                formData.append('_method', 'delete');

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                };

                axios.post(url, formData, config)
                    .then((response) => {
                        this.$store.state.transacao.status = 'sucesso';
                        this.$store.state.transacao.mensagem = response.data.msg;

                        this.carregarLista();
                    }).catch((errors) => {
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = errors.response.data.errors;
                    });
            }
        },
        mounted() {
            this.carregarLista()
        }
    }
</script>
