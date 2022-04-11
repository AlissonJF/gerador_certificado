<div class="container">
    <form class="form-horizontal" method="post" id="InfoCertificado">
        <fieldset>
            <div class="row">
                <div style="margin-left: 24%;">
                    <div class="col col-md-6" id="FormBasic">
                        <p class="text-center"><strong>Aluno</strong></p>
                        <div class="col-md-12 mb-3">
                            <div class="form-outline">
                                <input name="email" class="form-control" type="text">
                                <label class="form-label" for="email">E-Mail*</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-outline">
                                <input name="cpf" class="form-control" type="text" maxlength="14" onkeypress="formatar('###.###.###-##', this);">
                                <label class="form-label" for="cpf">CPF*</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="AbrirModal" class="text-center mb-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
                        Adicionar Assinatura
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col col-md-6">
                                        <p class="text-center"><strong>Adicione a imagem da assinatura</strong><br>Obs: Dê preferência em
                                            adicionar uma imagem <strong>JPG</strong> ou <strong>JPEG</strong>.</p>
                                        <p></p>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-outline">
                                                <input name="nomeImage" id="nameImage" class="form-control" type="text">
                                                <label class="form-label" for="nomeImage">Nome do responsável pela assinatura</label>
                                            </div>
                                        </div>
                                        <div class="col col-md-12 mb-3">
                                            <div>
                                                <input id="receiveFile" type="file" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col col-md-12 mb-3">
                                            <label class="form-label" for="ajusteContraste"><strong>Obs: caso a
                                                    imagem fique apagada ou estourada, ajustar na barra de contraste
                                                    abaixo</strong></label>
                                            <div class="range">
                                                <input type="range" class="form-range" min="100" max="200" id="ajusteContraste" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-md-6 mb-3 text-center">
                                        <img id="printImage" src="" style="border-radius: 5px; box-shadow: 6px 6px 8px" width="500" height="300" alt="Adicione uma imagem" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="removeBackground" class="btn btn-default">Salvar Assinatura</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-outline text-center">
                <button type="button" id="GeraCerti" class="btn btn-dark">Gerar Certificado</button>
            </div>
        </fieldset>
    </form>
</div>
<br>