<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component
                    titulo="Busca de carros"
                >
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col">
                                <input-container-component
                                    id="inputPlaca"
                                    titulo="Placa"
                                    id-help="placaHelp"
                                    texto-ajuda="Opcional. Informe a placa do carro"
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="inputPlaca"
                                        aria-describedby="placaHelp"
                                        placeholder="Placa"
                                        v-model="busca.placa"
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
                    titulo="Relação de carros"
                >
                    <template v-slot:conteudo>
                        <table-component
                            :dados="carros.data"
                            :visualizar="{
                                visivel: true,
                                dataToggle: 'modal',
                                dataTarget: '#modalVisualizar'
                            }"
                            :atualizar="{
                                visivel: true,
                                dataToggle: 'modal',
                                dataTarget: '#modalAtualizar'
                            }"
                            :remover="{
                                visivel: true,
                                dataToggle: 'modal',
                                dataTarget: '#modalRemover'
                            }"
                            :titulos="{
                                id: { titulo: '#', tipo: 'texto' },
                                modelo_id: { titulo: 'Modelo', tipo: 'texto' },
                                placa: { titulo: 'Placa', tipo: 'texto' },
                                disponivel: { titulo: 'Disponível', tipo: 'boolean' },
                                km: { titulo: 'KM', tipo: 'texto' },
                                created_at: { titulo: 'Criação', tipo: 'data' }
                            }"
                        />
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li
                                        v-for="link, key in carros.links"
                                        :key="key"
                                        :class="link.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(link)"

                                    >
                                        <a class="page-link" v-html="link.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col-2">
                                <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalAdicionar">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>

        <modal-component id="modalAdicionar" titulo="Adicionar Carro">
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
                        id="novoModelo"
                        titulo="Modelo"
                        id-help="novoModeloHelp"
                        texto-ajuda="Informe o modelo"
                    >
                        <select
                            class="form-select"
                            aria-label="Modelos"
                            v-model="modelo_id"
                        >
                            <option value="" disabled selected>Escolha um modelo</option>

                            <option
                                v-for="modelo in modelos"
                                :key="modelo.id"
                                :value="modelo.id"
                            >
                                {{ modelo.nome }}
                            </option>
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novaPlaca"
                        titulo="Placa"
                        id-help="novaPlacaHelp"
                        texto-ajuda="Informe a placa"
                    >
                        <input
                            type="text"
                            class="form-control"
                            id="novaPlaca"
                            aria-describedby="novaPlacaHelp"
                            placeholder="Placa"
                            v-model="placa"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novoDisponivel"
                        id-help="disponivelHelp"
                        texto-ajuda="Informe se está disponível"
                    >
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="novoDisponivel"
                                true-value="1"
                                false-value="0"
                                v-model="disponivel"
                            />

                            <label class="form-check-label" for="flexCheckChecked">
                                Disponível
                            </label>
                        </div>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novoKm"
                        titulo="KM"
                        id-help="kmHelp"
                        texto-ajuda="Informe o KM"
                    >
                        <input
                            type="number"
                            class="form-control"
                            id="novoKm"
                            aria-describedby="kmHelp"
                            placeholder="km"
                            v-model="km"
                        />
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>

        <modal-component id="modalVisualizar" titulo="Visualizar Carro">
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
                        id="atualizarModelo"
                        titulo="Modelo"
                        id-help="atualizarModeloHelp"
                        texto-ajuda="Informe a modelo"
                    >
                        <select
                            class="form-select"
                            aria-label="Marcas"
                            v-model="$store.state.item.modelo_id"
                            disabled
                        >
                            <option value="" disabled>Escolha um modelo</option>

                            <option
                                v-for="modelo in modelos"
                                :key="modelo.id"
                                :value="modelo.id"
                            >
                                {{ modelo.nome }}
                            </option>
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarPlaca"
                        titulo="Placa"
                        id-help="atualizarPlacaHelp"
                        texto-ajuda="Informe a placa"
                    >
                        <input
                            type="text"
                            class="form-control"
                            id="atualizarPlaca"
                            aria-describedby="atualizarPlacaHelp"
                            placeholder="Placa"
                            v-model="$store.state.item.placa"
                            disabled
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarDisponivel"
                        id-help="atualizarDisponivelHelp"
                        texto-ajuda="Informe se está disponível"
                    >
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="atualizarDisponivel"
                                true-value="1"
                                false-value="0"
                                v-model="$store.state.item.disponivel"
                                disabled
                            />

                            <label class="form-check-label" for="flexCheckChecked">
                                Disponível
                            </label>
                        </div>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>

        <modal-component id="modalAtualizar" titulo="Atualizar Carro">
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
                        id="atualizarModelo"
                        titulo="Modelo"
                        id-help="atualizarModeloHelp"
                        texto-ajuda="Informe o modelo"
                    >
                        <select
                            class="form-select"
                            aria-label="Modelos"
                            v-model="$store.state.item.modelo_id"
                        >
                            <option value="" disabled>Escolha um modelo</option>

                            <option
                                v-for="modelo in modelos"
                                :key="modelo.id"
                                :value="modelo.id"
                            >
                                {{ modelo.nome }}
                            </option>
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarPlaca"
                        titulo="Placa"
                        id-help="atualizarPlacaHelp"
                        texto-ajuda="Informe a placa"
                    >
                        <input
                            type="text"
                            class="form-control"
                            id="atualizarPlaca"
                            aria-describedby="atualizarPlacaHelp"
                            placeholder="Placa"
                            v-model="$store.state.item.placa"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarDisponivel"
                        id-help="atualizarDisponivelHelp"
                        texto-ajuda="Informe se está disponível"
                    >
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="atualizarDisponivel"
                                true-value="1"
                                false-value="0"
                                v-model="$store.state.item.disponivel"
                            />

                            <label class="form-check-label" for="flexCheckChecked">
                                Disponível
                            </label>
                        </div>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarKm"
                        titulo="KM"
                        id-help="atualizarKmHelp"
                        texto-ajuda="Informe o KM"
                    >
                        <input
                            type="text"
                            class="form-control"
                            id="atualizarKm"
                            aria-describedby="atualizarKmHelp"
                            placeholder="KM"
                            v-model="$store.state.item.km"
                        />
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>

        <modal-component id="modalRemover" titulo="Remover Carro">
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
                <input-container-component titulo="#">
                    <input
                        type="text"
                        class="form-control"
                        :value="$store.state.item.id"
                        disabled
                    />
                </input-container-component>

                <input-container-component titulo="Placa">
                    <input
                        type="text"
                        class="form-control"
                        :value="$store.state.item.placa"
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
                urlBase: `${this.base_url}/api/v1/carro`,
                urlModelo: `${this.base_url}/api/v1/modelo`,
                urlPaginacao: '',
                urlFiltro: '',
                modelo_id: '',
                modelos: [],
                placa: '',
                disponivel: '0',
                km: '',
                transacaoStatus: '',
                transacaoDetalhaes: {},
                carros: { data: [] },
                busca: { placa: '' }
            }
        },
        methods: {
            async carregarModelos() {
                let url = this.urlModelo;

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                };

                await axios.get(url, config).then(response => {
                    console.log(response);

                    this.modelos = [...response.data.data];
                }).catch(err => {
                    console.log(err);
                });
            },
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
                        this.carros = response.data;
                    }).catch(errors => {
                        console.log(errors);
                    });
            },
            salvar() {
                let formData = new FormData();

                formData.append('modelo_id', this.modelo_id);
                formData.append('placa', this.placa);
                formData.append('disponivel', this.disponivel);
                formData.append('km', this.km);

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
                formData.append('modelo_id', this.$store.state.item.modelo_id);
                formData.append('placa', this.$store.state.item.placa);
                formData.append('disponivel', this.$store.state.item.disponivel);
                formData.append('km', this.$store.state.item.km);

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                };

                axios.post(url, formData, config)
                    .then(() => {
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
        },
        created() {
            this.carregarModelos();
        }
    }
</script>
