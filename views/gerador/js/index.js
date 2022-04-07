$(document).ready(function() {
    let posicaoX = 0; // MAX UP posicao X = 210px MIN DOWN posicao X = 20px
    let posicaoX2 = 0;
    let posicaoX3 = 0;
    let posicaoY = 0; // MAX UP posicao Y = 130px MIN DOWN posicao Y = 150px
    let posicaoY2 = 0;
    let posicaoY3 = 0;
    let tamanho = 0;
    let tamanho2 = 0;
    let tamanho3 = 0;
    let qntAss = 0;
    let assinaturaSelecionada = 0;

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
        &posicaoX=${posicaoX}&posicaoY=${posicaoY}
        &posicaoX2=${posicaoX2}&posicaoY2=${posicaoY2}
        &posicaoX3=${posicaoX3}&posicaoY3=${posicaoY3}`, function(data) {
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
            qntAss = parseInt(data.qntAss);
            let aluno = data.aluno;
            $("#viewPDF").html(`<embed style="border-radius: 5px; box-shadow: 6px 6px 8px" src="${data.arquivo}" width="850" height="650">`);
            $("#posicaoX").val(posicaoX + 'px');
            $("#posicaoY").val(posicaoY + 'px');
            $("#tamanho1").val(tamanho + 'px');
            if (qntAss == 1) {
                $("#SelectMove").css("visibility", "hidden");
            }
            if (qntAss > 1) {
                $("#SelectMove").css("visibility", "visible");
            }
            if (qntAss == 2) {
                descSelect = ["Mover Assinatura", "Assinatura 1 (lado esquerdo)", "Assinatura 2 (lado direito)"]
                html = `<select id="AssMove" name="AssMove" class="btn btn-default col-md-12">`
                for (let i = 0; i <= qntAss; i++) {
                    if (i == parseInt(assinaturaSelecionada)) {
                        html += `<option value=${i} selected>${descSelect[i]}</option>`
                    } else {
                        html += `<option value=${i}>${descSelect[i]}</option>`
                    }
                }
                html += `</select>`
                $("#SelectMove").html(html)
            }
            if (data.move == 1) {
                $("#posicaoX").val(posicaoX + 'px');
                $("#posicaoY").val(posicaoY + 'px');
                $("#tamanho1").val(tamanho + 'px');
            }
            if (data.move == 2) {
                $("#posicaoX").val(posicaoX2 + 'px');
                $("#posicaoY").val(posicaoY2 + 'px');
                $("#tamanho1").val(tamanho2 + 'px');
            }
            if (data.move == 3) {
                $("#posicaoX").val(posicaoX3 + 'px');
                $("#posicaoY").val(posicaoY3 + 'px');
                $("#tamanho1").val(tamanho3 + 'px');
            }

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

    $(document).on("change", "#SelectMove", function(valor) {
        assinaturaSelecionada = valor.target.value
    })

});