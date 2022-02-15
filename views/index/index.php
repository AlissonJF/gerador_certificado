<div class="container">
    <form class="form-horizontal" method="post" id="InfoCertificado">
        <fieldset>
            <div class="row">
                <div class="col col-md-6">
                    <p class="text-center"><strong>Aluno</strong></p>
                    <div class="col-md-12 mb-3">
                        <div class="form-outline">
                            <input name="email" class="form-control" type="text">
                            <label class="form-label" for="email">E-Mail*</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-outline">
                            <input name="cpf" class="form-control" type="text" maxlength="14"
                                   onkeypress="formatar('###.###.###-##', this);">
                            <label class="form-label" for="cpf">CPF*</label>
                        </div>
                    </div>
                    <p class="text-center"><strong>Adicione a imagem da assinatura</strong><br>Obs: Dê preferência em adicionar uma imagem <strong>PNG</strong>.</p>
                    <p></p>
                    <div class="col col-md-12 mb-3">
                        <div id="file">
                            <input id="receiveFile" type="file" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-outline text-center">
                        <button type="button" id="GeraCerti" class="btn btn-dark">Gerar Certificado</button>
                    </div>
                </div>
                <div class="col col-md-6" style="padding-left: 60px">
                    <br>
                    <div class="form-outline text-center mb-3">
                        <img id="printImage" src="" style="border-radius: 5px; box-shadow: 6px 6px 8px" width="600"
                             height="400" alt="Adicione uma imagem"/>
                        <br><br>
                        <button type="button" id="removeBackground" class="btn btn-default">Remover Fundo</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<br>