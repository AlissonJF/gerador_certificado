$(document).ready(function () {
    let posicaoX = 20; // MAX UP posicao X = 210px MIN DOWN posicao X = 20px
    let posicaoX2 = 120;
    let posicaoX3 = 210;
    let posicaoY = 140; // MAX UP posicao Y = 130px MIN DOWN posicao Y = 150px
    let posicaoY2 = 140;
    let posicaoY3 = 140;

    $('.ArrowUP').click(function () {
        posicaoY -= 10;
        posicaoY2 -= 10;
        posicaoY3 -= 10;
        $("#formCertificado").submit();
    });

    $('.ArrowDown').click(function () {
        posicaoY += 10;
        posicaoY2 += 10;
        posicaoY3 += 10;
        $("#formCertificado").submit();
    });

    $('.ArrowLeft').click(function () {
        posicaoX -= 10;
        posicaoX2 -= 10;
        posicaoX3 -= 10;
        $("#formCertificado").submit();
    });

    $('.ArrowRight').click(function () {
        posicaoX += 10;
        posicaoX2 += 10;
        posicaoX3 += 10;
        $("#formCertificado").submit();
    });

    $(document).on("click", "#verCertificado", function () {
        $("#formCertificado").submit()
    });

    $(document).on("submit", "#formCertificado", function (event) {
        event.preventDefault();
        $("#editPositions").html(`
            <div class="col-md-4">
                <div>
                    <label class="form-label" for="posicaoX">Posição X</label>
                    <input name="posicaoX" disabled value="" id="posicaoX"
                           class="form-control text-center" type="text">
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <label class="form-label" for="tamanho">Tamanho</label>
                    <input name="tamanho" value="" id="tamanho"
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
        `);
        arrumaPosicao(this)
    });

    function selectAssinatura() {
        getUrl(BASEURL + "/gerador/selectAssinatura").then(res => {
            var txt = `<option selected disabled>SELECIONE A ASSINATURA</option>`;

            res.data.forEach(element => {
                txt += `<option value="${element.sequencia}">${element.nomeassinatura}</option>`
            })
            $("#selectAss1").html(txt);
            $("#selectAss2").html(txt);
            $("#selectAss3").html(txt);
        })
    }

    selectAssinatura()

    function arrumaPosicao(dados) {
        $.post(BASEURL + "/gerador/arrumaPosicao", `${$(dados).serialize()}
        &posicaoX=${posicaoX}&posicaoY=${posicaoY}
        &posicaoX2=${posicaoX2}&posicaoY2=${posicaoY2}
        &posicaoX3=${posicaoX3}&posicaoY3=${posicaoY3}`, function (data) {
            if (data == '') {
                swal("Oops", 'Não foi possível continuar! Verifique se há alguma assinatura selecionada.', "error");
            }
            data = JSON.parse(data)
            posicaoX = parseInt(data.posicaoX);
            posicaoX2 = parseInt(data.posicaoX2);
            posicaoX3 = parseInt(data.posicaoX3);
            posicaoY = parseInt(data.posicaoY);
            posicaoY2 = parseInt(data.posicaoY2);
            posicaoY3 = parseInt(data.posicaoY3);
            let tamanho = parseInt(data.tamanho);
            let tamanho2 = parseInt(data.tamanho2);
            let tamanho3 = parseInt(data.tamanho3);
            updateCertificado(data)
        })
    }

    function updateCertificado(dados) {
        $.post(BASEURL + "/gerador/gerador", dados, function (data) {
            console.log(data);
            data = JSON.parse(data);
            posicaoX = parseInt(data.posicaoX);
            posicaoX2 = parseInt(data.posicaoX2);
            posicaoX3 = parseInt(data.posicaoX3);
            posicaoY = parseInt(data.posicaoY);
            posicaoY2 = parseInt(data.posicaoY2);
            posicaoY3 = parseInt(data.posicaoY3);
            tamanho = parseInt(data.tamanho);
            tamanho2 = parseInt(data.tamanho2);
            tamanho3 = parseInt(data.tamanho3);
            let qntAss = parseInt(data.qntAss);
            let aluno = data.aluno;
            $("#viewPDF").html(`<embed style="border-radius: 5px; box-shadow: 6px 6px 8px" src="${data.arquivo}" width="850" height="650">`);
            $("#posicaoX").val(posicaoX + 'px');
            $("#posicaoY").val(posicaoY + 'px');
            if (qntAss == 1) {
                $("#SelectMove").css("visibility", "hidden");
            }
            if (qntAss > 1) {
                $("#SelectMove").css("visibility", "visible");
            }
            if (data.move == 1) {
                $("#posicaoX").val(posicaoX + 'px');
                $("#posicaoY").val(posicaoY + 'px');
            }
            if (data.move == 2) {
                $("#posicaoX").val(posicaoX2 + 'px');
                $("#posicaoY").val(posicaoY2 + 'px');
            }
            if (data.move == 3) {
                $("#posicaoX").val(posicaoX3 + 'px');
                $("#posicaoY").val(posicaoY3 + 'px');
            }
            $("#tamanho").val(tamanho + 'px');

            const positions = {
                "Ass": [
                    posicaoX,
                    posicaoY
                ],
                "Ass2": [
                    posicaoX2,
                    posicaoY2
                ],
                "Ass3": [
                    posicaoX3,
                    posicaoY3
                ],
                "tamanho": [
                    tamanho,
                    tamanho2,
                    tamanho3
                ],
                "aluno": [
                    aluno[0]
                ],
            };

            $(document).on("click", "#SalvarDados", function () {
                axios.post(BASEURL + "/gerador/savePosition", positions).then(res => {
                    if (res.data.codigo == "1") {
                        swal("", res.data.texto, "success");
                    }
                    if (res.data.codigo == "0") {
                        swal("Oops", res.data.texto, "error")
                    }
                });
            })
        });
    }

});