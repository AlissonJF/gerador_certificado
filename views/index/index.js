$(document).ready(function() {
    $(document).on("click", "#btnTransparent", function () {
        $("#InfoCertificado").submit()
    });
    $(document).on("submit", "#InfoCertificado", function (event) {
        event.preventDefault();
        RemoveBackground(this);
    })
    function RemoveBackground(dados) {
        $.post(BASEURL + "/index/ImageBackgroundRemove", `${$(dados).serialize()}`).then(res => {
            console.log(res.data);
        })
    }
});