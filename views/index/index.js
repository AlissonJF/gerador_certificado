function formatar(mascara, documento) {
    const i = documento.value.length;
    const saida = mascara.substring(0, 1);
    const texto = mascara.substring(i);
    if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
    }
}

$(document).ready(function () {
    $('#InfoCertificado').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Insira o e-mail'
                    },
                    emailAddress: {
                        message: 'E-mail Incorreto'
                    }
                }
            },
            cpf: {
                validators: {
                    callback: {
                        message: 'CPF inválido',
                        callback: function (value) {
                            // retira mascara e não números
                            cpf = value.replace(/[^\d]+/g, '');
                            if (cpf == '') return false;

                            if (cpf.length != 11) return false;

                            // testa se os 11 digitos são inguais
                            let valido = 0;
                            for (i = 1; i < 11; i++) {
                                if (cpf.charAt(0) != cpf.charAt(i)) valido = 1;
                            }
                            if (valido == 0) return false;

                            // calculo primeira parte
                            aux = 0;
                            for (i = 0; i < 9; i++)
                                aux += parseInt(cpf.charAt(i)) * (10 - i);
                            check = 11 - (aux % 11);
                            if (check == 10 || check == 11)
                                check = 0;
                            if (check != parseInt(cpf.charAt(9)))
                                return false;

                            // calculo segunda parte
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
            }
        }
    });

    $(document).on("click", "#GeraCerti", function () {
        var infos = $("#InfoCertificado").submit()
        axios.post(BASEURL + "/index/GeraCertificado", `${$(infos).serialize()}`)
            .then(res => {
                if (res.data.codigo == "1") {
                    window.location.href = BASEURL + "/gerador/index";
                } else {
                    swal("", res.data.texto, "error")
                }
            })
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#printImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function RemoveBackground(dados) {
        console.log(dados)
        $.post(BASEURL + "/index/ImageBackgroundRemove", `${$(dados).serialize()}`).then(res => {})
    }

    $("#receiveFile").change(function () {
        readURL(this);
    });

    $(document).on("submit", "#InfoCertificado", function (event) {
        event.preventDefault();
    });

    $(document).on("click", "#removeBackground", function (img) {
        event.preventDefault();
        RemoveBackground(img.target.form);
    });
});
