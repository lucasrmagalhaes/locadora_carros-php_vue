<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component
                    titulo="Busca de Locações"
                >
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col">
                                <input-container-component
                                    id="inputId"
                                    titulo="ID"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID da locação."
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="inputId"
                                        aria-describedby="idHelp"
                                        placeholder="ID"
                                        v-model="busca.id"
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
                    titulo="Relação de locações"
                >
                    <template v-slot:conteudo>
                        <table-component
                            :dados="locacoes.data"
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
                                cliente_id: { titulo: 'Cliente', tipo: 'texto' },
                                carro_id: { titulo: 'Carro', tipo: 'texto' },
                                data_inicio_periodo: { titulo: 'Data Início Período', tipo: 'datetime' },
                                data_final_previsto_periodo: { titulo: 'Data Final Previsto Período', tipo: 'datetime' },
                                data_final_realizado_periodo: { titulo: 'Data Final Realizado Período', tipo: 'datetime' },
                                valor_diaria: { titulo: 'Valor Diária', tipo: 'texto' },
                                km_inicial: { titulo: 'KM Inicial', tipo: 'texto' },
                                km_final: { titulo: 'KM Final', tipo: 'texto' }
                            }"
                        />
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li
                                        v-for="link, key in locacoes.links"
                                        :key="key"
                                        :class="link.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(link)"

                                    >
                                        <a class="page-link" v-html="link.label"></a>
                                    </li>
                                </paginate-component>
                            </div>

                            <div class="col-2">
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm float-end"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalAdicionar"
                                >
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>

        <modal-component id="modalAdicionar" titulo="Adicionar Locação">
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
                        id="novoCliente"
                        titulo="Cliente"
                        id-help="novoClienteHelp"
                        texto-ajuda="Selecione o cliente"
                    >
                        <select
                            class="form-select"
                            aria-label="Clientes"
                            v-model="cliente_id"
                        >
                            <option value="" disabled selected>Escolha um cliente</option>

                            <option
                                v-for="cliente in clientes"
                                :key="cliente.id"
                                :value="cliente.id"
                            >
                                {{ cliente.nome }}
                            </option>
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novoCarro"
                        titulo="Carro"
                        id-help="novoCarroHelp"
                        texto-ajuda="Selecione o carro"
                    >
                        <select
                            class="form-select"
                            aria-label="Carros"
                            v-model="carro_id"
                        >
                            <option value="" disabled selected>Escolha um carro</option>

                            <option
                                v-for="carro in carros"
                                :key="carro.id"
                                :value="carro.id"
                            >
                                {{ carro.placa }}
                            </option>
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novaDataInicioPeriodo"
                        titulo="Data Início Período"
                        id-help="novaDataInicioPeriodoHelp"
                        texto-ajuda="Informe a data início período"
                    >
                        <input
                            type="date"
                            class="form-control"
                            id="novaDataInicioPeriodo"
                            aria-describedby="novaDataInicioPeriodoHelp"
                            placeholder="Data Início Período"
                            v-model="data_inicio_periodo"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novaDataFinalPrevistoPeriodo"
                        titulo="Data Final Previsto Período"
                        id-help="novaDataFinalPrevistoPeriodoHelp"
                        texto-ajuda="Informe a data final previsto período"
                    >
                        <input
                            type="date"
                            class="form-control"
                            id="novaDataFinalPrevistoPeriodo"
                            aria-describedby="novaDataFinalPrevistoPeriodoHelp"
                            placeholder="Data Final Previsto Período"
                            v-model="data_final_previsto_periodo"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novaDataFinalRealizadoPeriodo"
                        titulo="Data Final Realizado Período"
                        id-help="novaDataFinalRealizadoPeriodoHelp"
                        texto-ajuda="Informe a data final realizado período"
                    >
                        <input
                            type="date"
                            class="form-control"
                            id="novaDataFinalRealizadoPeriodo"
                            aria-describedby="novaDataFinalRealizadoPeriodoHelp"
                            placeholder="Data Final Realizado Período"
                            v-model="data_final_realizado_periodo"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novoValorDiaria"
                        titulo="Valor Diária"
                        id-help="novoValorDiariaHelp"
                        texto-ajuda="Informe o valor da diária"
                    >
                        <input
                            type="number"
                            class="form-control"
                            id="novoValorDiaria"
                            aria-describedby="novoValorDiariaHelp"
                            placeholder="Valor Diária"
                            v-model="valor_diaria"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novoKmInicial"
                        titulo="KM Inicial"
                        id-help="novoKmInicialHelp"
                        texto-ajuda="Informe o valor da diária"
                    >
                        <input
                            type="number"
                            class="form-control"
                            id="novoKmInicial"
                            aria-describedby="novoKmInicialHelp"
                            placeholder="KM Inicial"
                            v-model="km_inicial"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novoKmIFinal"
                        titulo="KM Final"
                        id-help="novoKmIFinalHelp"
                        texto-ajuda="Informe o valor da diária"
                    >
                        <input
                            type="number"
                            class="form-control"
                            id="novoKmIFinal"
                            aria-describedby="novoKmIFinalHelp"
                            placeholder="KM Final"
                            v-model="km_final"
                        />
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>

        <modal-component id="modalVisualizar" titulo="Visualizar Locação">
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
                <input-container-component titulo="Cliente">
                    <select
                        class="form-select"
                        aria-label="Clientes"
                        :value="$store.state.item.cliente_id"
                        disabled
                    >
                        <option value="" disabled>Escolha um cliente</option>

                        <option
                            v-for="cliente in clientes"
                            :key="cliente.id"
                            :value="cliente.id"
                        >
                            {{ cliente.nome }}
                        </option>
                    </select>
                </input-container-component>

                <input-container-component titulo="Carro">
                    <select
                        class="form-select"
                        aria-label="Carros"
                        :value="$store.state.item.carro_id"
                        disabled
                    >
                        <option value="" disabled>Escolha um carro</option>

                        <option
                            v-for="carro in carros"
                            :key="carro.id"
                            :value="carro.id"
                        >
                            {{ carro.placa }}
                        </option>
                    </select>
                </input-container-component>

                <input-container-component titulo="Data Início Período">
                    <input
                        type="datetime-local"
                        class="form-control"
                        :value="$store.state.item.data_inicio_periodo"
                        disabled
                    />
                </input-container-component>

                <input-container-component titulo="Data Final Previsto Período">
                    <input
                        type="datetime-local"
                        class="form-control"
                        :value="$store.state.item.data_final_previsto_periodo"
                        disabled
                    />
                </input-container-component>

                <input-container-component titulo="Data Final Realizado Período">
                    <input
                        type="datetime-local"
                        class="form-control"
                        :value="$store.state.item.data_final_realizado_periodo"
                        disabled
                    />
                </input-container-component>

                <input-container-component titulo="Valor diária">
                    <input
                        type="number"
                        class="form-control"
                        :value="$store.state.item.valor_diaria"
                        disabled
                    />
                </input-container-component>

                <input-container-component titulo="KM inicial">
                    <input
                        type="number"
                        class="form-control"
                        :value="$store.state.item.km_inicial"
                        disabled
                    />
                </input-container-component>

                <input-container-component titulo="KM final">
                    <input
                        type="number"
                        class="form-control"
                        :value="$store.state.item.km_final"
                        disabled
                    />
                </input-container-component>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>

        <modal-component id="modalAtualizar" titulo="Atualizar Locação">
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
                        id="atualizarCliente"
                        titulo="Cliente"
                        id-help="atualizarClienteHelp"
                        texto-ajuda="Informe o cliente"
                    >
                        <select
                            class="form-select"
                            aria-label="Clientes"
                            v-model="$store.state.item.cliente_id"
                        >
                            <option value="" disabled>Escolha um cliente</option>

                            <option
                                v-for="cliente in clientes"
                                :key="cliente.id"
                                :value="cliente.id"
                            >
                                {{ cliente.nome }}
                            </option>
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarCarro"
                        titulo="Carro"
                        id-help="atualizarCarroHelp"
                        texto-ajuda="Informe o carro"
                    >
                        <select
                            class="form-select"
                            aria-label="Carros"
                            v-model="$store.state.item.carro_id"
                        >
                            <option value="" disabled>Escolha um carro</option>

                            <option
                                v-for="carro in carros"
                                :key="carro.id"
                                :value="carro.id"
                            >
                                {{ carro.placa }}
                            </option>
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarDataFinalRealizadoPeriodo"
                        titulo="Data Final Realizado Período"
                        id-help="atualizarDataFinalRealizadoPeriodoHelp"
                        texto-ajuda="Informe a data final realizado período"
                    >
                        <input
                            type="datetime-local"
                            class="form-control"
                            id="atualizarDataFinalRealizadoPeriodo"
                            aria-describedby="atualizarDataFinalRealizadoPeriodoHelp"
                            placeholder="Data Final Realizado Período"
                            v-model="$store.state.item.data_final_realizado_periodo"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarValorDiaria"
                        titulo="Valor diária"
                        id-help="atualizarValorDiariaHelp"
                        texto-ajuda="Informe o valor"
                    >
                        <input
                            type="number"
                            class="form-control"
                            id="atualizarValorDiaria"
                            aria-describedby="atualizarValorDiariaHelp"
                            placeholder="Valor Diária"
                            v-model="$store.state.item.valor_diaria"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarKmInicial"
                        titulo="KM Inicial"
                        id-help="atualizarKmInicialHelp"
                        texto-ajuda="Informe o KM inicial"
                    >
                        <input
                            type="number"
                            class="form-control"
                            id="atualizarKmInicial"
                            aria-describedby="atualizarKmInicialHelp"
                            placeholder="KM Inicial"
                            v-model="$store.state.item.km_inicial"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarKmFinal"
                        titulo="KM Final"
                        id-help="atualizarKmFinalHelp"
                        texto-ajuda="Informe o KM final"
                    >
                        <input
                            type="number"
                            class="form-control"
                            id="atualizarKmFinal"
                            aria-describedby="atualizarKmFinalHelp"
                            placeholder="KM Final"
                            v-model="$store.state.item.km_final"
                        />
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>

        <modal-component id="modalRemover" titulo="Remover Locação">
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
                urlBase: `${this.base_url}/api/v1/locacao`,
                urlCliente: `${this.base_url}/api/v1/cliente`,
                urlCarro: `${this.base_url}/api/v1/carro`,
                urlPaginacao: '',
                urlFiltro: '',
                cliente_id: '',
                clientes: [],
                carro_id: '',
                carros: [],
                data_inicio_periodo: '',
                data_final_previsto_periodo: '',
                data_final_realizado_periodo: '',
                valor_diaria: '',
                km_inicial: '',
                km_final: '',
                transacaoStatus: '',
                transacaoDetalhaes: {},
                locacoes: { data: [] },
                busca: { id: '' }
            }
        },
        methods: {
            async carregarClientes() {
                let url = this.urlCliente;

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                };

                await axios.get(url, config).then(response => {
                    this.clientes = [...response.data.data];
                }).catch(err => {
                    console.log(err);
                });
            },
            async carregarCarros() {
                let url = this.urlCarro;

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                };

                await axios.get(url, config).then(response => {
                    this.carros = [...response.data.data];
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
                        this.locacoes = response.data;
                    }).catch(errors => {
                        console.log(errors);
                    });
            },
            salvar() {
                let formData = new FormData();

                formData.append('cliente_id', this.cliente_id);
                formData.append('carro_id', this.carro_id);
                formData.append('data_inicio_periodo', this.data_inicio_periodo);
                formData.append('data_final_previsto_periodo', this.data_final_previsto_periodo);
                formData.append('data_final_realizado_periodo', this.data_final_realizado_periodo);
                formData.append('valor_diaria', this.valor_diaria);
                formData.append('km_inicial', this.km_inicial);
                formData.append('km_final', this.km_final);

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
                formData.append('cliente_id', this.$store.state.item.cliente_id);
                formData.append('carro_id', this.$store.state.item.carro_id);
                formData.append('data_inicio_periodo', this.$store.state.item.data_inicio_periodo);
                formData.append('data_final_previsto_periodo', this.$store.state.item.data_final_previsto_periodo);
                formData.append('data_final_realizado_periodo', this.$store.state.item.data_final_realizado_periodo);
                formData.append('valor_diaria', this.$store.state.item.valor_diaria);
                formData.append('km_inicial', this.$store.state.item.km_inicial);
                formData.append('km_final', this.$store.state.item.km_final);

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
            this.carregarLista();
        },
        created() {
            this.carregarClientes();
            this.carregarCarros();
        }
    }
</script>
