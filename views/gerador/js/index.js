$(document).ready(function () {
    let posicaoX = 120; // MAX UP posicao X = 210px MIN DOWN posicao X = 20px
    let posicaoX2 = 210;
    let posicaoX3 = 120;
    let posicaoY = 140; // MAX UP posicao Y = 130px MIN DOWN posicao Y = 150px
    let posicaoY2 = 140;
    let posicaoY3 = 140;
    let tamanho = 60; // Tamanho padrão = 60px
    $('#formCertificado').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nome: {
                validators: {
                    stringLength: {
                        min: 2,
                    },
                    notEmpty: {
                        message: 'Insira o seu nome'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Insira o seu e-mail'
                    },
                    emailAddress: {
                        message: 'E-mail incorreto'
                    }
                }
            },
            cpf: {
                validators: {
                    callback: {
                        message: 'CPF Invalido',
                        callback: function (value) {
                            //retira mascara e nao numeros
                            cpf = value.replace(/[^\d]+/g, '');
                            if (cpf == '') return false;

                            if (cpf.length != 11) return false;

                            // testa se os 11 digitos são iguais.
                            let valido = 0;
                            for (i = 1; i < 11; i++) {
                                if (cpf.charAt(0) != cpf.charAt(i)) valido = 1;
                            }
                            if (valido == 0) return false;

                            //  calculo primeira parte
                            aux = 0;
                            for (i = 0; i < 9; i++)
                                aux += parseInt(cpf.charAt(i)) * (10 - i);
                            check = 11 - (aux % 11);
                            if (check == 10 || check == 11)
                                check = 0;
                            if (check != parseInt(cpf.charAt(9)))
                                return false;

                            //calculo segunda parte
                            aux = 0;
                            for (i = 0; i < 10; i++)
                                aux += parseInt(cpf.charAt(i)) * (11 - i);
                            check = 11 - (aux % 11);
                            if (check == 10 || check == 11)
                                check = 0;
                            return check == parseInt(cpf.charAt(10));
                        }
                    }
                }
            },
        }
    });

    $(document).on("click", "#verCertificado", function () {
        $("#formCertificado").submit()
    });

    $(document).on("submit", "#formCertificado", function (event) {
        event.preventDefault();
        updateCertificado(this);
    });

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
                tamanho = parseInt(data.tamanho);
                let qntAss = parseInt(data.qntAss);
                let aluno = data.aluno;
                let nomeassinatura = data.nomeassinatura;
                let nomeassinatura2 = data.nomeassinatura2;
                let nomeassinatura3 = data.nomeassinatura3;
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
                    "Ass": [posicaoX,
                        posicaoY,
                        nomeassinatura[0]],
                    "Ass2": [posicaoX2,
                        posicaoY2,
                        nomeassinatura2[0]],
                    "Ass3": [posicaoX3,
                        posicaoY3,
                        nomeassinatura3[0]],
                    "tamanho": [tamanho],
                    "aluno": [aluno[0]],
                };

                $(document).on("click", "#SalvarDados", function () {
                    axios.post(BASEURL + "/gerador/savePosition", positions).then(res => {
                        if (res.data.codigo == "1") {
                            swal(":)",res.data.texto, "success");
                        } else {
                            swal(":/", res.data.texto, "error")
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