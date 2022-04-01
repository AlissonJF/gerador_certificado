<form class="form-horizontal" method="post" id="formCertificado">
    <fieldset>
        <div class="row">
            <div class="col col-md-6 text-center" style="width: 650px">
                <div class="col-md-12 mb-3">
                    <p><strong>Assinaturas</strong></p>
                    <div class="form-outline">
                        <select id="selectAss1" name="selectAss1" class="btn btn-default col-md-12"></select>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-outline">
                        <select id="selectAss2" name="selectAss2" class="btn btn-default col-md-12"></select>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-outline">
                        <select id="selectAss3" name="selectAss3" class="btn btn-default col-md-12"></select>
                    </div>
                </div>


                <div class="col-md-12 mb-3">
                    <button id="verCertificado" type="button" class="btn btn-default col-md-12">
                        Atualizar Certificado
                    </button>
                </div>

                <p><strong>Movimentação da Assinatura</strong></p>

                <div class="col-md-6" style="padding-left: 45%">
                    <div class="ArrowUP">
                        <div id="cta">
                            <span class="arrow primera next "></span>
                            <img src="<?= URL; ?>public/images/up-arrow.png" class="arrow arrowUP next ">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-outline" style="visibility: hidden" id="SelectMove">
                        <select id="AssMove" name="AssMove" class="btn btn-default col-md-12">
                            <option value="0" selected>Mover Assinatura</option>
                            <option value="1">Assinatura 1 (lado esquerdo)</option>
                            <option value="2">Assinatura 2 (lado meio)</option>
                            <option value="3">Assinatura 3 (lado direito)</option>
                        </select>
                    </div>
                </div>
                <p></p>
                <div class="col-md-6" style="padding-left: 35%">
                    <div class="ArrowLeft">
                        <div id="cta">
                            <span class="arrow primera next "></span>
                            <img src="<?= URL; ?>public/images/left-arrow.png" class="arrow arrowLEFT next ">
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="padding-left: 55%">
                    <div class="ArrowRight">
                        <div id="cta">
                            <span class="arrow primera next "></span>
                            <img src="<?= URL; ?>public/images/right-arrow.png"
                                 class="arrow arrowRIGHT next ">
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="col-md-6" style="padding-left: 45%">
                    <div class="ArrowDown">
                        <div id="cta">
                            <span class="arrow primera next "></span>
                            <img src="<?= URL; ?>public/images/down-arrow.png" class="arrow arrowDOWN next ">
                        </div>
                    </div>
                </div>

                <br><br>

                <div class="row" id="editPositions">
                    <div class="col-md-4">
                        <div>
                            <label class="form-label" for="posicaoX">Posição X</label>
                            <input name="posicaoX" disabled value="" id="posicaoX"
                                   class="form-control text-center" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <label class="form-label" for="tamanho1">Tamanho</label>
                            <input name="tamanho1" value="" id="tamanho1"
                                   class="form-control text-center" type="text">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <label class="form-label" for="posicaoY">Posição Y</label>
                            <input name="posicaoY" disabled value="" id="posicaoY"
                                   class="form-control text-center" type="text">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-md-6" style="padding-top: 20px">
                <div id="viewPDF"></div>
                <p></p>
                <div style="padding-left: 50%">
                    <button type="button" id="SalvarDados" class="btn btn-default">Salvar</button>
                </div>
            </div>
        </div>
    </fieldset>
</form>
<br>