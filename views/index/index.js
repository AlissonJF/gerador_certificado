$(document).ready(function() {
    $(document).on("click", "btnTransparent", function () {
        $("#RemoveBackground").submit()
    });
    $(document).on("submit", "#RemoveBackground", function () {
        event.preventDefault();
        RemoveBackground(this);
    })
    function RemoveBackground(image) {
        console.log(image);
        $.post(BASEURL + "/index/index", image).then(res => {
            console.log(res.data);
        })
    }
});