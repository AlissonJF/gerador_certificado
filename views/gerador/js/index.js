$(document).ready(function () {
    let posicaoX = 120; // MAX UP posicao X = 210px MIN DOWN posicao X = 20px
    let posicaoX2 = 210;
    let posicaoX3 = 120;
    let posicaoY = 140; // MAX UP posicao Y = 130px MIN DOWN posicao Y = 150px
    let posicaoY2 = 140;
    let posicaoY3 = 140;

    $(document).on("click", "#verCertificado", function () {
        $("#formCertificado").submit()
    });

    $(document).on("submit", "#formCertificado", function (event) {
        event.preventDefault();
        updateCertificado(this);
    });

    function selectAssinatura()
    {
        getUrl(BASEURL + "/gerador/selectAssinatura").then(res => {
            var txt = "";

            res.data.forEach(element => {
                txt += `<option value="${element.sequencia}">${element.nomeassinatura}</option>`
            })
            $("#selectAss1").html(txt);
            $("#selectAss2").html(txt);
            $("#selectAss3").html(txt);
        })
    } selectAssinatura()

    function updateCertificado(dados) {
        $.post(BASEURL + "/gerador/gerador", `${$(dados).serialize()}
        &posicaoX=${posicaoX}&posicaoY=${posicaoY}
        &posicaoX2=${posicaoX2}&posicaoY2=${posicaoY2}
        &posicaoX3=${posicaoX3}&posicaoY3=${posicaoY3}`, function (data) {
            if (data == '') {
                alert('Não foi possível gerar o PDF! Verifique se os campos obrigatórios(*) estão preenchidos.');
            } else {
                data = JSON.parse(data);
                posicaoX = parseInt(data.posicaoX);
                posicaoX2 = parseInt(data.posicaoX2);
                posicaoX3 = parseInt(data.posicaoX3);
                posicaoY = parseInt(data.posicaoY);
                posicaoY2 = parseInt(data.posicaoY2);
                posicaoY3 = parseInt(data.posicaoY3);
                let tamanho = parseInt(data.tamanho);
                let tamanho2 = parseInt(data.tamanho);
                let tamanho3 = parseInt(data.tamanho);
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
                            swal("",res.data.texto, "success");
                        } else {
                            swal("", res.data.texto, "error")
                        }
                    });
                })
            }
        });
    }

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

});