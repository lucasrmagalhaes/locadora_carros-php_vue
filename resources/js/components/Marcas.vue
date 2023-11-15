<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Busca de marcas</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <label for="inputId">ID</label>
                                <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Informa o ID da marca" />
                                <small id="idHelp" class="form-text text-muted">Opcional. Informe o ID do registro.</small>
                            </div>

                            <div class="col">
                                <label for="inputNome">Nome</label>
                                <input type="number" class="form-control" id="inputNome" aria-describedby="idHelp" placeholder="Informe o nome da marca" />
                                <small id="idHelp" class="form-text text-muted">Opcional. Informe o nome da marca.</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm float-end">Pesquisar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
