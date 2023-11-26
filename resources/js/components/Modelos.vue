<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component
                    titulo="Busca de modelos"
                >
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col">
                                <input-container-component
                                    id="inputId"
                                    titulo="ID"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID do modelo."
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
                                    texto-ajuda="Opcional. Informe o nome do modelo"
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
                    titulo="Relação de modelos"
                >
                    <template v-slot:conteudo>
                        <table-component
                            :dados="modelos.data"
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
                                marca_id: { titulo: 'Marca', tipo: 'texto' },
                                nome: { titulo: 'Nome', tipo: 'texto' },
                                imagem: { titulo: 'Imagem', tipo: 'imagem' },
                                numero_portas: { titulo: 'Número de portas', tipo: 'texto' },
                                lugares: { titulo: 'Lugares', tipo: 'texto' },
                                created_at: { titulo: 'Criação', tipo: 'data' },
                            }"
                        />
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li
                                        v-for="link, key in modelos.links"
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

        <modal-component id="modalAdicionar" titulo="Adicionar Modelo">
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
                        id="novoMarca"
                        titulo="Marca"
                        id-help="novaMarcaHelp"
                        texto-ajuda="Informe a marca"
                    >
                        <select
                            class="form-select"
                            aria-label="Marcas"
                            v-model="marca_id"
                        >
                            <option value="" disabled selected>Escolha uma marca</option>

                            <option
                                v-for="marca in marcas"
                                :key="marca.id"
                                :value="marca.id"
                            >
                                {{ marca.nome }}
                            </option>
                        </select>
                    </input-container-component>
                </div>

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
                            v-model="nomeModelo"
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

                <div class="form-group">
                    <input-container-component
                        id="novoNumeroPortas"
                        titulo="Número de portas"
                        id-help="numeroPortasHelp"
                        texto-ajuda="Informe o número de portas"
                    >
                        <input
                            type="text"
                            class="form-control"
                            id="novoNumeroPortas"
                            aria-describedby="numeroPortasHelp"
                            placeholder="Número de portas"
                            v-model="numeroPortas"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novoLugares"
                        titulo="Lugares"
                        id-help="lugaresHelp"
                        texto-ajuda="Informe a quantidade de lugares"
                    >
                        <input
                            type="text"
                            class="form-control"
                            id="novoLugares"
                            aria-describedby="lugaresHelp"
                            placeholder="Número de lugares"
                            v-model="lugares"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novoAirBag"
                        id-help="airbagHelp"
                        texto-ajuda="Informe se possui airbag"
                    >
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="novoAirBag"
                                true-value="1"
                                false-value="0"
                                v-model="airBag"
                            />

                            <label class="form-check-label" for="flexCheckChecked">
                                Airbag
                            </label>
                        </div>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novoAbs"
                        id-help="absHelp"
                        texto-ajuda="Informe se possui ABS"
                    >
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="novoAbs"
                                true-value="1"
                                false-value="0"
                                v-model="abs"
                            />

                            <label class="form-check-label" for="flexCheckChecked">
                                ABS
                            </label>
                        </div>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>

        <modal-component id="modalVisualizar" titulo="Visualizar Modelo">
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

        <modal-component id="modalAtualizar" titulo="Atualizar Modelo">
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
                        id="atualizarMarca"
                        titulo="Marca"
                        id-help="atualizarMarcaHelp"
                        texto-ajuda="Informe a marca"
                    >
                        <select
                            class="form-select"
                            aria-label="Marcas"
                            v-model="$store.state.item.marca_id"
                        >
                            <option value="" disabled>Escolha uma marca</option>

                            <option
                                v-for="marca in marcas"
                                :key="marca.id"
                                :value="marca.id"
                            >
                                {{ marca.nome }}
                            </option>
                        </select>
                    </input-container-component>
                </div>

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

                <div class="form-group">
                    <input-container-component
                        id="atualizarNumeroPortas"
                        titulo="Número de portas"
                        id-help="atualizarNumeroPortasHelp"
                        texto-ajuda="Informe o número de portas"
                    >
                        <input
                            type="text"
                            class="form-control"
                            id="atualizarNumeroPortas"
                            aria-describedby="atualizarNumeroPortasHelp"
                            placeholder="Número de portas"
                            v-model="$store.state.item.numero_portas"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarLugares"
                        titulo="Lugares"
                        id-help="atualizarLugaresHelp"
                        texto-ajuda="Informe a quantidade de lugares"
                    >
                        <input
                            type="text"
                            class="form-control"
                            id="atualizarLugares"
                            aria-describedby="atualizarLugaresHelp"
                            placeholder="Número de lugares"
                            v-model="$store.state.item.lugares"
                        />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarAirBag"
                        id-help="atualizarAirbagHelp"
                        texto-ajuda="Informe se possui airbag"
                    >
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="atualizarAirBag"
                                true-value="1"
                                false-value="0"
                                v-model="$store.state.item.air_bag"
                            />

                            <label class="form-check-label" for="flexCheckChecked">
                                Airbag
                            </label>
                        </div>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="atualizarAbs"
                        id-help="atualizarAbsHelp"
                        texto-ajuda="Informe se possui ABS"
                    >
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="atualizarAbs"
                                true-value="1"
                                false-value="0"
                                v-model="$store.state.item.abs"
                            />

                            <label class="form-check-label" for="flexCheckChecked">
                                ABS
                            </label>
                        </div>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>

        <modal-component id="modalRemover" titulo="Remover Modelo">
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
                urlBase: `${this.base_url}/api/v1/modelo`,
                urlMarca: `${this.base_url}/api/v1/marca`,
                urlPaginacao: '',
                urlFiltro: '',
                marca_id: '',
                marcas: [],
                nomeModelo: '',
                numeroPortas: '',
                lugares: '',
                airBag: '0',
                abs: '0',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhaes: {},
                modelos: { data: [] },
                busca: { id: '', nome: '' }
            }
        },
        methods: {
            async carregarMarcas() {
                let url = this.urlMarca;

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                };

                await axios.get(url, config).then(response => {
                    this.marcas = [...response.data.data];
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
                        this.modelos = response.data;
                    }).catch(errors => {
                        console.log(errors);
                    });
            },
            carregarImagem(event) {
                this.arquivoImagem = event.target.files;
            },
            salvar() {
                let formData = new FormData();

                formData.append('marca_id', this.marca_id);
                formData.append('nome', this.nomeModelo);
                formData.append('imagem', this.arquivoImagem[0]);
                formData.append('numero_portas', this.numeroPortas);
                formData.append('lugares', this.lugares);
                formData.append('air_bag', this.airBag);
                formData.append('abs', this.abs);

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
                formData.append('marca_id', this.$store.state.item.marca_id);
                formData.append('nome', this.$store.state.item.nome);

                if (this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0]);
                }

                formData.append('numero_portas', this.$store.state.item.numero_portas);
                formData.append('lugares', this.$store.state.item.lugares);
                formData.append('air_bag', this.$store.state.item.air_bag ?? '0');
                formData.append('abs', this.$store.state.item.abs ?? '0');

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                };

                axios.post(url, formData, config)
                    .then(() => {
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
        },
        created() {
            this.carregarMarcas();
        }
    }
</script>
