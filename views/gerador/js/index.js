$(document).ready(function() {
    let posicaoX = 120; // MAX UP posicao X = 210px MIN DOWN posicao X = 20px
    let posicaoX2 = 210;
    let posicaoX3 = 120;
    let posicaoY = 140; // MAX UP posicao Y = 130px MIN DOWN posicao Y = 150px
    let posicaoY2 = 140;
    let posicaoY3 = 140;
    let tamanho = 60;
    let tamanho2 = 60;
    let tamanho3 = 60;

    $('.ArrowUP').click(function() {
        posicaoY -= 10;
        posicaoY2 -= 10;
        posicaoY3 -= 10;
        $("#formCertificado").submit();
    });

    $('.ArrowDown').click(function() {
        posicaoY += 10;
        posicaoY2 += 10;
        posicaoY3 += 10;
        $("#formCertificado").submit();
    });

    $('.ArrowLeft').click(function() {
        posicaoX -= 10;
        posicaoX2 -= 10;
        posicaoX3 -= 10;
        $("#formCertificado").submit();
    });

    $('.ArrowRight').click(function() {
        posicaoX += 10;
        posicaoX2 += 10;
        posicaoX3 += 10;
        $("#formCertificado").submit();
    });

    $(document).on("click", "#verCertificado", function() {
        $("#formCertificado").submit()
    });

    $(document).on("submit", "#formCertificado", function(event) {
        event.preventDefault();
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
        &posicaoX=${posicaoX}&posicaoY=${posicaoY}&tamanho=${tamanho}
        &posicaoX2=${posicaoX2}&posicaoY2=${posicaoY2}&tamanho2=${tamanho2}
        &posicaoX3=${posicaoX3}&posicaoY3=${posicaoY3}&tamanho3=${tamanho3}`, function(data) {
            if (data == '') {
                swal("Oops", 'Não foi possível continuar! Verifique se há alguma assinatura selecionada.', "error");
            }
            data = JSON.parse(data)
            posicaoX = data.posicaoX;
            posicaoX2 = data.posicaoX2;
            posicaoX3 = data.posicaoX3;
            posicaoY = data.posicaoY;
            posicaoY2 = data.posicaoY2;
            posicaoY3 = data.posicaoY3;
            tamanho = data.tamanho;
            tamanho2 = data.tamanho2;
            tamanho3 = data.tamanho3;
            updateCertificado(data)
        })
    }

    function updateCertificado(dados) {
        $.post(BASEURL + "/gerador/gerador", dados, function(data) {
            data = JSON.parse(data);
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
                $("#tamanho1").val(tamanho + 'px');
            }
            if (data.move == 2) {
                $("#posicaoX").val(posicaoX3 + 'px');
                $("#posicaoY").val(posicaoY3 + 'px');
                $("#tamanho1").val(tamanho3 + 'px');
            }
            if (data.move == 3) {
                $("#posicaoX").val(posicaoX2 + 'px');
                $("#posicaoY").val(posicaoY2 + 'px');
                $("#tamanho1").val(tamanho2 + 'px');
            }
            $("#tamanho1").val(tamanho + 'px');

            const positions = {
                "Ass": [posicaoX, posicaoY],
                "Ass2": [posicaoX2, posicaoY2],
                "Ass3": [posicaoX3, posicaoY3],
                "tamanho": [tamanho, tamanho2, tamanho3],
                "aluno": [aluno[0]],
            };

            $(document).on("click", "#SalvarDados", function() {
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