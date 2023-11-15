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
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" />
                                </input-container-component>
                            </div>

                            <div class="col">
                                <input-container-component
                                    id="inputNome"
                                    titulo="Nome"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o nome da marca"
                                >
                                    <input type="number" class="form-control" id="inputNome" aria-describedby="idHelp" placeholder="Nome" />
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                    </template>
                </card-component>

                <card-component
                    titulo="Relação de marcas"
                >
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalMarca">
                            Adicionar
                        </button>
                    </template>
                </card-component>
            </div>
        </div>

        <modal-component id="modalMarca" titulo="Adicionar Marca">
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component
                        id="novoNome"
                        titulo="Nome"
                        id-help="novoNomeHelp"
                        texto-ajuda="Informe o nome da marca"
                    >
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome" />
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component
                        id="novaImagem"
                        titulo="Imagem"
                        id-help="novaImagemHelp"
                        texto-ajuda="Selecione uma imagem no formato PNG"
                    >
                        <input type="file" class="form-control-file" id="novaImagem" aria-describedby="novaImagemHelp" placeholder="Selecione uma imagem" />
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">Salvar</button>
            </template>
        </modal-component>
    </div>
</template>
