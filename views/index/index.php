<div class="container">
    <form class="form-horizontal" method="post" id="InfoCertificado">
        <fieldset>
            <div class="col-md-3 mb-3">
                <p><strong>Assinaturas</strong></p>
                <div class="form-outline">
                    <select id="selectAss1" name="selectAss1" class="btn btn-default col-md-12">
                        <option value="0" selected>Selecione o tipo de Assinatura*</option>
                        <option value="1">Coordenador(a) X Engenharia</option>
                        <option value="2">Coordenador(a) X Fisioterapia</option>
                        <option value="3">Professor(a) X ADS</option>
                    </select>
                </div>
            </div>
            <p><strong>Adicione a imagem da assinatura abaixo</strong></p>
            <p>Obs: Apenas se a mesma não se encontrar na lista de seleção.</p>
            <div class="col col-md-6">
                <div id="file">
                    <input type="file" class="form-control"/>
                </div>
            </div>
            <div class="col col-md-6 mb-3">
                <div id="removeBackground"></div>
            </div>
            <button type="button" id="btnTransparent" class="btn btn-dark">Ativa</button>
        </fieldset>
    </form>
</div>
<br>